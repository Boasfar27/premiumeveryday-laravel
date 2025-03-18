<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    public function run()
    {
        DB::table('coupons')->insert([
            [
                'code' => 'WELCOME100',
                'type' => 'percentage',
                'value' => 10,
                'min_purchase' => 100000,
                'max_discount' => 50000,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(1),
                'usage_limit' => 100,
                'used_count' => 0,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'SAVE10',
                'type' => 'percentage',
                'value' => 20,
                'min_purchase' => 200000,
                'max_discount' => 100000,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(1),
                'usage_limit' => 50,
                'used_count' => 0,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'FLAT10K',
                'type' => 'fixed',
                'value' => 50000,
                'min_purchase' => 500000,
                'max_discount' => 50000,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(1),
                'usage_limit' => 25,
                'used_count' => 0,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'FARHAN',
                'type' => 'percentage',
                'value' => 100,
                'min_purchase' => 10000,
                'max_discount' => 25000,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(1),
                'usage_limit' => 100,
                'used_count' => 0,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
} 