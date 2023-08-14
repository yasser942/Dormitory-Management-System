<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;
    protected $fillable =[
        'title',
        'description',
        'category',
        'price',
        'image',
        'status',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('date','created_at');
    }
    public  function image (){

        return $this->morphOne(Image::class,'imageable');
    }
}
