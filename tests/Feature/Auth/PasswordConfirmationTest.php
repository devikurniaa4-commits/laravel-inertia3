<?php

// Menetapkan namespace untuk pengujian konfirmasi kata sandi.
namespace Tests\Feature\Auth;

// Mengimpor model pengguna untuk menjalankan pengujian autentikasi.
use App\Models\User;
// Mengisolasi perubahan database pada setiap pengujian.
use Illuminate\Foundation\Testing\RefreshDatabase;
// Mengimpor kelas dasar pengujian aplikasi.
use Tests\TestCase;

// Menguji keberhasilan dan kegagalan konfirmasi kata sandi.
class PasswordConfirmationTest extends TestCase
{
    // Mengatur ulang database untuk setiap kasus pengujian.
    use RefreshDatabase;

    /** Memastikan halaman konfirmasi kata sandi dapat ditampilkan. */
    public function test_confirm_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/confirm-password');

        $response->assertStatus(200);
    }

    /** Memastikan kata sandi yang benar dapat mengonfirmasi identitas pengguna. */
    public function test_password_can_be_confirmed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    /** Memastikan kata sandi yang salah gagal mengonfirmasi identitas pengguna. */
    public function test_password_is_not_confirmed_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
