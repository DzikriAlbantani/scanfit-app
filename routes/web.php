<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\ClosetController;
use App\Http\Controllers\BrandRegisterController;
use App\Http\Controllers\BrandDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClickTrackingController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BulkProductImportController;
use App\Http\Controllers\Brand\BannerController;
use App\Http\Controllers\Brand\BannerPlacementController;
use App\Http\Controllers\Admin\BannerAdminController;
use App\Http\Controllers\BannerClickController;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    
    $brands = \App\Models\Brand::where('status', 'approved')
        ->whereNotNull('logo_url')
        ->limit(6)
        ->get();
    
    return view('welcome', compact('brands'));
});

// Brand Registration (Form)
Route::get('/brand/register', [BrandRegisterController::class, 'showRegistrationForm'])->name('brand.register');
Route::post('/brand/register', [BrandRegisterController::class, 'register'])->name('brand.register.store');

// Public Product & Tracking
Route::get('/products/{item}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{item}/track-click', [ProductController::class, 'trackClick'])->name('products.trackClick');

// Banner Click Tracking
Route::get('/banner/{banner}/click', [BannerClickController::class, 'click'])->name('banner.click');
Route::post('/banner/record-impression', [BannerClickController::class, 'recordImpression'])->name('banner.recordImpression');


