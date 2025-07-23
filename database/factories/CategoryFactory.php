<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
                'Bug Fix', 'Feature', 'Documentation', 'Testing', 'Refactoring',
                'UI/UX', 'Backend', 'Frontend', 'Database', 'Security'
            ]),
            'created_by' => 1, // Will be set explicitly in seeder
            'project_id' => 1, // Will be set explicitly in seeder
        ];
    }
}
