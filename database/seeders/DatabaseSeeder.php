<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Truncate tables to avoid duplicates
        User::truncate();
        Brand::truncate();
        Product::truncate();
        UserProfile::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ===== CREATE MAIN USERS =====

        // 1. Admin User
        $admin = User::create([
            'name' => 'Admin ScanFit',
            'email' => 'admin@scanfit.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Brand Owner
        $brandOwner = User::create([
            'name' => 'Erigo Owner',
            'email' => 'owner@erigo.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'brand_owner',
        ]);

        // 3. Regular User
        $regularUser = User::create([
            'name' => 'Abe',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // ===== CREATE USER PROFILE =====
        UserProfile::create([
            'user_id' => $regularUser->id,
            'gender' => 'male',
            'style_preference' => 'street',
            'skin_tone' => 'medium',
            'body_size' => 'M',
        ]);

        // ===== CREATE 5 LOCAL BRANDS =====
        $brands = [
            [
                'brand_name' => 'Erigo',
                'description' => 'Premium casual wear dengan desain minimalis modern',
                'owner_id' => $brandOwner->id,
            ],
            [
                'brand_name' => 'Roughneck 1991',
                'description' => 'Brand skate dan streetwear dengan vibes vintage',
                'owner_id' => $brandOwner->id,
            ],
            [
                'brand_name' => '3Second',
                'description' => 'Fashion casual trendy untuk millennial Indonesia',
                'owner_id' => $brandOwner->id,
            ],
            [
                'brand_name' => 'Greenlight',
                'description' => 'Sustainable fashion dengan material eco-friendly',
                'owner_id' => $brandOwner->id,
            ],
            [
                'brand_name' => 'Screamous',
                'description' => 'Bold graphic tees dengan desain artistik unik',
                'owner_id' => $brandOwner->id,
            ],
        ];

        foreach ($brands as $brandData) {
            Brand::create(array_merge($brandData, ['status' => 'approved']));
        }

        // ===== CREATE 25 FASHION PRODUCTS =====
        $allBrands = Brand::all();

        $products = [
            // Tops (Atasan) - 8 items
            ['name' => 'Oversized Cotton Tee', 'price' => 149000, 'category' => 'Atasan', 'style' => 'casual', 'fit_type' => 'loose'],
            ['name' => 'White Crew Neck Shirt', 'price' => 179000, 'category' => 'Atasan', 'style' => 'casual', 'fit_type' => 'regular'],
            ['name' => 'Striped Long Sleeve Tee', 'price' => 199000, 'category' => 'Atasan', 'style' => 'casual', 'fit_type' => 'regular'],
            ['name' => 'Black Graphic Print Tee', 'price' => 129000, 'category' => 'Atasan', 'style' => 'street', 'fit_type' => 'regular'],
            ['name' => 'Vintage Band Tee Shirt', 'price' => 169000, 'category' => 'Atasan', 'style' => 'vintage', 'fit_type' => 'loose'],
            ['name' => 'Minimalist Polo Shirt', 'price' => 249000, 'category' => 'Atasan', 'style' => 'formal', 'fit_type' => 'slim'],
            ['name' => 'Henley Neck Tee', 'price' => 159000, 'category' => 'Atasan', 'style' => 'casual', 'fit_type' => 'regular'],
            ['name' => 'Oversized Hoodie', 'price' => 299000, 'category' => 'Atasan', 'style' => 'street', 'fit_type' => 'loose'],

            // Bottoms (Bawahan) - 9 items
            ['name' => 'Black Skinny Jeans', 'price' => 249000, 'category' => 'Bawahan', 'style' => 'casual', 'fit_type' => 'slim'],
            ['name' => 'Blue Cargo Pants', 'price' => 279000, 'category' => 'Bawahan', 'style' => 'street', 'fit_type' => 'loose'],
            ['name' => 'Khaki Chino Pants', 'price' => 229000, 'category' => 'Bawahan', 'style' => 'formal', 'fit_type' => 'regular'],
            ['name' => 'Black Track Pants', 'price' => 199000, 'category' => 'Bawahan', 'style' => 'casual', 'fit_type' => 'loose'],
            ['name' => 'Vintage Denim Shorts', 'price' => 179000, 'category' => 'Bawahan', 'style' => 'casual', 'fit_type' => 'regular'],
            ['name' => 'Jogger Pants Grey', 'price' => 189000, 'category' => 'Bawahan', 'style' => 'casual', 'fit_type' => 'loose'],
            ['name' => 'Slim Fit Trousers', 'price' => 259000, 'category' => 'Bawahan', 'style' => 'formal', 'fit_type' => 'slim'],
            ['name' => 'Baggy Wide Leg Jeans', 'price' => 289000, 'category' => 'Bawahan', 'style' => 'street', 'fit_type' => 'loose'],
            ['name' => 'Cropped Pants Beige', 'price' => 219000, 'category' => 'Bawahan', 'style' => 'casual', 'fit_type' => 'regular'],

            // Outwear (Jaket/Outer) - 5 items
            ['name' => 'Denim Jacket Blue', 'price' => 349000, 'category' => 'Outer', 'style' => 'casual', 'fit_type' => 'regular'],
            ['name' => 'Varsity Jacket Black', 'price' => 399000, 'category' => 'Outer', 'style' => 'street', 'fit_type' => 'regular'],
            ['name' => 'Bomber Jacket Navy', 'price' => 379000, 'category' => 'Outer', 'style' => 'casual', 'fit_type' => 'regular'],
            ['name' => 'Windbreaker Jacket', 'price' => 329000, 'category' => 'Outer', 'style' => 'sport', 'fit_type' => 'loose'],
            ['name' => 'Leather Blazer Black', 'price' => 499000, 'category' => 'Outer', 'style' => 'formal', 'fit_type' => 'slim'],

            // Accessories (Aksesoris) - 3 items
            ['name' => 'White Canvas Sneakers', 'price' => 329000, 'category' => 'Aksesoris', 'style' => 'casual', 'fit_type' => 'regular'],
            ['name' => 'Black Leather Boots', 'price' => 449000, 'category' => 'Aksesoris', 'style' => 'formal', 'fit_type' => 'regular'],
            ['name' => 'Classic Wool Beanie', 'price' => 89000, 'category' => 'Aksesoris', 'style' => 'casual', 'fit_type' => 'regular'],
        ];

        $imageUrls = [
            'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1503342217505-b0a15ec3dd1f?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1506157786151-b8491531f063?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1505572409655-46ef922f107f?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1489749798305-4fea3ba63d60?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1495225794014-2aed4e4993d5?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1542272604-787c62d465d1?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1542272604-787c62d465d1?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1473951574080-11b8fbb9130b?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1548883329-3a3fcf0642c2?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1552820728-8ac41f1ce891?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1519086308692-4514894109fb?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1551028719-00167b16ebc5?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1530268729831-4ca8d3146f56?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1540522918619-cd96860a2b81?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1495521821757-a1efb6729352?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1539533057592-4ee4ad9b8b46?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1556821552-5ffbdb87c5e0?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1552062407-291826ad9da8?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1516762689617-e1cffbb0d47b?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1572635196237-14b3f281503f?q=80&w=1000&auto=format&fit=crop',
        ];

        foreach ($products as $index => $productData) {
            Product::create([
                'brand_id' => $allBrands->random()->id,
                'name' => $productData['name'],
                'description' => 'Produk fashion berkualitas dari brand lokal Indonesia',
                'price' => $productData['price'],
                'category' => $productData['category'],
                'style' => $productData['style'],
                'fit_type' => $productData['fit_type'],
                'gender_target' => collect(['male', 'female', 'unisex'])->random(),
                'affiliate_link' => 'https://shopee.co.id/produk-' . $index,
                'image_url' => $imageUrls[$index % count($imageUrls)],
            ]);
        }

        // Seed fashion items
        $this->call(FashionItemSeeder::class);

        // Seed closet items
        $this->call(ClosetItemSeeder::class);

        $this->command->info('Database seeded successfully with 3 users, 5 brands, 25 products, 50 fashion items, and 20 closet items!');
    }
}
