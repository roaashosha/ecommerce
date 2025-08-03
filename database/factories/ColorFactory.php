<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Color>
 */
class ColorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    static $index = 0;
    public function definition(): array
    {
        $values = [
        ['name' => 'Red', 'active' => true],
        ['name' => 'Green', 'active' => true],
        ['name' => 'Blue', 'active' => false],
    ];

        $value = $values[self::$index % count($values)];
        self::$index++;

        return $value;
    }
}
