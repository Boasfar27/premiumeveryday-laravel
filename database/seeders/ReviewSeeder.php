<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Order;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Make sure we have at least one user and order to associate with reviews
        $user = User::first();
        $order = Order::first();
        
        if (!$user || !$order) {
            $this->command->info('No users or orders found. Please create them first.');
            return;
        }
        
        // Create sample reviews
        $reviews = [
            [
                'user_id' => $user->id,
                'order_id' => $order->id,
                'name' => 'John Doe',
                'rating' => 5,
                'content' => 'Layanan sangat memuaskan! Akses premium diberikan dengan cepat dan semua berjalan dengan lancar.',
                'is_active' => true,
            ],
            [
                'user_id' => $user->id,
                'order_id' => $order->id,
                'name' => 'Jane Smith',
                'rating' => 4,
                'content' => 'Harga terjangkau dan layanan pelanggan sangat responsif. Akan menggunakan lagi!',
                'is_active' => true,
            ],
            [
                'user_id' => $user->id,
                'order_id' => $order->id,
                'name' => 'Ahmad Sulaiman',
                'rating' => 5,
                'content' => 'Proses pembayaran mudah dan akun langsung aktif. Sangat direkomendasikan!',
                'is_active' => true,
            ],
        ];
        
        foreach ($reviews as $reviewData) {
            Review::create($reviewData);
        }
        
        $this->command->info('Sample reviews created successfully!');
    }
}
