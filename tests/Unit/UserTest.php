<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Ride;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_has_vehicles_relationship()
    {
        $user = User::factory()->create(['role' => 'driver']);
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->vehicles->contains($vehicle));
        $this->assertInstanceOf(Vehicle::class, $user->vehicles->first());
    }

    /** @test */
    public function user_has_rides_relationship()
    {
        $user = User::factory()->create(['role' => 'driver']);
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);
        $ride = Ride::factory()->create(['user_id' => $user->id, 'vehicle_id' => $vehicle->id]);

        $this->assertTrue($user->rides->contains($ride));
        $this->assertInstanceOf(Ride::class, $user->rides->first());
    }

    /** @test */
    public function user_has_reservations_relationship()
    {
        $passenger = User::factory()->create(['role' => 'passenger']);
        $driver = User::factory()->create(['role' => 'driver']);
        $vehicle = Vehicle::factory()->create(['user_id' => $driver->id]);
        $ride = Ride::factory()->create(['user_id' => $driver->id, 'vehicle_id' => $vehicle->id]);
        $reservation = Reservation::factory()->create(['ride_id' => $ride->id, 'passenger_id' => $passenger->id]);

        $this->assertTrue($passenger->reservations->contains($reservation));
        $this->assertInstanceOf(Reservation::class, $passenger->reservations->first());
    }

    /** @test */
    public function user_password_is_hashed()
    {
        $user = User::factory()->create(['password' => 'password123']);

        $this->assertNotEquals('password123', $user->password);
        $this->assertTrue(\Hash::check('password123', $user->password));
    }

    /** @test */
    public function user_has_default_pending_status()
    {
        $user = User::factory()->create();

        $this->assertEquals('pending', $user->status);
    }
}
