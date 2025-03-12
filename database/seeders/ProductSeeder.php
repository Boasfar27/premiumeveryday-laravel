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
                'type_sharing' => '1 Akun 1 Profile (Sharing)',
                'type_private' => '1 Akun 5 Profile (Private)',
                'price' => 45000,
                'private_price' => 159000,
                'image' => 'images/netflix.webp',
                'featured' => true,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Disney+ Hotstar',
                'type_sharing' => '1 Akun 1 Profile (Sharing)',
                'type_private' => '1 Akun 4 Profile (Private)',
                'price' => 35000,
                'private_price' => 129000,
                'image' => 'images/primevideo.webp',
                'featured' => true,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Spotify Premium',
                'type_sharing' => 'Individual Plan (Sharing)',
                'type_private' => 'Family Plan (Private)',
                'price' => 29000,
                'private_price' => 89000,
                'image' => 'images/spotify.webp',
                'featured' => true,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'YouTube Premium',
                'type_sharing' => 'Individual Plan (Sharing)',
                'type_private' => 'Family Plan (Private)',
                'price' => 35000,
                'private_price' => 99000,
                'image' => 'images/youtube.webp',
                'featured' => false,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vidio Premier',
                'type_sharing' => 'Platinum (Sharing)',
                'type_private' => 'Platinum (Private)',
                'price' => 39000,
                'private_price' => 119000,
                'image' => 'images/viu.webp',
                'featured' => false,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'WeTV VIP',
                'type_sharing' => 'VIP Access (Sharing)',
                'type_private' => 'VIP Access (Private)',
                'price' => 25000,
                'private_price' => 79000,
                'image' => 'images/wetv.webp',
                'featured' => false,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
} 