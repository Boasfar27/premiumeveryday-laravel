<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\DigitalProduct;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users (except admin)
        $users = User::where('role', '!=', 1)->get();
        
        // Get all digital products
        $products = DigitalProduct::all();
        
        // Check if we have users and products
        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->info('Cannot seed orders: No users or products found. Run UserSeeder and DigitalProductSeeder first.');
            return;
        }
        
        // Define payment methods to use randomly
        $paymentMethods = ['bank_transfer', 'paypal', 'credit_card', 'other'];
        
        // Create some orders (at least 15 for the reviews)
        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();
            $product = $products->random();
            $price = $product->price;
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD' . str_pad($i + 1, 8, '0', STR_PAD_LEFT),
                'name' => $user->name,
                'email' => $user->email,
                'whatsapp' => $user->phone,
                'subtotal' => $price,
                'tax' => 0,
                'shipping' => 0,
                'discount_amount' => 0,
                'total' => $price,
                'status' => 'approved',
                'payment_status' => 'paid',
                'payment_method' => $paymentMethod,
                'paid_at' => now()->subDays(rand(1, 30)),
            ]);
            
            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'orderable_id' => $product->id,
                'orderable_type' => DigitalProduct::class,
                'name' => $product->name,
                'quantity' => 1,
                'unit_price' => $price,
                'price' => $price,
                'subtotal' => $price,
                'discount' => 0,
                'total' => $price,
                'subscription_type' => 'sharing',
                'duration' => 1,
                'account_type' => 'sharing'
            ]);
        }
    }
} 