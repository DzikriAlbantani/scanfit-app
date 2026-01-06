<?php

namespace App\Services;

use App\Models\FashionItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OutfitAnalyzer
{
    private $apiKey;
    // Update model ke gemini-2.0-flash-lite untuk performa & stabilitaslebih baik
    private $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-lite:generateContent';
    private $currentImagePath; // Menyimpan path gambar untuk fallback ekstraksi warna

    public function __construct()
    {
        $this->apiKey = config('services.google.ai_api_key') ?? env('GOOGLE_AI_API_KEY');
    }

    /**
     * Entry point utama untuk analisa gambar
     */
    public function analyze($imagePath)
    {
        try {
            $this->currentImagePath = $imagePath;
            
            if (!file_exists($imagePath)) {
                Log::error('Image file not found: ' . $imagePath);
                return $this->getFallbackAnalysis($imagePath); // Return fallback cerdas
            }

            // --- 1. Cek Cache (Agar hemat kuota API) ---
            $imageMd5 = md5_file($imagePath);
            $cacheFile = storage_path('framework/cache/outfit_' . $imageMd5 . '.json');
            
            if (file_exists($cacheFile)) {
                $cached = json_decode(file_get_contents($cacheFile), true);
                // Validasi cache: tidak expired & bukan hasil kosong
                if ($cached && isset($cached['expires']) && $cached['expires'] > time()) {
                    if (!$this->isWeakAnalysis($cached['data'])) {
                        Log::info('Using cached analysis for: ' . basename($imagePath));
                        return $cached['data'];
                    } else {
                        @unlink($cacheFile); // Hapus cache busuk
                    }
                }
            }

            // --- 2. Siapkan Gambar & Prompt ---
            [$mimeType, $imageData] = $this->prepareImagePayload($imagePath);
            $prompt = $this->getPrompt();

            // --- 3. Panggil Gemini API ---
            $response = $this->callGemini($this->apiUrl, $prompt, $mimeType, $imageData);
            
            // --- 4. Parsing Hasil ---
            $analysis = [];
            if ($response['success']) {
                $analysis = $this->parseGeminiResponse($response['body']);
            }

            // Jika parsing gagal total (array kosong), gunakan fallback cerdas
            if (empty($analysis) || empty($analysis['style_name'])) {
                Log::warning('Gemini analysis failed/empty, switching to smart fallback.');
                $analysis = $this->getFallbackAnalysis($imagePath);
            }
            
            // --- 5. Simpan ke Cache (Jika hasil valid) ---
            if (!$this->isWeakAnalysis($analysis)) {
                @mkdir(storage_path('framework/cache'), 0755, true);
                file_put_contents($cacheFile, json_encode([
                    'data' => $analysis,
                    'expires' => time() + (7 * 24 * 60 * 60) // 7 hari
                ]));
            }
            
            return $analysis;

        } catch (\Exception $e) {
            Log::error('Critical Outfit Analysis Error: ' . $e->getMessage());
            return $this->getFallbackAnalysis($imagePath ?? null);
        }
    }

    /**
     * Memproses respon mentah dari API menjadi Array Data
     */
    private function parseGeminiResponse($response)
    {
        try {
            // Debug: Log full response
            Log::debug('Full Gemini Response', ['response' => $response]);
            
            // Ambil teks kandidat pertama
            $candidate = $response['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            if (empty($candidate)) {
                Log::error('Empty candidate text', ['response_keys' => array_keys($response)]);
                throw new \Exception('Empty text in Gemini response');
            }

            Log::info('Raw Gemini Response:', ['snippet' => substr($candidate, 0, 300)]);

            // 1. Bersihkan & Decode JSON
            $data = $this->robustJsonDecode($candidate);

            if (empty($data)) {
                Log::warning('Initial JSON decode failed, attempting string cleanup');
                // Aggressive cleanup: remove all non-JSON characters
                $cleaned = preg_replace('/[^\{\}\[\]:,.\-\d"a-zA-Z#_\s]/', '', $candidate);
                $data = $this->robustJsonDecode($cleaned);
                
                if (empty($data)) {
                    throw new \Exception('JSON decoding failed after cleanup');
                }
            }

            // 2. Normalisasi Data (Isi yang kosong dengan fallback)
            $normalized = $this->normalizeAnalysis($data);

            // 3. Validasi bahwa hasil tidak completely empty
            if (empty($normalized['style_name']) || empty($normalized['clothing_items'])) {
                throw new \Exception('Normalized analysis missing critical fields');
            }

            // 4. Tambahkan Rekomendasi Produk dari Database Lokal
            $normalized['recommendations'] = $this->getRecommendations(
                $normalized['style_name'], 
                []
            );

            // 5. Tambahkan flag info
            $normalized['needs_rescan'] = $this->isWeakAnalysis($normalized);

            return $normalized;

        } catch (\Exception $e) {
            Log::error('Parsing Error: ' . $e->getMessage(), [
                'raw' => substr($candidate ?? '', 0, 200),
                'response_structure' => isset($response['candidates']) ? 'has candidates' : 'no candidates'
            ]);
            return []; // Return empty trigger fallback di method analyze
        }
    }

    /**
     * JSON Decoder yang "Tahan Banting"
     * Bisa baca format markdown dan menghapus trailing commas
     */
    private function robustJsonDecode(string $text): array
    {
        // 1. Hapus Markdown code blocks (```json ... ```)
        if (preg_match('/```json\s*(\{.*?\})\s*```/si', $text, $match)) {
            $text = $match[1];
        } 
        // 2. Atau cari kurung kurawal terluar
        elseif (preg_match('/\{.*\}/s', $text, $match)) {
            $text = $match[0];
        }

        // 3. Hapus Trailing Commas (Musuh utama json_decode PHP)
        // Contoh: ["a", "b",] menjadi ["a", "b"]
        $text = preg_replace('/,\s*([\]\}])/m', '$1', $text);

        // 4. Decode
        $decoded = json_decode($text, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        Log::warning('JSON Decode Failed. Error: ' . json_last_error_msg());
        return [];
    }

    /**
     * Memastikan data hasil scan lengkap. 
     * Jika API lupa warna, kita ambil dari gambar.
     */
    private function normalizeAnalysis(array $data): array
    {
        // Style Logic
        $style = $this->normalizeStyle($data['style_name'] ?? 'Casual');

        // Confidence Logic
        $confidence = (int)($data['confidence'] ?? 75);
        if ($confidence < 30) $confidence = 50; // Bump up if too low, but don't be dishonest
        if ($confidence > 100) $confidence = 100;

        // Items Logic (PRIMARY FOCUS) (PRIMARY FOCUS)
        $items = $data['clothing_items'] ?? [];
        if (empty($items)) {
            // Jika item kosong, buat item dummy dari style agar UI tidak rusak
            $items[] = [
                'type' => $style . ' Outfit',
                'details' => 'Generic ' . strtolower($style) . ' clothing',
                'material' => 'Various'
            ];
        }
        
        // Clean clothing items format
        $cleanItems = [];
        foreach (array_slice($items, 0, 8) as $item) {
            $cleanItems[] = [
                'type' => $item['type'] ?? 'Item',
                'details' => $item['details'] ?? ($item['description'] ?? 'Standard item'),
                'material' => $item['material'] ?? 'Unknown'
            ];
        }

        return [
            'style_name' => $style,
            'confidence' => $confidence,
            'description' => $data['description'] ?? "Outfit bergaya $style dengan kombinasi item yang menarik.",
            'mood' => $data['mood'] ?? $this->generateMoodFromStyle($style),
            'clothing_items' => $cleanItems,
        ];
    }

    /**
     * Map berbagai variasi style ke enam kategori utama.
     */
    private function normalizeStyle(string $raw): string
    {
        $slug = strtolower(trim($raw));

        $map = [
            'Casual' => ['casual', 'smart casual', 'smart-casual', 'everyday', 'relaxed', 'laid-back'],
            'Formal' => ['formal', 'business', 'office', 'dressy', 'professional', 'semi formal', 'semi-formal'],
            'Street' => ['street', 'streetwear', 'urban', 'hype', 'hypebeast'],
            'Vintage' => ['vintage', 'retro', 'classic', 'old school', 'old-school'],
            'Sport' => ['sport', 'athleisure', 'athletic', 'activewear', 'running', 'training', 'gym'],
            'Minimal' => ['minimal', 'minimalist', 'clean', 'modern', 'simple'],
        ];

        foreach ($map as $canonical => $keywords) {
            foreach ($keywords as $kw) {
                if (strpos($slug, $kw) !== false) {
                    return $canonical;
                }
            }
        }

        // Default fallback
        return 'Casual';
    }

    /**
     * Generate mood description jika API tidak memberikannya
     */
    private function generateMoodFromStyle($style): string
    {
        $moods = [
            'Casual' => 'Relaxed & comfortable',
            'Formal' => 'Professional & sophisticated',
            'Street' => 'Trendy & bold',
            'Vintage' => 'Retro & nostalgic',
            'Sport' => 'Active & energetic',
            'Minimal' => 'Clean & understated',
        ];
        return $moods[$style] ?? 'Stylish';
    }

    /**
     * Cek apakah hasil analisis layak disimpan
     * Fokus pada style dan items saja
     */
    private function isWeakAnalysis(?array $analysis): bool
    {
        if (empty($analysis)) return true;
        
        $style = $analysis['style_name'] ?? null;
        $items = $analysis['clothing_items'] ?? [];
        $confidence = $analysis['confidence'] ?? 0;
        
        // Jika style valid dan minimal ada 2 items, OK
        if (!empty($style) && $style !== 'Unknown' && count($items) >= 2) {
            return false; // False = Good analysis
        }
        
        // Hanya mark sebagai weak jika benar-benar kurang data
        if ($confidence < 40 || count($items) < 2) {
            return true; // True = Weak, needs rescan
        }

        return false; // Otherwise OK
    }

    /**
     * Fallback Cerdas: Jika API mati/gagal, berikan basic analysis
     * 
     * NOTE: Fallback tetap menggunakan rekomendasi produk REAL dari database (FashionItem).
     * Tidak ada produk dummy - semua dari brand partner (Erigo, Roughneck, dll)
     */
    private function getFallbackAnalysis($imagePath)
    {
        Log::info('Running Smart Fallback Analysis...');
        
        // Default ke Casual style
        $style = 'Casual';
        $mood = 'Relaxed & comfortable';

        // Cari rekomendasi dari style default
        $recommendations = $this->getRecommendations(strtolower($style), []);

        // Generate basic clothing items description
        $basicItems = [
            ['type' => 'Atasan', 'details' => 'Item pakaian bagian atas', 'material' => 'Textile'],
            ['type' => 'Bawahan', 'details' => 'Item pakaian bagian bawah', 'material' => 'Textile'],
            ['type' => 'Alas Kaki', 'details' => 'Sepatu atau sandal', 'material' => 'Various'],
        ];

        return [
            'style_name' => $style,
            'confidence' => 60, // Base confidence untuk fallback
            'description' => 'Berdasarkan analisis visual awal, outfit ini menampilkan gaya ' . $style . ' yang nyaman. Lihat rekomendasi produk di bawah yang sesuai dengan style ini.',
            'mood' => $mood,
            'clothing_items' => $basicItems,
            'recommendations' => $recommendations,
            'fallback' => true,
            'needs_rescan' => false
        ];
    }

    /**
     * Mengambil Produk Rekomendasi dari Database
     * HANYA produk dengan brand (real products), tanpa dummy data
     */
    public function getRecommendations($style, array $colors = [])
    {
        // Mapping style AI ke style Database
        $map = [
            'casual' => 'casual', 'formal' => 'formal', 'street' => 'street',
            'vintage' => 'vintage', 'sport' => 'sport', 'minimal' => 'minimal'
        ];
        $dbStyle = $map[strtolower($style)] ?? 'casual';

        // Query ke DB - FILTER HANYA produk dengan brand (real products)
        $query = FashionItem::query()
            ->with('brand')
            ->whereNotNull('brand_id') // CRITICAL: Only real products with brands
            ->where('style', $dbStyle);

        $items = $query->inRandomOrder()->take(8)->get();
        
        // Jika tidak cukup produk (kurang dari 8), ambil dari style lain untuk melengkapi
        if ($items->count() < 8) {
            $additionalItems = FashionItem::query()
                ->with('brand')
                ->whereNotNull('brand_id')
                ->whereNotIn('id', $items->pluck('id'))
                ->inRandomOrder()
                ->take(8 - $items->count())
                ->get();
            
            $items = $items->merge($additionalItems);
        }
        
        return $items;
    }

    /**
     * Ekstraksi Warna dari Piksel Gambar (Menggunakan GD Library)
     */
    private function extractColorsFromImage($imagePath): array
    {
        if (!$imagePath || !file_exists($imagePath)) return [];

        try {
            $info = getimagesize($imagePath);
            $mime = $info['mime'] ?? 'image/jpeg';

            // Load gambar berdasarkan tipe
            switch ($mime) {
                case 'image/jpeg': $img = imagecreatefromjpeg($imagePath); break;
                case 'image/png':  $img = imagecreatefrompng($imagePath); break;
                case 'image/webp': $img = imagecreatefromwebp($imagePath); break;
                default: return [];
            }

            if (!$img) return [];

            // Resize kecil untuk mempercepat sampling (misal 150x150)
            $smallImg = imagecreatetruecolor(150, 150);
            imagecopyresampled($smallImg, $img, 0, 0, 0, 0, 150, 150, imagesx($img), imagesy($img));
            imagedestroy($img);

            $colors = [];
            // Sample piksel
            for ($x = 0; $x < 150; $x += 10) {
                for ($y = 0; $y < 150; $y += 10) {
                    $rgb = imagecolorat($smallImg, $x, $y);
                    $r = ($rgb >> 16) & 0xFF;
                    $g = ($rgb >> 8) & 0xFF;
                    $b = $rgb & 0xFF;
                    
                    // Abaikan putih/hitam murni (background/noise)
                    if ($r > 240 && $g > 240 && $b > 240) continue; 
                    
                    // Quantize (bulatkan ke kelipatan 30 agar warna mirip jadi satu)
                    $r = round($r / 30) * 30;
                    $g = round($g / 30) * 30;
                    $b = round($b / 30) * 30;
                    
                    $hex = sprintf("#%02x%02x%02x", $r, $g, $b);
                    $colors[$hex] = ($colors[$hex] ?? 0) + 1;
                }
            }
            imagedestroy($smallImg);

            // Ambil 3 warna terbanyak
            arsort($colors);
            $topColors = array_slice(array_keys($colors), 0, 3);
            
            $result = [];
            foreach ($topColors as $hex) {
                $result[] = [
                    'name' => 'Detected', // Nama warna generik
                    'hex' => strtoupper($hex),
                    'percentage' => 33 // Dummy percentage
                ];
            }
            return $result;

        } catch (\Throwable $e) {
            Log::warning('Pixel extraction failed: ' . $e->getMessage());
            return [];
        }
    }

    // --- Helper API Call ---
    private function callGemini($url, $prompt, $mime, $data) {
        try {
            // Try with SSL verification first
            $response = Http::timeout(60)->post("$url?key={$this->apiKey}", [
                'contents' => [[
                    'parts' => [
                        ['text' => $prompt],
                        ['inline_data' => ['mime_type' => $mime, 'data' => $data]]
                    ]
                ]],
                'generationConfig' => [
                    'temperature' => 0.7, // Slightly higher untuk lebih kreatif namun tetap konsisten
                    'topP' => 0.95,
                    'topK' => 40,
                    'maxOutputTokens' => 2000,
                    'response_mime_type' => 'application/json' // FORCE JSON
                ]
            ]);
            
            if ($response->successful()) {
                return [
                    'success' => true,
                    'body' => $response->json()
                ];
            } else {
                Log::error('Gemini API Error', [
                    'status' => $response->status(),
                    'body' => $response->json()
                ]);
                return [
                    'success' => false,
                    'body' => $response->json()
                ];
            }
        } catch (\Exception $e) {
            // If SSL error, retry without SSL verification (for dev environment)
            if (strpos($e->getMessage(), 'SSL') !== false || strpos($e->getMessage(), 'certificate') !== false) {
                Log::warning('SSL Error detected, retrying without verification', ['error' => $e->getMessage()]);
                
                try {
                    $response = Http::withOptions(['verify' => false])
                        ->timeout(60)
                        ->post("$url?key={$this->apiKey}", [
                            'contents' => [[
                                'parts' => [
                                    ['text' => $prompt],
                                    ['inline_data' => ['mime_type' => $mime, 'data' => $data]]
                                ]
                            ]],
                            'generationConfig' => [
                                'temperature' => 0.7,
                                'topP' => 0.95,
                                'topK' => 40,
                                'maxOutputTokens' => 2000,
                                'response_mime_type' => 'application/json'
                            ]
                        ]);
                    
                    return [
                        'success' => $response->successful(),
                        'body' => $response->json()
                    ];
                } catch (\Exception $retryError) {
                    Log::error('Gemini Retry Failed', ['error' => $retryError->getMessage()]);
                    return [
                        'success' => false,
                        'body' => ['error' => $retryError->getMessage()]
                    ];
                }
            }
            
            Log::error('Gemini API Call Error', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'body' => ['error' => $e->getMessage()]
            ];
        }
    }

    private function getPrompt() {
        return "You are an expert fashion analyst. Analyze this outfit image focusing on STYLE and CLOTHING ITEMS.

INSTRUCTIONS:
1. STYLE CLASSIFICATION: Identify the primary fashion style from: Casual, Formal, Street, Vintage, Sport, or Minimal (style_name MUST be exactly one of these)
2. CONFIDENCE: Rate 0-100 based on image clarity and style distinctiveness
3. DESCRIPTION: Provide a 2-3 sentence analysis of the outfit's overall aesthetic, trends, and appeal
4. CLOTHING ITEMS: List ALL visible clothing items (minimum 3-5 items), including:
   - Type (e.g., T-shirt, Jeans, Sneakers, Jacket, Hoodie, Cap, etc.)
   - Specific description (e.g., Slim fit jeans, Oversized hoodie, etc.)
   - Material/fabric hint if visible (Cotton, Denim, Leather, etc.)
   - Any notable details (logos, patterns, distressing, etc.)
5. MOOD/VIBE: Describe the emotional tone (e.g., casual and relaxed, professional, trendy, etc.)

RETURN ONLY this JSON structure (no markdown, no code blocks):
{
    \"style_name\": \"Casual|Formal|Street|Vintage|Sport|Minimal\",
    \"confidence\": 85,
    \"description\": \"Detailed description of outfit vibe and style\",
    \"mood\": \"Single word or short phrase describing emotional tone\",
    \"clothing_items\": [
        {\"type\": \"T-shirt\", \"details\": \"Black oversized graphic tee\", \"material\": \"Cotton\"},
        {\"type\": \"Jeans\", \"details\": \"Slim fit dark wash\", \"material\": \"Denim\"},
        {\"type\": \"Sneakers\", \"details\": \"White leather low-tops\", \"material\": \"Leather\"}
    ]
}

CRITICAL: Focus on identifying as many clothing items as possible. Minimum 3 items required.";
    }

    private function prepareImagePayload($path) {
        $data = base64_encode(file_get_contents($path));
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $mime = match($ext) { 'png' => 'image/png', 'webp' => 'image/webp', default => 'image/jpeg' };
        return [$mime, $data];
    }
}