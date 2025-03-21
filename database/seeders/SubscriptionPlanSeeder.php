<?php

namespace Database\Seeders;

use App\Models\DigitalProduct;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get product IDs
        $netflixId = DigitalProduct::where('slug', 'netflix-premium')->first()->id ?? null;
        $spotifyId = DigitalProduct::where('slug', 'spotify-premium')->first()->id ?? null;
        
        $subscriptionPlans = [
            // Netflix Plans
            [
                'digital_product_id' => $netflixId,
                'name' => 'Netflix Sharing',
                'slug' => 'netflix-sharing',
                'description' => 'Paket berbagi akun Netflix untuk 2 pengguna. Harga lebih terjangkau dengan semua fitur premium.',
                'type' => 'sharing',
                'max_users' => 2,
                'price' => 99000,
                'sale_price' => 89000,
                'billing_cycle' => 'monthly',
                'duration_days' => 30,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'digital_product_id' => $netflixId,
                'name' => 'Netflix Premium Private',
                'slug' => 'netflix-premium-private',
                'description' => 'Akun Netflix pribadi dengan akses eksklusif untuk 1 pengguna. Tanpa berbagi, privasi terjamin.',
                'type' => 'individual',
                'max_users' => 1,
                'price' => 149000,
                'sale_price' => 129000,
                'billing_cycle' => 'monthly',
                'duration_days' => 30,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            
            // Spotify Plans
            [
                'digital_product_id' => $spotifyId,
                'name' => 'Spotify Individu',
                'slug' => 'spotify-individu',
                'description' => 'Paket Spotify Premium untuk pengguna individu. Nikmati musik tanpa iklan, download untuk offline, dan kualitas audio superior.',
                'type' => 'individual',
                'max_users' => 1,
                'price' => 59000,
                'sale_price' => null,
                'billing_cycle' => 'monthly',
                'duration_days' => 30,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'digital_product_id' => $spotifyId,
                'name' => 'Spotify Family',
                'slug' => 'spotify-family',
                'description' => 'Paket Spotify Premium untuk keluarga hingga 6 anggota yang tinggal serumah. Masing-masing mendapatkan akun premium terpisah.',
                'type' => 'sharing',
                'max_users' => 6,
                'price' => 89000,
                'sale_price' => 79000,
                'billing_cycle' => 'monthly',
                'duration_days' => 30,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($subscriptionPlans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
