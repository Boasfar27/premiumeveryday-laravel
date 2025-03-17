<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;
use App\Models\DigitalProduct;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get products, users and orders
        $products = DigitalProduct::all();
        $users = User::where('role', 0)->get(); // Regular users
        $orders = Order::whereIn('status', ['completed', 'active'])->get();
        
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
        
        // Create feedback for orders
        if ($orders->isNotEmpty()) {
            $orderFeedbackData = [
                [
                    'content' => 'Pesanan dikirim dengan cepat dan produk sesuai harapan. Customer service juga sangat membantu ketika saya mengalami kesulitan saat aktivasi.',
                    'rating' => 5,
                    'created_at' => Carbon::now()->subDays(2),
                ],
                [
                    'content' => 'Sangat puas dengan layanan Premium Everyday. Proses pembayaran mudah, akun langsung aktif setelah konfirmasi, dan layanan customer support sangat baik.',
                    'rating' => 5,
                    'created_at' => Carbon::now()->subDays(4),
                ],
                [
                    'content' => 'Awalnya sempat ragu, tapi ternyata prosesnya sangat mudah dan aman. Akun langsung dikirim setelah pembayaran dikonfirmasi. Akan order lagi di sini.',
                    'rating' => 5,
                    'created_at' => Carbon::now()->subDays(6),
                ],
                [
                    'content' => 'Harga lebih murah dari tempat lain dan proses tidak ribet. Sempat ada kendala kecil tapi langsung dibantu oleh admin dengan sangat responsif.',
                    'rating' => 4,
                    'created_at' => Carbon::now()->subDays(8),
                ],
                [
                    'content' => 'Sudah langganan beberapa kali dan selalu puas. Layanan cepat, akun stabil, dan harga sangat terjangkau. Recommended!',
                    'rating' => 5,
                    'created_at' => Carbon::now()->subDays(10),
                ],
            ];
            
            foreach ($orders as $index => $order) {
                if (isset($orderFeedbackData[$index % count($orderFeedbackData)])) {
                    $feedback = $orderFeedbackData[$index % count($orderFeedbackData)];
                    
                    // Create order feedback
                    Feedback::updateOrCreate(
                        [
                            'user_id' => $order->user_id,
                            'order_id' => $order->id,
                        ],
                        [
                            'name' => $order->user ? $order->user->name : 'Customer',
                            'email' => $order->user ? $order->user->email : $order->email,
                            'content' => $feedback['content'],
                            'rating' => $feedback['rating'],
                            'is_active' => true,
                            'created_at' => $feedback['created_at'],
                            'updated_at' => now(),
                        ]
                    );
                    
                    // If order has items with related products, also create product-specific feedback
                    foreach ($order->items as $item) {
                        if ($item->product) {
                            Feedback::updateOrCreate(
                                [
                                    'user_id' => $order->user_id,
                                    'feedbackable_id' => $item->product->id,
                                    'feedbackable_type' => get_class($item->product),
                                    'order_id' => $order->id,
                                ],
                                [
                                    'name' => $order->user ? $order->user->name : 'Customer',
                                    'email' => $order->user ? $order->user->email : $order->email,
                                    'content' => $feedback['content'],
                                    'rating' => $feedback['rating'],
                                    'is_active' => true,
                                    'created_at' => $feedback['created_at'],
                                    'updated_at' => now(),
                                ]
                            );
                        }
                    }
                }
            }
        }
    }
} 