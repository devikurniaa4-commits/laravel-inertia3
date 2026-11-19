<?php

// Menetapkan namespace untuk pengujian verifikasi email.
namespace Tests\Feature\Auth;

// Mengimpor model pengguna untuk membuat akun yang diuji.
use App\Models\User;
// Mengimpor event yang diharapkan saat email berhasil diverifikasi.
use Illuminate\Auth\Events\Verified;
// Mengisolasi perubahan database pada setiap pengujian.
use Illuminate\Foundation\Testing\RefreshDatabase;
// Mengimpor facade event untuk memeriksa event verifikasi.
use Illuminate\Support\Facades\Event;
// Mengimpor helper URL untuk membuat tautan verifikasi bertanda tangan.
use Illuminate\Support\Facades\URL;
// Mengimpor kelas dasar pengujian aplikasi.
use Tests\TestCase;

// Menguji halaman, tautan, dan validitas proses verifikasi email.
class EmailVerificationTest extends TestCase
{
    // Mengatur ulang database setelah setiap pengujian.
    use RefreshDatabase;

    /** Memastikan halaman verifikasi email dapat ditampilkan. */
    public function test_email_verification_screen_can_be_rendered(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/verify-email');

        $response->assertStatus(200);
    }

    /** Memastikan email dapat diverifikasi menggunakan tautan yang valid. */
    public function test_email_can_be_verified(): void
    {
        $user = User::factory()->unverified()->create();

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
        $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
    }

    /** Memastikan hash yang tidak valid tidak memverifikasi email. */
    public function test_email_is_not_verified_with_invalid_hash(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }
}
