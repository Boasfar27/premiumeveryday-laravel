@extends('pages.mobile.layouts.app')

@section('title', 'Premium Everyday - Layanan Streaming Premium Terpercaya')

@push('styles')
    <style>
        .testimonial-carousel .carousel-inner {
            display: flex;
            transition: transform 0.5s ease;
        }

        .carousel-page {
            flex: 0 0 100%;
            width: 100%;
        }

        .mobile-carousel-indicator.bg-pink-500 {
            width: 3px;
            height: 3px;
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section id="home"
        class="bg-gradient-to-r from-pink-600 to-pink-700 text-white min-h-[85vh] flex items-center -mt-[1px]">
        <div class="container mx-auto px-4 py-12">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold mb-4">Akses Premium ke Layanan Streaming Favorit Anda</h1>
                <p class="text-lg mb-6">Nikmati Netflix, Disney+, Spotify, dan layanan premium lainnya dengan harga
                    terjangkau dan proses yang mudah.</p>
                <div class="flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4 justify-center">
                    <a href="{{ route('products.streaming-video') }}"
                        class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-pink-700 bg-white hover:bg-gray-50 shadow-md transition duration-300">
                        Streaming Video
                        <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                    <a href="{{ route('products.streaming-music') }}"
                        class="inline-flex items-center justify-center px-5 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-pink-800 shadow-md transition duration-300">
                        Streaming Musik
                        <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 max-w-xs mx-auto">
                <div class="transform hover:scale-105 transition duration-300">
                    <img src="{{ asset('storage/products/thumbnails/netflix.webp') }}" alt="Netflix"
                        class="w-full h-24 object-contain bg-white rounded-xl p-3 shadow-lg">
                </div>
                <div class="transform hover:scale-105 transition duration-300">
                    <img src="{{ asset('storage/products/thumbnails/spotify.webp') }}" alt="Spotify"
                        class="w-full h-24 object-contain bg-white rounded-xl p-3 shadow-lg">
                </div>
                <div class="transform hover:scale-105 transition duration-300">
                    <img src="{{ asset('storage/products/thumbnails/youtube.webp') }}" alt="YouTube"
                        class="w-full h-24 object-contain bg-white rounded-xl p-3 shadow-lg">
                </div>
                <div class="transform hover:scale-105 transition duration-300">
                    <img src="{{ asset('storage/products/thumbnails/appletv.webp') }}" alt="Apple TV+"
                        class="w-full h-24 object-contain bg-white rounded-xl p-3 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="featured-products" class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Layanan Premium Terpopuler</h2>
                <p class="mt-2 text-gray-600">Pilihan terbaik dari layanan streaming premium</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach ($featuredProducts->take(4) as $product)
                    <div
                        class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 border border-gray-100 group transform hover:-translate-y-1">
                        <div class="relative">
                            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                class="w-full h-40 object-cover transform group-hover:scale-105 transition-transform duration-500">
                            @if ($product->is_on_sale)
                                <div class="absolute top-2 left-2 flex flex-col gap-1">
                                    <span
                                        class="inline-flex items-center rounded-full bg-pink-100 px-2 py-0.5 text-xs font-semibold text-pink-700 shadow-sm">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                </div>
                            @endif
                            @if ($product->created_at->diffInDays(now()) <= 7)
                                <div class="absolute top-2 right-2">
                                    <span
                                        class="inline-flex items-center rounded-full bg-pink-100 px-2 py-0.5 text-xs font-semibold text-pink-700 shadow-sm">
                                        New
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex items-center mb-2">
                                <span class="text-xs font-medium text-pink-700 bg-pink-50 rounded-full px-2 py-1">
                                    {{ $product->category ? $product->category->name : 'Uncategorized' }}
                                </span>
                            </div>
                            <h3 class="text-base font-bold text-gray-900 mb-2 group-hover:text-pink-600 transition-colors">
                                {{ $product->name }}</h3>
                            <p class="text-gray-600 text-xs mb-3 line-clamp-2">{!! strip_tags($product->description) !!}</p>
                            <div class="flex items-center justify-between">
                                <div>
                                    @if ($product->is_on_sale)
                                        <span class="text-gray-400 line-through text-xs">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-sm font-bold text-pink-700">Rp
                                            {{ number_format($product->current_price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-sm font-bold text-pink-700">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product) }}"
                                    class="inline-flex items-center justify-center rounded-lg px-3 py-1.5 bg-pink-50 text-pink-600 hover:bg-pink-600 hover:text-white transition-all duration-200 text-xs font-medium shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-5 py-2.5 border border-pink-600 text-base font-medium rounded-md text-pink-600 hover:bg-pink-50 transition duration-300">
                    Lihat Semua Layanan
                    <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Streaming Video Section -->
    <section id="streaming-video" class="py-12">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Streaming Video</h2>
                    <p class="mt-1 text-sm text-gray-600">Akses ke layanan streaming video premium</p>
                </div>
                <a href="{{ route('products.streaming-video') }}"
                    class="text-pink-600 hover:text-pink-700 font-medium flex items-center">
                    <span class="text-sm">Lihat Semua</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 gap-4">
                @foreach ($streamingVideoProducts->take(6) as $product)
                    <div
                        class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 border border-gray-100 group transform hover:-translate-y-1 flex flex-col">
                        <div class="relative">
                            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                class="w-full h-28 object-cover transform group-hover:scale-105 transition-transform duration-500">
                            @if ($product->is_on_sale)
                                <div class="absolute top-1 left-1 flex flex-col gap-1">
                                    <span
                                        class="inline-flex items-center rounded-full bg-pink-100 px-1.5 py-0.5 text-xs font-semibold text-pink-700 shadow-sm text-[10px]">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="p-2 flex-1 flex flex-col">
                            <h3
                                class="text-xs font-bold text-gray-900 mb-1 line-clamp-1 group-hover:text-pink-600 transition-colors">
                                {{ $product->name }}</h3>
                            <div class="mt-auto flex items-center justify-between">
                                <div>
                                    @if ($product->is_on_sale)
                                        <span class="text-gray-400 line-through text-[10px]">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <div class="text-pink-700 font-bold text-xs">Rp
                                            {{ number_format($product->current_price, 0, ',', '.') }}</div>
                                    @else
                                        <div class="text-pink-700 font-bold text-xs">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</div>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product) }}"
                                    class="inline-flex items-center justify-center rounded-full px-2 py-0.5 bg-pink-50 text-pink-600 hover:bg-pink-600 hover:text-white transition-all duration-200 text-[10px] font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 mr-0.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Streaming Music Section -->
    <section id="streaming-music" class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Streaming Musik</h2>
                    <p class="mt-1 text-sm text-gray-600">Akses ke layanan streaming musik premium</p>
                </div>
                <a href="{{ route('products.streaming-music') }}"
                    class="text-pink-600 hover:text-pink-700 font-medium flex items-center">
                    <span class="text-sm">Lihat Semua</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 gap-4">
                @foreach ($streamingMusicProducts->take(6) as $product)
                    <div
                        class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 border border-gray-100 group transform hover:-translate-y-1 flex flex-col">
                        <div class="relative">
                            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                class="w-full h-28 object-cover transform group-hover:scale-105 transition-transform duration-500">
                            @if ($product->is_on_sale)
                                <div class="absolute top-1 left-1 flex flex-col gap-1">
                                    <span
                                        class="inline-flex items-center rounded-full bg-pink-100 px-1.5 py-0.5 text-xs font-semibold text-pink-700 shadow-sm text-[10px]">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="p-2 flex-1 flex flex-col">
                            <h3
                                class="text-xs font-bold text-gray-900 mb-1 line-clamp-1 group-hover:text-pink-600 transition-colors">
                                {{ $product->name }}</h3>
                            <div class="mt-auto flex items-center justify-between">
                                <div>
                                    @if ($product->is_on_sale)
                                        <span class="text-gray-400 line-through text-[10px]">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <div class="text-pink-700 font-bold text-xs">Rp
                                            {{ number_format($product->current_price, 0, ',', '.') }}</div>
                                    @else
                                        <div class="text-pink-700 font-bold text-xs">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</div>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product) }}"
                                    class="inline-flex items-center justify-center rounded-full px-2 py-0.5 bg-pink-50 text-pink-600 hover:bg-pink-600 hover:text-white transition-all duration-200 text-[10px] font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 mr-0.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section id="why-choose-us" class="py-12">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Mengapa Memilih Kami</h2>
                <p class="mt-2 text-sm text-gray-600">Keunggulan berlangganan layanan streaming melalui Premium Everyday
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <div
                    class="bg-white p-6 rounded-lg shadow-sm text-center hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div
                        class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-pink-100 text-pink-600 mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Harga Terjangkau</h3>
                    <p class="text-gray-600 text-sm">Nikmati layanan premium dengan harga yang lebih terjangkau
                        dibandingkan
                        berlangganan langsung.</p>
                </div>

                <div
                    class="bg-white p-6 rounded-lg shadow-sm text-center hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div
                        class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-pink-100 text-pink-600 mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Aman & Terpercaya</h3>
                    <p class="text-gray-600 text-sm">Transaksi aman dan akun dikelola dengan baik untuk memastikan layanan
                        tetap
                        aktif.</p>
                </div>

                <div
                    class="bg-white p-6 rounded-lg shadow-sm text-center hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div
                        class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-pink-100 text-pink-600 mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Dukungan 24/7</h3>
                    <p class="text-gray-600 text-sm">Tim dukungan kami siap membantu Anda kapan saja dengan respons cepat
                        dan
                        solusi efektif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Apa Kata Pelanggan</h2>
                <p class="mt-2 text-sm text-gray-600">Testimoni dari pelanggan yang puas dengan layanan kami</p>
            </div>

            @if (is_object($testimonials) && count($testimonials) > 0)
                <div class="testimonial-carousel relative">
                    <div class="overflow-hidden">
                        <div class="carousel-inner flex transition-transform duration-500">
                            @foreach (collect($testimonials)->chunk(1) as $chunk)
                                <div class="carousel-page flex-shrink-0 w-full grid grid-cols-1 gap-6">
                                    @foreach ($chunk as $testimonial)
                                        <div
                                            class="bg-white p-5 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                            <div class="flex items-center mb-3">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 font-bold text-lg">
                                                    {{ substr($testimonial->name, 0, 1) }}
                                                </div>
                                                <div class="ml-3">
                                                    <h4 class="text-base font-bold text-gray-900">{{ $testimonial->name }}
                                                    </h4>
                                                    <div class="flex items-center mt-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $testimonial->rating)
                                                                <svg class="w-3 h-3 text-yellow-400 fill-current"
                                                                    viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                                    </path>
                                                                </svg>
                                                            @else
                                                                <svg class="w-3 h-3 text-gray-300 fill-current"
                                                                    viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                                    </path>
                                                                </svg>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-gray-600 text-sm italic">"{{ $testimonial->content }}"</p>
                                            <p class="text-gray-400 text-xs mt-2">
                                                {{ $testimonial->created_at->format('M d, Y') }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Carousel Indicators -->
                    <div class="flex justify-center mt-4">
                        @foreach (collect($testimonials)->chunk(1) as $index => $chunk)
                            <button type="button" data-mobile-carousel-target="{{ $index }}"
                                class="mobile-carousel-indicator mx-1 w-2 h-2 rounded-full bg-gray-300 hover:bg-pink-500 focus:outline-none"></button>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">No testimonials yet.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-12">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Pertanyaan Umum</h2>
                <p class="mt-2 text-sm text-gray-600">Jawaban untuk pertanyaan yang sering diajukan</p>
            </div>

            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Umum</h3>
                    @foreach ($generalFaqs as $faq)
                        <div
                            class="mb-3 bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                            <details class="group">
                                <summary class="flex items-center justify-between p-3 cursor-pointer">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $faq->question }}</h4>
                                    <svg class="w-4 h-4 text-gray-500 group-open:rotate-180 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </summary>
                                <div class="p-3 pt-0 text-gray-600 text-xs border-t border-gray-100">
                                    {!! $faq->answer !!}
                                </div>
                            </details>
                        </div>
                    @endforeach
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Layanan Streaming</h3>
                    @foreach ($streamingFaqs as $faq)
                        <div
                            class="mb-3 bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                            <details class="group">
                                <summary class="flex items-center justify-between p-3 cursor-pointer">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $faq->question }}</h4>
                                    <svg class="w-4 h-4 text-gray-500 group-open:rotate-180 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </summary>
                                <div class="p-3 pt-0 text-gray-600 text-xs border-t border-gray-100">
                                    {!! $faq->answer !!}
                                </div>
                            </details>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('faq') }}"
                    class="inline-flex items-center px-5 py-2.5 border border-pink-600 text-base font-medium rounded-md text-pink-600 hover:bg-pink-50 hover:text-pink-700 transition-all duration-300">
                    Lihat Semua FAQ
                    <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Hubungi Kami</h2>
                <p class="mt-2 text-sm text-gray-600">Punya pertanyaan atau butuh bantuan? Jangan ragu untuk menghubungi
                    kami.</p>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-sm p-5 hover:shadow-md transition-all duration-300">
                    <div class="space-y-4">
                        @foreach ($contacts as $contact)
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center text-pink-600">
                                        <i class="{{ $contact->icon }} text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-bold text-gray-900">{{ ucfirst($contact->type) }}</h3>
                                    <p class="text-gray-600 text-xs mt-1">
                                        @if ($contact->link)
                                            <a href="{{ $contact->link }}"
                                                class="text-pink-600 hover:text-pink-700 hover:underline">{{ $contact->value }}</a>
                                        @else
                                            {{ $contact->value }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-5 hover:shadow-md transition-all duration-300">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Kirim Pesan</h3>
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="block text-xs font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" id="name" name="name"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 transition-colors text-sm">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 transition-colors text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="message" class="block text-xs font-medium text-gray-700 mb-1">Pesan</label>
                            <textarea id="message" name="message" rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 transition-colors text-sm"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-pink-600 hover:bg-pink-700 text-white py-2.5 px-4 rounded-md font-medium transition-colors shadow-sm hover:shadow text-sm">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="cta" class="py-12 bg-gradient-to-r from-pink-600 to-pink-700 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold mb-4">Siap Menikmati Layanan Premium?</h2>
            <p class="text-base mb-6">Bergabunglah dengan ribuan pelanggan yang puas dan nikmati layanan streaming favorit
                Anda
                dengan harga terjangkau.</p>
            <a href="{{ route('products.index') }}"
                class="inline-flex items-center px-5 py-2.5 border border-transparent text-base font-medium rounded-md text-pink-700 bg-white hover:bg-gray-50 shadow-md transition duration-300">
                Lihat Layanan
                <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('section');
            const navLinks = document.querySelectorAll('nav a');

            function onScroll() {
                let current = '';

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    if (pageYOffset >= (sectionTop - 60)) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('text-pink-600');
                    link.classList.add('text-gray-500');
                    if (link.getAttribute('href').includes(current)) {
                        link.classList.remove('text-gray-500');
                        link.classList.add('text-pink-600');
                    }
                });
            }

            window.addEventListener('scroll', onScroll);

            // Mobile Testimonial Carousel
            const carousel = document.querySelector('.testimonial-carousel .carousel-inner');
            if (carousel) {
                const pages = document.querySelectorAll('.carousel-page');
                const indicators = document.querySelectorAll('.mobile-carousel-indicator');

                let currentPage = 0;
                let pageCount = pages.length;

                // Initialize
                updateCarousel();

                // Set first indicator as active
                if (indicators.length > 0) {
                    indicators[0].classList.add('bg-pink-500');
                }

                // Set up auto scroll every 3 seconds
                let intervalId = setInterval(() => {
                    currentPage = (currentPage + 1) % pageCount;
                    updateCarousel();
                }, 3000);

                // Indicator click handling
                indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', () => {
                        currentPage = index;
                        updateCarousel();

                        // Reset the interval
                        clearInterval(intervalId);
                        intervalId = setInterval(() => {
                            currentPage = (currentPage + 1) % pageCount;
                            updateCarousel();
                        }, 3000);
                    });
                });

                function updateCarousel() {
                    // Move carousel
                    carousel.style.transform = `translateX(-${currentPage * 100}%)`;

                    // Update indicators
                    indicators.forEach((indicator, index) => {
                        if (index === currentPage) {
                            indicator.classList.add('bg-pink-500');
                            indicator.classList.remove('bg-gray-300');
                        } else {
                            indicator.classList.remove('bg-pink-500');
                            indicator.classList.add('bg-gray-300');
                        }
                    });
                }
            }
        });
    </script>
@endpush
