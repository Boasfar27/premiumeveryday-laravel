<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 1, // Admin role
            ]);
        }

        // Create regular users if they don't exist
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 0, // Regular user
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 0,
            ],
            [
                'name' => 'Robert Johnson',
                'email' => 'robert@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 0,
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 0,
            ],
            [
                'name' => 'Michael Wilson',
                'email' => 'michael@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 0,
            ],
        ];

        foreach ($users as $userData) {
            if (!User::where('email', $userData['email'])->exists()) {
                User::create($userData);
            }
        }
    }
} 