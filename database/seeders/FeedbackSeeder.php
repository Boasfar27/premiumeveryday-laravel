<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;
use App\Models\DigitalProduct;
use App\Models\User;
use Carbon\Carbon;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get products and users
        $products = DigitalProduct::all();
        $users = User::where('role', 0)->get(); // Regular users
        
        if ($users->isEmpty()) {
            // Create some users if none exist
            $users = [
                User::factory()->create([
                    'name' => 'Budi Santoso',
                    'email' => 'budi@example.com',
                ]),
                User::factory()->create([
                    'name' => 'Siti Rahayu',
                    'email' => 'siti@example.com',
                ]),
                User::factory()->create([
                    'name' => 'Agus Wijaya',
                    'email' => 'agus@example.com',
                ]),
            ];
        }
        
        // Sample feedback data
        $feedbackData = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'content' => 'Langganan Netflix Premium sangat worth it! Kualitas video HD dan UHD sangat jernih, dan bisa diakses di berbagai perangkat. Proses berlangganan juga sangat mudah.',
                'rating' => 5,
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti@example.com',
                'content' => 'Saya sangat puas dengan layanan Spotify Premium. Tidak ada iklan, kualitas audio bagus, dan bisa download lagu untuk didengarkan offline. Harga juga lebih murah dibanding langganan langsung.',
                'rating' => 5,
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'name' => 'Agus Wijaya',
                'email' => 'agus@example.com',
                'content' => 'Disney+ Hotstar lancar jaya, konten Marvel dan Star Wars lengkap. Sempat ada masalah login tapi customer service responsif dan cepat menyelesaikan masalah.',
                'rating' => 4,
                'created_at' => Carbon::now()->subDays(15),
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'content' => 'YouTube Premium worth banget buat yang sering nonton YouTube. No ads, bisa play di background, dan download video. Customer service juga ramah dan membantu.',
                'rating' => 5,
                'created_at' => Carbon::now()->subDays(7),
            ],
            [
                'name' => 'Rudi Hermawan',
                'email' => 'rudi@example.com',
                'content' => 'Langganan Apple Music sangat memuaskan. Koleksi lagu lengkap dan fitur lyrics sangat membantu. Sempat ada kendala saat aktivasi tapi cepat diatasi.',
                'rating' => 4,
                'created_at' => Carbon::now()->subDays(20),
            ],
            [
                'name' => 'Nina Safitri',
                'email' => 'nina@example.com',
                'content' => 'Viu Premium recommended banget buat pecinta drama Korea. Update cepat dan subtitle berkualitas. Harga juga sangat terjangkau dibanding platform lain.',
                'rating' => 5,
                'created_at' => Carbon::now()->subDays(12),
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@example.com',
                'content' => 'WeTV Premium worth it untuk nonton drama China terbaru. Kualitas video bagus dan update cepat. Proses berlangganan juga mudah dan cepat.',
                'rating' => 5,
                'created_at' => Carbon::now()->subDays(8),
            ],
            [
                'name' => 'Maya Anggraini',
                'email' => 'maya@example.com',
                'content' => 'ChatGPT Plus sangat membantu untuk pekerjaan saya. Respon cepat dan akurat. Sangat worth it untuk meningkatkan produktivitas.',
                'rating' => 5,
                'created_at' => Carbon::now()->subDays(3),
            ],
        ];
        
        // Create feedback for each product
        foreach ($products as $index => $product) {
            if (isset($feedbackData[$index])) {
                $feedback = $feedbackData[$index];
                $user = $users[array_rand($users instanceof \Illuminate\Database\Eloquent\Collection ? $users->toArray() : $users)];
                
                Feedback::updateOrCreate(
                    [
                        'feedbackable_id' => $product->id,
                        'feedbackable_type' => get_class($product),
                        'user_id' => $user->id,
                    ],
                    [
                        'name' => $feedback['name'],
                        'email' => $feedback['email'],
                        'content' => $feedback['content'],
                        'rating' => $feedback['rating'],
                        'is_active' => true,
                        'order' => $index + 1,
                        'created_at' => $feedback['created_at'],
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
} 