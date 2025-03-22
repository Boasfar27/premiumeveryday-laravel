<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
                'description' => 'Premium streaming video services including Netflix, Disney+, HBO Max, and more.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Streaming Music',
                'slug' => 'streaming-music',
                'description' => 'Premium music streaming services including Spotify, Apple Music, and more.',
                'sort_order' => 2,
            ],
            [
                'name' => 'AI Tools',
                'slug' => 'ai-tools',
                'description' => 'Premium AI tools and services including ChatGPT, Gemini AI, and more.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Productivity Tools',
                'slug' => 'productivity-tools',
                'description' => 'Premium productivity software including Microsoft 365, Canva Pro, and more.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Creative Software',
                'slug' => 'creative-software',
                'description' => 'Premium creative software including Capcut Pro, Picsart, and more.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Sports Streaming',
                'slug' => 'sports-streaming',
                'description' => 'Premium sports streaming services including Vision+ Sport, RCTI+ Sport, and more.',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                array_merge($category, ['is_active' => true])
            );
        }
    }
} 