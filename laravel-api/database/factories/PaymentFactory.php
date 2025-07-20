<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'transaction_id' => 'txn_' . $this->faker->unique()->regexify('[A-Za-z0-9]{12}'),
            'amount' => $this->faker->randomFloat(2, 50, 2000), // This will be overwritten in the seeder
            'status' => 'success', // Default to success for simplicity
            'payment_gateway_details' => json_encode(['foo' => 'bar']),
        ];
    }
}
