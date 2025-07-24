<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Project;
use App\Models\Column;
use App\Models\Category;
use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $users = User::all();

        foreach ($projects as $project) {
            $columns = $project->columns;
            $categories = $project->categories;
            $groups = $project->groups;
            
            // Create 8-15 tasks per project
            $taskCount = rand(8, 15);
            
            for ($i = 0; $i < $taskCount; $i++) {
                $task = Task::factory()->create([
                    'project_id' => $project->id,
                    'column_id' => $columns->random()->id,
                    'category_id' => $categories->random()->id,
                    'created_by' => $users->random()->id,
                ]);

                // Assign 1-3 users to each task
                $taskUsers = $users->random(rand(1, 3));
                $task->users()->attach($taskUsers);

                // Assign 0-2 groups to each task (some tasks may not have groups)
                if (rand(0, 1) && $groups->count() > 0) {
                    $taskGroups = $groups->random(rand(1, min(2, $groups->count())));
                    $task->groups()->attach($taskGroups);
                }
            }
        }
    }
}
