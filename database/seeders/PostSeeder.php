<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users or create one if none exist
        $user = User::first() ?? User::factory()->create();

        // Create posts
        Post::factory()->count(10)->create([
            'user_id' => $user->id,
        ]);
    }
}