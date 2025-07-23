<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $users = User::all();

        // Create 2-4 groups per project
        foreach ($projects as $project) {
            $groupCount = rand(2, 4);
            
            for ($i = 0; $i < $groupCount; $i++) {
                $group = Group::factory()->create([
                    'project_id' => $project->id,
                    'created_by' => $users->random()->id,
                ]);

                // Attach 2-6 random users to each group
                $groupUsers = $users->random(rand(2, 6));
                $group->users()->attach($groupUsers);
            }
        }
    }
}
