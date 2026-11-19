<?php

// Menetapkan namespace untuk pengujian reset kata sandi.
namespace Tests\Feature\Auth;

// Mengimpor model pengguna dan notifikasi reset kata sandi.
use App\Models\User;
// Mengimpor notifikasi yang dikirim untuk tautan reset kata sandi.
use Illuminate\Auth\Notifications\ResetPassword;
// Mengisolasi perubahan database pada setiap pengujian.
use Illuminate\Foundation\Testing\RefreshDatabase;
// Mengimpor facade notifikasi untuk memeriksa pengiriman email reset.
use Illuminate\Support\Facades\Notification;
// Mengimpor kelas dasar pengujian aplikasi.
use Tests\TestCase;

// Menguji permintaan tautan reset dan penyimpanan kata sandi baru.
class PasswordResetTest extends TestCase
{
    // Mengatur ulang database sebelum setiap kasus pengujian.
    use RefreshDatabase;

    /** Memastikan halaman permintaan tautan reset kata sandi dapat ditampilkan. */
    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    /** Memastikan pengguna dapat meminta tautan reset kata sandi. */
    public function test_reset_password_link_can_be_requested(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    /** Memastikan halaman pengaturan ulang kata sandi dapat ditampilkan. */
    public function test_reset_password_screen_can_be_rendered(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
            $response = $this->get('/reset-password/'.$notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    /** Memastikan kata sandi dapat diatur ulang menggunakan token yang valid. */
    public function test_password_can_be_reset_with_valid_token(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $response = $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response
                ->assertSessionHasNoErrors()
                ->assertRedirect(route('login'));

            return true;
        });
    }
}
