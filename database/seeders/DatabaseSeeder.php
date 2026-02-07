<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);

        $tags = [
            ['name' => 'Nature'],
            ['name' => 'Abstract'],
            ['name' => 'Minimal'],
            ['name' => 'Dark'],
            ['name' => 'Light'],
            ['name' => 'Space'],
            ['name' => 'Mountains'],
            ['name' => 'Ocean'],
            ['name' => 'Forest'],
            ['name' => 'City'],
            ['name' => 'Architecture'],
            ['name' => 'Technology'],
            ['name' => 'Gaming'],
            ['name' => 'Anime'],
            ['name' => 'Art'],
            ['name' => 'Cars'],
            ['name' => 'Motorcycles'],
            ['name' => 'Animals'],
            ['name' => 'Flowers'],
            ['name' => 'Landscape'],
            ['name' => 'Portrait'],
            ['name' => 'Gradient'],
            ['name' => 'Pattern'],
            ['name' => 'Neon'],
            ['name' => 'Retro'],
        ];

        Tag::insert($tags);
    }
}
