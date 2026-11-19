<?php

// Menetapkan namespace untuk pengujian perubahan kata sandi.
namespace Tests\Feature\Auth;

// Mengimpor model pengguna yang akan diperbarui.
use App\Models\User;
// Mengisolasi perubahan database pada setiap pengujian.
use Illuminate\Foundation\Testing\RefreshDatabase;
// Mengimpor helper hash untuk memeriksa kata sandi tersimpan.
use Illuminate\Support\Facades\Hash;
// Mengimpor kelas dasar pengujian aplikasi.
use Tests\TestCase;

// Menguji perubahan kata sandi dengan validasi kata sandi saat ini.
class PasswordUpdateTest extends TestCase
{
    // Mengatur ulang database di setiap kasus pengujian.
    use RefreshDatabase;

    /** Memastikan pengguna dapat memperbarui kata sandinya. */
    public function test_password_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    /** Memastikan perubahan kata sandi memerlukan kata sandi saat ini yang benar. */
    public function test_correct_password_must_be_provided_to_update_password(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasErrors('current_password')
            ->assertRedirect('/profile');
    }
}
