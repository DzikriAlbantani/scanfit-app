<?php

namespace App\Http\Controllers;

use App\Models\FashionItem;
use App\Models\ClickEvent;
use App\Models\ClosetItem;
use App\Models\Payment;
use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use App\Services\Payments\MidtransService;

class BrandDashboardController extends Controller
{
    /**
     * =========================================================================
     * DASHBOARD & ANALYTICS
     * =========================================================================
     */

    /**
     * Menampilkan halaman utama Dashboard Brand.
     * Melakukan pengecekan ketat apakah user memiliki brand dan statusnya 'approved'.
     */
    public function dashboard()
    {
        Log::info('BrandDashboardController: Mengakses Dashboard');

        $user = Auth::user();
        
        // 1. Cek User
        if (!$user) {
            return response('Not authenticated', 401);
        }

        // 2. Cek Brand
        $brand = $user->brand;
        if (!$brand) {
            Log::error('User ' . $user->id . ' tidak memiliki brand.');
            return response('No brand found', 404);
        }

        // 3. Cek Status Approval
        if ($brand->status !== 'approved') {
            Log::warning('Brand ' . $brand->id . ' mencoba akses tapi status: ' . $brand->status);
            return response('Brand not approved', 403);
        }

        // 4. Siapkan Data Statistik Real-Time
        $totalProducts = $brand->fashionItems()->count();
        
        // Total Scan Matches: hitung berapa kali produk brand muncul di scan results
        // Loop through scans dan hitung setiap product dari brand yang muncul di recommendations
        $totalScanMatches = 0;
        $scans = \App\Models\Scan::whereNotNull('scan_result')->get();
        
        foreach ($scans as $scan) {
            // Parse scan_result JSON
            $result = is_string($scan->scan_result) ? json_decode($scan->scan_result, true) : $scan->scan_result;
            
            if (!is_array($result)) {
                continue;
            }
            
            // Check in recommendations (format: array of product objects/arrays)
            if (isset($result['recommendations']) && is_array($result['recommendations'])) {
                foreach ($result['recommendations'] as $product) {
                    // Product dapat berupa object atau array
                    $productArray = is_object($product) ? get_object_vars($product) : (is_array($product) ? $product : []);
                    
                    // Cek apakah brand_id cocok dengan brand yang sedang diakses
                    if (isset($productArray['brand_id']) && $productArray['brand_id'] == $brand->id) {
                        $totalScanMatches++;
                    } elseif (isset($productArray['brand']) && is_array($productArray['brand'])) {
                        // Jika brand nested dalam array
                        if (isset($productArray['brand']['id']) && $productArray['brand']['id'] == $brand->id) {
                            $totalScanMatches++;
                        }
                    }
                }
            }
        }
        
        // Product Views: sum clicks_count
        $totalClicks = $brand->fashionItems()->sum('clicks_count') ?? 0;
        
        // Wishlisted: hitung berapa kali produk brand di-save ke closet
        $totalWishlisted = \App\Models\ClosetItem::whereIn(
            'fashion_item_id',
            $brand->fashionItems()->pluck('id')
        )->count();
        
        // Conversion Rate: (wishlisted / clicks) * 100
        $conversionRate = $totalClicks > 0 ? ($totalWishlisted / $totalClicks) * 100 : 0;
        
        // Popular Products
        $popularProducts = $brand->fashionItems()
            ->withCount(['closetItems as saves_count'])
            ->orderBy('clicks_count', 'desc')
            ->take(10)
            ->get();

        // 5. Prepare 30-day Chart Data
        $chartData = $this->prepare30DayChartData($brand);
        
        Log::info('Chart data prepared for brand ' . $brand->id, [
            'labels_count' => count($chartData['labels'] ?? []),
            'clicks_sum' => array_sum($chartData['clicks'] ?? []),
            'scans_sum' => array_sum($chartData['scans'] ?? []),
            'saves_sum' => array_sum($chartData['saves'] ?? []),
        ]);

        // 6. Prepare Banner Data
        $banners = $brand->banners()->latest('created_at')->paginate(5);
        $bannerStats = [
            'total' => $brand->banners()->count(),
            'active' => $brand->banners()->where('status', 'active')->count(),
            'pending' => $brand->banners()->where('status', 'pending')->count(),
            'clicks' => $brand->banners()->sum('clicks'),
            'impressions' => $brand->banners()->sum('impressions'),
        ];

        return view('brand.dashboard', compact(
            'brand',
            'totalProducts',
            'totalScanMatches',
            'totalClicks',
            'totalWishlisted',
            'conversionRate',
            'popularProducts',
            'chartData',
            'banners',
            'bannerStats'
        ));
    }

