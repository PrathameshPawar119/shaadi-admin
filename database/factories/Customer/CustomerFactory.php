<?php

namespace Database\Factories\Customer;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


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
                "name" => $name = fake()->name,
                "slug" => Str::slug($name),
                "title" => fake()->sentence(3),
                "email" => fake()->unique()->safeEmail(),
                "password" => Hash::make('customer'),
                "contact" => fake()->numberBetween(5555555555,9999999999),
                "city" =>  fake()->randomElement(City::all()->pluck('name', 'id')),
                "email_verified_at" => now()->timestamp,
                'created_at' => fake()->dateTimeBetween(now()->subMonth(2),now()),
                'updated_at' => fake()->dateTimeBetween(now()->subMonth(2),now())
            ];
        }
    }
}
