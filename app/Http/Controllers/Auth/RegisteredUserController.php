<?php

// Menentukan lokasi namespace file controller ini berada
namespace App\Http\Controllers\Auth;

// Mengimpor class Controller utama sebagai induk dari controller ini
use App\Http\Controllers\Controller;
// Mengimpor model User untuk menyimpan dan mengelola data pengguna baru ke database
use App\Models\User;
// Mengimpor event Registered yang dipicu saat pengguna baru berhasil mendaftar
use Illuminate\Auth\Events\Registered;
// Mengimpor RedirectResponse untuk tipe kembalian berupa pengalihan halaman (redirect)
use Illuminate\Http\RedirectResponse;
// Mengimpor Request untuk menangkap data permintaan HTTP yang masuk
use Illuminate\Http\Request;
// Mengimpor facade Auth untuk langsung meloginkan pengguna setelah berhasil mendaftar
use Illuminate\Support\Facades\Auth;
// Mengimpor facade Hash untuk mengenkripsi (hashing) password pengguna baru
use Illuminate\Support\Facades\Hash;
// Mengimpor Rules untuk aturan validasi standar keamanan password
use Illuminate\Validation\Rules;
// Mengimpor ValidationException untuk melemparkan pesan error jika validasi pendaftaran gagal
use Illuminate\Validation\ValidationException;
// Mengimpor Inertia untuk merender komponen tampilan berbasis Vue.js
use Inertia\Inertia;
// Mengimpor Response dari Inertia sebagai tipe kembalian saat merender halaman
use Inertia\Response;

/**
 * Controller untuk menangani tampilan halaman registrasi dan proses pendaftaran pengguna baru.
 */
class RegisteredUserController extends Controller
{
    /**
     * Menampilkan halaman tampilan registrasi (pendaftaran akun).
     */
    public function create(): Response
    {
        // Merender komponen Vue 'Auth/Register'
        return Inertia::render('Auth/Register');
    }

    /**
     * Menangani permintaan pendaftaran pengguna baru yang masuk.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Memvalidasi data input nama, email (harus unik di tabel users), dan password beserta konfirmasinya
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Membuat dan menyimpan data pengguna baru ke database dengan password yang sudah di-hash
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Memicu event Registered bahwa pengguna baru telah berhasil terdaftar
        event(new Registered($user));

        // Otomatis meloginkan pengguna yang baru saja mendaftar
        Auth::login($user);

        // Mengarahkan pengguna ke halaman tujuan setelah login yaitu route 'dashboard'
        return redirect(route('dashboard', absolute: false));
    }
}