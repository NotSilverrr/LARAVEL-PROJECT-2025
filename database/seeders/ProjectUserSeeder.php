<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $users = User::all();

        foreach ($projects as $project) {
            // Attach the project creator as owner
            $project->users()->attach($project->created_by, ['role' => 'owner']);
            
            // Get remaining users (excluding the creator)
            $remainingUsers = $users->except($project->created_by);
            
            // Attach 3-8 additional users with random roles
            $projectUsers = $remainingUsers->random(rand(3, min(8, $remainingUsers->count())));
            
            foreach ($projectUsers as $user) {
                $role = fake()->randomElement(['admin', 'member', 'member', 'member']); // More members than admins
                $project->users()->attach($user->id, ['role' => $role]);
            }
        }
    }
}
