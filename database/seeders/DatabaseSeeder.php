<?php

// Menetapkan namespace seeder database aplikasi.
namespace Database\Seeders;

// Mengimpor model pengguna dan kelas dasar seeder Laravel.
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Menyediakan data awal yang diperlukan untuk aplikasi.
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Contoh pembuatan banyak pengguna, dinonaktifkan untuk seeding standar.
        // User::factory(10)->create();

        // Membuat satu akun pengguna contoh untuk kebutuhan pengembangan.
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
