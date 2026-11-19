<?php

// Menetapkan namespace untuk request validasi profil.
namespace App\Http\Requests;

// Mengimpor model pengguna untuk memeriksa keunikan alamat email.
use App\Models\User;
// Mengimpor kontrak tipe aturan validasi.
use Illuminate\Contracts\Validation\ValidationRule;
// Mengimpor kelas dasar untuk memvalidasi form request.
use Illuminate\Foundation\Http\FormRequest;
// Mengimpor aturan validasi unik untuk kolom email.
use Illuminate\Validation\Rule;

// Memvalidasi data yang dikirim saat pengguna memperbarui profil.
class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Mensyaratkan nama dan email valid serta mengabaikan email milik pengguna saat ini.
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}
