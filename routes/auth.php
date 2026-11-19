<?php

// Menangani tampilan login, proses autentikasi, dan logout.
use App\Http\Controllers\Auth\AuthenticatedSessionController;
// Menampilkan dan memproses konfirmasi kata sandi.
use App\Http\Controllers\Auth\ConfirmablePasswordController;
// Mengirim ulang notifikasi verifikasi email.
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
// Menampilkan pemberitahuan bahwa email belum diverifikasi.
use App\Http\Controllers\Auth\EmailVerificationPromptController;
// Menampilkan formulir reset dan menyimpan kata sandi baru.
use App\Http\Controllers\Auth\NewPasswordController;
// Memproses perubahan kata sandi oleh pengguna aktif.
use App\Http\Controllers\Auth\PasswordController;
// Menampilkan formulir permintaan reset dan mengirim tautannya.
use App\Http\Controllers\Auth\PasswordResetLinkController;
// Menampilkan formulir pendaftaran dan menyimpan akun baru.
use App\Http\Controllers\Auth\RegisteredUserController;
// Memproses tautan verifikasi email pengguna.
use App\Http\Controllers\Auth\VerifyEmailController;
// Mengimpor facade untuk mendaftarkan rute HTTP.
use Illuminate\Support\Facades\Route;

// Membatasi rute berikut untuk pengunjung yang belum login.
Route::middleware('guest')->group(function () {
    // Menampilkan formulir pendaftaran dan menerima data akun baru.
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // Menerima data formulir untuk membuat akun pengguna baru.
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Menampilkan formulir login dan memproses kredensial pengguna.
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Menerima kredensial untuk memulai sesi pengguna.
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Menampilkan formulir permintaan reset dan mengirim tautan melalui email.
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    // Meminta pengiriman tautan reset kata sandi.
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Menampilkan formulir reset dengan token dan menyimpan kata sandi baru.
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    // Menyimpan kata sandi baru menggunakan token reset.
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Membatasi rute berikut untuk pengguna yang sudah login.
Route::middleware('auth')->group(function () {
    // Menampilkan status verifikasi dan memproses verifikasi email bertanda tangan.
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    // Memverifikasi email melalui tautan yang ditandatangani.
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Mengirim ulang notifikasi verifikasi dengan pembatasan jumlah permintaan.
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Menampilkan formulir konfirmasi kata sandi dan memproses konfirmasinya.
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Mengubah kata sandi akun pengguna yang sedang login.
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Mengakhiri sesi dan mengeluarkan pengguna dari aplikasi.
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
