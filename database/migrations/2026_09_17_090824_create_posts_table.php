<?php

// Mengimpor kelas dasar untuk menjalankan migrasi.
use Illuminate\Database\Migrations\Migration;
// Mengimpor pembangun struktur kolom tabel post.
use Illuminate\Database\Schema\Blueprint;
// Mengimpor facade untuk mengelola tabel pada database.
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Membuat tabel untuk menyimpan data post.
    /**
     * Run the migrations.
     */
    public function up(): void
{
    // Menambahkan kolom identitas, judul, isi, dan waktu post.
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('content');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel post saat migrasi dibatalkan.
        Schema::dropIfExists('posts');
    }
};
