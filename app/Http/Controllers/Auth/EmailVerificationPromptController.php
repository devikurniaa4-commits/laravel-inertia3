<?php

// Menentukan lokasi namespace file controller ini berada
namespace App\Http\Controllers\Auth;

// Mengimpor class Controller utama sebagai induk dari controller ini
use App\Http\Controllers\Controller;
// Mengimpor RedirectResponse untuk tipe kembalian berupa pengalihan halaman (redirect)
use Illuminate\Http\RedirectResponse;
// Mengimpor Request untuk menangkap data permintaan HTTP dan data pengguna yang sedang login
use Illuminate\Http\Request;
// Mengimpor Inertia untuk merender komponen tampilan berbasis Vue.js
use Inertia\Inertia;
// Mengimpor Response dari Inertia sebagai tipe kembalian saat merender halaman
use Inertia\Response;

/**
 * Controller single-action untuk menampilkan halaman pemberitahuan verifikasi email kepada pengguna.
 */
class EmailVerificationPromptController extends Controller
{
    /**
     * Menampilkan tampilan perintah (prompt) verifikasi email jika email pengguna belum terverifikasi.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        // Mengecek apakah email pengguna sudah terverifikasi:
        // Jika sudah, arahkan ke halaman tujuan sebelumnya atau 'dashboard'.
        // Jika belum, tampilkan komponen Vue 'Auth/VerifyEmail' beserta pesan status sesi.
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('dashboard', absolute: false))
                    : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}