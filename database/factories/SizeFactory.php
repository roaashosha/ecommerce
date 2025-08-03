<?php

namespace Database\Factories;
use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Size>
 */
class SizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    static $index = 0;
    public function definition()
    {
        $values = [
        ['name' => 'Small', 'active' => true],
        ['name' => 'Medium', 'active' => true],
        ['name' => 'Large', 'active' => false],
    ];

        $value = $values[self::$index % count($values)];
        self::$index++;

        return $value;
    }
}
