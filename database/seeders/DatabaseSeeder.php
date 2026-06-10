<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
        ]);

        // Create standard mock student (Aufa Algifari)
        \App\Models\User::updateOrCreate(
            ['email' => 'aufa.algifari@mhs.unsoed.ac.id'],
            [
                'name' => 'Aufa Algifari',
                'password' => bcrypt('password123'),
                'phone_number' => '0812-3456-7890',
                'unsoed_faculty' => 'Teknik',
                'unsoed_major' => 'Informatika',
                'avatar_url' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80',
                'rating_cache' => 5.0,
                'role' => 'student',
                'is_verified' => true,
                'no_kampus' => 'H1D024001',
            ]
        );

        // Create an admin user matching ERD roles
        \App\Models\User::updateOrCreate(
            ['email' => 'admin.preloved@unsoed.ac.id'],
            [
                'name' => 'Admin PrelovedinAja',
                'password' => bcrypt('admin123'),
                'phone_number' => '0811-2222-3333',
                'unsoed_faculty' => 'Rektorat',
                'unsoed_major' => 'Layanan Akademik',
                'avatar_url' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?auto=format&fit=crop&w=150&h=150&q=80',
                'rating_cache' => 5.0,
                'role' => 'admin',
                'is_verified' => true,
                'no_kampus' => 'ADM998811',
            ]
        );
    }
}
