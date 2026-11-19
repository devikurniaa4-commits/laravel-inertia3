<?php

// Menentukan lokasi namespace file controller ini berada
namespace App\Http\Controllers\Auth;

// Mengimpor class Controller utama sebagai induk dari controller ini
use App\Http\Controllers\Controller;
// Mengimpor LoginRequest untuk menangani validasi dan proses autentikasi login
use App\Http\Requests\Auth\LoginRequest;
// Mengimpor RedirectResponse untuk tipe kembalian berupa pengalihan halaman (redirect)
use Illuminate\Http\RedirectResponse;
// Mengimpor Request untuk menangkap data permintaan HTTP yang masuk
use Illuminate\Http\Request;
// Mengimpor facade Auth untuk mengelola proses autentikasi dan sesi login/logout pengguna
use Illuminate\Support\Facades\Auth;
// Mengimpor facade Route untuk mengecek ketersediaan route (seperti reset password)
use Illuminate\Support\Facades\Route;
// Mengimpor Inertia untuk merender komponen tampilan berbasis Vue.js
use Inertia\Inertia;
// Mengimpor Response dari Inertia sebagai tipe kembalian saat merender halaman
use Inertia\Response;

/**
 * Controller untuk mengatur sesi autentikasi pengguna (Login dan Logout).
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman tampilan login.
     */
    public function create(): Response
    {
        // Merender komponen Vue 'Auth/Login' dan mengirimkan status reset password serta pesan sesi
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Menangani permintaan autentikasi (proses login) yang masuk.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Memvalidasi dan memverifikasi kredensial (email & password) pengguna
        $request->authenticate();

        // Membuat ulang ID sesi untuk mencegah serangan session fixation
        $request->session()->regenerate();

        // Mengarahkan pengguna ke halaman tujuan sebelumnya atau ke route 'dashboard'
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Menghancurkan sesi autentikasi yang sedang aktif (proses logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Mengeluarkan pengguna dari guard autentikasi 'web'
        Auth::guard('web')->logout();

        // Membatalkan seluruh data sesi pengguna saat ini
        $request->session()->invalidate();

        // Membuat ulang token CSRF baru demi keamanan
        $request->session()->regenerateToken();

        // Mengarahkan pengguna kembali ke halaman utama ('/')
        return redirect('/');
    }
}