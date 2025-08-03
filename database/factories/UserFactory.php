<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'address_id' => Address::inRandomOrder()->first()->id ?? Address::factory(),
            'phone' => fake()->numerify('01#########'),
            'birth_date' => fake()->date('Y-m-d'),
            'theme' => fake()->boolean(),
            'lang' => fake()->randomElement(['en', 'ar']),
            'img' => 'img/' . fake()->uuid() . '.png',  // Just a fake image path as text
            'gender' => fake()->randomElement(['male', 'female']),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            // 'active' => fake()->boolean(),
            'role_id' => Role::inRandomOrder()->first()->id ?? Role::factory(),
            'remember_token' => Str::random(10),

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
