<?php

// Mengimpor aplikasi Laravel dan objek request HTTP.
use Illuminate\Foundation\Application;
// Mengimpor objek request yang akan diteruskan ke aplikasi.
use Illuminate\Http\Request;

// Mencatat waktu mulai proses aplikasi.
define('LARAVEL_START', microtime(true));

// Memuat halaman maintenance jika aplikasi sedang dalam pemeliharaan.
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Memuat autoloader Composer agar class aplikasi dan dependency tersedia.
require __DIR__.'/../vendor/autoload.php';

// Menjalankan bootstrap Laravel dan meneruskan request yang masuk.
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Menangkap request HTTP lalu menyerahkannya kepada aplikasi.
$app->handleRequest(Request::capture());
