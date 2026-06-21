<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $campusCategories = [
            'Buku Kuliah',
            'Elektronik',
            'Pakaian',
            'Furnitur',
            'Peralatan Kost',
            'Alat Tulis',
            'Sepatu & Tas',
            'Aksesoris Kuliah',
            'Alat Olahraga',
            'Modul & Diktat',
            'Lampu Belajar',
            'Sprei & Bantal Kost',
            'Alat Masak Portable',
            'Kipas Angin',
            'Rak Buku',
        ];

        try {
            $name = $this->faker->unique()->randomElement($campusCategories);
        } catch (\OverflowException $e) {
            $name = $this->faker->word() . ' ' . $this->faker->unique()->randomNumber(5);
        }

        return [
            'name' => $name,
            'description' => $this->faker->optional()->sentence(),
        ];
    }
}
