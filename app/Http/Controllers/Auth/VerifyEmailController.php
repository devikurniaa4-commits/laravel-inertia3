<?php

// Menetapkan namespace untuk controller verifikasi email.
namespace App\Http\Controllers\Auth;

// Mengimpor controller dasar sebagai induk controller ini.
use App\Http\Controllers\Controller;
// Mengimpor event yang dipicu setelah email berhasil diverifikasi.
use Illuminate\Auth\Events\Verified;
// Mengimpor request khusus yang memvalidasi tautan verifikasi email.
use Illuminate\Foundation\Auth\EmailVerificationRequest;
// Mengimpor tipe respons pengalihan halaman.
use Illuminate\Http\RedirectResponse;

/**
 * Menangani permintaan verifikasi alamat email pengguna.
 */
class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    /**
     * Memverifikasi email pengguna dari tautan yang sudah divalidasi.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Mengarahkan pengguna yang sudah terverifikasi ke halaman tujuan.
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        // Menandai email sebagai terverifikasi dan mengirim event jika berhasil.
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Mengarahkan pengguna ke dashboard dengan status verifikasi berhasil.
        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
