<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ride>
 */
class RideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'vehicle_id' => Vehicle::factory(),
            'name' => fake()->sentence(3),
            'origin' => fake()->city(),
            'destination' => fake()->city(),
            'departure_time' => fake()->dateTimeBetween('now', '+1 month'),
            'cost' => fake()->randomFloat(2, 500, 5000),
            'seats' => fake()->numberBetween(1, 4),
        ];
    }
}
