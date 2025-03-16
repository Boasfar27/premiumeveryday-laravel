<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        // Create some dummy coupons
        Coupon::firstOrCreate(
            ['code' => 'WELCOME2024'],
            [
                'discount' => 10,
                'type' => 'percentage',
                'max_uses' => 100,
                'used_count' => 0,
                'expires_at' => Carbon::now()->addDays(30),
                'is_active' => true,
                'description' => 'Welcome discount 10% off',
            ]
        );

        Coupon::firstOrCreate(
            ['code' => 'SAVE2024'],
            [
                'discount' => 20,
                'type' => 'percentage',
                'max_uses' => 50,
                'used_count' => 5,
                'expires_at' => Carbon::now()->addDays(15),
                'is_active' => true,
                'description' => 'Save 20% on your purchase',
            ]
        );

        Coupon::firstOrCreate(
            ['code' => 'FIXED2024'],
            [
                'discount' => 50000,
                'type' => 'fixed',
                'max_uses' => 25,
                'used_count' => 10,
                'expires_at' => Carbon::now()->addDays(7),
                'is_active' => true,
                'description' => 'Flat Rp50.000 off',
            ]
        );
    }
} 