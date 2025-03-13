<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Netflix Premium',
                'description' => 'Stream unlimited movies, TV shows, and more on Netflix Premium.',
                'sharing_price' => 45000,
                'private_price' => 159000,
                'sharing_description' => '1 Akun 1 Profile (Sharing)',
                'private_description' => '1 Akun 5 Profile (Private)',
                'image' => 'images/netflix.webp',
                'is_active' => true,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Disney+ Hotstar',
                'description' => 'Access Disney+ Hotstar premium content with our subscription.',
                'sharing_price' => 35000,
                'private_price' => 129000,
                'sharing_description' => '1 Akun 1 Profile (Sharing)',
                'private_description' => '1 Akun 4 Profile (Private)',
                'image' => 'images/primevideo.webp',
                'is_active' => true,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Spotify Premium',
                'description' => 'Enjoy ad-free music streaming with Spotify Premium.',
                'sharing_price' => 29000,
                'private_price' => 89000,
                'sharing_description' => 'Individual Plan (Sharing)',
                'private_description' => 'Family Plan (Private)',
                'image' => 'images/spotify.webp',
                'is_active' => true,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'YouTube Premium',
                'description' => 'Watch YouTube without ads and download videos for offline viewing.',
                'sharing_price' => 35000,
                'private_price' => 99000,
                'sharing_description' => 'Individual Plan (Sharing)',
                'private_description' => 'Family Plan (Private)',
                'image' => 'images/youtube.webp',
                'is_active' => true,
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vidio Premier',
                'description' => 'Access Vidio Premier content with our subscription.',
                'sharing_price' => 39000,
                'private_price' => 119000,
                'sharing_description' => 'Platinum (Sharing)',
                'private_description' => 'Platinum (Private)',
                'image' => 'images/viu.webp',
                'is_active' => true,
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'WeTV VIP',
                'description' => 'Enjoy WeTV VIP content with our subscription.',
                'sharing_price' => 25000,
                'private_price' => 79000,
                'sharing_description' => 'VIP Access (Sharing)',
                'private_description' => 'VIP Access (Private)',
                'image' => 'images/wetv.webp',
                'is_active' => true,
                'order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
} 