<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectUser>
 */
class ProjectUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => 1, // Will be set explicitly in seeder
            'user_id' => 1, // Will be set explicitly in seeder
            'role' => fake()->randomElement(['owner', 'admin', 'member']),
        ];
    }
}
