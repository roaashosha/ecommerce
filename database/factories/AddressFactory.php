<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\Governorate;
use App\Models\Region;
use App\Models\Zipcode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_id'=>Country::factory(),
            'governorate_id'=>Governorate::factory(),
            'city_id'=>City::factory(),
            'region_id'=>Region::factory(),
            'zipcode_id'=>Zipcode::factory(),
            'street'=>$this->faker->streetName(),
            'house_no'=>$this->faker->buildingNumber(),
            // 'active'=>$this->faker->boolean(80)
        ];
    }
}
