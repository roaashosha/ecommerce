<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = now();
        $endDate = now()->addDays(30);

        return [
            'name' => $this->faker->word,
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'color_id' => Color::inRandomOrder()->first()->id ?? Color::factory(),
            'size_id' => Size::inRandomOrder()->first()->id ?? Size::factory(),
            'desc' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 200),
            'img' => 'default.png',
            'production_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'expire_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'offer' => $this->faker->boolean(40),
            'offer_type' => $this->faker->randomElement(['%', '-']),
            'offer_price' => $this->faker->randomFloat(2, 1, 50),
            'start_price' => $this->faker->randomFloat(2, 5, 100),
            'end_price' => $this->faker->randomFloat(2, 5, 100),
            // 'active' => $this->faker->boolean(),
            'is_offer' => $this->faker->boolean(),
            'child_id' => 1,
        ];
    }
}
