<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
                'description' => "Akses ke semua fitur premium\nDukungan pelanggan 24/7\nUpdate produk terbaru",
                'sharing_price' => 50000,
                'private_price' => 150000,
                'sharing_discount' => 10000,
                'private_discount' => 30000,
                'is_promo' => true,
                'promo_ends_at' => Carbon::now(),
                'sharing_description' => "Akses ke semua fitur premium\nDukungan pelanggan 24/7\nUpdate produk terbaru",
                'private_description' => "Akses ke semua fitur premium\nDukungan pelanggan 24/7\nUpdate produk terbaru",
                'image' => 'netflix.webp',
                'is_active' => true,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Disney+ Hotstar',
                'description' => "Akses ke semua fitur premium\nDukungan pelanggan 24/7\nUpdate produk terbaru",
                'sharing_price' => 40000,
                'private_price' => 120000,
                'sharing_discount' => 5000,
                'private_discount' => 20000,
                'is_promo' => true,
                'promo_ends_at' => Carbon::now()->addDays(5),
                'sharing_description' => "Akses ke semua fitur premium\nDukungan pelanggan 24/7\nUpdate produk terbaru",
                'private_description' => "Akses ke semua fitur premium\nDukungan pelanggan 24/7\nUpdate produk terbaru",
                'image' => 'netflix.webp',
                'is_active' => true,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'farhan mau jual badan nih gusyyyyy info tobrut ',
                'description' => "Akses ke semua fitur premium\nDukungan pelanggan 24/7\nUpdate produk terbaru\ninfokan tobrut terbaru",
                'sharing_price' => 1000000,
                'private_price' => 1200000,
                'sharing_discount' => 500000,
                'private_discount' => 200000,
                'is_promo' => true,
                'promo_ends_at' => Carbon::now()->addDays(5),
                'sharing_description' => "Akses ke semua fitur premium\nDukungan pelanggan 24/7\nUpdate produk terbaru",
                'private_description' => "Akses ke semua fitur premium\nDukungan pelanggan 24/7\nUpdate produk terbaru",
                'image' => 'logo.webp',
                'is_active' => true,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Add default values for other products
        $defaultProducts = [
            [
                'name' => 'Spotify Premium',
                'description' => 'Dengarkan musik tanpa iklan, download lagu untuk didengar offline, dan nikmati kualitas audio premium.',
                'sharing_price' => 29000,
                'private_price' => 89000,
                'sharing_description' => '✓ No Ads\n✓ Download Offline\n✓ High Quality Audio\n✓ Garansi Full 30 Hari',
                'private_description' => '✓ Family Plan (6 Akun)\n✓ No Ads\n✓ Download Offline\n✓ High Quality Audio\n✓ Garansi Full 30 Hari',
                'image' => 'spotify.webp',
                'order' => 3,
            ],
            [
                'name' => 'YouTube Premium',
                'description' => 'Tonton YouTube tanpa iklan, putar di background, dan download video untuk ditonton offline.',
                'sharing_price' => 35000,
                'private_price' => 99000,
                'sharing_description' => '✓ No Ads\n✓ Background Play\n✓ Download Offline\n✓ YouTube Music\n✓ Garansi Full 30 Hari',
                'private_description' => '✓ Family Plan (5 Akun)\n✓ No Ads\n✓ Background Play\n✓ Download Offline\n✓ YouTube Music\n✓ Garansi Full 30 Hari',
                'image' => 'youtube.webp',
                'order' => 4,
            ],
            [
                'name' => 'Apple TV+',
                'description' => 'Streaming Apple Originals eksklusif dengan kualitas 4K HDR dan Dolby Atmos.',
                'sharing_price' => 45000,
                'private_price' => 129000,
                'sharing_description' => '✓ 1 Profil\n✓ 4K HDR\n✓ Dolby Atmos\n✓ Download Offline\n✓ Garansi Full 30 Hari',
                'private_description' => '✓ Family Sharing (6 Akun)\n✓ 4K HDR\n✓ Dolby Atmos\n✓ Download Offline\n✓ Garansi Full 30 Hari\n✓ Akun Pribadi',
                'image' => 'appletv.webp',
                'order' => 5,
            ],
            [
                'name' => 'HBO Max',
                'description' => 'Akses ke film blockbuster terbaru, serial HBO Original, dan konten Warner Bros eksklusif.',
                'sharing_price' => 39000,
                'private_price' => 119000,
                'sharing_description' => '✓ 1 Profil\n✓ Full HD\n✓ Download Offline\n✓ No Ads\n✓ Garansi Full 30 Hari',
                'private_description' => '✓ 5 Profil\n✓ 4K HDR\n✓ Download Offline\n✓ No Ads\n✓ Garansi Full 30 Hari\n✓ Akun Pribadi',
                'image' => 'hbomax.webp',
                'order' => 6,
            ],
            [
                'name' => 'Prime Video',
                'description' => 'Streaming Amazon Originals, film & serial TV populer dengan kualitas hingga 4K UHD.',
                'sharing_price' => 35000,
                'private_price' => 109000,
                'sharing_description' => '✓ 1 Profil\n✓ Full HD\n✓ Download Offline\n✓ No Ads\n✓ Garansi Full 30 Hari',
                'private_description' => '✓ 3 Profil\n✓ 4K UHD\n✓ Download Offline\n✓ No Ads\n✓ Garansi Full 30 Hari\n✓ Akun Pribadi',
                'image' => 'primevideo.webp',
                'order' => 7,
            ],
            [
                'name' => 'Viu Premium',
                'description' => 'Tonton drama Korea, variety show, dan konten Asia terbaik tanpa iklan.',
                'sharing_price' => 25000,
                'private_price' => 79000,
                'sharing_description' => '✓ 1 Profil\n✓ Full HD\n✓ Download Offline\n✓ No Ads\n✓ Garansi Full 30 Hari',
                'private_description' => '✓ 4 Profil\n✓ Full HD\n✓ Download Offline\n✓ No Ads\n✓ Garansi Full 30 Hari\n✓ Akun Pribadi',
                'image' => 'viu.webp',
                'order' => 8,
            ],
            [
                'name' => 'WeTV VIP',
                'description' => 'Akses ke drama China, Korea, Thailand terbaru dan konten eksklusif WeTV.',
                'sharing_price' => 25000,
                'private_price' => 79000,
                'sharing_description' => '✓ 1 Profil\n✓ Full HD\n✓ Download Offline\n✓ No Ads\n✓ Garansi Full 30 Hari',
                'private_description' => '✓ Private Account\n✓ Full HD\n✓ Download Offline\n✓ No Ads\n✓ Garansi Full 30 Hari\n✓ Akun Pribadi',
                'image' => 'wetv.webp',
                'order' => 9,
            ],
            [
                'name' => 'iQIYI Premium',
                'description' => 'Streaming drama China, Korea, & variety show terpopuler dengan kualitas HD.',
                'sharing_price' => 25000,
                'private_price' => 79000,
                'sharing_description' => '✓ 1 Profil\n✓ Full HD\n✓ Download Offline\n✓ No Ads\n✓ Garansi Full 30 Hari',
                'private_description' => '✓ Private Account\n✓ Full HD\n✓ Download Offline\n✓ No Ads\n✓ Garansi Full 30 Hari\n✓ Akun Pribadi',
                'image' => 'iqiyi.webp',
                'order' => 10,
            ],
        ];

        // Add default values to remaining products
        foreach ($defaultProducts as $product) {
            $products[] = array_merge([
                'sharing_discount' => 0,
                'private_discount' => 0,
                'is_promo' => false,
                'promo_ends_at' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ], $product);
        }

        DB::table('products')->insert($products);
    }
} 