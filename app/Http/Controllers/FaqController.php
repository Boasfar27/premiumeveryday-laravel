<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class FaqController extends Controller
{
    public function index()
    {
        $agent = new Agent();
        $faqs = [
            [
                'question' => 'Apa itu Premium Everyday?',
                'answer' => 'Premium Everyday adalah layanan penyedia akun premium sharing untuk berbagai platform digital seperti Netflix, Spotify, YouTube Premium, dan layanan streaming lainnya dengan harga yang terjangkau.'
            ],
            [
                'question' => 'Bagaimana cara berlangganan?',
                'answer' => 'Untuk berlangganan, Anda dapat memilih produk yang diinginkan, lalu klik tombol "Pesan via WhatsApp". Customer service kami akan membantu proses pemesanan Anda.'
            ],
            [
                'question' => 'Metode pembayaran apa saja yang tersedia?',
                'answer' => 'Kami menerima pembayaran melalui transfer bank (BCA, Mandiri, BNI, BRI), e-wallet (OVO, DANA, GoPay), dan QRIS.'
            ],
            [
                'question' => 'Berapa lama proses aktivasi?',
                'answer' => 'Proses aktivasi akun dilakukan segera setelah pembayaran dikonfirmasi, biasanya memakan waktu 5-15 menit pada jam kerja.'
            ],
            [
                'question' => 'Apakah akun sharing aman digunakan?',
                'answer' => 'Ya, akun sharing kami aman digunakan selama Anda mengikuti panduan penggunaan yang kami berikan, seperti tidak mengubah password dan informasi akun.'
            ],
            [
                'question' => 'Bagaimana jika terjadi masalah dengan akun?',
                'answer' => 'Jika terjadi masalah dengan akun, Anda dapat langsung menghubungi customer service kami melalui WhatsApp. Kami akan membantu menyelesaikan masalah Anda secepat mungkin.'
            ],
            [
                'question' => 'Apakah bisa perpanjang langganan?',
                'answer' => 'Ya, Anda bisa memperpanjang langganan sebelum masa aktif habis. Kami akan mengirimkan notifikasi melalui WhatsApp ketika masa aktif akan berakhir.'
            ],
            [
                'question' => 'Berapa device yang bisa digunakan?',
                'answer' => 'Setiap akun sharing hanya bisa digunakan di 1 device pada satu waktu untuk menjaga kualitas layanan.'
            ]
        ];

        return view($agent->isMobile() ? 'pages.mobile.faq' : 'pages.desktop.faq', [
            'faqs' => $faqs
        ]);
    }
}
