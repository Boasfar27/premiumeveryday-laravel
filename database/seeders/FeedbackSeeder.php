<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;
use App\Models\User;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users
        $users = User::all();
        
        // Feedback types
        $types = ['suggestion', 'complaint', 'praise', 'question', 'bug_report'];
        
        // Statuses
        $statuses = ['pending', 'in_progress', 'resolved', 'closed'];
        
        // Create 15 feedback entries
        for ($i = 0; $i < 15; $i++) {
            $user = $users->random();
            $type = $types[array_rand($types)];
            $status = $statuses[array_rand($statuses)];
            
            Feedback::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'subject' => fake()->sentence(4),
                'message' => fake()->paragraph(3),
                'type' => $type,
                'status' => $status,
                'is_read' => rand(0, 1),
                'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
                'updated_at' => fake()->dateTimeBetween('-6 months', 'now'),
            ]);
        }
        
        // Create some anonymous feedback
        for ($i = 0; $i < 5; $i++) {
            $type = $types[array_rand($types)];
            $status = $statuses[array_rand($statuses)];
            
            Feedback::create([
                'user_id' => null,
                'name' => fake()->name(),
                'email' => fake()->email(),
                'subject' => fake()->sentence(4),
                'message' => fake()->paragraph(3),
                'type' => $type,
                'status' => $status,
                'is_read' => rand(0, 1),
                'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
                'updated_at' => fake()->dateTimeBetween('-6 months', 'now'),
            ]);
        }
    }
} 