<?php

// Menetapkan namespace service provider aplikasi.
namespace App\Providers;

// Mengimpor facade Vite untuk mengatur pemuatan aset frontend.
use Illuminate\Support\Facades\Vite;
// Mengimpor kelas dasar service provider Laravel.
use Illuminate\Support\ServiceProvider;

// Mendaftarkan konfigurasi layanan yang berlaku di seluruh aplikasi.
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Tempat pendaftaran binding layanan aplikasi.
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Memuat aset lebih awal dengan batas tiga permintaan bersamaan.
        Vite::prefetch(concurrency: 3);
    }
}
