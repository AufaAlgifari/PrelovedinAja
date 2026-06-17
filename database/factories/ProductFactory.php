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

        return [
            'seller_id' => User::factory(),
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->numberBetween(50000, 5000000),
            'condition' => $this->faker->randomElement($conditions),
            'category' => $this->faker->randomElement($categories),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'status' => 'Available',
            'image_urls' => [
                'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80'
            ],
            'views_count' => $this->faker->numberBetween(0, 100),
        ];
    }
}
