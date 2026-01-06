<?php

/**
 * TEST ROUTE - SCAN DENGAN GEMINI API
 * Gunakan untuk testing sebelum di-deploy
 * 
 * URL: http://127.0.0.1:8000/test-scan
 */

use Illuminate\Support\Facades\Route;
use App\Services\OutfitAnalyzer;

Route::get('/test-scan', function () {
    // Test dengan image URL (dari URL public yang sudah ada)
    // Atau bisa gunakan sample image path
    
    $testImagePath = storage_path('app/public/scans/sample.jpg');
    
    // Jika file tidak ada, buat path dummy
    if (!file_exists($testImagePath)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Test image tidak ditemukan di: ' . $testImagePath,
            'instructions' => [
                '1. Upload satu gambar outfit di halaman /scan',
                '2. Periksa hasil analisis di halaman results',
                '3. Lihat logs di storage/logs/laravel.log untuk debugging'
            ]
        ], 404);
    }

    try {
        $analyzer = new OutfitAnalyzer();
        $result = $analyzer->analyze($testImagePath);

        return response()->json([
            'status' => 'success',
            'message' => 'Gemini API Analysis successful!',
            'data' => $result
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => config('app.debug') ? $e->getTraceAsString() : null
        ], 500);
    }
});
