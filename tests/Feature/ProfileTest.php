<?php

// Menetapkan namespace untuk rangkaian pengujian fitur profil.
namespace Tests\Feature;

// Mengimpor model pengguna untuk kebutuhan pengujian akun.
use App\Models\User;
// Mengimpor trait untuk mengatur ulang database pada setiap pengujian.
use Illuminate\Foundation\Testing\RefreshDatabase;
// Mengimpor kelas dasar pengujian aplikasi.
use Tests\TestCase;

// Menguji tampilan, pembaruan, dan penghapusan profil pengguna.
class ProfileTest extends TestCase
{
    // Mengisolasi data database di setiap kasus pengujian.
    use RefreshDatabase;

    /** Memastikan halaman profil dapat ditampilkan kepada pengguna. */
    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    /** Memastikan pengguna dapat memperbarui informasi profilnya. */
    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    /** Memastikan status verifikasi email tetap sama jika alamat email tidak berubah. */
    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    /** Memastikan pengguna dapat menghapus akunnya sendiri. */
    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    /** Memastikan penghapusan akun memerlukan kata sandi yang benar. */
    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrors('password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
