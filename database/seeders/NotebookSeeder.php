<?php

namespace Database\Seeders;

use App\Models\Notebook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotebookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notebook::factory(50)->create()->each(function (Notebook $notebook) {
            $notebook->users()->attach($notebook->creator_id);
        });
    }
}
