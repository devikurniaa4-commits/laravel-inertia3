<?php

// Menetapkan namespace untuk pengujian fitur aplikasi.
namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// Mengimpor kelas dasar test aplikasi.
use Tests\TestCase;

// Memastikan aplikasi dapat merespons request dasar.
class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Meminta halaman utama lalu memastikan respons berhasil.
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
