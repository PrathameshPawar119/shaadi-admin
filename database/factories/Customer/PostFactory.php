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
            "tags" => fake()->randomElements(["new", "done", "happy", "helpful", "nice", "glass", "polish", "project"], 2, false),
            "likes" => fake()->numberBetween(0, 100),
            "creator" => $creator = fake()->randomElement(Customer::all()->pluck('id')),
            "city" => Customer::find($creator)->city,
            'created_at' => fake()->dateTimeBetween(now()->subMonth(2),now()),
            'updated_at' => fake()->dateTimeBetween(now()->subMonth(2),now())
        ];
    }
}
