<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            DigitalProductSeeder::class,
            CouponSeeder::class,
            TimelineSeeder::class,
            FaqSeeder::class,
            ContactSeeder::class,
            OrderSeeder::class,
            ReviewSeeder::class,
            SettingSeeder::class,
        ]);
    }
} 