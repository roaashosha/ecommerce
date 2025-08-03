<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id"=>User::factory(),
            "price"=>$this->faker->numberBetween(100,2000),
            "discount"=>$this->faker->numberBetween(100,200),
            "shipping"=>$this->faker->numberBetween(10,60),
            "fees"=>$this->faker->numberBetween(10,100),
            // "active"=>$this->faker->boolean(80)
        ];
    }
}
