<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FashionItem>
 */
class FashionItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Casual', 'Streetwear', 'Formal', 'Sporty', 'Vintage', 'Minimalist'];
        $stores = ['Tokopedia', 'Shopee', 'Zalora'];

        $names = [
            'Casual' => ['Kaos Polos Hitam', 'Celana Jeans Slim', 'Jaket Denim Klasik', 'Sneakers Putih', 'Blouse Katun'],
            'Streetwear' => ['Hoodie Oversize', 'Cargo Pants', 'Sneakers High Top', 'Graphic Tee', 'Bucket Hat'],
            'Formal' => ['Kemeja Putih', 'Blazer Navy', 'Celana Chinos', 'Sepatu Loafers', 'Dasar Sutra'],
            'Sporty' => ['Legging Olahraga', 'Bra Sport', 'Running Shoes', 'Tank Top', 'Shorts Gym'],
            'Vintage' => ['Blouse Retro', 'Skirt A-Line', 'Cardigan Wol', 'Boots Ankle', 'Necklace Antik'],
            'Minimalist' => ['T-Shirt Basic', 'Pants Straight', 'Loafers Kulit', 'Watch Simple', 'Earrings Stud']
        ];

        $category = $this->faker->randomElement($categories);
        $name = $this->faker->randomElement($names[$category]);

        $price = $this->faker->numberBetween(50000, 500000);
        $isOnSale = $this->faker->boolean(30); // 30% chance of sale
        $originalPrice = $isOnSale ? $price + $this->faker->numberBetween(20000, 100000) : null;

        return [
            'name' => $name,
            'category' => $category,
            'price' => $price,
            'original_price' => $originalPrice,
            'rating' => $this->faker->randomFloat(1, 3.5, 5.0),
            'review_count' => $this->faker->numberBetween(0, 500),
            'store_name' => $this->faker->randomElement($stores),
            'image_url' => 'https://picsum.photos/400/500?random=' . $this->faker->numberBetween(1, 1000),
        ];
    }
}
