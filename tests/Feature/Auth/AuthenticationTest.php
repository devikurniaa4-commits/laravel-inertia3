<?php

// Menetapkan namespace untuk pengujian fitur autentikasi.
namespace Tests\Feature\Auth;

// Mengimpor model pengguna untuk membuat akun pengujian.
use App\Models\User;
// Mengisolasi perubahan database pada setiap pengujian.
use Illuminate\Foundation\Testing\RefreshDatabase;
// Mengimpor kelas dasar pengujian aplikasi.
use Tests\TestCase;

// Menguji proses masuk dan keluar akun.
class AuthenticationTest extends TestCase
{
    // Mengembalikan database ke kondisi awal untuk setiap kasus.
    use RefreshDatabase;

    /** Memastikan halaman login dapat ditampilkan. */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /** Memastikan pengguna dapat login dengan kredensial yang valid. */
    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    /** Memastikan kata sandi yang salah tidak dapat digunakan untuk login. */
    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    /** Memastikan pengguna yang sudah login dapat keluar. */
    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
