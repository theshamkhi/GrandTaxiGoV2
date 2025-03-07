<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo',
        'phone'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => 'string',
    ];

    // Relationships
    public function tripsAsPassenger()
    {
        return $this->hasMany(Trip::class, 'passenger_id');
    }

    public function tripsAsDriver()
    {
        return $this->hasMany(Trip::class, 'driver_id');
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'driver_id');
    }

    public function paymentsAsPassenger()
    {
        return $this->hasMany(Payment::class, 'passenger_id');
    }
    public function paymentsAsDriver()
    {
        return $this->hasMany(Payment::class, 'driver_id');
    }
    public function reviewsAsDriver()
    {
        return $this->hasMany(Review::class, 'driver_id');
    }
    public function reviewsAsPassenger()
    {
        return $this->hasMany(Review::class, 'passenger_id');
    }
}