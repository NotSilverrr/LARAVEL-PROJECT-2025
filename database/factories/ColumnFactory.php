<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Column>
 */
class ColumnFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'To Do', 'In Progress', 'Review', 'Testing', 'Done',
                'Backlog', 'Ready', 'Development', 'QA', 'Completed'
            ]),
            'is_final' => fake()->boolean(20), // 20% chance of being final
            'created_by' => 1, // Will be set explicitly in seeder
            'project_id' => 1, // Will be set explicitly in seeder
        ];
    }
}
