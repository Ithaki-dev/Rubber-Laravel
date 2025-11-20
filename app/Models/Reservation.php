<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'ride_id',
        'passenger_id',
        'status',
    ];

    /**
     * Get the ride for the reservation.
     */
    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }

    /**
     * Get the passenger for the reservation.
     */
    public function passenger()
    {
        return $this->belongsTo(User::class, 'passenger_id');
    }
}
