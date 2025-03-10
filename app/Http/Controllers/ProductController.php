<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class ProductController extends Controller
{
    public function index()
    {
        $agent = new Agent();
        $products = [
            [
                'id' => 1,
                'name' => 'Netflix',
                'description' => 'Akses Netflix Premium dengan akun sharing. Nikmati semua konten tanpa iklan!',
                'price' => 24999,
                'status' => 'Tersedia'
            ],
            [
                'id' => 2,
                'name' => 'Spotify Premium',
                'description' => 'Dengarkan musik tanpa iklan dan download untuk didengarkan offline!',
                'price' => 19999,
                'status' => 'Tersedia'
            ],
            [
                'id' => 3,
                'name' => 'YouTube Premium',
                'description' => 'Tonton YouTube tanpa iklan dan putar di background!',
                'price' => 9999,
                'status' => 'Tersedia'
            ]
        ];

        return view($agent->isMobile() ? 'pages.mobile.products' : 'pages.desktop.products', [
            'products' => $products
        ]);
    }

    public function show($id)
    {
        $agent = new Agent();
        $product = $this->findProduct($id);

        if (!$product) {
            return redirect()->route('products')->with('error', 'Produk tidak ditemukan');
        }

        return view($agent->isMobile() ? 'pages.mobile.product-detail' : 'pages.desktop.product-detail', [
            'product' => $product
        ]);
    }

    private function findProduct($id)
    {
        $products = [
            1 => [
                'id' => 1,
                'name' => 'Netflix',
                'description' => 'Akses Netflix Premium dengan akun sharing. Nikmati semua konten tanpa iklan!',
                'price' => 24999,
                'status' => 'Tersedia',
                'features' => [
                    'Akses ke semua konten Netflix',
                    'Kualitas HD/Ultra HD',
                    'Dapat digunakan di 1 perangkat',
                    'Durasi 30 hari'
                ]
            ],
            2 => [
                'id' => 2,
                'name' => 'Spotify Premium',
                'description' => 'Dengarkan musik tanpa iklan dan download untuk didengarkan offline!',
                'price' => 19999,
                'status' => 'Tersedia',
                'features' => [
                    'Dengarkan musik tanpa iklan',
                    'Download musik untuk offline',
                    'Kualitas audio premium',
                    'Durasi 30 hari'
                ]
            ],
            3 => [
                'id' => 3,
                'name' => 'YouTube Premium',
                'description' => 'Tonton YouTube tanpa iklan dan putar di background!',
                'price' => 9999,
                'status' => 'Tersedia',
                'features' => [
                    'Tonton video tanpa iklan',
                    'Putar di background',
                    'Download video untuk offline',
                    'Durasi 30 hari'
                ]
            ]
        ];

        return $products[$id] ?? null;
    }
}
