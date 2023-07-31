<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable =[
        'room_number',
        'type',
        'price',
        'description',
    ];

    public function students()
    {
        return $this->belongsToMany(User::class, 'room_student', 'room_id', 'student_id');
    }
}
