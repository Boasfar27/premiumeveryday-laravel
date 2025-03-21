<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\DigitalProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DigitalProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs
        $streamingVideoId = Category::where('slug', 'streaming-video')->first()->id ?? null;
        $streamingMusicId = Category::where('slug', 'streaming-music')->first()->id ?? null;
        $productivityToolsId = Category::where('slug', 'productivity-tools')->first()->id ?? null;
        $premiumSoftwareId = Category::where('slug', 'premium-software')->first()->id ?? null;
        
        $products = [
            [
                'name' => 'Netflix Premium',
                'slug' => 'netflix-premium',
                'description' => '<p>Akses ke semua konten premium Netflix dengan kualitas 4K dan HDR. Nikmati ribuan film dan serial TV populer tanpa iklan dan batasan regional.</p>
                <p>Fitur:</p>
                <ul>
                    <li>Kualitas streaming 4K Ultra HD & HDR</li>
                    <li>Download untuk ditonton offline</li>
                    <li>Tanpa iklan</li>
                    <li>Akses ke semua original series</li>
                </ul>',
                'features' => '<ul>
                    <li>4 profil pengguna</li>
                    <li>Streaming di smartphone, tablet, smart TV, laptop, dan perangkat streaming</li>
                    <li>Konten original ekslusif</li>
                    <li>Tanpa iklan dan gangguan</li>
                </ul>',
                'requirements' => '<ul>
                    <li>Koneksi internet minimal 5Mbps</li>
                    <li>Device yang kompatibel</li>
                </ul>',
                'thumbnail' => 'products/thumbnails/netflix.webp',
                'price' => 149000,
                'sale_price' => 129000,
                'is_on_sale' => true,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $streamingVideoId,
                'product_type' => 'subscription',
                'sort_order' => 1,
            ],
            [
                'name' => 'Spotify Premium',
                'slug' => 'spotify-premium',
                'description' => '<p>Nikmati musik premium tanpa iklan, dengan kualitas audio yang superior. Akses ke jutaan lagu dan podcast dari seluruh dunia.</p>
                <p>Fitur:</p>
                <ul>
                    <li>Tanpa iklan</li>
                    <li>Unduh musik untuk didengarkan offline</li>
                    <li>Kualitas audio sangat baik</li>
                    <li>Skip lagu tanpa batas</li>
                </ul>',
                'features' => '<ul>
                    <li>Akses ke 70+ juta lagu</li>
                    <li>Ribuan podcast eksklusif</li>
                    <li>Audio streaming kualitas tinggi</li>
                    <li>Mode offline</li>
                </ul>',
                'requirements' => '<ul>
                    <li>Smartphone, tablet, atau PC dengan OS terbaru</li>
                    <li>Koneksi internet yang stabil</li>
                </ul>',
                'thumbnail' => 'products/thumbnails/spotify.webp',
                'price' => 59000,
                'sale_price' => null,
                'is_on_sale' => false,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $streamingMusicId,
                'product_type' => 'subscription',
                'sort_order' => 1,
            ],
            [
                'name' => 'Microsoft Office 365',
                'slug' => 'microsoft-office-365',
                'description' => '<p>Suite office lengkap termasuk Word, Excel, PowerPoint, dan lainnya. Dibundel dengan cloud storage OneDrive 1TB untuk semua kebutuhan produktivitas Anda.</p>
                <p>Aplikasi yang tersedia:</p>
                <ul>
                    <li>Microsoft Word</li>
                    <li>Microsoft Excel</li>
                    <li>Microsoft PowerPoint</li>
                    <li>Microsoft Outlook</li>
                    <li>Microsoft OneNote</li>
                    <li>OneDrive 1TB</li>
                </ul>',
                'features' => '<ul>
                    <li>Semua aplikasi Office terbaru</li>
                    <li>1TB cloud storage</li>
                    <li>Update reguler ke versi terbaru</li>
                    <li>Dapat digunakan hingga 5 perangkat</li>
                </ul>',
                'requirements' => '<ul>
                    <li>Windows 10 atau macOS versi terbaru</li>
                    <li>4GB RAM minimum</li>
                    <li>10GB ruang disk</li>
                </ul>',
                'thumbnail' => 'products/thumbnails/logo.webp',
                'price' => 999000,
                'sale_price' => 899000,
                'is_on_sale' => true,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $productivityToolsId,
                'product_type' => 'license',
                'sort_order' => 1,
            ],
            [
                'name' => 'Adobe Creative Cloud',
                'slug' => 'adobe-creative-cloud',
                'description' => '<p>Akses lengkap ke semua aplikasi Adobe Creative Suite termasuk Photoshop, Illustrator, Premiere Pro, dan banyak lagi untuk kebutuhan kreatif digital Anda.</p>
                <p>Aplikasi yang tersedia:</p>
                <ul>
                    <li>Adobe Photoshop</li>
                    <li>Adobe Illustrator</li>
                    <li>Adobe Premiere Pro</li>
                    <li>Adobe After Effects</li>
                    <li>Adobe InDesign</li>
                    <li>Dan banyak lagi...</li>
                </ul>',
                'features' => '<ul>
                    <li>20+ aplikasi kreatif profesional</li>
                    <li>100GB cloud storage</li>
                    <li>Ribuan font dan aset desain</li>
                    <li>Update reguler ke versi terbaru</li>
                </ul>',
                'requirements' => '<ul>
                    <li>Windows 10 64-bit atau macOS versi terbaru</li>
                    <li>8GB RAM (16GB direkomendasikan)</li>
                    <li>GPU dengan dukungan DirectX 12</li>
                    <li>20GB ruang disk per aplikasi</li>
                </ul>',
                'thumbnail' => 'products/thumbnails/placeholder.webp',
                'price' => 1299000,
                'sale_price' => 1099000,
                'is_on_sale' => true,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $premiumSoftwareId,
                'product_type' => 'license',
                'sort_order' => 1,
            ],
        ];

        foreach ($products as $product) {
            DigitalProduct::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }
    }
}
