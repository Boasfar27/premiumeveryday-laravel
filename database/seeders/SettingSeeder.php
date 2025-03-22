<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // General Settings
        Setting::set('site_name', 'Premium Everyday', [
            'group' => 'general',
            'type' => 'text',
            'label' => 'Site Name',
            'description' => 'The name of the website',
            'is_public' => true,
        ]);
        
        Setting::set('site_description', 'Premium digital products subscription service', [
            'group' => 'general',
            'type' => 'text',
            'label' => 'Site Description',
            'description' => 'A short description of the website',
            'is_public' => true,
        ]);
        
        // Payment Settings
        Setting::set('tax_rate', '5', [
            'group' => 'payment',
            'type' => 'number',
            'label' => 'Tax Rate (%)',
            'description' => 'Tax rate in percentage (e.g. 5 for 5%)',
            'is_public' => true,
        ]);
        
        Setting::set('currency', 'IDR', [
            'group' => 'payment',
            'type' => 'text',
            'label' => 'Currency',
            'description' => 'The default currency for all transactions',
            'is_public' => true,
        ]);
        
        Setting::set('currency_symbol', 'Rp', [
            'group' => 'payment',
            'type' => 'text',
            'label' => 'Currency Symbol',
            'description' => 'The symbol for the default currency',
            'is_public' => true,
        ]);
        
        // Subscription Settings
        Setting::set('subscription_durations', json_encode([
            'monthly' => [
                'label' => '1 Month',
                'days' => 30,
                'discount' => 0,
            ],
            'quarterly' => [
                'label' => '3 Months',
                'days' => 90,
                'discount' => 5,
            ],
            'biannual' => [
                'label' => '6 Months',
                'days' => 180,
                'discount' => 10,
            ],
            'yearly' => [
                'label' => '1 Year',
                'days' => 365,
                'discount' => 15,
            ],
        ]), [
            'group' => 'subscription',
            'type' => 'json',
            'label' => 'Subscription Durations',
            'description' => 'Available subscription durations and their discounts',
            'is_public' => true,
        ]);
        
        Setting::set('subscription_max_users', json_encode([
            1 => [
                'label' => 'Single User',
                'price_multiplier' => 1,
            ],
            2 => [
                'label' => '2 Users',
                'price_multiplier' => 1.8,
            ],
            5 => [
                'label' => '5 Users',
                'price_multiplier' => 4,
            ],
            10 => [
                'label' => '10 Users',
                'price_multiplier' => 7.5,
            ],
            'unlimited' => [
                'label' => 'Unlimited Users',
                'price_multiplier' => 20,
            ],
        ]), [
            'group' => 'subscription',
            'type' => 'json',
            'label' => 'Max Users Options',
            'description' => 'Available options for max users and their price multipliers',
            'is_public' => true,
        ]);
    }
}
