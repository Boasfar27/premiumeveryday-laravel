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
                'title' => 'Mulai Bisnis',
                'description' => 'Kami memulai perjalanan dengan tekad untuk membuat layanan premium digital lebih terjangkau bagi masyarakat Indonesia.',
                'date' => '2020-01-15',
                'order' => 1,
                'type' => 'general',
                'is_active' => true,
            ],
            [
                'title' => 'Ekspansi Layanan',
                'description' => 'Kami memperluas katalog layanan dengan menambahkan lebih banyak platform streaming dan alat produktivitas premium.',
                'date' => '2021-05-20',
                'order' => 2,
                'type' => 'product',
                'is_active' => true,
            ],
            [
                'title' => 'Peluncuran Platform Baru',
                'description' => 'Meresmikan platform online baru yang memudahkan pelanggan untuk menelusuri dan membeli berbagai layanan digital premium.',
                'date' => '2022-08-10',
                'order' => 3,
                'type' => 'feature',
                'is_active' => true,
            ],
            [
                'title' => 'Pencapaian 10,000 Pelanggan',
                'description' => 'Kami mencapai 10,000 pelanggan aktif, menandai kepercayaan masyarakat terhadap layanan kami.',
                'date' => '2023-02-25',
                'order' => 4,
                'type' => 'event',
                'is_active' => true,
            ],
            [
                'title' => 'Pengenalan Layanan AI',
                'description' => 'Mulai menawarkan akses ke alat-alat AI premium seperti ChatGPT dan Gemini AI untuk mendukung era digital yang baru.',
                'date' => '2023-11-15',
                'order' => 5,
                'type' => 'product',
                'is_active' => true,
            ],
        ];

        foreach ($timelines as $timelineData) {
            Timeline::updateOrCreate(
                ['title' => $timelineData['title'], 'date' => $timelineData['date']],
                $timelineData
            );
        }
    }
} 