/*
|--------------------------------------------------------------------------
| 2. AUTHENTICATED ROUTES (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/setup', [UserProfileController::class, 'create'])->name('profile.setup');
    Route::post('/profile', [UserProfileController::class, 'store'])->name('profile.store');

    // Scan & Closet
    Route::get('/scan', [ScanController::class, 'index'])->name('scan.index');
    Route::post('/scan', [ScanController::class, 'store'])->name('scan.store');
    Route::get('/scan/result/{id}', [ScanController::class, 'result'])->name('scan.result');
    
    // Test subscription status (for debugging)
    Route::get('/test-subscription', function () {
        $user = auth()->user();
        if (!$user) return 'Please login first';
        $user->refresh();
        auth()->setUser($user);
        return [
            'user_id' => $user->id,
            'name' => $user->name,
            'subscription_plan' => $user->subscription_plan,
            'is_premium' => $user->is_premium ? 'TRUE' : 'FALSE',
            'subscription_expires_at' => $user->subscription_expires_at,
            'isPremium()' => $user->isPremium() ? 'TRUE' : 'FALSE',
            'hasActiveSubscription()' => $user->hasActiveSubscription() ? 'TRUE' : 'FALSE',
        ];
    });
    
    Route::resource('closet', ClosetController::class)->except(['create', 'show', 'edit']);
    Route::post('/closet/save', [ClosetController::class, 'save'])->name('closet.save'); // Pindah ke sini jika butuh login
    
    // Outfit Albums
    Route::post('/closet/albums', [ClosetController::class, 'createAlbum'])->name('closet.album.create');
    Route::get('/closet/albums/{album}', [ClosetController::class, 'viewAlbum'])->name('closet.album.view');
    Route::patch('/closet/albums/{album}', [ClosetController::class, 'updateAlbum'])->name('closet.album.update');
    Route::delete('/closet/albums/{album}', [ClosetController::class, 'destroyAlbum'])->name('closet.album.destroy');
    Route::post('/closet/item/add-to-album', [ClosetController::class, 'addItemToAlbum'])->name('closet.item.add-to-album');
    Route::delete('/closet/items/{item}/remove-from-album', [ClosetController::class, 'removeItemFromAlbum'])->name('closet.item.remove-from-album');
    
    Route::get('/explore', [ExploreController::class, 'index'])->name('explore.index');

    // Pricing (canonical) and Premium redirect
    Route::get('/pricing', [PremiumController::class, 'index'])->name('pricing.index');
    Route::get('/premium', function () { return redirect()->route('pricing.index'); })->name('premium.index');

    // Subscription info & management
    Route::get('/subscription/info', [SubscriptionController::class, 'info'])->name('subscription.info');

    // Mock subscription upgrade
    Route::post('/subscription/upgrade/{plan}', [SubscriptionController::class, 'upgrade'])->name('subscription.upgrade');

    // Payment checkout & finish
    Route::get('/checkout/{plan}', [PaymentController::class, 'checkout'])->name('payments.checkout');
    Route::get('/payment/success/{paymentId}', [PaymentController::class, 'success'])->name('payments.success');
    Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payments.finish');
    Route::get('/payment/refresh-subscription', [PaymentController::class, 'refreshSubscription'])->name('payments.refresh-subscription');

    // --- BRAND STATUS PAGES (Wajib di atas Wildcard) ---
    Route::get('/brand/pending', [BrandRegisterController::class, 'pending'])->name('brand.pending');
    Route::get('/brand/rejected', [BrandRegisterController::class, 'rejected'])->name('brand.rejected');

    // --- BRAND DASHBOARD (Wajib di atas Wildcard) ---
    Route::middleware('brand.approved')->prefix('brand')->name('brand.')->group(function () {
        Route::get('/dashboard', [BrandDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/analytics', [BrandDashboardController::class, 'analytics'])->name('analytics');
        Route::get('/api/analytics', [BrandDashboardController::class, 'analyticsData'])->name('analytics.data');
        Route::get('/pricing', function () {
            return view('brand.pricing');
        })->name('pricing');
        Route::post('/upgrade', [BrandDashboardController::class, 'upgradeSubscription'])->name('subscription.upgrade');
        
        // Banner Management Routes (Integrated into Dashboard)
        Route::post('/banner', [BrandDashboardController::class, 'storeBanner'])->name('banner.store');
        Route::patch('/banner/{banner}', [BrandDashboardController::class, 'updateBanner'])->name('banner.update');
        Route::delete('/banner/{banner}', [BrandDashboardController::class, 'deleteBanner'])->name('banner.delete');
        
        // Standalone Banner Routes (for backward compatibility)
        // Arahkan ke dashboard agar tidak dobel halaman
        Route::get('/banners', function () {
            return redirect()->route('brand.dashboard');
        })->name('banners.index');
        Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
        Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
        Route::get('/banners/{banner}', [BannerController::class, 'show'])->name('banners.show');
        Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');
        Route::patch('/banners/{banner}', [BannerController::class, 'update'])->name('banners.update');
        Route::delete('/banners/{banner}', [BannerController::class, 'delete'])->name('banners.delete');

        // Paid Banner Placements
        Route::get('/banners/{banner}/placements/create', [BannerPlacementController::class, 'create'])->name('bannerPlacements.create');
        Route::post('/banners/{banner}/placements', [BannerPlacementController::class, 'store'])->name('bannerPlacements.store');
        Route::get('/banners/{banner}/placements/{placement}/finish', [BannerPlacementController::class, 'finish'])->name('bannerPlacements.finish');
        
        // Bulk Import Routes (HARUS sebelum resource untuk menghindari wildcard match)
        Route::get('/products/csv-template', [BulkProductImportController::class, 'csvTemplate'])->name('products.csv-template');
        Route::post('/products/bulk-import', [BulkProductImportController::class, 'bulkImport'])->name('products.bulk-import');
        
        Route::resource('products', BrandDashboardController::class);
        Route::post('/products/{product}/toggle-status', [BrandDashboardController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::delete('/products/{product}', [BrandDashboardController::class, 'destroyProduct'])->name('products.destroy');
        Route::get('/profile/edit', [BrandDashboardController::class, 'editProfile'])->name('profile.edit');
        Route::patch('/profile', [BrandDashboardController::class, 'updateProfile'])->name('profile.update');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        // Dashboard
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Users Management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/{user}', [AdminController::class, 'userShow'])->name('users.show');
        Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
        
        // Brands Management
        Route::get('/brands', [AdminController::class, 'brands'])->name('brands');
        Route::get('/brands/{brand}', [AdminController::class, 'brandShow'])->name('brands.show');
        Route::patch('/brands/{brand}/approve', [AdminController::class, 'approveBrand'])->name('brands.approve');
        Route::patch('/brands/{brand}/reject', [AdminController::class, 'rejectBrand'])->name('brands.reject');
        Route::patch('/brands/{brand}/update-logo', [AdminController::class, 'updateBrandLogo'])->name('brands.update-logo');
        Route::delete('/brands/{brand}', [AdminController::class, 'deleteBrand'])->name('brands.delete');
        
        // System Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        
        // Activity Logs
        Route::get('/logs', [AdminController::class, 'logs'])->name('logs');

        // Banner Management
        Route::get('/banners', [BannerAdminController::class, 'index'])->name('banners.index');
        Route::get('/banners/{banner}', [BannerAdminController::class, 'show'])->name('banners.show');
        Route::patch('/banners/{banner}/approve', [BannerAdminController::class, 'approve'])->name('banners.approve');
        Route::patch('/banners/{banner}/activate', [BannerAdminController::class, 'activate'])->name('banners.activate');
        Route::patch('/banners/{banner}/deactivate', [BannerAdminController::class, 'deactivate'])->name('banners.deactivate');
        Route::patch('/banners/{banner}/reject', [BannerAdminController::class, 'reject'])->name('banners.reject');
        Route::delete('/banners/{banner}', [BannerAdminController::class, 'delete'])->name('banners.delete');
    });
});

/*
|--------------------------------------------------------------------------
| TEST ROUTES (Hanya untuk Development)
|--------------------------------------------------------------------------
*/
if (config('app.debug')) {
    Route::get('/test-scan-api', function () {
        return response()->json([
            'status' => 'ready',
            'message' => 'Gemini API Setup Complete',
            'api_key_set' => !empty(env('GOOGLE_AI_API_KEY')),
            'instructions' => [
                '1. Buka http://127.0.0.1:8000/scan',
                '2. Upload satu gambar outfit',
                '3. Tunggu proses analisis dari Gemini API',
                '4. Lihat hasil analisis di halaman results',
                '5. Periksa logs di storage/logs/laravel.log untuk debugging'
            ]
        ]);
    });
}

