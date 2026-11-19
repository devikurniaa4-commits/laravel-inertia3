<?php

// Mengimpor kelas dasar untuk menjalankan migrasi.
use Illuminate\Database\Migrations\Migration;
// Mengimpor pembangun struktur kolom tabel.
use Illuminate\Database\Schema\Blueprint;
// Mengimpor facade untuk mengelola skema database.
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Menyiapkan tabel cache dan kunci cache.
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menyimpan nilai cache berdasarkan kunci dan waktu kedaluwarsanya.
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        // Menyimpan kepemilikan dan masa berlaku kunci cache.
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel cache dan kunci cache.
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
