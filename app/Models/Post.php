<?php

// Menetapkan namespace model untuk data post.
namespace App\Models;

// Mengimpor model Eloquent sebagai dasar model post.
use Illuminate\Database\Eloquent\Model;

// Merepresentasikan post dan menentukan kolom yang boleh diisi secara massal.
class Post extends Model
{
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        // Membatasi pengisian massal pada judul dan isi post.
        'title', 'content'
    ];
}