<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\HttpKernel\EventListener\AddRequestFormatsListener;

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
            "price"=>$this->faker->numberBetween(10,200),
            "status"=>$this->faker->randomElement(['bending','cancelled','delevired']),
            // "active"=>$this->faker->boolean(80),
            "user_id"=>User::factory(),
            "address_id"=>Address::factory()
        ];
    }
}
