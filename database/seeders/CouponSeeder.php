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
                'min_purchase' => 50000,
                'max_discount' => 25000,
                'start_date' => now(),
                'end_date' => now()->addMonths(1),
                'usage_limit' => 100,
                'used_count' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'SAVE20',
                'type' => 'percentage',
                'value' => 20.00,
                'min_purchase' => 100000,
                'max_discount' => 50000,
                'start_date' => now(),
                'end_date' => now()->addDays(15),
                'usage_limit' => 50,
                'used_count' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'NEWYEAR25',
                'type' => 'percentage',
                'value' => 25.00,
                'min_purchase' => 150000,
                'max_discount' => 75000,
                'start_date' => now(),
                'end_date' => now()->addMonths(2),
                'usage_limit' => 30,
                'used_count' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'FLAT15K',
                'type' => 'fixed',
                'value' => 15000,
                'min_purchase' => 75000,
                'max_discount' => 15000,
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'usage_limit' => 40,
                'used_count' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'PREMIUM30',
                'type' => 'percentage',
                'value' => 30.00,
                'min_purchase' => 200000,
                'max_discount' => 100000,
                'start_date' => now(),
                'end_date' => now()->addWeeks(2),
                'usage_limit' => 20,
                'used_count' => 0,
                'is_active' => true,
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