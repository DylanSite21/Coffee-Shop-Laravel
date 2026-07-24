<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_number' => 'ORD-' . strtoupper(fake()->bothify('??####')),
            'user_id' => User::factory(),
            'total' => fake()->numberBetween(10000, 200000),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed']),
            'payment_method' => fake()->randomElement(['cash', 'qris', 'transfer']),
            'notes' => fake()->optional()->sentence(),
            'shipping_address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
        ];
    }
}
