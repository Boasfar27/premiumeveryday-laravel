<?php

namespace Database\Seeders;

use App\Models\SubscriptionFeature;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get plan IDs
        $netflixPrivateId = SubscriptionPlan::where('slug', 'netflix-premium-private')->first()->id ?? null;
        $netflixSharingId = SubscriptionPlan::where('slug', 'netflix-sharing')->first()->id ?? null;
        $spotifyIndividuId = SubscriptionPlan::where('slug', 'spotify-individu')->first()->id ?? null;
        $spotifyFamilyId = SubscriptionPlan::where('slug', 'spotify-family')->first()->id ?? null;
        
        $features = [
            // Netflix Premium Private
            [
                'subscription_plan_id' => $netflixPrivateId,
                'name' => 'Akun Pribadi',
                'description' => 'Akun milik sendiri, tidak berbagi dengan orang lain',
                'icon' => 'user-circle',
                'is_highlighted' => true,
                'sort_order' => 1,
            ],
            [
                'subscription_plan_id' => $netflixPrivateId,
                'name' => 'Kualitas 4K Ultra HD',
                'description' => 'Streaming resolusi tertinggi hingga 4K',
                'icon' => 'film',
                'is_highlighted' => true,
                'sort_order' => 2,
            ],
            [
                'subscription_plan_id' => $netflixPrivateId,
                'name' => 'Download Offline',
                'description' => 'Download film & serial untuk ditonton offline',
                'icon' => 'download',
                'is_highlighted' => true,
                'sort_order' => 3,
            ],
            [
                'subscription_plan_id' => $netflixPrivateId,
                'name' => '4 Perangkat Sekaligus',
                'description' => 'Streaming hingga 4 perangkat bersamaan',
                'icon' => 'device-mobile',
                'is_highlighted' => false,
                'sort_order' => 4,
            ],
            
            // Netflix Sharing
            [
                'subscription_plan_id' => $netflixSharingId,
                'name' => 'Berbagi dengan 1 Pengguna',
                'description' => 'Akun dibagi dengan 1 pengguna lain',
                'icon' => 'users',
                'is_highlighted' => true,
                'sort_order' => 1,
            ],
            [
                'subscription_plan_id' => $netflixSharingId,
                'name' => 'Kualitas Full HD',
                'description' => 'Streaming resolusi Full HD 1080p',
                'icon' => 'film',
                'is_highlighted' => true,
                'sort_order' => 2,
            ],
            [
                'subscription_plan_id' => $netflixSharingId,
                'name' => 'Download Offline',
                'description' => 'Download film & serial untuk ditonton offline',
                'icon' => 'download',
                'is_highlighted' => false,
                'sort_order' => 3,
            ],
            [
                'subscription_plan_id' => $netflixSharingId,
                'name' => '2 Perangkat Sekaligus',
                'description' => 'Streaming hingga 2 perangkat bersamaan',
                'icon' => 'device-mobile',
                'is_highlighted' => false,
                'sort_order' => 4,
            ],
            
            // Spotify Individu
            [
                'subscription_plan_id' => $spotifyIndividuId,
                'name' => 'Tanpa Iklan',
                'description' => 'Dengarkan musik tanpa gangguan iklan',
                'icon' => 'ban',
                'is_highlighted' => true,
                'sort_order' => 1,
            ],
            [
                'subscription_plan_id' => $spotifyIndividuId,
                'name' => 'Audio Kualitas Tinggi',
                'description' => 'Kualitas audio 320kbps',
                'icon' => 'music',
                'is_highlighted' => true,
                'sort_order' => 2,
            ],
            [
                'subscription_plan_id' => $spotifyIndividuId,
                'name' => 'Mode Offline',
                'description' => 'Download untuk didengarkan offline',
                'icon' => 'download',
                'is_highlighted' => true,
                'sort_order' => 3,
            ],
            [
                'subscription_plan_id' => $spotifyIndividuId,
                'name' => 'Skip Track Tak Terbatas',
                'description' => 'Skip lagu sebanyak yang Anda mau',
                'icon' => 'fast-forward',
                'is_highlighted' => false,
                'sort_order' => 4,
            ],
            
            // Spotify Family
            [
                'subscription_plan_id' => $spotifyFamilyId,
                'name' => 'Hingga 6 Akun',
                'description' => 'Akun terpisah untuk hingga 6 anggota keluarga',
                'icon' => 'users',
                'is_highlighted' => true,
                'sort_order' => 1,
            ],
            [
                'subscription_plan_id' => $spotifyFamilyId,
                'name' => 'Tanpa Iklan',
                'description' => 'Semua akun bebas dari iklan',
                'icon' => 'ban',
                'is_highlighted' => true,
                'sort_order' => 2,
            ],
            [
                'subscription_plan_id' => $spotifyFamilyId,
                'name' => 'Mode Offline',
                'description' => 'Download untuk didengarkan offline',
                'icon' => 'download',
                'is_highlighted' => true,
                'sort_order' => 3,
            ],
            [
                'subscription_plan_id' => $spotifyFamilyId,
                'name' => 'Spotify Kids',
                'description' => 'Akses ke aplikasi Spotify Kids',
                'icon' => 'heart',
                'is_highlighted' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($features as $feature) {
            SubscriptionFeature::updateOrCreate(
                [
                    'subscription_plan_id' => $feature['subscription_plan_id'],
                    'name' => $feature['name'],
                ],
                $feature
            );
        }
    }
}
