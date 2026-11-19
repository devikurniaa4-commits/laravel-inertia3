<?php

// Menentukan lokasi namespace file controller ini berada
namespace App\Http\Controllers\Auth;

// Mengimpor class Controller utama sebagai induk dari controller ini
use App\Http\Controllers\Controller;
// Mengimpor RedirectResponse untuk tipe kembalian berupa pengalihan halaman (redirect)
use Illuminate\Http\RedirectResponse;
// Mengimpor Request untuk menangkap data permintaan HTTP yang masuk
use Illuminate\Http\Request;
// Mengimpor facade Password untuk menangani pengiriman tautan (link) reset password
use Illuminate\Support\Facades\Password;
// Mengimpor ValidationException untuk melemparkan pesan error jika pengiriman gagal
use Illuminate\Validation\ValidationException;
// Mengimpor Inertia untuk merender komponen tampilan berbasis Vue.js
use Inertia\Inertia;
// Mengimpor Response dari Inertia sebagai tipe kembalian saat merender halaman
use Inertia\Response;

/**
 * Controller untuk menangani tampilan lupa password dan pengiriman link reset password ke email pengguna.
 */
class PasswordResetLinkController extends Controller
{
    /**
     * Menampilkan halaman tampilan permintaan link reset password (Lupa Password).
     */
    public function create(): Response
    {
        // Merender komponen Vue 'Auth/ForgotPassword' beserta pesan status sesi jika ada
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Menangani permintaan pengiriman link reset password yang masuk.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Memvalidasi bahwa kolom email wajib diisi dan berformat email yang valid
        $request->validate([
            'email' => 'required|email',
        ]);

        // Mengirimkan link reset password ke alamat email pengguna dan menyimpan status hasilnya
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Jika status menunjukkan link berhasil dikirim, kembalikan ke halaman sebelumnya dengan pesan sukses
        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        // Jika pengiriman gagal (misalnya email tidak terdaftar), lemparkan pesan error validasi pada kolom email
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}