<?php

// Menentukan lokasi namespace file controller ini berada
namespace App\Http\Controllers\Auth;

// Mengimpor class Controller utama sebagai induk dari controller ini
use App\Http\Controllers\Controller;
// Mengimpor event PasswordReset yang dipicu setelah password pengguna berhasil diubah
use Illuminate\Auth\Events\PasswordReset;
// Mengimpor RedirectResponse untuk tipe kembalian berupa pengalihan halaman (redirect)
use Illuminate\Http\RedirectResponse;
// Mengimpor Request untuk menangkap data permintaan HTTP yang masuk
use Illuminate\Http\Request;
// Mengimpor facade Hash untuk mengenkripsi (hashing) password baru pengguna
use Illuminate\Support\Facades\Hash;
// Mengimpor facade Password untuk memproses logika reset password bawaan Laravel
use Illuminate\Support\Facades\Password;
// Mengimpor helper Str untuk membuat string acak (digunakan pada remember_token)
use Illuminate\Support\Str;
// Mengimpor Rules untuk aturan validasi standar keamanan password
use Illuminate\Validation\Rules;
// Mengimpor ValidationException untuk melemparkan pesan error jika proses reset gagal
use Illuminate\Validation\ValidationException;
// Mengimpor Inertia untuk merender komponen tampilan berbasis Vue.js
use Inertia\Inertia;
// Mengimpor Response dari Inertia sebagai tipe kembalian saat merender halaman
use Inertia\Response;

/**
 * Controller untuk menangani tampilan dan proses penyimpanan password baru saat reset password.
 */
class NewPasswordController extends Controller
{
    /**
     * Menampilkan halaman tampilan reset password.
     */
    public function create(Request $request): Response
    {
        // Merender komponen Vue 'Auth/ResetPassword' dengan mengirimkan data email dan token dari URL
        return Inertia::render('Auth/ResetPassword', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Menangani permintaan penyimpanan password baru yang masuk.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Memvalidasi input token, format email, serta kecocokan konfirmasi password baru
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Mencoba mereset password pengguna di database. Jika berhasil, password baru akan
        // di-hash dan disimpan ke model User beserta remember_token baru.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                // Memperbarui kolom password (dengan enkripsi Hash) dan remember_token secara langsung
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                // Memicu event PasswordReset bahwa password pengguna telah berhasil diperbarui
                event(new PasswordReset($user));
            }
        );

        // Jika status menunjukkan password berhasil direset, arahkan pengguna ke halaman login
        // disertai pesan status keberhasilan.
        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        // Jika proses reset gagal (misal token kadaluarsa/salah), lemparkan pesan error validasi pada email
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}