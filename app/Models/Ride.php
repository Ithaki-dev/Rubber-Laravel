<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'name',
        'origin',
        'destination',
        'departure_time',
        'cost',
        'seats',
    ];

    protected function casts(): array
    {
        return [
            'departure_time' => 'datetime',
            'cost' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the ride.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the vehicle for the ride.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the reservations for the ride.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get available seats for the ride.
     */
    public function availableSeats()
    {
        $acceptedReservations = $this->reservations()->where('status', 'accepted')->count();
        return $this->seats - $acceptedReservations;
    }
}
