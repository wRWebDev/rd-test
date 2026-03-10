<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class WarehouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $city = $this->faker->city;
        $name = "{$city} Warehouse";

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'geo_location' => "{$this->faker->latitude},{$this->faker->longitude}",
            'address_1' => 'Unit '.rand(1, 100),
            'address_2' => $this->faker->streetName,
            'town' => $city,
            'county' => $city.$this->faker->citySuffix,
            'postcode' => $this->faker->postcode,
            'state_code' => strtoupper($this->faker->randomLetter.$this->faker->randomLetter),
            'country_code' => $this->faker->countryCode,
        ];
    }
}
