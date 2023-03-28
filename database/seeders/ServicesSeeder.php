<?php

namespace Database\Seeders;

use App\Models\Company\Services;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Services::upsert([
            [
                'name' => 'Painting',
                'description' => 'Painting desc',
                'slug' => 'painting',
            ],
            [
                'name' => 'Plumbing',
                'description' => 'Plumbing desc',
                'slug' => 'plumbing',
            ],
            [
                'name' => 'Electrician',
                'description' => 'Electrician desc',
                'slug' => 'electrian',
            ],
            [
                'name' => 'Interior',
                'description' => 'Interior desc',
                'slug' => 'interior',
            ],
            [
                'name' => 'Tiles Decoration',
                'description' => 'Tiles decoration desc',
                'slug' => 'tiles-decoration',
            ],
            [
                'name' => 'Spray Painting',
                'description' => 'Spray painting desc',
                'slug' => 'spray-painting',
            ],
            [
                'name' => 'Carpentry',
                'description' => 'Carpentry service desc',
                'slug' => 'carpenter',
            ],
            [
                'name' => 'Wood Polish',
                'description' => 'Wood Polish service desc',
                'slug' => 'wood-polish',
            ],
        ], 'name');
    }
}
