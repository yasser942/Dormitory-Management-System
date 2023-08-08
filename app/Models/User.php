<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'last_name',
        'phone',
        'address',
        'status',
        'profileable_id',
        'profileable_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function profileable()
    {
        return $this->morphTo();
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_student', 'student_id', 'room_id') ->withPivot('start_date', 'end_date');
    }
    public function fees()
    {
        return $this->belongsToMany(Fee::class, 'fee_user', 'user_id', 'fee_id');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class)
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }
    public function sports()
    {
        return $this->belongsToMany(Sport::class)
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }
    public function meals()
    {
        return $this->belongsToMany(Meal::class)->withPivot('date');
    }
}
