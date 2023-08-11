<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;
    protected $fillable =[
        'title',
        'description',
        'capacity',
        'price',
        'image',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'sport_user', 'sport_id', 'user_id')
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }
    public  function image (){

        return $this->morphOne(Image::class,'imageable');
    }
}
