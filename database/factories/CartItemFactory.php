<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "price"=>$this->faker->numberBetween(10,200),
            'offer'=>$this->faker->numberBetween(1,50),
            'offer_price'=>$this->faker->numberBetween(9,199),
            'quantity'=>$this->faker->numberBetween(1,50),
            "product_id"=>Product::factory(),
            "color_id"=>Color::factory(),
            "size_id"=>Size::factory(),
            "cart_id"=>Cart::factory(),
            // "active"=>$this->faker->boolean(80)
        ];
    }
}
