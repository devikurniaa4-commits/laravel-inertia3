<?php

// Menetapkan namespace controller fitur profil.
namespace App\Http\Controllers;

// Mengimpor request khusus untuk validasi perubahan profil.
use App\Http\Requests\ProfileUpdateRequest;
// Mengimpor kontrak untuk mengetahui apakah akun wajib memverifikasi email.
use Illuminate\Contracts\Auth\MustVerifyEmail;
// Mengimpor tipe respons pengalihan.
use Illuminate\Http\RedirectResponse;
// Mengimpor request HTTP untuk membaca pengguna dan sesi aktif.
use Illuminate\Http\Request;
// Mengimpor facade autentikasi untuk mengakhiri sesi pengguna.
use Illuminate\Support\Facades\Auth;
// Mengimpor facade redirect untuk navigasi setelah operasi profil.
use Illuminate\Support\Facades\Redirect;
// Mengimpor renderer Inertia untuk menampilkan halaman profil.
use Inertia\Inertia;
// Mengimpor tipe respons halaman Inertia.
use Inertia\Response;

// Menangani tampilan, pembaruan informasi, dan penghapusan akun pengguna.
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        // Menampilkan halaman profil beserta status verifikasi dan status sesi.
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Mengisi model pengguna dengan data yang lolos validasi.
        $request->user()->fill($request->validated());

        // Menghapus status verifikasi jika alamat email pengguna berubah.
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Menyimpan perubahan profil ke database.
        $request->user()->save();

        // Kembali ke halaman profil setelah penyimpanan.
        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Memastikan kata sandi yang dimasukkan sesuai dengan akun aktif.
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        // Menyimpan referensi pengguna sebelum sesi autentikasi diakhiri.
        $user = $request->user();

        // Mengakhiri sesi login pengguna.
        Auth::logout();

        // Menghapus data akun dari database.
        $user->delete();

        // Membatalkan sesi lama dan membuat token CSRF baru.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Mengarahkan pengguna ke halaman utama.
        return Redirect::to('/');
    }
}
