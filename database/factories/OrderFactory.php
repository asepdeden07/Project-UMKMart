<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total_price' => fake()->numberBetween(50000, 1000000),
            'status' => fake()->randomElement(['pending', 'confirmed', 'shipped', 'delivered']),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
