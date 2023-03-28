<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Skill::upsert([
            [
                'name' => 'Painting',
                'description' => 'painting desc',
                'slug' => 'painiting'
            ],
            [
                'name' => 'Plumber',
                'description' => 'Plumber desc',
                'slug' => 'plumber'
            ],
            [
                'name' => 'Electrician',
                'description' => 'Electrician desc',
                'slug' => 'electrician'
            ],
            [
                'name' => 'Polisher',
                'description' => 'Polisher desc',
                'slug' => 'polisher'
            ],
            [
                'name' => 'Carpenter',
                'description' => 'Carpenter desc',
                'slug' => 'carpenter'
            ],
            [
                'name' => 'Spray Painter',
                'description' => 'Spray Painter desc',
                'slug' => 'spray-painter'
            ],
            [
                'name' => 'Tiles Setter',
                'description' => 'Tiles Setter desc',
                'slug' => 'tiles-setter'
            ],
            
        ], 'name');
    }
}