    /**
     * Prepare 30-day performance chart data
     */
    private function prepare30DayChartData($brand)
    {
        $end = now()->endOfDay();
        $start = now()->subDays(29)->startOfDay();
        $itemIds = $brand->fashionItems()->pluck('id');
        
        Log::info('Preparing chart data for brand ' . $brand->id, [
            'itemIds_count' => $itemIds->count(),
            'itemIds_sample' => $itemIds->take(5)->toArray(),
        ]);

        // Aggregate clicks per day from click_events
        $clicksPerDay = ClickEvent::whereIn('fashion_item_id', $itemIds)
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as d, COUNT(*) as total')
            ->groupBy('d')
            ->pluck('total', 'd');
        
        Log::info('Clicks per day calculated', ['days_count' => $clicksPerDay->count()]);

        // Aggregate saves per day from closet_items
        $savesPerDay = ClosetItem::whereIn('fashion_item_id', $itemIds)
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as d, COUNT(*) as total')
            ->groupBy('d')
            ->pluck('total', 'd');
        
        Log::info('Saves per day calculated', ['days_count' => $savesPerDay->count()]);

        // Aggregate scans per day that include this brand
        $scansPerDay = [];
        $scans = Scan::whereBetween('created_at', [$start, $end])->get();
        foreach ($scans as $scan) {
            $result = is_string($scan->scan_result) ? json_decode($scan->scan_result, true) : $scan->scan_result;
            if (!is_array($result)) {
                continue;
            }
            
            $hasBrand = false;
            
            // Check recommendations (new structure)
            if (isset($result['recommendations']) && is_array($result['recommendations'])) {
                foreach ($result['recommendations'] as $product) {
                    $productArray = is_object($product) ? get_object_vars($product) : (is_array($product) ? $product : []);
                    
                    if ((isset($productArray['brand_id']) && $productArray['brand_id'] == $brand->id) ||
                        (isset($productArray['brand']) && is_array($productArray['brand']) && isset($productArray['brand']['id']) && $productArray['brand']['id'] == $brand->id)) {
                        $hasBrand = true;
                        break;
                    }
                }
            }
            
            // Legacy fallback for old structure with 'items'
            if (!$hasBrand && isset($result['items'])) {
                foreach ($result['items'] as $item) {
                    if (isset($item['brand_id']) && (int)$item['brand_id'] === (int)$brand->id) {
                        $hasBrand = true;
                        break;
                    }
                }
            }
            
            if ($hasBrand) {
                $dateKey = Carbon::parse($scan->created_at)->format('Y-m-d');
                $scansPerDay[$dateKey] = ($scansPerDay[$dateKey] ?? 0) + 1;
            }
        }

        $days = [];
        $clicksData = [];
        $scansData = [];
        $savesData = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateKey = $date->format('Y-m-d');
            $days[] = $date->format('d M');

            $clicksData[] = (int)($clicksPerDay[$dateKey] ?? 0);
            $scansData[] = (int)($scansPerDay[$dateKey] ?? 0);
            $savesData[] = (int)($savesPerDay[$dateKey] ?? 0);
        }

