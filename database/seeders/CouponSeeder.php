<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

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
                'type' => 'percentage',
                'value' => 10.00,
                'discount' => 10.00,
                'min_purchase' => 50000,
                'max_discount' => 25000,
                'start_date' => now(),
                'expires_at' => now()->addMonths(1),
                'max_uses' => 100,
                'used_count' => 0,
                'is_active' => true,
                'description' => 'Welcome discount for new customers',
            ],
            [
                'code' => 'SAVE20',
                'type' => 'percentage',
                'value' => 20.00,
                'discount' => 20.00,
                'min_purchase' => 100000,
                'max_discount' => 50000,
                'start_date' => now(),
                'expires_at' => now()->addDays(15),
                'max_uses' => 50,
                'used_count' => 0,
                'is_active' => true,
                'description' => 'Save 20% on your purchase',
            ],
            [
                'code' => 'NEWYEAR25',
                'type' => 'percentage',
                'value' => 25.00,
                'discount' => 25.00,
                'min_purchase' => 150000,
                'max_discount' => 75000,
                'start_date' => now(),
                'expires_at' => now()->addMonths(2),
                'max_uses' => 30,
                'used_count' => 0,
                'is_active' => true,
                'description' => 'New Year special discount',
            ],
            [
                'code' => 'FLAT15K',
                'type' => 'fixed',
                'value' => 15000,
                'discount' => 15000,
                'min_purchase' => 75000,
                'max_discount' => 15000,
                'start_date' => now(),
                'expires_at' => now()->addMonth(),
                'max_uses' => 40,
                'used_count' => 0,
                'is_active' => true,
                'description' => 'Flat Rp 15.000 off on your purchase',
            ],
            [
                'code' => 'PREMIUM30',
                'type' => 'percentage',
                'value' => 30.00,
                'discount' => 30.00,
                'min_purchase' => 200000,
                'max_discount' => 100000,
                'start_date' => now(),
                'expires_at' => now()->addWeeks(2),
                'max_uses' => 20,
                'used_count' => 0,
                'is_active' => true,
                'description' => 'Premium discount for loyal customers',
            ],
        ];

        foreach ($coupons as $couponData) {
            Coupon::updateOrCreate(
                ['code' => $couponData['code']],
                $couponData
            );
        }
    }
} 