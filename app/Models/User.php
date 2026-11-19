<?php

// Menetapkan namespace model untuk data pengguna.
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// Mengimpor dukungan factory untuk membuat data pengguna.
use Illuminate\Database\Eloquent\Factories\HasFactory;
// Mengimpor model dasar autentikasi Laravel.
use Illuminate\Foundation\Auth\User as Authenticatable;
// Mengimpor dukungan notifikasi untuk pengguna.
use Illuminate\Notifications\Notifiable;

// Merepresentasikan akun pengguna yang dapat diautentikasi.
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    // Menambahkan dukungan pembuatan data factory dan notifikasi.
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
