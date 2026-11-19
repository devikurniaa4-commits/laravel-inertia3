<?php

// Mengimpor controller CRUD post, facade route, dan renderer Inertia.
use App\Http\Controllers\PostController;
// Mengimpor facade untuk mendaftarkan route web.
use Illuminate\Support\Facades\Route;
// Mengimpor renderer halaman Inertia untuk route publik.
use Inertia\Inertia;

// 1. LANDING PAGE (Bisa diakses publik tanpa login)
Route::get('/', function () {
    // Menampilkan halaman sambutan untuk pengunjung.
    return Inertia::render('Welcome');
});

// 2. SEMUA ROUTE APPS / POSTS (Wajib Login dulu)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Halaman utama setelah login (Dashboard mengarah ke Posts)
    // Menampilkan daftar post untuk pengguna yang sudah login dan terverifikasi.
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    
    Route::get('/dashboard', function () {
        // Mengarahkan dashboard ke halaman daftar post.
        return redirect()->route('posts.index');
    })->name('dashboard');

    // Route CRUD Posts
    // Menampilkan formulir post dan mendaftarkan aksi CRUD post.
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// Route Bawaan Auth (Login, Register, Logout)
// Memuat kumpulan route autentikasi dari file terpisah.
require __DIR__.'/auth.php';