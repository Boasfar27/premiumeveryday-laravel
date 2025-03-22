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
        // Get categories
        $streamingVideoCategory = Category::where('slug', 'streaming-video')->first();
        $streamingMusicCategory = Category::where('slug', 'streaming-music')->first();
        $aiToolsCategory = Category::where('slug', 'ai-tools')->first();
        $productivityToolsCategory = Category::where('slug', 'productivity-tools')->first();
        $creativeSoftwareCategory = Category::where('slug', 'creative-software')->first();
        $sportsStreamingCategory = Category::where('slug', 'sports-streaming')->first();

        // Streaming Video Products
        $streamingVideoProducts = [
            [
                'name' => 'Netflix Premium',
                'slug' => 'netflix-premium',
                'description' => '<p>Netflix Premium subscription with Ultra HD 4K quality. Enjoy thousands of movies, TV shows, and award-winning Netflix originals.</p>
                <p>Perfect for family entertainment with multiple screens and profiles.</p>',
                'features' => '<ul>
                    <li>UHD 4K quality streaming</li>
                    <li>Access on all devices (Max login 2 devices)</li>
                    <li>1 Month (29-30 days) subscription</li>
                    <li>Private (1 Profile 1 User) option</li>
                </ul>',
                'price' => 59000,
                'is_featured' => true,
                'thumbnail' => 'images/products/netflix.webp',
                'product_type' => 'subscription',
                'sort_order' => 1,
            ],
            [
                'name' => 'Disney+ Premium',
                'slug' => 'disney-premium',
                'description' => '<p>Disney+ Premium subscription with Ultra HD 4K quality. Access Disney, Pixar, Marvel, Star Wars, and National Geographic content.</p>
                <p>Perfect for family entertainment with exclusive Disney+ originals.</p>',
                'features' => '<ul>
                    <li>UHD 4K quality streaming</li>
                    <li>Access on all devices</li>
                    <li>Max login 2 devices</li>
                    <li>Private (1 Profile 1 User) option</li>
                </ul>',
                'price' => 59000,
                'is_featured' => true,
                'thumbnail' => 'images/products/placeholder.webp',
                'product_type' => 'subscription',
                'sort_order' => 2,
            ],
            [
                'name' => 'HBO Max',
                'slug' => 'hbo-max',
                'description' => '<p>HBO Max subscription with access to HBO\'s premium content library including exclusive HBO Max originals.</p>
                <p>Get access to Warner Bros. movies, DC Universe, and more.</p>',
                'features' => '<ul>
                    <li>Account from official store</li>
                    <li>1 Month (28-30 days) subscription</li>
                    <li>Access on all devices (Max login 2 devices)</li>
                    <li>Private (1 Profile) & Gold (1 Account) options</li>
                </ul>',
                'price' => 29000,
                'is_featured' => false,
                'thumbnail' => 'images/products/hbomax.webp',
                'product_type' => 'subscription',
                'sort_order' => 3,
            ],
            [
                'name' => 'Prime Video',
                'slug' => 'prime-video',
                'description' => '<p>Amazon Prime Video subscription with access to thousands of movies, TV shows, and Amazon Originals.</p>
                <p>Enjoy exclusive content and the ability to rent or purchase additional movies and shows.</p>',
                'features' => '<ul>
                    <li>Account from official store</li>
                    <li>1 Month (28-30 days) subscription</li>
                    <li>Access on all devices (Max login 2 devices)</li>
                    <li>Private (1 Profile) & Gold (1 Account) options</li>
                </ul>',
                'price' => 24000,
                'is_featured' => false,
                'thumbnail' => 'images/products/primevideo.webp',
                'product_type' => 'subscription',
                'sort_order' => 4,
            ],
            [
                'name' => 'Apple TV',
                'slug' => 'apple-tv',
                'description' => '<p>Apple TV+ subscription with access to Apple\'s exclusive original content.</p>
                <p>Enjoy high-quality streaming of shows like Ted Lasso, The Morning Show, and more.</p>',
                'features' => '<ul>
                    <li>Account from official store</li>
                    <li>1 Month (28-30 days) subscription</li>
                    <li>Access on all devices (Max login 2 devices)</li>
                    <li>Sharing (Account Sharing) & Gold (1 Account Anti Limit) options</li>
                </ul>',
                'price' => 32000,
                'is_featured' => false,
                'thumbnail' => 'images/products/appletv.webp',
                'product_type' => 'subscription',
                'sort_order' => 5,
            ],
            [
                'name' => 'Youtube Premium',
                'slug' => 'youtube-premium',
                'description' => '<p>YouTube Premium subscription for ad-free viewing, background play, and YouTube Music access.</p>
                <p>Enjoy YouTube without interruptions and download videos for offline viewing.</p>',
                'features' => '<ul>
                    <li>Email from buyer</li>
                    <li>1 Month (28-30 days) subscription</li>
                    <li>Access on all devices</li>
                    <li>Ad-free viewing, 1080p resolution</li>
                </ul>',
                'price' => 23000,
                'sale_price' => 13000,
                'is_on_sale' => true,
                'sale_ends_at' => now()->addDays(7),
                'is_featured' => false,
                'thumbnail' => 'images/products/youtube.webp',
                'product_type' => 'subscription',
                'sort_order' => 6,
            ],
            [
                'name' => 'Viu Premium',
                'slug' => 'viu-premium',
                'description' => '<p>Viu Premium subscription with access to Asian dramas, variety shows, and Viu originals.</p>
                <p>Watch the latest Korean, Japanese, Thai, and Chinese content with HD quality.</p>',
                'features' => '<ul>
                    <li>Account from official store</li>
                    <li>1 Month (28-30 days) subscription</li>
                    <li>Access on all devices (Max login 2 devices)</li>
                    <li>Sharing (Account sharing) & Gold (Account sendiri) options</li>
                </ul>',
                'price' => 23000,
                'is_featured' => false,
                'thumbnail' => 'images/products/viu.webp',
                'product_type' => 'subscription',
                'sort_order' => 7,
            ],
            [
                'name' => 'WeTv',
                'slug' => 'wetv',
                'description' => '<p>WeTV subscription for premium Chinese and Asian content including exclusive WeTV originals.</p>
                <p>Watch Chinese dramas, variety shows, and more with HD quality.</p>',
                'features' => '<ul>
                    <li>Account from official store</li>
                    <li>1 Month (25-27 days) subscription</li>
                    <li>Max login 2 devices</li>
                    <li>Sharing (Account Sharing) & Gold (1 Account Anti Limit) options</li>
                </ul>',
                'price' => 30000,
                'is_featured' => false,
                'thumbnail' => 'images/products/wetv.webp',
                'product_type' => 'subscription',
                'sort_order' => 8,
            ],
            [
                'name' => 'iQiyi',
                'slug' => 'iqiyi',
                'description' => '<p>iQiyi subscription for premium Chinese and Asian content including exclusive iQiyi originals.</p>
                <p>Enjoy a vast library of Chinese dramas, movies, variety shows, and animations.</p>',
                'features' => '<ul>
                    <li>Account from official store</li>
                    <li>1 Month (29-30 days) subscription</li>
                    <li>Access on all devices (Max login 2 devices)</li>
                    <li>Sharing (Account Sharing) & Gold (1 Account Anti Limit) options</li>
                </ul>',
                'price' => 25000,
                'is_featured' => false,
                'thumbnail' => 'images/products/iqiyi.webp',
                'product_type' => 'subscription',
                'sort_order' => 9,
            ],
        ];

        // Streaming Music Products
        $streamingMusicProducts = [
            [
                'name' => 'Spotify Premium',
                'slug' => 'spotify-premium',
                'description' => '<p>Spotify Premium subscription with ad-free music streaming, offline listening, and high-quality audio.</p>
                <p>Access millions of songs and podcasts with unlimited skips.</p>',
                'features' => '<ul>
                    <li>Account from Buyer / Official Store (Depending on Stock)</li>
                    <li>Access on all devices & Without Ads</li>
                    <li>Free Ads and Download Feature</li>
                </ul>',
                'price' => 59000,
                'is_featured' => true,
                'thumbnail' => 'images/products/spotify.webp',
                'product_type' => 'subscription',
                'sort_order' => 1,
            ],
            [
                'name' => 'Apple Music',
                'slug' => 'apple-music',
                'description' => '<p>Apple Music subscription with access to over 90 million songs, playlists, and Apple\'s exclusive content.</p>
                <p>Enjoy spatial audio, lyrics, and offline listening.</p>',
                'features' => '<ul>
                    <li>System invite via link</li>
                    <li>1 Month (29-30 days) subscription</li>
                    <li>Max. join family 2x</li>
                    <li>Private access</li>
                </ul>',
                'price' => 27000,
                'is_featured' => false,
                'thumbnail' => 'images/products/applemusic.webp',
                'product_type' => 'subscription',
                'sort_order' => 2,
            ],
        ];

        // AI Tools Products
        $aiToolsProducts = [
            [
                'name' => 'ChatGPT',
                'slug' => 'chatgpt',
                'description' => '<p>ChatGPT Premium (Plus) subscription with access to GPT-4 and advanced features.</p>
                <p>Experience faster response times, priority access during peak times, and new feature previews.</p>',
                'features' => '<ul>
                    <li>Account from official store</li>
                    <li>Access on all devices (Max login 1 device)</li>
                    <li>1 Month (28-30 days) subscription</li>
                    <li>Sharing (Account sharing) & Gold (1 Account Personal) options</li>
                </ul>',
                'price' => 49000,
                'is_featured' => true,
                'thumbnail' => 'images/products/chatgpt.webp',
                'product_type' => 'subscription',
                'sort_order' => 1,
            ],
            [
                'name' => 'Gemini AI',
                'slug' => 'gemini-ai',
                'description' => '<p>Gemini AI Premium subscription (Google\'s advanced AI model) with access to Gemini Ultra capabilities.</p>
                <p>Use advanced AI for creative writing, coding assistance, and complex problem-solving.</p>',
                'features' => '<ul>
                    <li>Account from official store</li>
                    <li>Access on all devices (Max login 1 device)</li>
                    <li>1 Month (28-30 days) subscription</li>
                    <li>Sharing (Account sharing) & Gold (1 Account Personal) options</li>
                </ul>',
                'price' => 49000,
                'is_featured' => true,
                'thumbnail' => 'images/products/placeholder.webp',
                'product_type' => 'subscription',
                'sort_order' => 2,
            ],
        ];

        // Productivity Tools Products
        $productivityToolsProducts = [
            [
                'name' => 'Microsoft 365',
                'slug' => 'microsoft-365',
                'description' => '<p>Microsoft 365 subscription with access to Office apps, OneDrive storage, and premium features.</p>
                <p>Get Word, Excel, PowerPoint, Outlook, and more on all your devices.</p>',
                'features' => '<ul>
                    <li>Email from buyer</li>
                    <li>Access on all devices</li>
                    <li>1 Month (27-30 days) subscription</li>
                    <li>All Microsoft features</li>
                </ul>',
                'price' => 25000,
                'is_featured' => false,
                'thumbnail' => 'images/products/placeholder.webp',
                'product_type' => 'subscription',
                'sort_order' => 1,
            ],
            [
                'name' => 'Canva Pro',
                'slug' => 'canva-pro',
                'description' => '<p>Canva Pro subscription with access to premium templates, elements, and features.</p>
                <p>Create professional designs effortlessly with brand kits and magic resize features.</p>',
                'features' => '<ul>
                    <li>Via email from buyer</li>
                    <li>Access on all devices & unlimited login on any device</li>
                    <li>1 Month (28-30 days) subscription</li>
                    <li>Private</li>
                </ul>',
                'price' => 20000,
                'is_featured' => false,
                'thumbnail' => 'images/products/placeholder.webp',
                'product_type' => 'subscription',
                'sort_order' => 2,
            ],
            [
                'name' => 'Scribd',
                'slug' => 'scribd',
                'description' => '<p>Scribd subscription with access to millions of books, audiobooks, magazines, and documents.</p>
                <p>Unlimited reading and listening with a single subscription.</p>',
                'features' => '<ul>
                    <li>Account from official store</li>
                    <li>Access on all devices & unlimited login on any device</li>
                    <li>1 Month (28-30 days) subscription</li>
                    <li>Sharing (Account sharing) & Gold (1 Account Personal) options</li>
                </ul>',
                'price' => 23000,
                'is_featured' => false,
                'thumbnail' => 'images/products/placeholder.webp',
                'product_type' => 'subscription',
                'sort_order' => 3,
            ],
        ];

        // Creative Software Products
        $creativeSoftwareProducts = [
            [
                'name' => 'Capcut Pro',
                'slug' => 'capcut-pro',
                'description' => '<p>Capcut Pro subscription with access to premium video editing features, effects, and templates.</p>
                <p>Create professional videos without watermarks and access all Pro features.</p>',
                'features' => '<ul>
                    <li>Account from official store</li>
                    <li>1 Month (28-30 days) subscription</li>
                    <li>Access all Pro features without watermark</li>
                    <li>Private</li>
                </ul>',
                'price' => 38000,
                'is_featured' => false,
                'thumbnail' => 'images/products/capcut.webp',
                'product_type' => 'subscription',
                'sort_order' => 1,
            ],
            [
                'name' => 'Picsart',
                'slug' => 'picsart',
                'description' => '<p>Picsart subscription with access to premium photo and video editing tools, templates, and effects.</p>
                <p>Create stunning visual content with professional editing features.</p>',
                'features' => '<ul>
                    <li>Account from official store</li>
                    <li>Access on all devices</li>
                    <li>1 Month (28-30 days) subscription</li>
                    <li>Sharing (Account sharing) & Gold (1 Account Personal) options</li>
                </ul>',
                'price' => 25000,
                'is_featured' => false,
                'thumbnail' => 'images/products/placeholder.webp',
                'product_type' => 'subscription',
                'sort_order' => 2,
            ],
            [
                'name' => 'Remini Web',
                'slug' => 'remini-web',
                'description' => '<p>Remini Web subscription for AI-powered photo enhancement and restoration.</p>
                <p>Transform low-quality, blurry images into clear, high-definition photos.</p>',
                'features' => '<ul>
                    <li>Account from official store</li>
                    <li>Access on all devices & unlimited login on any device</li>
                    <li>1 Month (28-30 days) subscription</li>
                    <li>Sharing (Account sharing) & Gold (1 Account Personal) options</li>
                </ul>',
                'price' => 28000,
                'is_featured' => false,
                'thumbnail' => 'images/products/placeholder.webp',
                'product_type' => 'subscription',
                'sort_order' => 3,
            ],
        ];

        // Sports Streaming Products
        $sportsStreamingProducts = [
            [
                'name' => 'Vision+ Sport Premium',
                'slug' => 'vision-sport-premium',
                'description' => '<p>Vision+ Sport Premium subscription with access to live sports events, highlights, and exclusive content.</p>
                <p>Watch football, motorsports, basketball, and more in HD quality.</p>',
                'features' => '<ul>
                    <li>Account from official store</li>
                    <li>1 Month (28-30 days) subscription</li>
                    <li>Access on all devices (Max login 2 devices)</li>
                    <li>Sharing (Account sharing) & Gold (1 Account Personal) options</li>
                </ul>',
                'price' => 32000,
                'is_featured' => false,
                'thumbnail' => 'images/products/placeholder.webp',
                'product_type' => 'subscription',
                'sort_order' => 1,
            ],
            [
                'name' => 'RCTI+ Sport',
                'slug' => 'rcti-sport',
                'description' => '<p>RCTI+ Sport subscription with access to live sports broadcasts, match replays, and highlights.</p>
                <p>Watch Indonesian football leagues, international matches, and more exclusive sports content.</p>',
                'features' => '<ul>
                    <li>Account from official store</li>
                    <li>1 Month (28-30 days) subscription</li>
                    <li>Access on all devices</li>
                    <li>Gold (1 Account Personal) option</li>
                </ul>',
                'price' => 38000,
                'is_featured' => false,
                'thumbnail' => 'images/products/placeholder.webp',
                'product_type' => 'subscription',
                'sort_order' => 2,
            ],
        ];

        // Seed Streaming Video Products
        $this->seedProducts($streamingVideoProducts, $streamingVideoCategory);

        // Seed Streaming Music Products
        $this->seedProducts($streamingMusicProducts, $streamingMusicCategory);

        // Seed AI Tools Products
        $this->seedProducts($aiToolsProducts, $aiToolsCategory);

        // Seed Productivity Tools Products
        $this->seedProducts($productivityToolsProducts, $productivityToolsCategory);

        // Seed Creative Software Products
        $this->seedProducts($creativeSoftwareProducts, $creativeSoftwareCategory);

        // Seed Sports Streaming Products
        $this->seedProducts($sportsStreamingProducts, $sportsStreamingCategory);
    }

    /**
     * Seed products to the database.
     *
     * @param array $products
     * @param Category $category
     * @return void
     */
    private function seedProducts(array $products, Category $category): void
    {
        foreach ($products as $index => $productData) {
            // Remove fields that might not exist in the model
            if (isset($productData['private_price'])) {
                unset($productData['private_price']);
            }
            
            DigitalProduct::updateOrCreate(
                ['slug' => $productData['slug']],
                array_merge($productData, [
                    'category_id' => $category->id,
                    'is_active' => true,
                ])
            );
        }
    }
} 