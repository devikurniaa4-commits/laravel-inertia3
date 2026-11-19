<?php

// Menentukan lokasi namespace file controller ini berada
namespace App\Http\Controllers\Auth;

// Mengimpor class Controller utama sebagai induk dari controller ini
use App\Http\Controllers\Controller;
// Mengimpor RedirectResponse untuk tipe kembalian berupa pengalihan halaman (redirect)
use Illuminate\Http\RedirectResponse;
// Mengimpor Request untuk menangkap data permintaan HTTP dan data pengguna yang sedang login
use Illuminate\Http\Request;

/**
 * Controller untuk menangani pengiriman ulang email notifikasi verifikasi akun pengguna.
 */
class EmailVerificationNotificationController extends Controller
{
    /**
     * Mengirimkan notifikasi email verifikasi baru ke pengguna.
     */
    public function store(Request $request): RedirectResponse
    {
        // Memeriksa apakah alamat email pengguna saat ini sudah terverifikasi sebelumnya
        if ($request->user()->hasVerifiedEmail()) {
            // Jika sudah terverifikasi, langsung arahkan ke halaman tujuan sebelumnya atau ke route 'dashboard'
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Mengirimkan tautan (link) notifikasi verifikasi ke email pengguna
        $request->user()->sendEmailVerificationNotification();

        // Mengembalikan pengguna ke halaman sebelumnya dengan pesan status bahwa link verifikasi telah dikirim
        return back()->with('status', 'verification-link-sent');
    }
}