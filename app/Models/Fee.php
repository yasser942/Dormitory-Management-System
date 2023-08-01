<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;
    protected $fillable =[
        'facility',
        'amount',
        'description'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'fee_user', 'fee_id', 'user_id');
    }
}
