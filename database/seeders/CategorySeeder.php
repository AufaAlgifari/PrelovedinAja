<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Textbooks',
                'description' => 'Buku Kuliah, modul praktikum, dan referensi akademik lainnya.'
            ],
            [
                'name' => 'Electronics',
                'description' => 'Elektronik & Gadget penunjang kuliah seperti laptop, tablet, kalkulator, dan lampu belajar.'
            ],
            [
                'name' => 'Dorm Life',
                'description' => 'Kebutuhan anak kost seperti kasur, kulkas mini, rice cooker, kipas angin, dan rak lemari.'
            ],
            [
                'name' => 'Apparel',
                'description' => 'Pakaian, sepatu, tas kuliah, dan aksesoris fashion mahasiswa.'
            ],
            [
                'name' => 'Others',
                'description' => 'Barang preloved kategori lainnya.'
            ]
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(
                ['name' => $cat['name']],
                ['description' => $cat['description'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
