<?php

namespace Tests\Feature;

use App\Models\Ride;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RideManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function driver_can_create_ride()
    {
        $driver = User::factory()->create(['role' => 'driver', 'status' => 'active']);
        $vehicle = Vehicle::factory()->create(['user_id' => $driver->id]);

        $response = $this->actingAs($driver)->post('/rides', [
            'vehicle_id' => $vehicle->id,
            'name' => 'Test Ride',
            'origin' => 'San José',
            'destination' => 'Cartago',
            'departure_time' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'cost' => 2000,
            'seats' => 3,
        ]);

        $this->assertDatabaseHas('rides', [
            'name' => 'Test Ride',
            'origin' => 'San José',
            'destination' => 'Cartago',
            'user_id' => $driver->id,
        ]);
    }

    /** @test */
    public function passenger_cannot_create_ride()
    {
        $passenger = User::factory()->create(['role' => 'passenger', 'status' => 'active']);
        $driver = User::factory()->create(['role' => 'driver', 'status' => 'active']);
        $vehicle = Vehicle::factory()->create(['user_id' => $driver->id]);

        $response = $this->actingAs($passenger)->post('/rides', [
            'vehicle_id' => $vehicle->id,
            'name' => 'Test Ride',
            'origin' => 'San José',
            'destination' => 'Cartago',
            'departure_time' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'cost' => 2000,
            'seats' => 3,
        ]);

        $this->assertDatabaseMissing('rides', [
            'name' => 'Test Ride',
        ]);
    }

    /** @test */
    public function driver_can_update_own_ride()
    {
        $driver = User::factory()->create(['role' => 'driver', 'status' => 'active']);
        $vehicle = Vehicle::factory()->create(['user_id' => $driver->id]);
        $ride = Ride::factory()->create(['user_id' => $driver->id, 'vehicle_id' => $vehicle->id]);

        $response = $this->actingAs($driver)->put("/rides/{$ride->id}", [
            'vehicle_id' => $vehicle->id,
            'name' => 'Updated Ride',
            'origin' => $ride->origin,
            'destination' => $ride->destination,
            'departure_time' => $ride->departure_time->format('Y-m-d H:i:s'),
            'cost' => $ride->cost,
            'seats' => $ride->seats,
        ]);

        $this->assertDatabaseHas('rides', [
            'id' => $ride->id,
            'name' => 'Updated Ride',
        ]);
    }

    /** @test */
    public function driver_cannot_update_other_driver_ride()
    {
        $driver1 = User::factory()->create(['role' => 'driver', 'status' => 'active']);
        $driver2 = User::factory()->create(['role' => 'driver', 'status' => 'active']);
        $vehicle = Vehicle::factory()->create(['user_id' => $driver1->id]);
        $ride = Ride::factory()->create(['user_id' => $driver1->id, 'vehicle_id' => $vehicle->id]);

        $response = $this->actingAs($driver2)->put("/rides/{$ride->id}", [
            'vehicle_id' => $vehicle->id,
            'name' => 'Hacked Ride',
            'origin' => $ride->origin,
            'destination' => $ride->destination,
            'departure_time' => $ride->departure_time->format('Y-m-d H:i:s'),
            'cost' => $ride->cost,
            'seats' => $ride->seats,
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function driver_can_delete_own_ride()
    {
        $driver = User::factory()->create(['role' => 'driver', 'status' => 'active']);
        $vehicle = Vehicle::factory()->create(['user_id' => $driver->id]);
        $ride = Ride::factory()->create(['user_id' => $driver->id, 'vehicle_id' => $vehicle->id]);

        $response = $this->actingAs($driver)->delete("/rides/{$ride->id}");

        $this->assertDatabaseMissing('rides', [
            'id' => $ride->id,
        ]);
    }
}
