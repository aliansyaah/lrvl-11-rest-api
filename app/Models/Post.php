<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Mass assignment
    protected $fillable = [
        'image',
        'title',
        'content',
    ];

    /*
     * Aturan Penamaan Accessor 
     * Penamaan method yang dibuat harus sama dengan nama field yang akan diformat 
     * dan menggunakan "CamelCase".
     * 
     */
    protected function image(): Attribute
    {
        // Contoh return: domain.com/storage/posts/nama_file_image.png
        return Attribute::make(
            get: fn ($image) => url('/storage/posts/'.$image),
        );
    }
}
