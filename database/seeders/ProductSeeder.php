<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Casual
            ['brand_id' => 1, 'name' => 'Kaos Polos Katun', 'description' => 'Kaos polos berkualitas tinggi.', 'price' => 150000, 'stock' => 50, 'image_url' => 'https://via.placeholder.com/300x400?text=Kaos+Polos', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'casual', 'fit_type' => 'regular', 'dominant_color' => 'Putih', 'category' => 'Atasan', 'gender_target' => 'unisex'],
            ['brand_id' => 1, 'name' => 'Celana Jeans Slim', 'description' => 'Celana jeans dengan potongan slim.', 'price' => 350000, 'stock' => 30, 'image_url' => 'https://via.placeholder.com/300x400?text=Celana+Jeans', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'casual', 'fit_type' => 'slim', 'dominant_color' => 'Biru', 'category' => 'Bawahan', 'gender_target' => 'unisex'],
            ['brand_id' => 1, 'name' => 'Jaket Hoodie', 'description' => 'Jaket hoodie nyaman untuk sehari-hari.', 'price' => 250000, 'stock' => 40, 'image_url' => 'https://via.placeholder.com/300x400?text=Jaket+Hoodie', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'casual', 'fit_type' => 'regular', 'dominant_color' => 'Hitam', 'category' => 'Atasan', 'gender_target' => 'unisex'],
            ['brand_id' => 1, 'name' => 'Sneakers Putih', 'description' => 'Sepatu sneakers klasik.', 'price' => 400000, 'stock' => 20, 'image_url' => 'https://via.placeholder.com/300x400?text=Sneakers+Putih', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'casual', 'fit_type' => 'regular', 'dominant_color' => 'Putih', 'category' => 'Sepatu', 'gender_target' => 'unisex'],
            ['brand_id' => 1, 'name' => 'Topi Baseball', 'description' => 'Topi baseball untuk gaya casual.', 'price' => 120000, 'stock' => 60, 'image_url' => 'https://via.placeholder.com/300x400?text=Topi+Baseball', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'casual', 'fit_type' => 'regular', 'dominant_color' => 'Hitam', 'category' => 'Aksesoris', 'gender_target' => 'unisex'],

            // Formal
            ['brand_id' => 1, 'name' => 'Kemeja Formal Putih', 'description' => 'Kemeja formal untuk kantor.', 'price' => 200000, 'stock' => 25, 'image_url' => 'https://via.placeholder.com/300x400?text=Kemeja+Formal', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'formal', 'fit_type' => 'slim', 'dominant_color' => 'Putih', 'category' => 'Atasan', 'gender_target' => 'male'],
            ['brand_id' => 1, 'name' => 'Celana Chinos', 'description' => 'Celana chinos formal.', 'price' => 300000, 'stock' => 35, 'image_url' => 'https://via.placeholder.com/300x400?text=Celana+Chinos', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'formal', 'fit_type' => 'regular', 'dominant_color' => 'Abu-abu', 'category' => 'Bawahan', 'gender_target' => 'unisex'],
            ['brand_id' => 1, 'name' => 'Blazer Navy', 'description' => 'Blazer untuk acara formal.', 'price' => 600000, 'stock' => 15, 'image_url' => 'https://via.placeholder.com/300x400?text=Blazer+Navy', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'formal', 'fit_type' => 'regular', 'dominant_color' => 'Navy', 'category' => 'Atasan', 'gender_target' => 'unisex'],
            ['brand_id' => 1, 'name' => 'Sepatu Loafers', 'description' => 'Sepatu loafers elegan.', 'price' => 450000, 'stock' => 18, 'image_url' => 'https://via.placeholder.com/300x400?text=Sepatu+Loafers', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'formal', 'fit_type' => 'regular', 'dominant_color' => 'Coklat', 'category' => 'Sepatu', 'gender_target' => 'unisex'],
            ['brand_id' => 1, 'name' => 'Das Krawat', 'description' => 'Das untuk tampilan formal.', 'price' => 80000, 'stock' => 70, 'image_url' => 'https://via.placeholder.com/300x400?text=Das+Krawat', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'formal', 'fit_type' => 'regular', 'dominant_color' => 'Merah', 'category' => 'Aksesoris', 'gender_target' => 'male'],

            // Street
            ['brand_id' => 1, 'name' => 'Hoodie Oversize', 'description' => 'Hoodie dengan potongan oversize.', 'price' => 280000, 'stock' => 45, 'image_url' => 'https://via.placeholder.com/300x400?text=Hoodie+Oversize', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'street', 'fit_type' => 'loose', 'dominant_color' => 'Hitam', 'category' => 'Atasan', 'gender_target' => 'unisex'],
            ['brand_id' => 1, 'name' => 'Cargo Pants', 'description' => 'Celana cargo untuk gaya street.', 'price' => 320000, 'stock' => 28, 'image_url' => 'https://via.placeholder.com/300x400?text=Cargo+Pants', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'street', 'fit_type' => 'regular', 'dominant_color' => 'Hijau', 'category' => 'Bawahan', 'gender_target' => 'unisex'],
            ['brand_id' => 1, 'name' => 'Sneakers High Top', 'description' => 'Sneakers high top trendy.', 'price' => 500000, 'stock' => 22, 'image_url' => 'https://via.placeholder.com/300x400?text=Sneakers+High+Top', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'street', 'fit_type' => 'regular', 'dominant_color' => 'Putih', 'category' => 'Sepatu', 'gender_target' => 'unisex'],
            ['brand_id' => 1, 'name' => 'Bucket Hat', 'description' => 'Topi bucket untuk gaya street.', 'price' => 100000, 'stock' => 55, 'image_url' => 'https://via.placeholder.com/300x400?text=Bucket+Hat', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'street', 'fit_type' => 'regular', 'dominant_color' => 'Hitam', 'category' => 'Aksesoris', 'gender_target' => 'unisex'],
            ['brand_id' => 1, 'name' => 'Graphic Tee', 'description' => 'Kaos dengan desain grafis.', 'price' => 180000, 'stock' => 40, 'image_url' => 'https://via.placeholder.com/300x400?text=Graphic+Tee', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'street', 'fit_type' => 'regular', 'dominant_color' => 'Putih', 'category' => 'Atasan', 'gender_target' => 'unisex'],

            // Vintage
            ['brand_id' => 1, 'name' => 'Kaos Retro', 'description' => 'Kaos dengan desain retro.', 'price' => 160000, 'stock' => 38, 'image_url' => 'https://via.placeholder.com/300x400?text=Kaos+Retro', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'vintage', 'fit_type' => 'regular', 'dominant_color' => 'Merah', 'category' => 'Atasan', 'gender_target' => 'unisex'],
            ['brand_id' => 1, 'name' => 'Bell Bottom Jeans', 'description' => 'Celana jeans model bell bottom.', 'price' => 380000, 'stock' => 20, 'image_url' => 'https://via.placeholder.com/300x400?text=Bell+Bottom+Jeans', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'vintage', 'fit_type' => 'loose', 'dominant_color' => 'Biru', 'category' => 'Bawahan', 'gender_target' => 'unisex'],
            ['brand_id' => 1, 'name' => 'Platform Shoes', 'description' => 'Sepatu platform vintage.', 'price' => 550000, 'stock' => 12, 'image_url' => 'https://via.placeholder.com/300x400?text=Platform+Shoes', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'vintage', 'fit_type' => 'regular', 'dominant_color' => 'Hitam', 'category' => 'Sepatu', 'gender_target' => 'female'],
            ['brand_id' => 1, 'name' => 'Scarf Floral', 'description' => 'Scarf dengan motif floral.', 'price' => 90000, 'stock' => 65, 'image_url' => 'https://via.placeholder.com/300x400?text=Scarf+Floral', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'vintage', 'fit_type' => 'regular', 'dominant_color' => 'Pink', 'category' => 'Aksesoris', 'gender_target' => 'female'],
            ['brand_id' => 1, 'name' => 'Denim Jacket Patches', 'description' => 'Jaket denim dengan patches.', 'price' => 420000, 'stock' => 25, 'image_url' => 'https://via.placeholder.com/300x400?text=Denim+Patches', 'is_affiliate' => false, 'affiliate_link' => null, 'style' => 'vintage', 'fit_type' => 'regular', 'dominant_color' => 'Biru', 'category' => 'Atasan', 'gender_target' => 'unisex'],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
