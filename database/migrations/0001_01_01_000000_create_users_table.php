<?php

// Mengimpor kelas dasar untuk mendefinisikan migrasi.
use Illuminate\Database\Migrations\Migration;
// Mengimpor pembangun definisi kolom tabel.
use Illuminate\Database\Schema\Blueprint;
// Mengimpor facade untuk membuat dan menghapus tabel.
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Membuat tabel akun, token reset kata sandi, dan sesi pengguna.
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menyimpan informasi utama akun dan waktu verifikasi email.
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Menyimpan token yang digunakan untuk proses reset kata sandi.
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Menyimpan data sesi aktif, termasuk pengguna dan aktivitas terakhir.
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel yang dibuat oleh migrasi ini.
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
