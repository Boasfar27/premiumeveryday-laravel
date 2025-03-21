<?php

namespace Database\Seeders;

use App\Models\Timeline;
use Illuminate\Database\Seeder;

class TimelineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timelines = [
            [
                'type' => 'general',
                'title' => 'Peluncuran Premium Everyday',
                'description' => 'Premium Everyday resmi diluncurkan sebagai platform berlangganan premium terpercaya.',
                'date' => now()->subMonths(12),
                'icon' => 'rocket',
                'color' => 'blue',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'type' => 'product',
                'title' => 'Tambahan Kategori Streaming Video',
                'description' => 'Kami menambahkan kategori Streaming Video dengan berbagai layanan premium populer.',
                'date' => now()->subMonths(10),
                'icon' => 'film',
                'color' => 'red',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'type' => 'feature',
                'title' => 'Metode Pembayaran Baru',
                'description' => 'Menambahkan dukungan untuk berbagai e-wallet dan virtual account untuk kemudahan pembayaran.',
                'date' => now()->subMonths(8),
                'icon' => 'credit-card',
                'color' => 'green',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'type' => 'update',
                'title' => 'Peningkatan Sistem Keamanan',
                'description' => 'Meningkatkan keamanan sistem untuk melindungi data pelanggan dan akun premium.',
                'date' => now()->subMonths(6),
                'icon' => 'shield-check',
                'color' => 'purple',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'type' => 'product',
                'title' => 'Peluncuran Kategori Productivity Tools',
                'description' => 'Menambahkan layanan Microsoft Office 365, Adobe Creative Cloud, dan berbagai software produktivitas lainnya.',
                'date' => now()->subMonths(4),
                'icon' => 'desktop-computer',
                'color' => 'indigo',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'type' => 'promotion',
                'title' => 'Promo Akhir Tahun',
                'description' => 'Diskon besar-besaran untuk semua layanan premium. Segera berlangganan sebelum promo berakhir!',
                'date' => now()->subMonths(2),
                'icon' => 'gift',
                'color' => 'yellow',
                'is_active' => true,
                'order' => 6,
            ],
            [
                'type' => 'event',
                'title' => 'Peluncuran Website Baru',
                'description' => 'Website baru dengan tampilan yang lebih modern dan fitur yang lebih lengkap untuk kenyamanan Anda.',
                'date' => now()->subWeeks(2),
                'icon' => 'globe',
                'color' => 'pink',
                'is_active' => true,
                'order' => 7,
            ],
        ];

        foreach ($timelines as $timeline) {
            Timeline::updateOrCreate(
                [
                    'title' => $timeline['title'],
                    'date' => $timeline['date'],
                ],
                $timeline
            );
        }
    }
}
