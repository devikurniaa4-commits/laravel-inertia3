<?php

// Menetapkan namespace request untuk proses autentikasi.
namespace App\Http\Requests\Auth;

// Mengimpor event yang dicatat saat percobaan login terkena batas.
use Illuminate\Auth\Events\Lockout;
// Mengimpor kontrak tipe aturan validasi.
use Illuminate\Contracts\Validation\ValidationRule;
// Mengimpor kelas dasar untuk validasi request login.
use Illuminate\Foundation\Http\FormRequest;
// Mengimpor facade untuk autentikasi kredensial.
use Illuminate\Support\Facades\Auth;
// Mengimpor layanan pembatas percobaan login.
use Illuminate\Support\Facades\RateLimiter;
// Mengimpor helper normalisasi kunci pembatas.
use Illuminate\Support\Str;
// Mengimpor exception untuk menampilkan error validasi.
use Illuminate\Validation\ValidationException;

// Memvalidasi kredensial dan menjalankan proses autentikasi pengguna.
class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Mengizinkan request login diproses oleh aturan validasi berikutnya.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Menetapkan email dan kata sandi sebagai input wajib.
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        // Memastikan request belum melewati batas percobaan login.
        $this->ensureIsNotRateLimited();

        // Mencoba login menggunakan email, kata sandi, dan pilihan ingat sesi.
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // Mencatat satu percobaan gagal sebelum mengirim error autentikasi.
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Menghapus hit pembatas setelah autentikasi berhasil.
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        // Mengizinkan proses berlanjut jika jumlah percobaan masih di bawah batas.
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        // Mencatat peristiwa lockout untuk request yang melewati batas percobaan.
        event(new Lockout($this));

        // Mengambil sisa waktu sebelum pengguna boleh mencoba login lagi.
        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        // Membentuk kunci unik dari email yang dinormalisasi dan alamat IP.
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
