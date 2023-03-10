<?php

namespace Database\Factories\Customer;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        if (env('APP_ENV') === 'testing')
        {
            return [
                "name" => fake()->name,
                "email" => fake()->email,
                "password" => Hash::make('customer'),
                "contact" => fake()->numberBetween(5555555555,9999999999),
            ];
        }else{
            return [
                "name" => fake()->name,
                "email" => fake()->unique()->safeEmail(),
                "password" => Hash::make('customer'),
                "contact" => fake()->numberBetween(5555555555,9999999999),
                "email_verified_at" => now()->timestamp,
                'created_at' => fake()->dateTimeBetween(now()->subMonth(2),now()),
                'updated_at' => fake()->dateTimeBetween(now()->subMonth(2),now())
            ];
        }
    }
}
