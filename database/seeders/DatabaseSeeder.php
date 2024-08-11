<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            AdminUserSeeder::class,
            UserSeeder::class,
            IdeaSeeder::class,
            IdeaLikeSeeder::class,
            CommentSeeder::class,
            NotebookSeeder::class,
        ]);
    }
}
