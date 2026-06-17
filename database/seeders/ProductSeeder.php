<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user penjual
        if (User::count() === 0) {
            User::factory()->create([
                'name' => 'Fadhil - FT Unsoed',
                'email' => 'fadhil@unsoed.ac.id',
            ]);
        }

        $seller = User::first();

        // Buat 10 produk testing
        Product::factory()->count(10)->create([
            'seller_id' => $seller->id,
        ]);
    }
}
