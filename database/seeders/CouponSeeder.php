<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'description' => 'Welcome discount for new users',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'min_purchase' => 50,
                'max_discount' => 100,
                'is_active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(1),
                'usage_limit' => 1000,
                'used_count' => 0,
            ],
            [
                'code' => 'SUMMER25',
                'description' => 'Summer sale discount',
                'discount_type' => 'percentage',
                'discount_value' => 25,
                'min_purchase' => 100,
                'max_discount' => 200,
                'is_active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addDays(30),
                'usage_limit' => 500,
                'used_count' => 0,
            ],
            [
                'code' => 'FREESHIP',
                'description' => 'Free shipping on all orders',
                'discount_type' => 'fixed',
                'discount_value' => 15,
                'min_purchase' => 75,
                'max_discount' => 15,
                'is_active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addWeeks(2),
                'usage_limit' => 300,
                'used_count' => 0,
            ],
            [
                'code' => 'FLASH50',
                'description' => 'Flash sale 50% off',
                'discount_type' => 'percentage',
                'discount_value' => 50,
                'min_purchase' => 200,
                'max_discount' => 300,
                'is_active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addDays(3),
                'usage_limit' => 100,
                'used_count' => 0,
            ],
            [
                'code' => 'VIP20',
                'description' => 'VIP customer discount',
                'discount_type' => 'percentage',
                'discount_value' => 20,
                'min_purchase' => 0,
                'max_discount' => 500,
                'is_active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addYear(),
                'usage_limit' => 50,
                'used_count' => 0,
            ],
        ];

        foreach ($coupons as $couponData) {
            Coupon::create($couponData);
        }
    }
} 