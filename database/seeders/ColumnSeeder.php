<?php

namespace Database\Seeders;

use App\Models\Column;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $users = User::all();

        // Define typical Kanban board columns
        $columnNames = ['To Do', 'In Progress', 'Review', 'Testing', 'Done'];

        // Create standard columns for each project
        foreach ($projects as $project) {
            foreach ($columnNames as $index => $columnName) {
                Column::factory()->create([
                    'name' => $columnName,
                    'project_id' => $project->id,
                    'created_by' => $users->random()->id,
                    'is_final' => $columnName === 'Done', // Only 'Done' is final
                ]);
            }
        }
    }
}
