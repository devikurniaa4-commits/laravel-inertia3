<?php

// Menetapkan namespace untuk pengujian unit.
namespace Tests\Unit;

// Mengimpor kelas dasar test dari PHPUnit.
use PHPUnit\Framework\TestCase;

// Menyediakan contoh pengujian unit sederhana.
class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }
}
