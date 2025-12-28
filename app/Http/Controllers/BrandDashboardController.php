<?php

namespace App\Http\Controllers;

use App\Models\FashionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        $totalScanMatches = \App\Models\Scan::whereNotNull('scan_result')
            ->get()
            ->filter(function ($scan) use ($brand) {
                // Parse scan_result jika JSON string
                $result = is_string($scan->scan_result) ? json_decode($scan->scan_result, true) : $scan->scan_result;
                if (!is_array($result) || !isset($result['items'])) {
                    return false;
                }
                // Cek apakah ada produk dari brand ini dalam recommendations
                foreach ($result['items'] as $item) {
                    if (isset($item['brand_id']) && $item['brand_id'] == $brand->id) {
                        return true;
                    }
                }
                return false;
            })
            ->count();
        
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
        $days = [];
        $clicksData = [];
        $scansData = [];
        $savesData = [];

        // Generate last 30 days
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateString = $date->format('Y-m-d');
            $days[] = $date->format('d M');

            // Count clicks for this day (using created_at from fashion_items as proxy)
            // In production, you'd have a clicks tracking table with timestamps
            $dailyClicks = $brand->fashionItems()
                ->whereDate('created_at', '<=', $date)
                ->sum('clicks_count');
            
            // For demo: generate realistic trend
            $baseClicks = max(0, $dailyClicks / 30);
            $clicksData[] = round($baseClicks + rand(-10, 30));

            // Count scans with brand products for this day
            $dailyScans = \App\Models\Scan::whereDate('created_at', $dateString)
                ->get()
                ->filter(function ($scan) use ($brand) {
                    $result = is_string($scan->scan_result) ? json_decode($scan->scan_result, true) : $scan->scan_result;
                    if (!is_array($result) || !isset($result['items'])) {
                        return false;
                    }
                    foreach ($result['items'] as $item) {
                        if (isset($item['brand_id']) && $item['brand_id'] == $brand->id) {
                            return true;
                        }
                    }
                    return false;
                })
                ->count();
            $scansData[] = $dailyScans;

            // Count saves for this day
            $dailySaves = \App\Models\ClosetItem::whereIn(
                'fashion_item_id',
                $brand->fashionItems()->pluck('id')
            )
            ->whereDate('created_at', $dateString)
            ->count();
            $savesData[] = $dailySaves;
        }

        return [
            'labels' => $days,
            'clicks' => $clicksData,
            'scans' => $scansData,
            'saves' => $savesData,
        ];
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

        // Ambil produk beserta save count untuk analitik
        $products = $brand->fashionItems()
            ->withCount(['closetItems as saves_count'])
            ->get();

        $totalViews   = $products->sum('clicks_count');
        $totalSaves   = $products->sum('saves_count');
        $activeCount  = $products->where('status', 'active')->count();

        // Hitung conversion & engagement
        $conversionRate = $totalViews > 0 ? round(($totalSaves / $totalViews) * 100, 1) : 0.0;

        // Engagement rate: kombinasi tindakan (views + saves) dibanding total views (jika ada)
        $engagementRate = $totalViews > 0 ? round((($totalSaves + $totalViews) / $totalViews) * 100, 1) : 0.0;

        // Chart data 30 hari terakhir (reuse helper)
        $chartData = $this->prepare30DayChartData($brand);

        // Top performing products (berdasar clicks + saves)
        $topProducts = $products
            ->map(function ($item) {
                $item->engagement_score = $item->clicks_count + $item->saves_count;
                return $item;
            })
            ->sortByDesc('engagement_score')
            ->take(10)
            ->values();

        $analytics = [
            'total_views'   => $totalViews,
            'active_products' => $activeCount,
            'conversion_rate' => $conversionRate,
            'engagement_rate' => $engagementRate,
            'total_saves'     => $totalSaves,
            'top_performing_products' => $topProducts,
            'chart' => $chartData,
        ];

        return view('brand.analytics', compact('brand', 'analytics'));
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