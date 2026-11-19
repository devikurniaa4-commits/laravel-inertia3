<?php

// Menetapkan namespace untuk pengujian pendaftaran akun.
namespace Tests\Feature\Auth;

// Mengisolasi perubahan database pada setiap pengujian.
use Illuminate\Foundation\Testing\RefreshDatabase;
// Mengimpor kelas dasar pengujian aplikasi.
use Tests\TestCase;

// Menguji tampilan dan proses pembuatan akun pengguna baru.
class RegistrationTest extends TestCase
{
    // Mengatur ulang database untuk setiap kasus pengujian.
    use RefreshDatabase;

    /** Memastikan halaman pendaftaran dapat ditampilkan. */
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /** Memastikan pengguna baru dapat mendaftar dengan data yang valid. */
    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
