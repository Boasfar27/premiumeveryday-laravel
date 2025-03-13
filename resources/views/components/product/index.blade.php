<!-- Product Section -->
<div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-16 md:py-24">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-4">Premium Products</h2>
            <p class="text-gray-300 text-lg md:text-xl max-w-3xl mx-auto">Discover our exclusive collection of premium
                streaming services</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
            @foreach ($featuredProducts as $product)
                <div class="group relative" x-data="{ activeTab: 'sharing' }">
                    <!-- Card Container with Glassmorphism -->
                    <div
                        class="bg-white/10 backdrop-blur-lg rounded-2xl overflow-hidden shadow-2xl transition-all duration-300 hover:shadow-blue-500/20 hover:scale-[1.02] border border-white/10 h-full flex flex-col">
                        <!-- Image Container -->
                        <div class="relative h-48 md:h-56 overflow-hidden bg-white/5 flex items-center justify-center">
                            @if ($product->image)
                                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-4/5 h-4/5 object-contain transition-transform duration-300 group-hover:scale-110"
                                    style="image-rendering: -webkit-optimize-contrast;">
                            @endif
                            <!-- Premium/Promo Badge -->
                            @if ($product->is_promo)
                                <div class="absolute top-4 right-4 flex flex-col gap-2">
                                    <div
                                        class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-3 py-1 rounded-full text-sm font-semibold shadow-lg">
                                        Premium
                                    </div>
                                    <div
                                        class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-1 rounded-full text-sm font-semibold shadow-lg animate-pulse">
                                        Promo
                                    </div>
                                </div>
                            @else
                                <div
                                    class="absolute top-4 right-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-3 py-1 rounded-full text-sm font-semibold shadow-lg">
                                    Premium
                                </div>
                            @endif
                        </div>

                        <div class="p-6 md:p-8 flex-grow flex flex-col">
                            <!-- Product Title -->
                            <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">
                                {{ Str::limit($product->name, 20) }}</h3>

                            <!-- Description -->
                            @if ($product->description)
                                <p class="text-gray-300 text-base mb-6">{{ Str::limit($product->description, 100) }}</p>
                            @endif

                            <!-- Tab Navigation -->
                            <div class="flex mb-6 bg-white/5 rounded-lg p-1">
                                <button @click="activeTab = 'sharing'"
                                    :class="{ 'bg-gradient-to-r from-blue-600 to-blue-700 text-white': activeTab === 'sharing', 'text-gray-300 hover:text-white': activeTab !== 'sharing' }"
                                    class="flex-1 py-2 px-4 rounded-lg text-sm md:text-base font-medium transition-all duration-200">
                                    Sharing
                                </button>
                                <button @click="activeTab = 'private'"
                                    :class="{ 'bg-gradient-to-r from-blue-600 to-blue-700 text-white': activeTab === 'private', 'text-gray-300 hover:text-white': activeTab !== 'private' }"
                                    class="flex-1 py-2 px-4 rounded-lg text-sm md:text-base font-medium transition-all duration-200">
                                    Private
                                </button>
                            </div>

                            <!-- Sharing Tab -->
                            <div x-show="activeTab === 'sharing'" x-transition
                                class="space-y-6 flex-grow flex flex-col">
                                <div class="space-y-4 flex-grow">
                                    @if ($product->sharing_description)
                                        <ul class="text-gray-300 text-sm md:text-base space-y-2">
                                            @foreach (explode("\n", $product->sharing_description) as $line)
                                                <li class="flex items-center space-x-2">
                                                    <svg class="w-4 h-4 text-blue-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span>{{ $line }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <div class="bg-white/5 p-4 rounded-xl space-y-2 mt-auto">
                                        @if ($product->is_promo && $product->sharing_discount > 0)
                                            <div class="flex items-center justify-between">
                                                <p class="text-lg line-through text-gray-400">
                                                    Rp {{ number_format($product->sharing_price, 0, ',', '.') }}
                                                </p>
                                                <span
                                                    class="text-red-400 text-sm font-semibold">-{{ number_format(($product->sharing_discount / $product->sharing_price) * 100, 0) }}%</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <p class="text-2xl md:text-3xl font-bold text-blue-400">
                                                    Rp
                                                    {{ number_format($product->sharing_price - $product->sharing_discount, 0, ',', '.') }}
                                                </p>
                                                <span class="text-gray-400 text-sm">/bulan</span>
                                            </div>
                                            <div class="text-yellow-500 text-sm">
                                                Promo berakhir:
                                                {{ \Carbon\Carbon::parse($product->promo_ends_at)->diffForHumans() }}
                                            </div>
                                        @else
                                            <div class="flex items-center justify-between">
                                                <p class="text-2xl md:text-3xl font-bold text-blue-400">
                                                    Rp {{ number_format($product->sharing_price, 0, ',', '.') }}
                                                </p>
                                                <span class="text-gray-400 text-sm">/bulan</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @auth
                                    <a href="https://wa.me/6285172010009?text=Halo, saya ingin berlangganan {{ $product->name }} (Sharing) {{ $product->is_promo ? 'dengan Promo' : '' }}"
                                        target="_blank"
                                        class="block text-center bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 px-6 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:scale-[1.02] font-medium text-base md:text-lg shadow-lg hover:shadow-blue-500/25">
                                        Pesan Sekarang
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="block text-center bg-gradient-to-r from-gray-600 to-gray-700 text-white py-3 px-6 rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 transform hover:scale-[1.02] font-medium text-base md:text-lg shadow-lg hover:shadow-gray-500/25">
                                        Login untuk Pesan
                                    </a>
                                @endauth
                            </div>

                            <!-- Private Tab -->
                            <div x-show="activeTab === 'private'" x-transition
                                class="space-y-6 flex-grow flex flex-col">
                                <div class="space-y-4 flex-grow">
                                    @if ($product->private_description)
                                        <ul class="text-gray-300 text-sm md:text-base space-y-2">
                                            @foreach (explode("\n", $product->private_description) as $line)
                                                <li class="flex items-center space-x-2">
                                                    <svg class="w-4 h-4 text-blue-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span>{{ $line }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <div class="bg-white/5 p-4 rounded-xl space-y-2 mt-auto">
                                        @if ($product->is_promo && $product->private_discount > 0)
                                            <div class="flex items-center justify-between">
                                                <p class="text-lg line-through text-gray-400">
                                                    Rp {{ number_format($product->private_price, 0, ',', '.') }}
                                                </p>
                                                <span
                                                    class="text-red-400 text-sm font-semibold">-{{ number_format(($product->private_discount / $product->private_price) * 100, 0) }}%</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <p class="text-2xl md:text-3xl font-bold text-blue-400">
                                                    Rp
                                                    {{ number_format($product->private_price - $product->private_discount, 0, ',', '.') }}
                                                </p>
                                                <span class="text-gray-400 text-sm">/bulan</span>
                                            </div>
                                            <div class="text-yellow-500 text-sm">
                                                Promo berakhir:
                                                {{ \Carbon\Carbon::parse($product->promo_ends_at)->diffForHumans() }}
                                            </div>
                                        @else
                                            <div class="flex items-center justify-between">
                                                <p class="text-2xl md:text-3xl font-bold text-blue-400">
                                                    Rp {{ number_format($product->private_price, 0, ',', '.') }}
                                                </p>
                                                <span class="text-gray-400 text-sm">/bulan</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @auth
                                    <a href="https://wa.me/6285172010009?text=Halo, saya ingin berlangganan {{ $product->name }} (Private) {{ $product->is_promo ? 'dengan Promo' : '' }}"
                                        target="_blank"
                                        class="block text-center bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 px-6 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:scale-[1.02] font-medium text-base md:text-lg shadow-lg hover:shadow-blue-500/25">
                                        Pesan Sekarang
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="block text-center bg-gradient-to-r from-gray-600 to-gray-700 text-white py-3 px-6 rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 transform hover:scale-[1.02] font-medium text-base md:text-lg shadow-lg hover:shadow-gray-500/25">
                                        Login untuk Pesan
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
