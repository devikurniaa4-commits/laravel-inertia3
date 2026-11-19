<?php

// Menetapkan namespace middleware yang menangani request web.
namespace App\Http\Middleware;

// Mengimpor objek permintaan HTTP yang sedang diproses.
use Illuminate\Http\Request;
// Mengimpor middleware dasar integrasi Inertia dengan Laravel.
use Inertia\Middleware;

// Menentukan template dan properti bersama untuk respons halaman Inertia.
class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        // Menggunakan mekanisme versi aset bawaan dari middleware induk.
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        // Menambahkan data autentikasi pengguna ke properti bersama Inertia.
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
        ];
    }
}
