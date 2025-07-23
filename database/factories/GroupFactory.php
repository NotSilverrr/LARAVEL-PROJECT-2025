<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
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
                'Frontend Team', 'Backend Team', 'Design Team', 'QA Team',
                'DevOps Team', 'Mobile Team', 'Marketing Team', 'Sales Team'
            ]),
            'created_by' => 1, // Will be set explicitly in seeder
            'project_id' => 1, // Will be set explicitly in seeder
        ];
    }
}
