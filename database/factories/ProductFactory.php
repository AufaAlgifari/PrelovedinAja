<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Textbooks', 'Electronics', 'Apparel', 'Dorm Life'];
        $conditions = ['New', 'Like New', 'Good', 'Well Used'];

        $availableImages = [
            'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1571175432240-a38f381c855a?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1629904853716-f0bc54fea481?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=600&q=80'
        ];
        $count = $this->faker->numberBetween(2, 4);
        $randomImages = $this->faker->randomElements($availableImages, $count);

        return [
            'seller_id' => User::factory(),
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->numberBetween(50000, 5000000),
            'condition' => $this->faker->randomElement($conditions),
            'category' => $this->faker->randomElement($categories),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'status' => 'Available',
            'image_urls' => $randomImages,
            'views_count' => $this->faker->numberBetween(0, 100),
        ];
    }
}
