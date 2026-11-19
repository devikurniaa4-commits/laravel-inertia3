<?php

// Menentukan lokasi namespace file controller ini berada
namespace App\Http\Controllers\Auth;

// Mengimpor class Controller utama sebagai induk dari controller ini
use App\Http\Controllers\Controller;
// Mengimpor RedirectResponse untuk tipe kembalian berupa pengalihan halaman (redirect)
use Illuminate\Http\RedirectResponse;
// Mengimpor Request untuk menangkap data permintaan HTTP yang masuk
use Illuminate\Http\Request;
// Mengimpor facade Hash untuk mengenkripsi (hashing) password baru pengguna
use Illuminate\Support\Facades\Hash;
// Mengimpor rule Password untuk aturan validasi standar keamanan password
use Illuminate\Validation\Rules\Password;

/**
 * Controller untuk menangani proses pembaruan (update) password pengguna yang sedang login.
 */
class PasswordController extends Controller
{
    /**
     * Memperbarui password pengguna di dalam database.
     */
    public function update(Request $request): RedirectResponse
    {
        // Memvalidasi password saat ini (harus cocok dengan di database) dan password baru beserta konfirmasinya
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Memperbarui kolom password milik pengguna yang sedang login dengan hasil enkripsi Hash
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Mengembalikan pengguna ke halaman sebelumnya setelah password berhasil diperbarui
        return back();
    }
}