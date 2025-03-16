<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users (excluding admin)
        $users = User::where('role', 0)->get();
        
        // Get products
        $products = Product::all();
        
        // Order statuses
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        
        // Payment methods
        $paymentMethods = ['credit_card', 'paypal', 'bank_transfer', 'cash_on_delivery'];
        
        // Create 20 orders with random data
        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();
            $status = $statuses[array_rand($statuses)];
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            
            // Select 1-3 random products
            $orderProducts = $products->random(rand(1, 3));
            
            // Calculate total
            $subtotal = 0;
            $items = [];
            
            foreach ($orderProducts as $product) {
                $quantity = rand(1, 3);
                $price = $product->discount_price ?? $product->price;
                $itemTotal = $price * $quantity;
                $subtotal += $itemTotal;
                
                $items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'total' => $itemTotal,
                ];
            }
            
            // Apply random discount (0-15%)
            $discountPercent = rand(0, 15);
            $discount = ($subtotal * $discountPercent) / 100;
            
            // Add shipping fee
            $shipping = 10.00;
            
            // Calculate total
            $total = $subtotal - $discount + $shipping;
            
            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(substr(md5(uniqid()), 0, 8)),
                'status' => $status,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping' => $shipping,
                'total' => $total,
                'payment_method' => $paymentMethod,
                'payment_status' => $status === 'completed' ? 'paid' : ($status === 'cancelled' ? 'refunded' : 'pending'),
                'shipping_address' => json_encode([
                    'name' => $user->name,
                    'address' => fake()->streetAddress(),
                    'city' => fake()->city(),
                    'state' => fake()->state(),
                    'postal_code' => fake()->postcode(),
                    'country' => fake()->country(),
                    'phone' => fake()->phoneNumber(),
                ]),
                'notes' => rand(0, 1) ? fake()->sentence() : null,
                'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
                'updated_at' => fake()->dateTimeBetween('-3 months', 'now'),
            ]);
            
            // Save order items
            foreach ($items as $item) {
                $order->items()->create($item);
            }
        }
    }
} 