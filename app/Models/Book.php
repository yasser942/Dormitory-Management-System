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

    public function users()
    {
        return $this->belongsToMany(User::class, 'book_user', 'book_id', 'user_id')
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }

    public  function image (){

        return $this->morphOne(Image::class,'imageable');
    }
    public function isBorrowedBy($user)
    {
        return $this->users->contains($user);
    }
    public function isAvailable()
    {
        return $this->users->isEmpty();
    }
    public function returnBook(User $user)
    {
        $this->users()->detach($user);
    }

}
