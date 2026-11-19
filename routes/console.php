<?php

// Mendaftarkan perintah konsol khusus untuk aplikasi.
// Mengimpor helper kutipan dan facade untuk mendefinisikan perintah Artisan.
use Illuminate\Foundation\Inspiring;
// Mengimpor facade Artisan untuk mendaftarkan perintah konsol.
use Illuminate\Support\Facades\Artisan;

// Mendaftarkan perintah inspire yang menampilkan kutipan acak.
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
