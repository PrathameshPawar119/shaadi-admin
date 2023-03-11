<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $name = fake()->unique()->word,
            'url' => Str::slug($name),
            'state_name' => fake()->word,
            'state_code' => fake()->word,
            'status' => true,
            'country_code' => 'IN',
            'default' => true
        ];
    }
}
