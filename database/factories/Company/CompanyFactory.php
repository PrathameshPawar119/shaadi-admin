<?php

namespace Database\Factories\Company;

use App\Models\Company\Company;
use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => fake()->company(),
            "title" => fake()->title(),
            "about" => fake()->paragraph(),
            "email" => fake()->unique()->safeEmail(),
            "industry_type" => fake()->randomElement(Company::IndustryTypes),
            "main_city" => fake()->city(),
            "company_size" => fake()->randomElement(Company::CompanySize),
            "creator" => fake()->randomElement(Customer::all()->pluck('id'))
        ];
    }
}
