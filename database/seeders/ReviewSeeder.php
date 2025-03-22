<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Review;
use App\Models\DigitalProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users (except admin)
        $users = User::where('role', '!=', 1)->get();
        
        // Get all products
        $products = DigitalProduct::all();
        
        // Check if we have users and products
        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->info('Cannot seed reviews: No users or products found. Run UserSeeder and DigitalProductSeeder first.');
            return;
        }
        
        // Testimonials data
        $reviews = [
            [
                'content' => 'Layanan sangat memuaskan! Akun Netflix Premium saya langsung aktif dalam beberapa menit setelah pembayaran. Sudah 3 bulan langganan dan tidak pernah ada masalah.',
                'rating' => 5,
                'name' => 'John D.',
                'is_active' => true,
            ],
            [
                'content' => 'Harga sangat terjangkau untuk akun premium. Awalnya ragu, tapi setelah mencoba ternyata legitimate. Sudah merekomendasikan ke teman-teman.',
                'rating' => 5,
                'name' => 'Siti R.',
                'is_active' => true,
            ],
            [
                'content' => 'Akun Spotify Premium berfungsi sempurna. Bisa download musik dan dengerin offline. Admin juga responsive banget kalau ada pertanyaan.',
                'rating' => 5,
                'name' => 'Budi S.',
                'is_active' => true,
            ],
            [
                'content' => 'ChatGPT Plus worth it banget! Jauh lebih cepat dari versi gratis dan fitur GPT-4 sangat membantu untuk pekerjaan saya. Terima kasih Premium Everyday!',
                'rating' => 5,
                'name' => 'Dewi L.',
                'is_active' => true,
            ],
            [
                'content' => 'Canva Pro bikin desain jadi lebih mudah dan cepat. Akses ke semua template premium dan elemen Pro sangat worth it dengan harga segini.',
                'rating' => 5,
                'name' => 'Anton P.',
                'is_active' => true,
            ],
            [
                'content' => 'Sudah langganan Microsoft 365 selama 6 bulan dan sangat puas. Bisa pakai di banyak device dan penyimpanan OneDrive sangat membantu.',
                'rating' => 4,
                'name' => 'Maya W.',
                'is_active' => true,
            ],
            [
                'content' => 'Awalnya ada kendala login ke HBO Max, tapi customer service sangat helpful dan masalah teratasi dalam waktu singkat. Pelayanan terbaik!',
                'rating' => 4,
                'name' => 'Rini T.',
                'is_active' => true,
            ],
            [
                'content' => 'Pengiriman akun cepat dan lancar. Paket Disney+ Premium cocok banget buat nonton bareng keluarga. Kualitas video bagus dan tidak ada buffering.',
                'rating' => 5,
                'name' => 'Anwar K.',
                'is_active' => true,
            ],
            [
                'content' => 'Akun Apple Music berfungsi dengan baik di iPhone dan Mac saya. Koleksi musiknya lengkap dan fitur lossless audio sangat worth it untuk audiophile.',
                'rating' => 5,
                'name' => 'Dian F.',
                'is_active' => true,
            ],
            [
                'content' => 'Premium Everyday jadi langganan tetap saya untuk semua kebutuhan digital. Harga kompetitif dan produk selalu berkualitas. Keep up the good work!',
                'rating' => 5,
                'name' => 'Rahman H.',
                'is_active' => true,
            ],
            [
                'content' => 'Picsart Pro membantu saya dalam editing foto untuk bisnis online. Fitur lengkap dan mudah digunakan. Sangat direkomendasikan!',
                'rating' => 4,
                'name' => 'Nina S.',
                'is_active' => true,
            ],
            [
                'content' => 'Langganan Vision+ Sport Premium membuat saya bisa nonton pertandingan favorit kapan saja. Streaming lancar dan kualitas gambar HD.',
                'rating' => 4,
                'name' => 'Joko P.',
                'is_active' => true,
            ],
            [
                'content' => 'Gemini AI sangat membantu untuk brainstorming ide konten. Saya suka fitur multimodal yang bisa memproses gambar dan teks sekaligus.',
                'rating' => 5,
                'name' => 'Linda M.',
                'is_active' => true,
            ],
            [
                'content' => 'Remini Web sangat worth it untuk memperbaiki kualitas foto lama. Hasilnya luar biasa dan prosesnya cepat. Terima kasih Premium Everyday!',
                'rating' => 5,
                'name' => 'Agus T.',
                'is_active' => true,
            ],
            [
                'content' => 'Proses checkout cepat dan aman. Metode pembayaran lengkap dan akun langsung dikirim lewat email. Puas banget dengan layanannya!',
                'rating' => 5,
                'name' => 'Dina R.',
                'is_active' => true,
            ],
        ];

        // Create reviews
        foreach ($reviews as $index => $reviewData) {
            $product = null;
            
            // Try to find a relevant product based on the review content
            if (str_contains($reviewData['content'], 'Netflix')) {
                $product = $products->where('name', 'like', '%Netflix%')->first();
            } elseif (str_contains($reviewData['content'], 'Disney')) {
                $product = $products->where('name', 'like', '%Disney%')->first();
            } elseif (str_contains($reviewData['content'], 'Spotify')) {
                $product = $products->where('name', 'like', '%Spotify%')->first();
            } elseif (str_contains($reviewData['content'], 'ChatGPT')) {
                $product = $products->where('name', 'like', '%ChatGPT%')->first();
            } elseif (str_contains($reviewData['content'], 'Canva')) {
                $product = $products->where('name', 'like', '%Canva%')->first();
            } elseif (str_contains($reviewData['content'], 'Microsoft')) {
                $product = $products->where('name', 'like', '%Microsoft%')->first();
            } elseif (str_contains($reviewData['content'], 'HBO')) {
                $product = $products->where('name', 'like', '%HBO%')->first();
            } elseif (str_contains($reviewData['content'], 'Apple Music')) {
                $product = $products->where('name', 'like', '%Apple Music%')->first();
            } elseif (str_contains($reviewData['content'], 'Picsart')) {
                $product = $products->where('name', 'like', '%Picsart%')->first();
            } elseif (str_contains($reviewData['content'], 'Vision')) {
                $product = $products->where('name', 'like', '%Vision%')->first();
            } elseif (str_contains($reviewData['content'], 'Gemini')) {
                $product = $products->where('name', 'like', '%Gemini%')->first();
            } elseif (str_contains($reviewData['content'], 'Remini')) {
                $product = $products->where('name', 'like', '%Remini%')->first();
            }
            
            // If no specific product was found, choose a random one
            if (!$product) {
                $product = $products->random();
            }
            
            // Create the review with order_id set to null
            Review::create([
                'content' => $reviewData['content'],
                'rating' => $reviewData['rating'],
                'name' => $reviewData['name'],
                'user_id' => $users->random()->id,
                'order_id' => null, // Set to null to avoid foreign key constraint
                'is_active' => $reviewData['is_active'],
                'reviewable_type' => 'App\Models\DigitalProduct',
                'reviewable_id' => $product->id,
            ]);
        }
    }
} 