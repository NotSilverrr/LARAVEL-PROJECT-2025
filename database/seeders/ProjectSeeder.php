<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all existing users to assign as project creators
        $users = User::all();

        // Create 10 projects with different users as creators
        foreach ($users->random(10) as $user) {
            Project::factory()->create([
                'created_by' => $user->id,
            ]);
        }
    }
}
