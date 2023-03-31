<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') === 'testing') {
            // Testing Seeder
            $this->call([]);
        } elseif (env('APP_ENV') === 'local') {
            // Local Seeder [Dev]
            $this->call(array_merge($this->productionSeeder(), $this->devSeeder()));

        } else {
            // Production Seeder
            $this->call($this->productionSeeder());
        }

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }

    protected function devSeeder()
    {
        return [
            CitySeeder::class,
            CustomerSeeder::class,
            CompanySeeder::class,
            PostSeeder::class,
            ServicesSeeder::class,
            SkillSeeder::class,
            TagSeeder::class
        ];
    }

    protected function productionSeeder()
    {
        return [
            CitySeeder::class,
            CustomerSeeder::class,
            CompanySeeder::class,
            PostSeeder::class,
            ServicesSeeder::class,
            SkillSeeder::class,
            TagSeeder::class
        ];
    }
}
