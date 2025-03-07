<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    protected static function booted()
    {
        static::retrieved(function ($trip) {
            $now = Carbon::now();
            if ($trip->status === 'pending' && $trip->departure_time < $now) {
                $trip->update(['status' => 'canceled']);
            }
        });
    }
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
    public function availability()
    {
        return $this->belongsTo(Availability::class, 'driver_id', 'driver_id')
                    ->where('start_time', '<=', $this->departure_time)
                    ->where('end_time', '>=', $this->departure_time);
    }
}