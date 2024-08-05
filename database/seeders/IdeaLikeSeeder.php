<?php

namespace Database\Seeders;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdeaLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ideas = Idea::all();
        User::all()->each(function ($user) use ($ideas) {
            for ($i = 0; $i < rand(1, 5); $i++) {
                $idea = $ideas->random();
                if (!$user->doesLikeIdea($idea)) {
                    $user->likedIdeas()->attach($idea);
                }
            }
        });
    }
}
