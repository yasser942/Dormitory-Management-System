<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;
    protected $fillable =[
        'student_number',
        'university',
        'department',
        'degree',
        'enrollment_date',
        'graduation_date'
    ];
    public function user()
    {
        return $this->morphOne(User::class, 'profileable');
    }
}
