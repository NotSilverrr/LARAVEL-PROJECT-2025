<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $users = User::all();

        // Create 3-5 categories per project
        foreach ($projects as $project) {
            $categoryCount = rand(3, 5);
            
            for ($i = 0; $i < $categoryCount; $i++) {
                Category::factory()->create([
                    'project_id' => $project->id,
                    'created_by' => $users->random()->id,
                ]);
            }
        }
    }
}
