<?php

namespace App\Http\Controllers;

use App\Models\FashionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class BulkProductImportController extends Controller
{
    /**
     * Generate and download CSV template
     */
    public function csvTemplate()
    {
        $headers = [
            'name', 'category', 'price', 'stock', 'description', 'original_price',
            'style', 'fit_type', 'gender_target', 'dominant_color', 'sizes', 'colors',
            'image_url', 'link_shopee', 'link_tokopedia', 'link_tiktok', 'link_lazada'
        ];

        $samples = [
            [
                'Oversized Cotton T-Shirt', 'tops', '99000', '50', 'Premium cotton t-shirt perfect for casual wear', '129000',
                'casual', 'loose', 'unisex', 'Black', 'S,M,L,XL', 'Black,White,Navy',
                'https://example.com/image1.jpg',
                'https://shopee.example/item1', 'https://tokopedia.example/item1', 'https://tiktok.example/item1', 'https://lazada.example/item1'
            ],
            [
                'Slim Fit Jeans', 'bottoms', '249000', '30', 'Comfortable slim fit jeans in dark blue', '329000',
                'casual', 'slim', 'male', 'Dark Blue', 'S,M,L,XL', 'Dark Blue',
                'https://example.com/image2.jpg',
                'https://shopee.example/item2', 'https://tokopedia.example/item2', 'https://tiktok.example/item2', 'https://lazada.example/item2'
            ],
            [
                'Floral Dress', 'dresses', '199000', '25', 'Beautiful floral print dress ideal for summer', '259000',
                'casual', 'regular', 'female', 'Multi Color', 'S,M,L', 'Pink,Blue,Yellow',
                'https://example.com/image3.jpg',
                'https://shopee.example/item3', 'https://tokopedia.example/item3', 'https://tiktok.example/item3', 'https://lazada.example/item3'
            ],
        ];

        $filename = 'scanfit-produk-template-' . date('Y-m-d') . '.csv';
        
        ob_start();
        $output = fopen('php://output', 'w');
        
        // Headers
        fputcsv($output, $headers);
        
        // Sample data
        foreach ($samples as $row) {
            fputcsv($output, $row);
        }
        
        fclose($output);
        $csv = ob_get_clean();

        return response()->streamDownload(function() use ($csv) {
            echo $csv;
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Process bulk CSV import
     */
    public function bulkImport(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120', // max 5MB
        ]);

        try {
            $file = $request->file('csv_file');
            $path = $file->getRealPath();
            
            // Read CSV file
            $csv = array_map('str_getcsv', file($path));
            $headers = array_map('trim', $csv[0]);
            
            // Validate headers
            $requiredColumns = ['name', 'category', 'price'];
            $missingColumns = array_diff($requiredColumns, $headers);
            
            if (!empty($missingColumns)) {
                return back()->withErrors('Kolom wajib diisi: ' . implode(', ', $missingColumns));
            }

            // Ensure we have a valid brand context
            $brandId = Auth::user()->brand?->id;
            if (!$brandId) {
                return back()->withErrors('Brand tidak ditemukan atau belum disetujui.');
            }
            $successCount = 0;
            $errorCount = 0;
            $errors = [];
            $duplicates = [];

            // Process each row (skip header)
            for ($i = 1; $i < count($csv); $i++) {
                // If CSV has fewer columns than headers, pad the row to prevent array_combine errors
                $normalizedRow = $csv[$i];
                if (count($normalizedRow) < count($headers)) {
                    $normalizedRow = array_pad($normalizedRow, count($headers), null);
                }
                $row = array_combine($headers, array_map('trim', $normalizedRow));
                
                // Skip empty rows
                if (empty($row['name']) || empty($row['category']) || empty($row['price'])) {
                    $errorCount++;
                    $errors[] = "Baris " . ($i + 1) . ": Kolom wajib kosong (name, category, price)";
                    continue;
                }

                try {
                    // Check for duplicates (same name within brand)
                    $existing = FashionItem::where('brand_id', $brandId)
                        ->where('name', $row['name'])
                        ->exists();
                    
                    if ($existing) {
                        $duplicates[] = $row['name'];
                        continue;
                    }

                    // Map category to enum values used in DB
                    $rawCategory = strtolower($row['category']);
                    $categoryMap = [
                        'tops' => 'Atasan',
                        'atasan' => 'Atasan',
                        'bottoms' => 'Bawahan',
                        'bawahan' => 'Bawahan',
                        'outerwear' => 'Outwear', // enum uses 'Outwear'
                        'outwear' => 'Outwear',
                        'dresses' => 'Dress',
                        'dress' => 'Dress',
                        'shoes' => 'Shoes',
                        'aksesoris' => 'Aksesoris',
                        'accessories' => 'Aksesoris',
                    ];
                    $mappedCategory = $categoryMap[$rawCategory] ?? 'Atasan';

                    // Prepare data
                    $data = [
                        'brand_id' => $brandId,
                        'name' => $row['name'],
                        'category' => $mappedCategory,
                        'price' => (int) $row['price'],
                        'stock' => isset($row['stock']) ? (int) $row['stock'] : 0,
                        'status' => 'active',
                    ];

                    // Optional fields
                    if (!empty($row['description'])) {
                        $data['description'] = $row['description'];
                    }
                    if (!empty($row['original_price'])) {
                        $data['original_price'] = (int) $row['original_price'];
                    }
                    if (!empty($row['style'])) {
                        $data['style'] = $row['style'];
                    }
                    if (!empty($row['fit_type'])) {
                        $data['fit_type'] = $row['fit_type'];
                    }
                    if (!empty($row['gender_target'])) {
                        $data['gender_target'] = $row['gender_target'];
                    }
                    if (!empty($row['dominant_color'])) {
                        $data['dominant_color'] = $row['dominant_color'];
                    }
                    if (!empty($row['sizes'])) {
                        // Store as array for JSON casting if provided as comma list
                        $sizes = is_array($row['sizes']) ? $row['sizes'] : explode(',', $row['sizes']);
                        $data['sizes'] = array_values(array_filter(array_map('trim', $sizes)));
                    }
                    if (!empty($row['colors'])) {
                        $colors = is_array($row['colors']) ? $row['colors'] : explode(',', $row['colors']);
                        $data['colors'] = array_values(array_filter(array_map('trim', $colors)));
                    }
                    if (!empty($row['image_url'])) {
                        $data['image_url'] = $row['image_url'];
                    }

                    // Marketplace links
                    if (!empty($row['link_shopee'])) {
                        $data['link_shopee'] = $row['link_shopee'];
                    }
                    if (!empty($row['link_tokopedia'])) {
                        $data['link_tokopedia'] = $row['link_tokopedia'];
                    }
                    if (!empty($row['link_tiktok'])) {
                        $data['link_tiktok'] = $row['link_tiktok'];
                    }
                    if (!empty($row['link_lazada'])) {
                        $data['link_lazada'] = $row['link_lazada'];
                    }

                    // Derive store_name from brand (optional fallback)
                    $data['store_name'] = Auth::user()->brand?->brand_name ?? 'Brand Store';

                    // Create product
                    FashionItem::create($data);
                    $successCount++;

                } catch (Exception $e) {
                    $errorCount++;
                    $errors[] = "Baris " . ($i + 1) . ": " . $e->getMessage();
                }
            }

            // Prepare response message
                    $message = "✓ Berhasil import {$successCount} produk";
            
            if (!empty($duplicates)) {
                $message .= " | ⚠ Diabaikan " . count($duplicates) . " duplikat";
            }
            
            if (!empty($errors)) {
                foreach (array_slice($errors, 0, 5) as $error) {
                    $message .= " | {$error}";
                }
            }

            return redirect()
                ->route('brand.products.index')
                ->with('success', $message);

        } catch (Exception $e) {
            return back()->withErrors('Error: ' . $e->getMessage());
        }
    }
}