/*
|--------------------------------------------------------------------------
| 3. WILDCARD ROUTES (Halaman Publik Brand)
|--------------------------------------------------------------------------
| TARUH PALING BAWAH. Ini menangkap sisa URL /brand/...
*/
Route::get('/brand/{brand}', [BrandController::class, 'show'])->name('brand.show');

require __DIR__.'/auth.php';

// Midtrans webhook (public, CSRF-exempt)
Route::post('/payments/midtrans/notify', [PaymentController::class, 'webhook'])
    ->withoutMiddleware('\\App\\Http\\Middleware\\VerifyCsrfToken');

// Development: Manual webhook trigger (simulate payment success)
Route::post('/test-trigger-webhook', function (Illuminate\Http\Request $request) {
    if (!in_array(config('app.env'), ['local', 'development'])) {
        return response()->json(['error' => 'Not available in production'], 403);
    }

    $paymentId = $request->query('payment_id');
    $payment = \App\Models\Payment::findOrFail($paymentId);

    // Simulate Midtrans webhook payload
    $payload = [
        'order_id' => $payment->order_id,
        'transaction_id' => 'test-' . time(),
        'transaction_status' => 'settlement',
        'payment_type' => 'bank_transfer',
    ];

    // Trigger webhook manually
    $response = app(\App\Http\Controllers\PaymentController::class)->webhook(
        new \Illuminate\Http\Request($payload)
    );

    return response()->json([
        'status' => 'success',
        'message' => 'Webhook processed',
        'payment_id' => $payment->id,
        'order_id' => $payment->order_id
    ]);
})
->middleware(['auth'])
->name('test.trigger-webhook');