        return [
            'labels' => $days,
            'clicks' => $clicksData,
            'scans' => $scansData,
            'saves' => $savesData,
            'totals' => [
                'clicks' => array_sum($clicksData),
                'scans' => array_sum($scansData),
                'saves' => array_sum($savesData),
            ],
            'range' => [
                'start' => $start,
                'end' => $end,
            ],
        ];
    }

    private function percentChange(float $current, float $previous): ?float
    {
        if ($previous <= 0) {
            return null;
        }
        return round((($current - $previous) / $previous) * 100, 1);
    }

    /**
     * Upgrade subscription for brand partner via Midtrans Snap.
     */
    public function upgradeSubscription(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:pro',
            'duration' => 'nullable|in:monthly,yearly',
        ]);

        $user = Auth::user();
        $brand = $user->brand;

        if (!$brand || $brand->status !== 'approved') {
            abort(403, 'Brand not approved');
        }

        $duration = $request->input('duration', 'monthly');
        $plans = config('pricing.brand_plans', []);
        $planKey = $request->input('plan');
        $planConfig = $plans[$planKey] ?? null;

        if (!$planConfig) {
            return Redirect::back()->with('error', 'Paket brand tidak tersedia.');
        }

        $base = (int)($planConfig['monthly_price'] ?? 0);
        $discountMonths = (int)($planConfig['yearly_discount_months'] ?? 0);
        $monthsToPay = $duration === 'yearly' ? max(0, 12 - $discountMonths) : 1;
        $amount = $base * $monthsToPay;

        if ($amount <= 0) {
            $expiresAt = $duration === 'yearly' ? now()->addYear() : now()->addMonth();
            $brand->update([
                'subscription_plan' => 'pro',
                'is_premium' => true,
                'subscription_expires_at' => $expiresAt,
            ]);

            return Redirect::route('brand.analytics')->with('success', 'Paket Pro diaktifkan untuk brand Anda.');
        }

        $orderId = 'SF-BRAND-' . Str::upper(Str::random(10));

        $payment = Payment::create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'plan' => $planKey,
            'amount' => $amount,
            'status' => 'pending',
            'metadata' => [
                'cycle' => $duration,
                'user_id' => $user->id,
                'brand_id' => $brand->id,
                'brand_name' => $brand->brand_name,
                'brand_subscription' => true,
                'plan' => $planKey,
            ],
        ]);

        $service = new MidtransService();
        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => 'brand-plan-' . $planKey . '-' . $duration,
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => 'ScanFit Brand ' . ucfirst($planKey) . ' (' . ucfirst($duration) . ')',
                ],
            ],
        ];

        try {
            $result = $service->createSnapTransaction($payload);

            Log::info('Brand Snap transaction created', [
                'order_id' => $orderId,
                'brand_id' => $brand->id,
                'token' => $result['token'] ?? null,
            ]);
        } catch (\Exception $e) {
            Log::error('Brand Snap transaction failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);

            return Redirect::back()->with('error', 'Gagal membuat transaksi Midtrans. Coba lagi.');
        }

        $payment->update([
            'snap_token' => $result['token'] ?? null,
            'snap_redirect_url' => $result['redirect_url'] ?? null,
            'metadata' => array_merge($payment->metadata ?? [], $result, [
                'cycle' => $duration,
                'base_price' => $base,
                'brand_subscription' => true,
            ]),
        ]);

        return view('payments.checkout', [
            'snapToken' => $result['token'] ?? null,
            'clientKey' => $service->clientKey(),
            'payment' => $payment,
        ]);
    }

    /**
     * Menampilkan halaman Analitik performa Brand.
     */
    public function analytics()
    {
        $user = Auth::user();
        $brand = $user->brand;

        // Validasi keamanan sederhana
        if (!$brand || $brand->status !== 'approved') {
            abort(403, 'Brand not approved');
        }

        $itemIds = $brand->fashionItems()->pluck('id');
        $isPro = $brand->isPro();
        $totalViews = $brand->fashionItems()->sum('clicks_count');

        if (!$isPro) {
            $analytics = [
                'is_pro' => false,
                'subscription_plan' => $brand->subscription_plan ?? 'basic',
                'total_views' => $totalViews,
                'chart' => [
                    'labels' => [],
                    'clicks' => [],
                    'saves' => [],
                    'scans' => [],
                    'totals' => [
                        'clicks' => $totalViews,
                        'saves' => 0,
                        'scans' => 0,
                    ],
                ],
                'deltas' => [
                    'views' => null,
                    'conversion' => null,
                    'engagement' => null,
                    'new_products' => null,
                ],
                'active_products' => null,
                'conversion_rate' => null,
                'engagement_rate' => null,
                'total_saves' => null,
                'top_performing_products' => [],
                'period' => [],
                'date_range' => [],
            ];

            return view('brand.analytics', compact('brand', 'analytics'));
        }

        // Chart data 30 hari terakhir (real events)
        $chartData = $this->prepare30DayChartData($brand);
        $start = $chartData['range']['start'];
        $end = $chartData['range']['end'];
        $prevStart = (clone $start)->subDays(30);
        $prevEnd = (clone $start)->subDay()->endOfDay();

        // Current & previous period aggregates (30 hari)
        $currentViews = ClickEvent::whereIn('fashion_item_id', $itemIds)
            ->whereBetween('created_at', [$start, $end])
            ->count();
        $prevViews = ClickEvent::whereIn('fashion_item_id', $itemIds)
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->count();

        $currentSaves = ClosetItem::whereIn('fashion_item_id', $itemIds)
            ->whereBetween('created_at', [$start, $end])
            ->count();
        $prevSaves = ClosetItem::whereIn('fashion_item_id', $itemIds)
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->count();

        $conversionRate = $currentViews > 0 ? round(($currentSaves / $currentViews) * 100, 1) : 0.0;
        $conversionPrev = $prevViews > 0 ? round(($prevSaves / $prevViews) * 100, 1) : 0.0;

        $engagementRate = $currentViews > 0 ? round((($currentSaves + $currentViews) / $currentViews) * 100, 1) : 0.0;
        $engagementPrev = $prevViews > 0 ? round((($prevSaves + $prevViews) / $prevViews) * 100, 1) : 0.0;

        // Produk + saves count untuk tabel
        $products = $brand->fashionItems()
            ->withCount(['closetItems as saves_count'])
            ->get();

        $totalSaves = $products->sum('saves_count');
        $activeCount = $products->where('status', 'active')->count();
        $newProducts = $brand->fashionItems()
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $topProducts = $products
            ->map(function ($item) {
                $item->engagement_score = $item->clicks_count + $item->saves_count;
                return $item;
            })
            ->sortByDesc('engagement_score')
            ->take(10)
            ->values();

        $analytics = [
            'is_pro' => true,
            'subscription_plan' => $brand->subscription_plan ?? 'pro',
            'total_views'   => $chartData['totals']['clicks'] ?? 0,
            'active_products' => $activeCount,
            'conversion_rate' => $conversionRate,
            'engagement_rate' => $engagementRate,
            'total_saves'     => $totalSaves,
            'top_performing_products' => $topProducts,
            'chart' => $chartData,
            'period' => [
                'current_views' => $currentViews,
                'prev_views' => $prevViews,
                'current_saves' => $currentSaves,
                'prev_saves' => $prevSaves,
            ],
            'deltas' => [
                'views' => $this->percentChange($currentViews, $prevViews),
                'conversion' => round($conversionRate - $conversionPrev, 1),
                'engagement' => round($engagementRate - $engagementPrev, 1),
                'new_products' => $newProducts,
            ],
            'date_range' => [
                'start' => $start->toDateString(),
                'end' => $end->toDateString(),
            ],
        ];

        return view('brand.analytics', compact('brand', 'analytics'));
    }

    /**
     * API endpoint untuk real-time analytics data (AJAX)
     * Return JSON data untuk refresh chart dan metrics tanpa page reload
     */
    public function analyticsData()
    {
        $user = Auth::user();
        $brand = $user->brand;

        if (!$brand || $brand->status !== 'approved') {
            return response()->json(['error' => 'Brand not approved'], 403);
        }

        $isPro = $brand->isPro();
        $totalViews = $brand->fashionItems()->sum('clicks_count');

        if (!$isPro) {
            return response()->json([
                'success' => true,
                'is_pro' => false,
                'metrics' => [
                    'total_views' => $totalViews,
                ],
                'message' => 'Upgrade untuk membuka analytics detail',
                'timestamp' => now()->toIso8601String(),
            ]);
        }

        $itemIds = $brand->fashionItems()->pluck('id');

        // Chart data 30 hari terakhir
        $chartData = $this->prepare30DayChartData($brand);
        $start = $chartData['range']['start'];
        $end = $chartData['range']['end'];
        $prevStart = (clone $start)->subDays(30);
        $prevEnd = (clone $start)->subDay()->endOfDay();

        // Current period metrics
        $currentViews = ClickEvent::whereIn('fashion_item_id', $itemIds)
            ->whereBetween('created_at', [$start, $end])
            ->count();
        $prevViews = ClickEvent::whereIn('fashion_item_id', $itemIds)
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->count();

        $currentSaves = ClosetItem::whereIn('fashion_item_id', $itemIds)
            ->whereBetween('created_at', [$start, $end])
            ->count();
        $prevSaves = ClosetItem::whereIn('fashion_item_id', $itemIds)
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->count();

        // Calculate rates
        $conversionRate = $currentViews > 0 ? round(($currentSaves / $currentViews) * 100, 1) : 0.0;
        $conversionPrev = $prevViews > 0 ? round(($prevSaves / $prevViews) * 100, 1) : 0.0;

        $engagementRate = $currentViews > 0 ? round((($currentSaves + $currentViews) / $currentViews) * 100, 1) : 0.0;
        $engagementPrev = $prevViews > 0 ? round((($prevSaves + $prevViews) / $prevViews) * 100, 1) : 0.0;

        // Top products
        $products = $brand->fashionItems()
            ->withCount(['closetItems as saves_count'])
            ->get();

        $totalViews = $products->sum('clicks_count');
        $activeCount = $products->where('status', 'active')->count();
        $newProducts = $brand->fashionItems()
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $topProducts = $products
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'image_url' => $item->image_url,
                    'category' => $item->category,
                    'clicks_count' => $item->clicks_count,
                ];
            })
            ->sortByDesc('clicks_count')
            ->take(10)
            ->values();

        return response()->json([
            'success' => true,
            'is_pro' => true,
            'timestamp' => now()->toIso8601String(),
            'metrics' => [
                'total_views' => $totalViews,
                'active_products' => $activeCount,
                'conversion_rate' => $conversionRate,
                'engagement_rate' => $engagementRate,
                'total_saves' => $products->sum('saves_count'),
                'new_products' => $newProducts,
            ],
            'deltas' => [
                'views' => $this->percentChange($currentViews, $prevViews),
                'conversion' => round($conversionRate - $conversionPrev, 1),
                'engagement' => round($engagementRate - $engagementPrev, 1),
                'new_products' => $newProducts,
            ],
            'chart' => [
                'labels' => $chartData['labels'],
                'datasets' => [
                    [
                        'label' => 'Views',
                        'data' => $chartData['clicks'],
                        'borderColor' => '#2563eb',
                        'backgroundColor' => 'rgba(37, 99, 235, 0.12)',
                    ],
                    [
                        'label' => 'Saves',
                        'data' => $chartData['saves'],
                        'borderColor' => '#f59e0b',
                        'backgroundColor' => 'rgba(245, 158, 11, 0.10)',
                    ],
                    [
                        'label' => 'Scan Matches',
                        'data' => $chartData['scans'],
                        'borderColor' => '#10b981',
                        'backgroundColor' => 'rgba(16, 185, 129, 0.10)',
                    ],
                ],
                'totals' => $chartData['totals'],
            ],
            'top_products' => $topProducts,
        ]);
    }

    /**
     * =========================================================================
     * PRODUCT MANAGEMENT (RESOURCE METHODS)
     * Method ini otomatis terhubung dengan Route::resource('products')
     * =========================================================================
     */

    /**
     * [GET] Menampilkan daftar semua produk milik brand.
     */
    public function index()
    {
        $brand = Auth::user()->brand;
        
        // Base query
        $query = $brand->fashionItems();

        // Search filter
        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('description', 'like', '%' . request('search') . '%');
        }

        // Status filter
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // Category filter
        if (request('category')) {
            $query->where('category', request('category'));
        }

        // Sorting
        $sort = request('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'most_viewed':
                $query->orderBy('clicks_count', 'desc');
                break;
            case 'most_saved':
                $query->withCount('closetItems')
                      ->orderBy('closet_items_count', 'desc');
                break;
            default: // 'latest'
                $query->latest();
        }

        // Get products with pagination
        $products = $query->paginate(12);

        // Get stats for display
        $activeCount = $brand->fashionItems()->where('status', 'active')->count();
        $inactiveCount = $brand->fashionItems()->where('status', 'inactive')->count();
        $totalViews = $brand->fashionItems()->sum('clicks_count');

        // Get unique categories
        $categories = $brand->fashionItems()->distinct('category')->pluck('category')->sort();

        return view('brand.products.index', compact('products', 'activeCount', 'inactiveCount', 'totalViews', 'categories'));
    }

    /**
     * [GET] Menampilkan form untuk menambah produk baru.
     */
    public function create()
    {
        return view('brand.products.create');
    }

    /**
     * [POST] Menyimpan data produk baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name'              => 'required|string|max:255',
            'category'          => 'required|string|max:255',
            'price'             => 'required|numeric|min:0',
            'original_price'    => 'nullable|numeric|min:0',
            'description'       => 'nullable|string',
            'marketplace_links' => 'nullable|array', // Array dari input name="marketplace_links[shopee]" dll
            'marketplace_links.*' => 'nullable|url',
            'sizes'             => 'nullable|array',
            'colors'            => 'nullable|array',
            'image'             => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'style'             => 'nullable|in:casual,formal,sport,street,vintage,minimal',
            'fit_type'          => 'nullable|in:slim,regular,loose',
            'dominant_color'    => 'nullable|string|max:255',
            'gender_target'     => 'nullable|in:male,female,unisex',
            'stock'             => 'nullable|integer|min:0',
        ]);

        $brand = Auth::user()->brand;

        // 2. Upload Gambar
        $imagePath = $request->file('image')->store('fashion-items', 'public');

        // 3. Ambil data marketplace
        $marketplace = $request->input('marketplace_links', []);

        // 4. Simpan ke Database
        FashionItem::create([
            'brand_id'       => $brand->id,
            'name'           => $request->name,
            'category'       => $request->category,
            'price'          => $request->price,
            'original_price' => $request->original_price,
            'description'    => $request->description,
            // Mapping Marketplace Link
            'link_shopee'    => $marketplace['shopee'] ?? null,
            'link_tokopedia' => $marketplace['tokopedia'] ?? null,
            'link_tiktok'    => $marketplace['tiktok'] ?? null,
            'link_lazada'    => $marketplace['lazada'] ?? null,
            // Atribut Fisik
            'sizes'          => $request->sizes,
            'colors'         => $request->colors,
            'image_url'      => Storage::url($imagePath),
            'store_name'     => $brand->brand_name, // Menggunakan nama brand sebagai store name
            'style'          => $request->style,
            'fit_type'       => $request->fit_type,
            'dominant_color' => $request->dominant_color,
            'gender_target'  => $request->gender_target,
            'stock'          => $request->stock ?? 0,
        ]);

        return redirect()->route('brand.products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * [GET] Menampilkan detail produk (redirect ke edit untuk sekarang).
     */
    public function show(FashionItem $product)
    {
        // Keamanan: Pastikan produk milik brand yang sedang login
        if ($product->brand_id !== Auth::user()->brand->id) {
            abort(403, 'Unauthorized action.');
        }

        // Redirect ke edit form untuk sekarang
        return redirect()->route('brand.products.edit', $product);
    }

    /**
     * [GET] Menampilkan form edit produk.
     */
    public function edit(FashionItem $product)
    {
        // Keamanan: Pastikan produk milik brand yang sedang login
        if ($product->brand_id !== Auth::user()->brand->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('brand.products.edit', compact('product'));
    }

    /**
     * [PUT/PATCH] Mengupdate data produk yang sudah ada.
     */
    public function update(Request $request, FashionItem $product)
    {
        // Keamanan
        if ($product->brand_id !== Auth::user()->brand->id) {
            abort(403, 'Unauthorized action.');
        }

        // 1. Validasi Input (Image jadi nullable karena tidak wajib ganti foto)
        $request->validate([
            'name'              => 'required|string|max:255',
            'category'          => 'required|string|max:255',
            'price'             => 'required|numeric|min:0',
            'original_price'    => 'nullable|numeric|min:0',
            'description'       => 'nullable|string',
            'marketplace_links' => 'nullable|array',
            'marketplace_links.*' => 'nullable|url',
            'sizes'             => 'nullable|array',
            'colors'            => 'nullable|array',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'style'             => 'nullable|in:casual,formal,sport,street,vintage,minimal',
            'fit_type'          => 'nullable|in:slim,regular,loose',
            'dominant_color'    => 'nullable|string|max:255',
            'gender_target'     => 'nullable|in:male,female,unisex',
            'stock'             => 'nullable|integer|min:0',
        ]);

        $marketplace = $request->input('marketplace_links', []);

        // 2. Siapkan Data Update
        $updateData = [
            'name'           => $request->name,
            'category'       => $request->category,
            'price'          => $request->price,
            'original_price' => $request->original_price,
            'description'    => $request->description,
            'link_shopee'    => $marketplace['shopee'] ?? null,
            'link_tokopedia' => $marketplace['tokopedia'] ?? null,
            'link_tiktok'    => $marketplace['tiktok'] ?? null, // Perbaikan logika mapping
            'link_lazada'    => $marketplace['lazada'] ?? null,
            'sizes'          => $request->sizes,
            'colors'         => $request->colors,
            'style'          => $request->style,
            'fit_type'       => $request->fit_type,
            'dominant_color' => $request->dominant_color,
            'gender_target'  => $request->gender_target,
            'stock'          => $request->stock ?? 0,
        ];

        // 3. Cek apakah ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika perlu (opsional)
            // if($product->image_url) { ... logic hapus ... }

            $imagePath = $request->file('image')->store('fashion-items', 'public');
            $updateData['image_url'] = Storage::url($imagePath);
        }

        // 4. Update Database
        $product->update($updateData);

        return redirect()->route('brand.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * [DELETE] Menghapus produk.
     */
    public function destroy(FashionItem $product)
    {
        // Keamanan
        if ($product->brand_id !== Auth::user()->brand->id) {
            abort(403);
        }

        // Hapus file gambar dari storage jika perlu (opsional tapi disarankan)
        // ... logic hapus gambar ...

        $product->delete();

        return redirect()->route('brand.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * =========================================================================
     * BRAND PROFILE MANAGEMENT
     * =========================================================================
     */

    public function editProfile()
    {
        $brand = Auth::user()->brand;
        return view('brand.profile.edit', compact('brand'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'brand_name'  => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $brand = Auth::user()->brand;

        $data = [
            'brand_name'  => $request->brand_name,
            'description' => $request->description,
        ];

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('brand-logos', 'public');
            $data['logo_url'] = Storage::url($logoPath);
        }

        $brand->update($data);

        return redirect()->route('brand.profile.edit')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Toggle product status between active and inactive
     */
    public function toggleStatus(FashionItem $product)
    {
        $user = Auth::user();
        $brand = $user->brand;

        // Verify product belongs to this brand
        if ($product->brand_id !== $brand->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Toggle status
        $newStatus = ($product->status === 'active') ? 'inactive' : 'active';
        $product->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'message' => 'Status produk berhasil diubah'
        ]);
    }

    /**
     * Delete a product
     */
    public function destroyProduct(FashionItem $product)
    {
        $user = Auth::user();
        $brand = $user->brand;

        // Verify product belongs to this brand
        if ($product->brand_id !== $brand->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Delete associated image if exists
        if ($product->image_url && str_starts_with($product->image_url, 'storage/')) {
            Storage::delete(str_replace('storage/', 'public/', $product->image_url));
        }

        // Delete product
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus'
        ]);
    }

    /**
     * =========================================================================
     * BANNER MANAGEMENT (Integrated into Dashboard)
     * =========================================================================
     */

    /**
     * Store New Banner
     */
    public function storeBanner(Request $request)
    {
        $brand = Auth::user()->brand;
        
        if (!$brand) {
            return redirect()->route('brand.pending');
        }

        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'link_url' => 'nullable|url',
            'cta_text' => 'required|string|max:50',
            'started_at' => 'nullable|date',
            'ended_at' => 'nullable|date',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $bannerPath = $request->file('banner_image')->store('brand-banners', 'public');

        \App\Models\BrandBanner::create([
            'brand_id' => $brand->id,
            'title' => $request->title,
            'description' => $request->description,
            'banner_image_url' => $bannerPath,
            'link_url' => $request->link_url,
            'cta_text' => $request->cta_text,
            'started_at' => $request->started_at,
            'ended_at' => $request->ended_at,
            'budget' => $request->budget,
            'status' => 'pending',
        ]);

        return redirect()->route('brand.dashboard')->with('success', 'Banner berhasil dibuat dan menunggu approval');
    }

    /**
     * Update Banner
     */
    public function updateBanner(Request $request, \App\Models\BrandBanner $banner)
    {
        if ($banner->brand_id !== Auth::user()->brand?->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'link_url' => 'nullable|url',
            'cta_text' => 'required|string|max:50',
            'started_at' => 'nullable|date',
            'ended_at' => 'nullable|date',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $data = $request->only(['title', 'description', 'link_url', 'cta_text', 'started_at', 'ended_at', 'budget']);

        if ($request->hasFile('banner_image')) {
            if ($banner->banner_image_url) {
                Storage::disk('public')->delete($banner->banner_image_url);
            }
            $data['banner_image_url'] = $request->file('banner_image')->store('brand-banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('brand.dashboard')->with('success', 'Banner berhasil diperbarui');
    }

    /**
     * Delete Banner
     */
    public function deleteBanner(\App\Models\BrandBanner $banner)
    {
        if ($banner->brand_id !== Auth::user()->brand?->id) {
            abort(403, 'Unauthorized');
        }

        if ($banner->banner_image_url) {
            Storage::disk('public')->delete($banner->banner_image_url);
        }

        $banner->delete();

        return redirect()->route('brand.dashboard')->with('success', 'Banner berhasil dihapus');
    }
}