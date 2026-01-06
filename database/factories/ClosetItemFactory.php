<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClosetItem>
 */
class ClosetItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Casual', 'Streetwear', 'Formal', 'Sporty', 'Vintage', 'Minimalist'];

        $names = [
            'Casual' => ['Kaos Polos Hitam', 'Celana Jeans', 'Jaket Denim', 'Sneakers Putih', 'Blouse Katun'],
            'Streetwear' => ['Hoodie Oversize', 'Cargo Pants', 'Sneakers High Top', 'Graphic Tee', 'Bucket Hat'],
            'Formal' => ['Kemeja Putih', 'Blazer Navy', 'Celana Chinos', 'Sepatu Loafers', 'Dasar Sutra'],
            'Sporty' => ['Legging Olahraga', 'Bra Sport', 'Running Shoes', 'Tank Top', 'Shorts Gym'],
            'Vintage' => ['Blouse Retro', 'Skirt A-Line', 'Cardigan Wol', 'Boots Ankle', 'Necklace Antik'],
            'Minimalist' => ['T-Shirt Basic', 'Pants Straight', 'Loafers Kulit', 'Watch Simple', 'Earrings Stud']
        ];

        $category = $this->faker->randomElement($categories);
        $name = $this->faker->randomElement($names[$category]);

        return [
            'user_id' => 1, // Assuming user with ID 1 exists
            'fashion_item_id' => null, // For now, no linked fashion item
            'image_url' => 'https://picsum.photos/400/500?random=' . $this->faker->numberBetween(1, 1000),
            'name' => $name,
            'description' => $this->faker->optional(0.7)->sentence(),
            'category' => $category,
        ];
    }
}
