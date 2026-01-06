<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OutfitAnalyzer;
use App\Models\Scan;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ScanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Force refresh user data from database to get latest subscription status
        if ($user) {
            $user->refresh();
            // Update session with refreshed user
            auth()->setUser($user);
        }
        
        $limit = (int)config('scan.free_limit', 10);
        $used = $user ? $user->scans()->count() : 0;
        $remaining = max(0, $limit - $used);

        return view('scan.index', compact('remaining', 'limit', 'used'));
    }

    public function store(Request $request)
    {
        try {
            // Enforce subscription quota for scans
            $user = auth()->user();
            if ($user && !$user->hasQuotaFor('scan')) {
                return redirect()->route('pricing.index')
                    ->with('error', 'Kuota habis! Upgrade untuk akses lebih.');
            }
            // Validate image upload
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            ]);

            // Store uploaded image
            $path = $request->file('image')->store('scans', 'public');
            $fullPath = storage_path('app/public/' . $path);

            Log::info('Image uploaded successfully', ['path' => $path, 'full_path' => $fullPath]);

            // Initialize Outfit Analyzer
            $analyzer = new OutfitAnalyzer();
            
            // Perform AI analysis using Gemini API
            $analysisResult = $analyzer->analyze($fullPath);

            // Guard against weak analysis - focus on confidence and items
            $itemsCount = count($analysisResult['clothing_items'] ?? []);
            $confidence = (int)($analysisResult['confidence'] ?? 0);

            // If fallback but still has minimal confidence, allow showing result
            $isFallback = !empty($analysisResult['fallback']);
            $tooWeak = ($itemsCount < 2 || $confidence < 50) && !$isFallback;

            if (!empty($analysisResult['needs_rescan']) && !$isFallback) {
                $tooWeak = true;
            }

            if ($tooWeak) {
                Log::warning('Scan result flagged as weak; asking user to rescan', [
                    'items' => $itemsCount,
                    'confidence' => $confidence,
                    'fallback' => $isFallback,
                ]);
                return redirect()->back()
                    ->with('error', 'Analisis kurang akurat. Silakan unggah foto yang lebih jelas atau coba ulang.');
            }

            Log::info('Analysis completed', ['result' => $analysisResult]);

            // Save scan result to database
            $scan = Scan::create([
                'user_id' => auth()->id(),
                'image_path' => $path,
                'scan_result' => json_encode($analysisResult),
                'match_percentage' => $analysisResult['confidence'] ?? 80,
            ]);

            // Increment monthly scan usage on success
            if ($user) {
                $user->incrementMonthlyScanUsage();
            }

            return redirect()->route('scan.result', $scan->id)
                           ->with('success', 'Scan berhasil! Lihat hasil analisis Anda.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                           ->withErrors($e->errors())
                           ->with('error', 'Upload gambar gagal. Pastikan file adalah gambar valid.');
        } catch (\Exception $e) {
            Log::error('Scan processing error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memproses gambar. Silakan coba lagi.');
        }
    }

    public function result($id)
    {
        try {
            // Retrieve scan record - ensure it belongs to authenticated user
            $scan = Scan::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

            // Decode scan result
            $scanData = json_decode($scan->scan_result, true);

            // Get recommendations from the analysis (already grounded to real products)
            $recommendations = $scanData['recommendations'] ?? [];

            // If missing, recompute using detected style/colors/items
            if (empty($recommendations)) {
                $detectedStyle = $scanData['style_name'] ?? null;
                $colors = $scanData['colors'] ?? [];
                $items = $scanData['clothing_items'] ?? [];
                $analyzer = new OutfitAnalyzer();
                $recommendations = $analyzer->getRecommendations($detectedStyle ?? 'casual', $colors, $items);
            }

            return view('scan.result', compact('scan', 'scanData', 'recommendations'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Scan result not found or unauthorized', [
                'scan_id' => $id,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('scan.index')
                           ->with('error', 'Hasil scan tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error fetching scan result', [
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('scan.index')
                           ->with('error', 'Terjadi kesalahan saat memuat hasil scan.');
        }
    }

    /**
     * Get product recommendations based on style
     */
    // Legacy fallback kept for compatibility (not used now)
    private function getProductRecommendations($style = null)
    {
        $analyzer = new OutfitAnalyzer();
        return $analyzer->getRecommendations($style ?? 'casual');
    }
}
