<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class TimelineController extends Controller
{
    public function index()
    {
        $agent = new Agent();
        $timelines = [
            [
                'date' => '10 Maret 2024',
                'title' => 'Promo Netflix Premium',
                'description' => 'Dapatkan diskon 20% untuk berlangganan Netflix Premium selama bulan Maret!',
                'type' => 'promo',
                'image' => 'https://ui-avatars.com/api/?name=Netflix&color=7F1D1D&background=FEE2E2'
            ],
            [
                'date' => '5 Maret 2024',
                'title' => 'Update Layanan Spotify',
                'description' => 'Sekarang tersedia paket Spotify Premium Family dengan harga spesial!',
                'type' => 'update',
                'image' => 'https://ui-avatars.com/api/?name=Spotify&color=064E3B&background=D1FAE5'
            ],
            [
                'date' => '1 Maret 2024',
                'title' => 'Maintenance Server',
                'description' => 'Akan ada maintenance server pada tanggal 2 Maret 2024 pukul 01:00 - 03:00 WIB',
                'type' => 'maintenance',
                'image' => 'https://ui-avatars.com/api/?name=Server&color=1E3A8A&background=DBEAFE'
            ],
            [
                'date' => '28 Februari 2024',
                'title' => 'YouTube Premium Tersedia',
                'description' => 'Layanan YouTube Premium sudah tersedia! Nikmati menonton tanpa iklan sekarang.',
                'type' => 'new',
                'image' => 'https://ui-avatars.com/api/?name=YouTube&color=991B1B&background=FEE2E2'
            ],
            [
                'date' => '25 Februari 2024',
                'title' => 'Metode Pembayaran Baru',
                'description' => 'Sekarang tersedia pembayaran melalui QRIS untuk semua layanan!',
                'type' => 'update',
                'image' => 'https://ui-avatars.com/api/?name=Payment&color=115E59&background=CCFBF1'
            ]
        ];

        return view($agent->isMobile() ? 'pages.mobile.timeline' : 'pages.desktop.timeline', [
            'timelines' => $timelines
        ]);
    }
}
