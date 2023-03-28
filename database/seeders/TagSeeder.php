<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::upsert([
            [
                'name' => 'new',
                'description' => 'new entity'
            ],
            [
                'name' => 'completed',
                'description' => 'completed entity'
            ],
            [
                'name' => 'painting',
                'description' => 'painting entity'
            ],
            [
                'name' => 'happy',
                'description' => 'happy entity'
            ],
            [
                'name' => 'information',
                'description' => 'information entity'
            ],
            [
                'name' => 'helpful',
                'description' => 'helpful entity'
            ],
            [
                'name' => 'comedy',
                'description' => 'comedy entity'
            ],
            [
                'name' => 'plumbing',
                'description' => 'plumbing entity'
            ],
            [
                'name' => 'carpenter',
                'description' => 'carpenter entity'
            ],
            [
                'name' => 'project',
                'description' => 'project entity'
            ],
            [
                'name' => 'nice',
                'description' => 'nice entity'
            ],
            [
                'name' => 'raw',
                'description' => 'raw entity'
            ],
            [
                'name' => 'glass',
                'description' => 'glass entity'
            ],
            [
                'name' => 'done',
                'description' => 'done entity'
            ],
            [
                'name' => 'polish',
                'descriptionription' => 'polish entity'
            ]
        ], 'name');
    }
}
