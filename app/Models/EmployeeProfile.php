<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeProfile extends Model
{
    use HasFactory;

    protected $fillable=[
        'job_title',
        'department',
        'salary',
        'hire_date',
    ];
    public function user()
    {
        return $this->morphOne(User::class, 'profileable');
    }
}
