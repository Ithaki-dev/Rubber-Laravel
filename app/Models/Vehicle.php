<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'user_id',
        'plate',
        'brand',
        'model',
        'year',
        'color',
        'photo',
        'capacity',
    ];

    /**
     * Get the user that owns the vehicle.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the rides for the vehicle.
     */
    public function rides()
    {
        return $this->hasMany(Ride::class);
    }
}
