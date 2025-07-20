<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-1 month', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate, '+2 months');
        
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->sentence(10), // Shorter description
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'status' => fake()->randomElement(['todo', 'in_progress', 'done']),
            'date_start' => $startDate,
            'date_end' => $endDate,
            'finished_at' => fake()->optional(0.3)->dateTimeBetween($startDate, $endDate),
            // These will be set explicitly in the seeder
            'created_by' => 1,
            'project_id' => 1,
            'column_id' => 1,
            'category_id' => 1,
        ];
    }
}
