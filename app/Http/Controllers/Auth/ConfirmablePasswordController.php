<?php

// Menentukan lokasi namespace file controller ini berada
namespace App\Http\Controllers\Auth;

// Mengimpor class Controller utama sebagai induk dari controller ini
use App\Http\Controllers\Controller;
// Mengimpor RedirectResponse untuk tipe kembalian berupa pengalihan halaman (redirect)
use Illuminate\Http\RedirectResponse;
// Mengimpor Request untuk menangkap data permintaan HTTP yang masuk
use Illuminate\Http\Request;
// Mengimpor facade Auth untuk memvalidasi kredensial pengguna yang sedang login
use Illuminate\Support\Facades\Auth;
// Mengimpor ValidationException untuk melemparkan pesan error jika validasi gagal
use Illuminate\Validation\ValidationException;
// Mengimpor Inertia untuk merender komponen tampilan berbasis Vue.js
use Inertia\Inertia;
// Mengimpor Response dari Inertia sebagai tipe kembalian saat merender halaman
use Inertia\Response;

/**
 * Controller untuk menangani konfirmasi ulang password pengguna sebelum mengakses fitur sensitif.
 */
class ConfirmablePasswordController extends Controller
{
    /**
     * Menampilkan halaman tampilan konfirmasi password.
     */
    public function show(): Response
    {
        // Merender komponen Vue 'Auth/ConfirmPassword'
        return Inertia::render('Auth/ConfirmPassword');
    }

    /**
     * Memproses dan memverifikasi konfirmasi password pengguna.
     */
    public function store(Request $request): RedirectResponse
    {
        // Memeriksa apakah kecocokan email dan password yang dimasukkan pengguna valid
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            // Jika password salah, tampilkan pesan error validasi pada kolom password
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        // Menyimpan waktu saat password berhasil dikonfirmasi ke dalam sesi
        $request->session()->put('auth.password_confirmed_at', time());

        // Mengarahkan pengguna ke halaman tujuan sebelumnya atau ke route 'dashboard'
        return redirect()->intended(route('dashboard', absolute: false));
    }
}