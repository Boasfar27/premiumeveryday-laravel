<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Streaming Video',
                'slug' => 'streaming-video',
                'description' => 'Layanan streaming film, serial TV, dan konten video',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Streaming Music',
                'slug' => 'streaming-music',
                'description' => 'Layanan streaming musik dan podcast',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Productivity Tools',
                'slug' => 'productivity-tools',
                'description' => 'Aplikasi dan layanan untuk meningkatkan produktivitas',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Premium Software',
                'slug' => 'premium-software',
                'description' => 'Berbagai software dan aplikasi premium',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Gaming',
                'slug' => 'gaming',
                'description' => 'Layanan dan konten premium untuk gaming',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }
    }
} 