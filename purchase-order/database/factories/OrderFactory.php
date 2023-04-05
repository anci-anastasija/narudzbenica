<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Product;
use App\Models\Supplier;

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
        return [
            'order_description'=>fake()->sentence,
            'quantity'=>fake()->randomNumber(2, false),
            'product_id'=>Product::factory(),
            'user_id'=>User::factory(),
            'supplier_id'=>Supplier::factory(),
        ];
    }
}
