<?php

namespace Tests\Unit;

use App\Models\Reservation;
use App\Models\Ride;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function reservation_belongs_to_ride()
    {
        $driver = User::factory()->create(['role' => 'driver']);
        $passenger = User::factory()->create(['role' => 'passenger']);
        $vehicle = Vehicle::factory()->create(['user_id' => $driver->id]);
        $ride = Ride::factory()->create(['user_id' => $driver->id, 'vehicle_id' => $vehicle->id]);
        $reservation = Reservation::factory()->create(['ride_id' => $ride->id, 'passenger_id' => $passenger->id]);

        $this->assertInstanceOf(Ride::class, $reservation->ride);
        $this->assertEquals($ride->id, $reservation->ride->id);
    }

    /** @test */
    public function reservation_belongs_to_passenger()
    {
        $driver = User::factory()->create(['role' => 'driver']);
        $passenger = User::factory()->create(['role' => 'passenger']);
        $vehicle = Vehicle::factory()->create(['user_id' => $driver->id]);
        $ride = Ride::factory()->create(['user_id' => $driver->id, 'vehicle_id' => $vehicle->id]);
        $reservation = Reservation::factory()->create(['ride_id' => $ride->id, 'passenger_id' => $passenger->id]);

        $this->assertInstanceOf(User::class, $reservation->passenger);
        $this->assertEquals($passenger->id, $reservation->passenger->id);
    }

    /** @test */
    public function reservation_has_default_pending_status()
    {
        $driver = User::factory()->create(['role' => 'driver']);
        $passenger = User::factory()->create(['role' => 'passenger']);
        $vehicle = Vehicle::factory()->create(['user_id' => $driver->id]);
        $ride = Ride::factory()->create(['user_id' => $driver->id, 'vehicle_id' => $vehicle->id]);
        $reservation = Reservation::factory()->create(['ride_id' => $ride->id, 'passenger_id' => $passenger->id]);

        $this->assertEquals('pending', $reservation->status);
    }
}
