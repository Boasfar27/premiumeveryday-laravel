<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

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
                'question' => 'Bagaimana cara melakukan pembelian di Premium Everyday?',
                'answer' => '<p>Untuk melakukan pembelian, Anda perlu:</p>
                <ol>
                    <li>Pilih produk yang ingin Anda beli</li>
                    <li>Klik tombol "Add to Cart"</li>
                    <li>Periksa keranjang belanja dan klik "Checkout"</li>
                    <li>Pilih metode pembayaran dan selesaikan transaksi</li>
                </ol>
                <p>Setelah pembayaran berhasil, Anda akan menerima akun atau akses sesuai dengan produk yang Anda beli.</p>',
                'category' => 'general',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Metode pembayaran apa saja yang tersedia?',
                'answer' => '<p>Kami menerima berbagai metode pembayaran, termasuk:</p>
                <ul>
                    <li>Transfer Bank (BCA, Mandiri, BNI, BRI)</li>
                    <li>E-wallet (Gopay, OVO, Dana, ShopeePay)</li>
                    <li>Virtual Account</li>
                    <li>QRIS</li>
                    <li>Kartu Kredit</li>
                </ul>',
                'category' => 'general',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Apa perbedaan antara akun Sharing dan Private/Gold?',
                'answer' => '<p>Akun Sharing: Akun yang dapat digunakan bersama dengan beberapa pengguna lain. Harga lebih terjangkau, tetapi mungkin memiliki batasan penggunaan atau region.</p>
                <p>Akun Private/Gold: Akun pribadi yang hanya digunakan oleh Anda. Memiliki harga lebih tinggi, tetapi memberikan pengalaman premium penuh tanpa batasan dan bisa digunakan di semua region.</p>',
                'category' => 'general',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'Berapa lama akun akan aktif setelah pembelian?',
                'answer' => '<p>Akun umumnya akan aktif dalam waktu 1-24 jam setelah pembayaran berhasil dikonfirmasi. Untuk sebagian besar produk, aktivasi biasanya dilakukan dalam beberapa menit.</p>',
                'category' => 'general',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana jika saya lupa password akun yang saya beli?',
                'answer' => '<p>Jika Anda lupa password akun yang Anda beli, silakan hubungi tim dukungan kami melalui WhatsApp atau email yang tertera di halaman Kontak. Tim kami akan membantu Anda untuk mereset password atau memberikan informasi yang diperlukan.</p>',
                'category' => 'general',
                'order' => 5,
                'is_active' => true,
            ],

            // Streaming Video FAQs
            [
                'question' => 'Apakah saya bisa menggunakan akun Netflix di beberapa perangkat?',
                'answer' => '<p>Ya, Anda bisa menggunakan akun Netflix di beberapa perangkat sesuai dengan paket yang Anda beli. Untuk akun sharing, umumnya dibatasi maksimal 2 perangkat login secara bersamaan untuk menghindari pembatasan dari pihak Netflix.</p>',
                'category' => 'streaming-video',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah ada batasan region untuk akun streaming?',
                'answer' => '<p>Untuk akun sharing, beberapa layanan streaming mungkin memiliki batasan region. Kami akan memberikan informasi tentang region yang didukung untuk setiap akun yang Anda beli. Akun private/gold umumnya dapat digunakan di semua region tanpa batasan.</p>',
                'category' => 'streaming-video',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana jika akun streaming saya tidak berfungsi?',
                'answer' => '<p>Jika akun streaming Anda tidak berfungsi, silakan ikuti langkah-langkah berikut:</p>
                <ol>
                    <li>Pastikan Anda menggunakan email dan password yang benar</li>
                    <li>Coba bersihkan cache browser atau gunakan browser berbeda</li>
                    <li>Jika masih bermasalah, hubungi tim dukungan kami melalui WhatsApp atau email dengan menyertakan bukti pembelian</li>
                </ol>
                <p>Kami akan membantu menyelesaikan masalah atau memberikan akun pengganti jika diperlukan.</p>',
                'category' => 'streaming-video',
                'order' => 3,
                'is_active' => true,
            ],

            // Streaming Music FAQs
            [
                'question' => 'Apakah saya bisa mengganti alamat email di akun Spotify Premium?',
                'answer' => '<p>Untuk akun Spotify Premium sharing, Anda tidak dapat mengganti alamat email karena akun tersebut dikelola oleh penyedia. Untuk akun private/gold, beberapa kasus memungkinkan perubahan email, silakan hubungi tim dukungan kami untuk informasi lebih lanjut.</p>',
                'category' => 'streaming-music',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Bisakah saya mengunduh lagu untuk didengarkan secara offline?',
                'answer' => '<p>Ya, semua akun premium Spotify, Apple Music, dan layanan musik streaming lainnya yang kami sediakan memungkinkan Anda untuk mengunduh lagu dan mendengarkannya secara offline, sesuai dengan kebijakan masing-masing platform.</p>',
                'category' => 'streaming-music',
                'order' => 2,
                'is_active' => true,
            ],

            // AI Tools FAQs
            [
                'question' => 'Apakah ChatGPT Plus yang Anda jual termasuk akses ke GPT-4?',
                'answer' => '<p>Ya, semua akun ChatGPT Plus yang kami jual sudah termasuk akses ke model GPT-4 dan fitur-fitur premium lainnya seperti respons lebih cepat dan akses prioritas saat trafik tinggi.</p>',
                'category' => 'ai-tools',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah saya bisa membuat akun Gemini AI dengan email saya sendiri?',
                'answer' => '<p>Untuk pilihan Gold (Akun Milik Sendiri), ya, Anda akan mendapatkan akun yang terdaftar dengan email Anda sendiri. Untuk pilihan Sharing, Anda akan menggunakan akun yang telah dibuat dan dikelola oleh kami.</p>',
                'category' => 'ai-tools',
                'order' => 2,
                'is_active' => true,
            ],

            // Productivity Tools FAQs
            [
                'question' => 'Apakah Microsoft 365 termasuk OneDrive dan semua aplikasi Office?',
                'answer' => '<p>Ya, akun Microsoft 365 yang kami sediakan mencakup semua aplikasi Office (Word, Excel, PowerPoint, Outlook, dll.), OneDrive dengan penyimpanan cloud, dan fitur premium lainnya sesuai dengan langganan Microsoft 365 standar.</p>',
                'category' => 'productivity-tools',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Bisakah saya menggunakan Canva Pro untuk keperluan komersial?',
                'answer' => '<p>Ya, Anda dapat menggunakan Canva Pro untuk keperluan komersial dan pribadi. Semua desain yang Anda buat menggunakan elemen Pro dapat digunakan secara komersial, sesuai dengan Syarat dan Ketentuan Canva.</p>',
                'category' => 'productivity-tools',
                'order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faqData) {
            Faq::updateOrCreate(
                ['question' => $faqData['question'], 'category' => $faqData['category']],
                $faqData
            );
        }
    }
} 