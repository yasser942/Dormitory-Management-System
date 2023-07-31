<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'isbn',
        'author',
        'category',
        'publication_date',
        'description',
        'cover_image',
    ];
}
