<?php

namespace Database\Factories\Customer;

use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "title" => fake()->sentence(),
            "content"=> fake()->paragraph(),
            // "tags" => fake()->randomElements([""]),
            "likes" => fake()->numberBetween(0, 100),
            "creator" => fake()->randomElement(Customer::all()->pluck('id')),
            'created_at' => fake()->dateTimeBetween(now()->subMonth(2),now()),
            'updated_at' => fake()->dateTimeBetween(now()->subMonth(2),now())
        ];
    }
}
