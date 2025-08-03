<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'name' => $this->faker->unique()->word,
        'img' => $this->faker->imageUrl(200, 200, 'category'),
        // 'active' => $this->faker->boolean(90), // 90% chance of being active
        'child_id' => 1, // Will be assigned manually in seeder
    ];
    }
}
