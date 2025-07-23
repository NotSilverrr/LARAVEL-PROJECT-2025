<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user first
        User::factory()->create([
            'firstname' => 'Test',
            'lastname' => 'User',
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);

        // Create additional users for testing
        User::factory(20)->create();
        
        // You could also create specific users for different roles/scenarios
        User::factory()->create([
            'firstname' => 'Admin',
            'lastname' => 'User',
            'username' => 'admin',
            'email' => 'admin@example.com',
        ]);
        
        User::factory()->create([
            'firstname' => 'Manager',
            'lastname' => 'User',
            'username' => 'manager',
            'email' => 'manager@example.com',
        ]);
    }
}
