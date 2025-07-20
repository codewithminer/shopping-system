<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $shippingAddress = [
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
            'zip_code' => $this->faker->postcode,
        ];
        return [
            'user_id' => User::factory(),
            'total_price' => 0, // We will calculate this in the seeder
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
            'shipping_address' => json_encode($shippingAddress),
            'billing_address' => json_encode($shippingAddress),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal']),
            'payment_status' => 'pending', // Default to pending, will be updated by payment seeder logic
        ];
    }
}
