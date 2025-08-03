<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "product_id"=>Product::factory(),
            "category_id"=>Category::factory(),
            "order_id"=>Order::factory(),
            "offer"=>$this->faker->numberBetween(10,200),
            "offer_price"=>$this->faker->numberBetween(9,199),
            "price"=>$this->faker->numberBetween(10,200),
            "count"=>$this->faker->numberBetween(1,100),
            // "active"=>$this->faker->boolean(80)

        ];
    }
}
