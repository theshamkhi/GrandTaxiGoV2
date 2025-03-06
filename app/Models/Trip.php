<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'passenger_id',
        'driver_id',
        'pickup_location',
        'destination',
        'departure_time',
        'status',
        'price'
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'price' => 'decimal:2',
        'status' => 'string',
    ];

    // Relationships
    public function passenger()
    {
        return $this->belongsTo(User::class, 'passenger_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'trip_id');
    }
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
}