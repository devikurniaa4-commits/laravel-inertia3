<?php

// Menetapkan namespace factory untuk model pengguna.
namespace Database\Factories;

// Mengimpor factory Eloquent, helper hashing, dan pembuat string acak.
use Illuminate\Database\Eloquent\Factories\Factory;
// Mengimpor facade untuk menyimpan kata sandi dalam bentuk hash.
use Illuminate\Support\Facades\Hash;
// Mengimpor helper pembuat token acak.
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Menyusun data pengguna contoh dengan email unik dan kata sandi ter-hash.
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        // Menghasilkan state pengguna yang belum memverifikasi alamat email.
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
