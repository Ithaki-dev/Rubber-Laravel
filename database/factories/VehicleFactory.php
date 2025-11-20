<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
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
            'plate' => fake()->unique()->bothify('???-####'),
            'brand' => fake()->randomElement(['Toyota', 'Honda', 'Nissan', 'Mazda', 'Hyundai']),
            'model' => fake()->randomElement(['Corolla', 'Civic', 'Sentra', 'CX-5', 'Elantra']),
            'year' => fake()->numberBetween(2010, 2024),
            'color' => fake()->safeColorName(),
            'photo' => null,
            'capacity' => fake()->numberBetween(2, 7),
        ];
    }
}
