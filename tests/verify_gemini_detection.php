<?php

/**
 * TEST SCRIPT - VERIFY GEMINI AI DETECTION
 * 
 * Jalankan dari terminal:
 * php artisan tinker < tests/verify_gemini_detection.php
 * 
 * Atau di tinker:
 * > include 'tests/verify_gemini_detection.php';
 */

use App\Services\OutfitAnalyzer;
use Illuminate\Support\Facades\Log;

echo "🤖 TESTING GEMINI AI OUTFIT DETECTION\n";
echo "=====================================\n\n";

// Get sample image path or use test image
$testImagePath = storage_path('app/public/scans');

// List available test images
if (is_dir($testImagePath)) {
    $files = array_diff(scandir($testImagePath), ['.', '..']);
    
    if (!empty($files)) {
        echo "📁 Available test images in storage/app/public/scans:\n";
        foreach ($files as $file) {
            echo "  • $file\n";
        }
        echo "\n";
    }
}

// Test with first available image
$testImages = glob($testImagePath . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);

if (empty($testImages)) {
    echo "⚠️  No test images found!\n\n";
    echo "📝 INSTRUCTIONS:\n";
    echo "1. Upload an outfit image at: http://127.0.0.1:8000/scan\n";
    echo "2. After upload completes, the image will be saved to: storage/app/public/scans/\n";
    echo "3. Run this test again\n\n";
    exit;
}

$firstImage = reset($testImages);
echo "🖼️  Testing with image: " . basename($firstImage) . "\n";
echo "📄 Full path: $firstImage\n\n";

try {
    echo "🔄 Initializing OutfitAnalyzer...\n";
    $analyzer = new OutfitAnalyzer();
    
    echo "📸 Analyzing outfit image...\n";
    echo "⏳ This may take 5-10 seconds (connecting to Gemini API)...\n\n";
    
    $result = $analyzer->analyze($firstImage);
    
    echo "✅ ANALYSIS COMPLETE!\n\n";
    echo "════════════════════════════════════════════\n";
    
    // Display results
    echo "📊 DETECTED STYLE:\n";
    echo "   Style: " . ($result['style_name'] ?? 'Not detected') . "\n";
    echo "   Confidence: " . ($result['confidence'] ?? 'N/A') . "%\n";
    echo "   Description: " . ($result['description'] ?? 'Not detected') . "\n\n";
    
    echo "🌈 DETECTED COLORS:\n";
    if (!empty($result['colors'])) {
        foreach ($result['colors'] as $i => $color) {
            echo "   " . ($i + 1) . ". " . $color['name'] . "\n";
            echo "      Hex: " . $color['hex'] . "\n";
            echo "      Percentage: " . $color['percentage'] . "%\n";
        }
    } else {
        echo "   ❌ No colors detected\n";
    }
    echo "\n";
    
    echo "🛍️  PRODUCT RECOMMENDATIONS:\n";
    if (!empty($result['recommendations'])) {
        foreach ($result['recommendations'] as $i => $product) {
            echo "   " . ($i + 1) . ". " . $product['name'] . "\n";
            echo "      Brand: " . ($product['brand']['name'] ?? 'Unknown') . "\n";
            echo "      Price: Rp " . number_format($product['price'], 0, ',', '.') . "\n";
        }
    } else {
        echo "   ❌ No recommendations found\n";
    }
    echo "\n";
    
    echo "════════════════════════════════════════════\n\n";
    
    // Full response for debugging
    echo "📋 FULL JSON RESPONSE:\n";
    echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n\n";
    
    // Verification checklist
    echo "✅ VERIFICATION CHECKLIST:\n";
    echo "   ✓ Style detected: " . (!empty($result['style_name']) ? "YES (" . $result['style_name'] . ")" : "NO ❌") . "\n";
    echo "   ✓ Colors detected: " . (!empty($result['colors']) ? "YES (" . count($result['colors']) . " colors)" : "NO ❌") . "\n";
    echo "   ✓ Confidence score: " . (!empty($result['confidence']) ? "YES (" . $result['confidence'] . "%)" : "NO ❌") . "\n";
    echo "   ✓ Recommendations: " . (!empty($result['recommendations']) ? "YES (" . count($result['recommendations']) . " items)" : "NO ❌") . "\n";
    echo "\n";
    
    // Overall status
    $isWorking = !empty($result['style_name']) && !empty($result['colors']) && !empty($result['recommendations']);
    echo $isWorking ? "🎉 AI DETECTION IS WORKING PROPERLY!\n" : "⚠️  Some detection features may not be working\n";
    
} catch (Exception $e) {
    echo "❌ ERROR OCCURRED:\n";
    echo "Message: " . $e->getMessage() . "\n\n";
    
    echo "🔍 DEBUGGING INFO:\n";
    if (strpos($e->getMessage(), 'API') !== false) {
        echo "   • This appears to be an API error\n";
        echo "   • Check your GOOGLE_AI_API_KEY in .env\n";
        echo "   • Verify internet connection\n";
    } elseif (strpos($e->getMessage(), 'file') !== false) {
        echo "   • File access issue\n";
        echo "   • Check if image file exists\n";
        echo "   • Check file permissions\n";
    }
    
    echo "\n📄 Full error trace:\n";
    echo $e->getTraceAsString() . "\n";
    
    // Check logs
    echo "\n📝 Check logs: storage/logs/laravel.log\n";
}

echo "\n";
