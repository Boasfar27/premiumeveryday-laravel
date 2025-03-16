<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DigitalProduct;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DigitalProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories if they don't exist
        $categories = [
            ['name' => 'Streaming Video', 'slug' => 'streaming-video', 'description' => 'Digital videos and content'],
            ['name' => 'Streaming Music', 'slug' => 'streaming-music', 'description' => 'Digital music and audio content'],
            ['name' => 'Productivity Tools', 'slug' => 'productivity-tools', 'description' => 'Tools for productivity'],
            ['name' => 'Premium Software', 'slug' => 'premium-software', 'description' => 'High-quality software'],
            ['name' => 'Graphics', 'slug' => 'graphics', 'description' => 'Digital art and design resources'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'is_active' => true
                ]
            );
        }

        // Get category IDs
        $categoryIds = Category::pluck('id')->toArray();

        // Sample product data
        $products = [
            [
                'name' => 'Netflix Premium Subscription',
                'description' => 'Enjoy unlimited access to movies, TV shows, and documentaries on Netflix. Stream on multiple devices in HD and Ultra HD quality.',
                'price' => 299000,
                'category_id' => $categoryIds[0], // Streaming Video
                'is_on_sale' => true,
                'sale_price' => 199000,
                'sale_ends_at' => Carbon::now()->addDays(7),
                'thumbnail' => 'images/products/netflix.webp',
                'download_url' => 'downloads/netflix-access.zip',
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'name' => 'Disney+ Hotstar Subscription',
                'description' => 'Access to Disney, Marvel, Star Wars, and National Geographic content. Stream on multiple devices with high-quality video.',
                'price' => 199000,
                'category_id' => $categoryIds[0], // Streaming Video
                'is_on_sale' => false,
                'thumbnail' => 'images/products/hbomax.webp',
                'download_url' => 'downloads/disney-access.zip',
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'name' => 'YouTube Premium Membership',
                'description' => 'Ad-free YouTube experience with background play, downloads, and access to YouTube Music Premium.',
                'price' => 149000,
                'category_id' => $categoryIds[0], // Streaming Video
                'is_on_sale' => true,
                'sale_price' => 99000,
                'sale_ends_at' => Carbon::now()->addDays(3),
                'thumbnail' => 'images/products/youtube.webp',
                'download_url' => 'downloads/youtube-premium.zip',
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'name' => 'Spotify Premium Subscription',
                'description' => 'Ad-free music streaming with offline listening, high-quality audio, and unlimited skips.',
                'price' => 99000,
                'category_id' => $categoryIds[1], // Streaming Music
                'is_on_sale' => false,
                'thumbnail' => 'images/products/spotify.webp',
                'download_url' => 'downloads/spotify-premium.zip',
                'created_at' => Carbon::now()->subDays(15),
            ],
            [
                'name' => 'Apple Music Subscription',
                'description' => 'Access to over 90 million songs, expert-curated playlists, and exclusive content.',
                'price' => 99000,
                'category_id' => $categoryIds[1], // Streaming Music
                'is_on_sale' => true,
                'sale_price' => 79000,
                'sale_ends_at' => Carbon::now()->addDays(5),
                'thumbnail' => 'images/products/applemusic.webp',
                'download_url' => 'downloads/apple-music.zip',
                'created_at' => Carbon::now()->subDays(8),
            ],
            [
                'name' => 'Apple TV+ Subscription',
                'description' => 'Stream exclusive Apple Originals, movies, and TV shows on your favorite devices.',
                'price' => 129000,
                'category_id' => $categoryIds[0], // Streaming Video
                'is_on_sale' => false,
                'thumbnail' => 'images/products/appletv.webp',
                'download_url' => 'downloads/apple-tv.zip',
                'created_at' => Carbon::now()->subDays(20),
            ],
            [
                'name' => 'Prime Video Subscription',
                'description' => 'Stream thousands of movies and TV shows, including Amazon Originals, plus free shipping on Amazon orders.',
                'price' => 159000,
                'category_id' => $categoryIds[0], // Streaming Video
                'is_on_sale' => true,
                'sale_price' => 119000,
                'sale_ends_at' => Carbon::now()->addDays(10),
                'thumbnail' => 'images/products/primevideo.webp',
                'download_url' => 'downloads/prime-video.zip',
                'created_at' => Carbon::now()->subDays(12),
            ],
            [
                'name' => 'WeTV Premium Subscription',
                'description' => 'Access to premium Asian dramas, variety shows, and exclusive content with no ads.',
                'price' => 89000,
                'category_id' => $categoryIds[0], // Streaming Video
                'is_on_sale' => false,
                'thumbnail' => 'images/products/wetv.webp',
                'download_url' => 'downloads/wetv-premium.zip',
                'created_at' => Carbon::now()->subDays(25),
            ],
            [
                'name' => 'Viu Premium Subscription',
                'description' => 'Stream the latest Korean dramas, variety shows, and other Asian content with no ads.',
                'price' => 79000,
                'category_id' => $categoryIds[0], // Streaming Video
                'is_on_sale' => true,
                'sale_price' => 59000,
                'sale_ends_at' => Carbon::now()->addDays(2),
                'thumbnail' => 'images/products/viu.webp',
                'download_url' => 'downloads/viu-premium.zip',
                'created_at' => Carbon::now()->subDays(1),
            ],
            [
                'name' => 'iQIYI VIP Membership',
                'description' => 'Access to premium Chinese dramas, movies, variety shows, and exclusive content.',
                'price' => 89000,
                'category_id' => $categoryIds[0], // Streaming Video
                'is_on_sale' => false,
                'thumbnail' => 'images/products/iqiyi.webp',
                'download_url' => 'downloads/iqiyi-vip.zip',
                'created_at' => Carbon::now()->subDays(18),
            ],
            [
                'name' => 'ChatGPT Plus Subscription',
                'description' => 'Priority access to ChatGPT during peak times, faster response times, and access to new features.',
                'price' => 249000,
                'category_id' => $categoryIds[2], // Productivity Tools
                'is_on_sale' => true,
                'sale_price' => 199000,
                'sale_ends_at' => Carbon::now()->addDays(4),
                'thumbnail' => 'images/products/chatgpt.webp',
                'download_url' => 'downloads/chatgpt-plus.zip',
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'name' => 'Capcut Pro Subscription',
                'description' => 'Professional video editing tools, premium effects, templates, and cloud storage.',
                'price' => 119000,
                'category_id' => $categoryIds[3], // Premium Software
                'is_on_sale' => false,
                'thumbnail' => 'images/products/capcut.webp',
                'download_url' => 'downloads/capcut-pro.zip',
                'created_at' => Carbon::now()->subDays(30),
            ],
        ];

        // Insert products
        foreach ($products as $index => $product) {
            DigitalProduct::updateOrCreate(
                ['slug' => Str::slug($product['name'])],
                array_merge($product, [
                    'slug' => Str::slug($product['name']),
                    'is_active' => true,
                    'is_featured' => $index < 6, // First 6 products are featured
                    'sort_order' => $index + 1,
                    'updated_at' => Carbon::now(),
                ])
            );
        }
    }
} 