<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert sample payments directly
        $userId = 1; // Assuming user with ID 1 exists
        
        // Use existing orders if available
        $orderIds = DB::table('orders')->where('user_id', $userId)->pluck('id')->toArray();
        
        // If no orders exist, use fixed IDs
        if (empty($orderIds)) {
            $orderIds = [1, 2, 3, 4, 5];
        }
        
        $payments = [];
        foreach ($orderIds as $index => $orderId) {
            $payments[] = [
                'user_id' => $userId,
                'order_id' => $orderId,
                'amount' => rand(100000, 500000),
                'payment_method' => $this->getRandomPaymentMethod(),
                'status' => $this->getRandomStatus(),
                'transaction_id' => 'TRX-' . uniqid(),
                'payment_date' => Carbon::now()->subDays(10 - $index * 2),
                'notes' => 'Payment for subscription order #' . $orderId,
                'created_at' => Carbon::now()->subDays(10 - $index * 2),
                'updated_at' => Carbon::now()->subDays(10 - $index * 2),
            ];
        }
        
        // Insert payments
        DB::table('payments')->insert($payments);
        
        $this->command->info('Sample payment data inserted successfully!');
    }
    
    /**
     * Get random payment method
     */
    private function getRandomPaymentMethod()
    {
        $methods = ['Credit Card', 'Bank Transfer', 'E-Wallet', 'PayPal', 'Virtual Account'];
        return $methods[array_rand($methods)];
    }
    
    /**
     * Get random status
     */
    private function getRandomStatus()
    {
        $statuses = ['completed', 'completed', 'completed', 'pending', 'processing', 'failed', 'refunded'];
        return $statuses[array_rand($statuses)];
    }
} 