<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Bagaimana cara berlangganan produk di Premium Everyday?',
                'answer' => '<p>Berlangganan produk di Premium Everyday sangat mudah. Berikut langkah-langkahnya:</p>
                <ol>
                    <li>Daftar atau masuk ke akun Anda</li>
                    <li>Pilih produk yang ingin Anda berlangganan</li>
                    <li>Pilih paket berlangganan yang sesuai dengan kebutuhan Anda</li>
                    <li>Lakukan pembayaran melalui metode pembayaran yang tersedia</li>
                    <li>Setelah pembayaran terverifikasi, Anda akan menerima detail akun melalui email</li>
                </ol>',
                'is_active' => true,
                'order' => 1,
                'category' => 'umum',
            ],
            [
                'question' => 'Metode pembayaran apa saja yang tersedia?',
                'answer' => '<p>Kami menerima berbagai metode pembayaran untuk kenyamanan Anda:</p>
                <ul>
                    <li>Transfer Bank (BCA, Mandiri, BNI, BRI)</li>
                    <li>E-wallet (OVO, DANA, GoPay, LinkAja)</li>
                    <li>QRIS</li>
                    <li>Virtual Account</li>
                </ul>',
                'is_active' => true,
                'order' => 2,
                'category' => 'pembayaran',
            ],
            [
                'question' => 'Berapa lama proses aktivasi akun setelah pembayaran?',
                'answer' => '<p>Proses aktivasi akun umumnya dilakukan dalam waktu:</p>
                <ul>
                    <li><strong>Pembayaran Otomatis</strong> (E-wallet, VA, QRIS): 5-15 menit setelah pembayaran terverifikasi</li>
                    <li><strong>Transfer Manual</strong>: 1-3 jam di jam kerja (09.00-21.00 WIB) setelah konfirmasi pembayaran</li>
                </ul>
                <p>Jika terjadi keterlambatan, silakan hubungi customer service kami melalui fitur Live Chat atau WhatsApp.</p>',
                'is_active' => true,
                'order' => 3,
                'category' => 'akun',
            ],
            [
                'question' => 'Apakah akun saya aman jika menggunakan layanan berbagi (sharing)?',
                'answer' => '<p>Ya, keamanan akun adalah prioritas kami. Untuk layanan berbagi (sharing):</p>
                <ul>
                    <li>Kami memberikan profil terpisah untuk setiap pengguna</li>
                    <li>Password utama tidak dibagikan ke pengguna sharing</li>
                    <li>Kami memantau aktivitas akun secara berkala</li>
                    <li>Tim kami siap membantu jika terjadi masalah pada akun Anda</li>
                </ul>',
                'is_active' => true,
                'order' => 4,
                'category' => 'keamanan',
            ],
            [
                'question' => 'Apakah saya bisa mendapatkan refund jika layanan bermasalah?',
                'answer' => '<p>Ya, kami menyediakan kebijakan refund untuk menjamin kepuasan pelanggan:</p>
                <ul>
                    <li>Jika terjadi masalah teknis pada akun yang tidak dapat kami perbaiki dalam 24 jam, Anda berhak mendapatkan refund penuh atau perpanjangan masa berlangganan</li>
                    <li>Refund akan diproses dalam waktu 1-3 hari kerja</li>
                    <li>Untuk masalah teknis yang dapat diselesaikan, kami akan memperpanjang masa aktif berlangganan sesuai dengan durasi gangguan</li>
                </ul>
                <p>Silakan hubungi customer service kami untuk mengajukan refund.</p>',
                'is_active' => true,
                'order' => 5,
                'category' => 'pembayaran',
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
