<?php

namespace Tests\Unit;

use App\Models\Ride;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RideTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ride_belongs_to_user()
    {
        $user = User::factory()->create(['role' => 'driver']);
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);
        $ride = Ride::factory()->create(['user_id' => $user->id, 'vehicle_id' => $vehicle->id]);

        $this->assertInstanceOf(User::class, $ride->user);
        $this->assertEquals($user->id, $ride->user->id);
    }

    /** @test */
    public function ride_belongs_to_vehicle()
    {
        $user = User::factory()->create(['role' => 'driver']);
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);
        $ride = Ride::factory()->create(['user_id' => $user->id, 'vehicle_id' => $vehicle->id]);

        $this->assertInstanceOf(Vehicle::class, $ride->vehicle);
        $this->assertEquals($vehicle->id, $ride->vehicle->id);
    }

    /** @test */
    public function ride_has_reservations_relationship()
    {
        $driver = User::factory()->create(['role' => 'driver']);
        $passenger = User::factory()->create(['role' => 'passenger']);
        $vehicle = Vehicle::factory()->create(['user_id' => $driver->id]);
        $ride = Ride::factory()->create(['user_id' => $driver->id, 'vehicle_id' => $vehicle->id]);
        $reservation = Reservation::factory()->create(['ride_id' => $ride->id, 'passenger_id' => $passenger->id]);

        $this->assertTrue($ride->reservations->contains($reservation));
    }

    /** @test */
    public function available_seats_calculates_correctly()
    {
        $driver = User::factory()->create(['role' => 'driver']);
        $vehicle = Vehicle::factory()->create(['user_id' => $driver->id]);
        $ride = Ride::factory()->create([
            'user_id' => $driver->id,
            'vehicle_id' => $vehicle->id,
            'seats' => 4
        ]);

        // No reservations
        $this->assertEquals(4, $ride->availableSeats());

        // Add 2 accepted reservations
        $passenger1 = User::factory()->create(['role' => 'passenger']);
        $passenger2 = User::factory()->create(['role' => 'passenger']);
        Reservation::factory()->create(['ride_id' => $ride->id, 'passenger_id' => $passenger1->id, 'status' => 'accepted']);
        Reservation::factory()->create(['ride_id' => $ride->id, 'passenger_id' => $passenger2->id, 'status' => 'accepted']);

        $ride->refresh();
        $this->assertEquals(2, $ride->availableSeats());

        // Pending reservations should not count
        $passenger3 = User::factory()->create(['role' => 'passenger']);
        Reservation::factory()->create(['ride_id' => $ride->id, 'passenger_id' => $passenger3->id, 'status' => 'pending']);

        $ride->refresh();
        $this->assertEquals(2, $ride->availableSeats());
    }
}
