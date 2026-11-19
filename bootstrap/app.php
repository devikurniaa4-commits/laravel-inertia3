<?php

// Mengimpor pembangun aplikasi dan konfigurasi exception serta middleware Laravel.
use Illuminate\Foundation\Application;
// Mengimpor konfigurasi penanganan exception.
use Illuminate\Foundation\Configuration\Exceptions;
// Mengimpor konfigurasi middleware aplikasi.
use Illuminate\Foundation\Configuration\Middleware;

// Memulai konfigurasi aplikasi dari direktori dasar proyek.
return Application::configure(basePath: dirname(__DIR__))
    // Mendaftarkan lokasi file route dan endpoint pemeriksaan kesehatan.
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // Menambahkan middleware untuk respons Inertia dan pemuatan aset lebih awal.
    ->withMiddleware(function (Middleware $middleware): void {
        // Menambahkan middleware Inertia pada grup web.
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->web(append: [
            App\Http\Middleware\HandleInertiaRequests::class,
        ]);
    })
    // Menyediakan tempat untuk konfigurasi penanganan exception.
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();