<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // General FAQs
            [
                'category' => 'general',
                'question' => 'Apa itu Premium Everyday?',
                'answer' => 'Premium Everyday adalah platform yang menyediakan akses ke berbagai layanan streaming premium seperti Netflix, Disney+, Spotify, dan lainnya dengan harga terjangkau dan proses yang mudah.',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'category' => 'general',
                'question' => 'Bagaimana cara berlangganan layanan di Premium Everyday?',
                'answer' => 'Pilih layanan yang Anda inginkan, tambahkan ke keranjang, lakukan pembayaran, dan Anda akan menerima akses ke layanan tersebut melalui email dalam waktu 24 jam.',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'category' => 'general',
                'question' => 'Metode pembayaran apa saja yang tersedia?',
                'answer' => 'Kami menerima pembayaran melalui transfer bank, e-wallet (OVO, GoPay, DANA, LinkAja), dan kartu kredit/debit.',
                'is_active' => true,
                'order' => 3,
            ],
            
            // Streaming Video FAQs
            [
                'category' => 'streaming-video',
                'question' => 'Apakah saya mendapatkan akun Netflix pribadi?',
                'answer' => 'Anda akan mendapatkan akses ke akun Netflix premium yang dapat digunakan pada satu profil. Akun ini dikelola oleh Premium Everyday untuk memastikan layanan tetap aktif.',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'category' => 'streaming-video',
                'question' => 'Berapa lama masa aktif langganan streaming video?',
                'answer' => 'Masa aktif bervariasi tergantung paket yang Anda pilih, mulai dari 1 bulan, 3 bulan, 6 bulan, hingga 1 tahun.',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'category' => 'streaming-video',
                'question' => 'Apakah saya bisa menonton di berbagai perangkat?',
                'answer' => 'Ya, Anda dapat menonton di berbagai perangkat seperti smartphone, tablet, laptop, smart TV, atau perangkat streaming lainnya sesuai dengan ketentuan masing-masing layanan.',
                'is_active' => true,
                'order' => 3,
            ],
            
            // Streaming Music FAQs
            [
                'category' => 'streaming-music',
                'question' => 'Apakah saya bisa mendownload musik untuk didengarkan offline?',
                'answer' => 'Ya, layanan streaming musik premium seperti Spotify dan Apple Music memungkinkan Anda untuk mendownload musik dan mendengarkannya secara offline.',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'category' => 'streaming-music',
                'question' => 'Apakah ada batasan jumlah perangkat untuk layanan musik?',
                'answer' => 'Setiap layanan memiliki kebijakan berbeda. Spotify Premium memungkinkan penggunaan pada satu perangkat pada satu waktu, sementara Apple Music memungkinkan hingga 10 perangkat.',
                'is_active' => true,
                'order' => 2,
            ],
            
            // Account & Security FAQs
            [
                'category' => 'account',
                'question' => 'Bagaimana jika akun saya tidak berfungsi?',
                'answer' => 'Jika mengalami masalah dengan akun, silakan hubungi tim dukungan kami melalui email support@premiumeveryday.com atau WhatsApp. Kami akan merespons dalam waktu 24 jam.',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'category' => 'account',
                'question' => 'Apakah saya bisa mengubah password akun?',
                'answer' => 'Untuk keamanan dan pengelolaan layanan, password akun dikelola oleh Premium Everyday. Jika Anda memerlukan perubahan, silakan hubungi tim dukungan kami.',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'category' => 'account',
                'question' => 'Apakah data saya aman?',
                'answer' => 'Ya, kami mengutamakan keamanan data pelanggan. Informasi pribadi dan pembayaran Anda dilindungi dengan enkripsi tingkat tinggi dan tidak akan dibagikan kepada pihak ketiga.',
                'is_active' => true,
                'order' => 3,
            ],
            
            // Renewal & Cancellation FAQs
            [
                'category' => 'renewal',
                'question' => 'Bagaimana cara memperpanjang langganan?',
                'answer' => 'Anda akan menerima notifikasi email sebelum masa langganan berakhir. Untuk memperpanjang, cukup login ke akun Anda dan pilih opsi perpanjangan atau balas email notifikasi tersebut.',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'category' => 'renewal',
                'question' => 'Apakah ada sistem perpanjangan otomatis?',
                'answer' => 'Saat ini kami tidak menyediakan perpanjangan otomatis. Anda perlu memperpanjang langganan secara manual sebelum masa aktif berakhir untuk menghindari gangguan layanan.',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'category' => 'renewal',
                'question' => 'Bagaimana jika saya ingin membatalkan langganan?',
                'answer' => 'Anda dapat membatalkan langganan kapan saja dengan menghubungi tim dukungan kami. Namun, biaya langganan yang sudah dibayarkan tidak dapat dikembalikan untuk periode yang sedang berjalan.',
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
} 