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
                'description' => '<p>Layanan streaming video premium dengan akses ke ribuan film dan serial TV terbaru. Nikmati konten berkualitas tinggi tanpa iklan dan batasan regional.</p>',
                'is_active' => true,
                'sort_order' => 1,
                'image' => 'categories/streaming-video.webp'
            ],
            [
                'name' => 'Streaming Music',
                'slug' => 'streaming-music',
                'description' => '<p>Akses ke jutaan lagu dan podcast dari seluruh dunia. Dengarkan musik premium tanpa iklan dengan kualitas audio yang superior.</p>',
                'is_active' => true,
                'sort_order' => 2,
                'image' => 'categories/streaming-music.webp'
            ],
            [
                'name' => 'Productivity Tools',
                'slug' => 'productivity-tools',
                'description' => '<p>Koleksi software dan tools premium untuk meningkatkan produktivitas kerja dan belajar. Dari aplikasi office hingga design tools.</p>',
                'is_active' => true,
                'sort_order' => 3,
                'image' => 'categories/productivity-tools.webp'
            ],
            [
                'name' => 'Premium Software',
                'slug' => 'premium-software',
                'description' => '<p>Software berlisensi original dengan harga terjangkau. Termasuk aplikasi desain, editing, dan software profesional lainnya.</p>',
                'is_active' => true,
                'sort_order' => 4,
                'image' => 'categories/premium-software.webp'
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
