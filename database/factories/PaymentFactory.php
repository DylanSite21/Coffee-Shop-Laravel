<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        $order = Order::factory();

        return [
            'order_id' => $order,
            'amount' => $order->total,
            'method' => $order->payment_method ?? 'cash',
            'status' => fake()->randomElement(['pending', 'paid', 'failed']),
            'paid_at' => fake()->optional()->dateTime(),
        ];
    }
}
