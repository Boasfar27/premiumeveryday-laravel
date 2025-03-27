@extends('pages.desktop.layouts.app')

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

        .carousel-indicator.bg-pink-500 {
            width: 4px;
            height: 4px;
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section id="home"
        class="bg-gradient-to-r from-pink-600 to-pink-700 text-white h-screen flex items-center -mt-[1px]">
        <div class="container mx-auto px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">Akses Premium ke Layanan Streaming Favorit
                        Anda</h1>
                    <p class="text-lg mb-8">Nikmati Netflix, Disney+, Spotify, dan layanan premium lainnya dengan harga
                        terjangkau dan proses yang mudah.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('products.streaming-video') }}"
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-pink-700 bg-white hover:bg-gray-50 shadow-md transition duration-300">
                            Streaming Video
                            <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                        <a href="{{ route('products.streaming-music') }}"
                            class="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-pink-800 shadow-md transition duration-300">
                            Streaming Musik
                            <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-2 gap-6">
                    <div class="transform hover:scale-105 transition duration-300">
                        <img src="{{ asset('storage/products/thumbnails/netflix.webp') }}" alt="Netflix"
                            class="w-full h-32 object-contain bg-white rounded-xl p-4 shadow-lg">
                    </div>
                    <div class="transform hover:scale-105 transition duration-300">
                        <img src="{{ asset('storage/products/thumbnails/spotify.webp') }}" alt="Spotify"
                            class="w-full h-32 object-contain bg-white rounded-xl p-4 shadow-lg">
                    </div>
                    <div class="transform hover:scale-105 transition duration-300">
                        <img src="{{ asset('storage/products/thumbnails/youtube.webp') }}" alt="YouTube"
                            class="w-full h-32 object-contain bg-white rounded-xl p-4 shadow-lg">
                    </div>
                    <div class="transform hover:scale-105 transition duration-300">
                        <img src="{{ asset('storage/products/thumbnails/appletv.webp') }}" alt="Apple TV+"
                            class="w-full h-32 object-contain bg-white rounded-xl p-4 shadow-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="featured-products" class="py-16 bg-gray-50">
        <div class="container mx-auto px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Layanan Premium Terpopuler</h2>
                <p class="mt-4 text-lg text-gray-600">Pilihan terbaik dari layanan streaming premium</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($featuredProducts->take(4) as $product)
                    <div
                        class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 border border-gray-100 group transform hover:-translate-y-1">
                        <div class="relative">
                            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-500">
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
                        <div class="p-5">
                            <div class="flex items-center mb-2">
                                <span class="text-xs font-medium text-pink-700 bg-pink-50 rounded-full px-2.5 py-1">
                                    {{ $product->category ? $product->category->name : 'Uncategorized' }}
                                </span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-pink-600 transition-colors">
                                {{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{!! strip_tags($product->description) !!}</p>
                            <div class="flex items-center justify-between">
                                <div>
                                    @if ($product->is_on_sale)
                                        <span class="text-gray-400 line-through text-sm">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-lg font-bold text-pink-700">Rp
                                            {{ number_format($product->current_price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-lg font-bold text-pink-700">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product) }}"
                                    class="inline-flex items-center justify-center rounded-md px-4 py-2 bg-pink-50 text-pink-600 hover:bg-pink-600 hover:text-white transition-all duration-200 text-sm font-medium shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
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

            <div class="text-center mt-12">
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-6 py-3 border border-pink-600 text-base font-medium rounded-md text-pink-600 hover:bg-pink-50 transition duration-300">
                    Lihat Semua Layanan
                    <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Streaming Video Section -->
    <section id="streaming-video" class="py-16">
        <div class="container mx-auto px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Streaming Video</h2>
                    <p class="mt-2 text-lg text-gray-600">Akses ke layanan streaming video premium</p>
                </div>
                <a href="{{ route('products.streaming-video') }}"
                    class="text-pink-600 hover:text-pink-700 font-medium flex items-center">
                    <span>Lihat Semua</span>
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($streamingVideoProducts->take(8) as $product)
                    <div
                        class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 border border-gray-100 group transform hover:-translate-y-1 flex flex-col">
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
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <h3
                                class="text-md font-bold text-gray-900 mb-2 line-clamp-1 group-hover:text-pink-600 transition-colors">
                                {{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2 flex-grow">
                                {!! strip_tags($product->description) !!}</p>
                            <div class="mt-auto flex items-center justify-between">
                                <div>
                                    @if ($product->is_on_sale)
                                        <span class="text-gray-400 line-through text-xs">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <div class="text-pink-700 font-bold">Rp
                                            {{ number_format($product->current_price, 0, ',', '.') }}</div>
                                    @else
                                        <div class="text-pink-700 font-bold">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</div>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product) }}"
                                    class="inline-flex items-center justify-center rounded-md px-3 py-1.5 bg-pink-50 text-pink-600 hover:bg-pink-600 hover:text-white transition-all duration-200 text-xs font-medium shadow-sm">
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
        </div>
    </section>

    <!-- Streaming Music Section -->
    <section id="streaming-music" class="py-16 bg-gray-50">
        <div class="container mx-auto px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Streaming Musik</h2>
                    <p class="mt-2 text-lg text-gray-600">Akses ke layanan streaming musik premium</p>
                </div>
                <a href="{{ route('products.streaming-music') }}"
                    class="text-pink-600 hover:text-pink-700 font-medium flex items-center">
                    <span>Lihat Semua</span>
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($streamingMusicProducts->take(8) as $product)
                    <div
                        class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 border border-gray-100 group transform hover:-translate-y-1 flex flex-col">
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
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <h3
                                class="text-md font-bold text-gray-900 mb-2 line-clamp-1 group-hover:text-pink-600 transition-colors">
                                {{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2 flex-grow">
                                {!! strip_tags($product->description) !!}</p>
                            <div class="mt-auto flex items-center justify-between">
                                <div>
                                    @if ($product->is_on_sale)
                                        <span class="text-gray-400 line-through text-xs">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <div class="text-pink-700 font-bold">Rp
                                            {{ number_format($product->current_price, 0, ',', '.') }}</div>
                                    @else
                                        <div class="text-pink-700 font-bold">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</div>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product) }}"
                                    class="inline-flex items-center justify-center rounded-md px-3 py-1.5 bg-pink-50 text-pink-600 hover:bg-pink-600 hover:text-white transition-all duration-200 text-xs font-medium shadow-sm">
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
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section id="why-choose-us" class="py-16">
        <div class="container mx-auto px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Mengapa Memilih Kami</h2>
                <p class="mt-4 text-lg text-gray-600">Keunggulan berlangganan layanan streaming melalui Premium Everyday
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="bg-white p-8 rounded-lg shadow-sm text-center hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-pink-100 text-pink-600 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Harga Terjangkau</h3>
                    <p class="text-gray-600">Nikmati layanan premium dengan harga yang lebih terjangkau dibandingkan
                        berlangganan langsung.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-lg shadow-sm text-center hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-pink-100 text-pink-600 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Aman & Terpercaya</h3>
                    <p class="text-gray-600">Transaksi aman dan akun dikelola dengan baik untuk memastikan layanan tetap
                        aktif.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-lg shadow-sm text-center hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-pink-100 text-pink-600 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Dukungan 24/7</h3>
                    <p class="text-gray-600">Tim dukungan kami siap membantu Anda kapan saja dengan respons cepat dan
                        solusi efektif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-16 bg-gray-50">
        <div class="container mx-auto px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Apa Kata Pelanggan</h2>
                <p class="mt-4 text-lg text-gray-600">Testimoni dari pelanggan yang puas dengan layanan kami</p>
            </div>

            @if (is_object($testimonials) && count($testimonials) > 0)
                <div class="testimonial-carousel relative" id="testimonialCarousel">
                    <!-- Navigation buttons -->
                    <button type="button"
                        class="carousel-nav-prev absolute top-1/2 left-0 -translate-y-1/2 -translate-x-5 md:-translate-x-10 bg-white rounded-full p-2 shadow-md z-10 focus:outline-none transition-all duration-300 hover:bg-pink-50 group opacity-0">
                        <svg class="w-6 h-6 text-gray-700 group-hover:text-pink-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>

                    <button type="button"
                        class="carousel-nav-next absolute top-1/2 right-0 -translate-y-1/2 translate-x-5 md:translate-x-10 bg-white rounded-full p-2 shadow-md z-10 focus:outline-none transition-all duration-300 hover:bg-pink-50 group opacity-0">
                        <svg class="w-6 h-6 text-gray-700 group-hover:text-pink-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>

                    <div class="overflow-hidden">
                        <div class="carousel-inner flex transition-transform duration-700 ease-in-out">
                            @foreach (collect($testimonials)->chunk(3) as $chunk)
                                <div class="carousel-page flex-shrink-0 w-full grid grid-cols-1 md:grid-cols-3 gap-8 px-3">
                                    @foreach ($chunk as $testimonial)
                                        <div
                                            class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                            <div class="flex items-center mb-4">
                                                <div
                                                    class="h-12 w-12 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 font-bold text-xl">
                                                    {{ substr($testimonial->name, 0, 1) }}
                                                </div>
                                                <div class="ml-4">
                                                    <h4 class="text-lg font-bold text-gray-900">{{ $testimonial->name }}
                                                    </h4>
                                                    <div class="flex items-center mt-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $testimonial->rating)
                                                                <svg class="w-4 h-4 text-yellow-400 fill-current"
                                                                    viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                                    </path>
                                                                </svg>
                                                            @else
                                                                <svg class="w-4 h-4 text-gray-300 fill-current"
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
                                            <p class="text-gray-600 italic">"{{ $testimonial->content }}"</p>
                                            <p class="text-gray-400 text-sm mt-3">
                                                {{ $testimonial->created_at->format('M d, Y') }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Carousel Indicators -->
                    <div class="flex justify-center mt-6">
                        @foreach (collect($testimonials)->chunk(3) as $index => $chunk)
                            <button type="button" data-carousel-target="{{ $index }}"
                                class="carousel-indicator mx-2 w-4 h-4 rounded-full bg-gray-300 hover:bg-pink-500 focus:outline-none transition-all duration-300 {{ $index === 0 ? 'bg-pink-500' : '' }}"></button>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">No testimonials yet.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-16">
        <div class="container mx-auto px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Pertanyaan Umum</h2>
                <p class="mt-4 text-lg text-gray-600">Jawaban untuk pertanyaan yang sering diajukan</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Umum</h3>
                    <div class="space-y-4">
                        @foreach ($generalFaqs as $faq)
                            <div
                                class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                                <details class="group">
                                    <summary class="flex items-center justify-between p-4 cursor-pointer">
                                        <h4 class="text-base font-medium text-gray-900">{{ $faq->question }}</h4>
                                        <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </summary>
                                    <div class="p-4 pt-0 text-gray-600 border-t border-gray-100">
                                        {!! $faq->answer !!}
                                    </div>
                                </details>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Layanan Streaming</h3>
                    <div class="space-y-4">
                        @foreach ($streamingFaqs as $faq)
                            <div
                                class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                                <details class="group">
                                    <summary class="flex items-center justify-between p-4 cursor-pointer">
                                        <h4 class="text-base font-medium text-gray-900">{{ $faq->question }}</h4>
                                        <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </summary>
                                    <div class="p-4 pt-0 text-gray-600 border-t border-gray-100">
                                        {!! $faq->answer !!}
                                    </div>
                                </details>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('faq') }}"
                    class="inline-flex items-center px-6 py-3 border border-pink-600 text-base font-medium rounded-md text-pink-600 hover:bg-pink-50 hover:text-pink-700 transition-all duration-300">
                    Lihat Semua FAQ
                    <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-gray-50">
        <div class="container mx-auto px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Hubungi Kami</h2>
                <p class="mt-4 text-lg text-gray-600">Punya pertanyaan atau butuh bantuan? Jangan ragu untuk menghubungi
                    kami.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow-sm p-8 hover:shadow-md transition-all duration-300">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Kontak</h3>
                    <div class="space-y-6">
                        @foreach ($contacts as $contact)
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center text-pink-600">
                                        <i class="{{ $contact->icon }} text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-bold text-gray-900">{{ ucfirst($contact->type) }}</h4>
                                    <p class="text-gray-600 mt-1">
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

                <div class="bg-white rounded-lg shadow-sm p-8 hover:shadow-md transition-all duration-300">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Kirim Pesan</h3>
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" id="name" name="name"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 transition-colors">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 transition-colors">
                        </div>
                        <div class="mb-6">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                            <textarea id="message" name="message" rows="4"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 transition-colors"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-pink-600 hover:bg-pink-700 text-white py-3 px-4 rounded-md font-medium transition-colors shadow-sm hover:shadow">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="cta" class="py-16 bg-gradient-to-r from-pink-600 to-pink-700 text-white">
        <div class="container mx-auto px-8 text-center">
            <h2 class="text-3xl font-bold mb-6">Siap Menikmati Layanan Premium?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto">Bergabunglah dengan ribuan pelanggan yang puas dan nikmati layanan
                streaming favorit Anda dengan harga terjangkau.</p>
            <a href="{{ route('products.index') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent text-lg font-medium rounded-md text-pink-700 bg-white hover:bg-gray-50 shadow-md transition duration-300">
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
            // Testimonial Carousel
            const carouselContainer = document.getElementById('testimonialCarousel');
            if (carouselContainer) {
                const carousel = carouselContainer.querySelector('.carousel-inner');
                const pages = carouselContainer.querySelectorAll('.carousel-page');
                const indicators = carouselContainer.querySelectorAll('.carousel-indicator');
                const prevButton = carouselContainer.querySelector('.carousel-nav-prev');
                const nextButton = carouselContainer.querySelector('.carousel-nav-next');

                let currentPage = 0;
                let pageCount = pages.length;
                let intervalId = null;
                let isPaused = false;
                const autoplaySpeed = 5000; // 5 seconds
                let isTransitioning = false; // Flag to prevent rapid multiple transitions

                // Clone the first and last slides for infinite effect if we have more than 1 slide
                if (pageCount > 1) {
                    const firstPageClone = pages[0].cloneNode(true);
                    const lastPageClone = pages[pageCount - 1].cloneNode(true);

                    // Add data attributes to identify clones
                    firstPageClone.setAttribute('data-clone', 'true');
                    lastPageClone.setAttribute('data-clone', 'true');

                    // Append/prepend clones
                    carousel.appendChild(firstPageClone);
                    carousel.insertBefore(lastPageClone, carousel.firstChild);

                    // Move to the real first slide (skip the prepended clone)
                    carousel.style.transform = `translateX(-100%)`;
                    currentPage = 0; // Reset to first real slide
                }

                // Initialize
                updateCarousel(false);
                startAutoplay();

                // Hover effects for navigation
                carouselContainer.addEventListener('mouseenter', () => {
                    if (pageCount > 1) {
                        prevButton.classList.remove('opacity-0');
                        nextButton.classList.remove('opacity-0');
                        prevButton.classList.add('opacity-100');
                        nextButton.classList.add('opacity-100');
                        isPaused = true; // Pause on hover
                    }
                });

                carouselContainer.addEventListener('mouseleave', () => {
                    prevButton.classList.remove('opacity-100');
                    nextButton.classList.remove('opacity-100');
                    prevButton.classList.add('opacity-0');
                    nextButton.classList.add('opacity-0');
                    isPaused = false; // Resume on mouse leave
                });

                // Navigation buttons
                prevButton.addEventListener('click', () => {
                    if (!isTransitioning) {
                        goToPage(currentPage - 1);
                    }
                });

                nextButton.addEventListener('click', () => {
                    if (!isTransitioning) {
                        goToPage(currentPage + 1);
                    }
                });

                // Indicators click handling
                indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', () => {
                        if (!isTransitioning) {
                            // Adjust for cloned slides - indicators point to real slides
                            goToPage(index + 1); // +1 because of prepended clone
                        }
                    });
                });

                function startAutoplay() {
                    // Only start autoplay if we have more than 1 page
                    if (pageCount > 1) {
                        intervalId = setInterval(() => {
                            if (!isPaused && !isTransitioning) {
                                goToPage(currentPage + 1);
                            }
                        }, autoplaySpeed);
                    }
                }

                function goToPage(pageIndex) {
                    if (isTransitioning) return; // Prevent multiple rapid transitions

                    isTransitioning = true;
                    currentPage = pageIndex;

                    // Move carousel with smooth animation
                    updateCarousel(true);

                    // Handle the infinite loop behavior
                    if (pageCount > 1) {
                        setTimeout(() => {
                            if (currentPage === 0) {
                                // If we're at the first clone (before real first), jump to real last
                                carousel.style.transition = 'none';
                                currentPage = pageCount;
                                updateCarousel(false);
                            } else if (currentPage === pageCount + 1) {
                                // If we're at the last clone (after real last), jump to real first
                                carousel.style.transition = 'none';
                                currentPage = 1;
                                updateCarousel(false);
                            }

                            setTimeout(() => {
                                carousel.style.transition = 'transform 700ms ease-in-out';
                                isTransitioning = false;
                            }, 50);
                        }, 700); // Match the CSS transition duration
                    } else {
                        // For a single slide, just reset transition state
                        setTimeout(() => {
                            isTransitioning = false;
                        }, 700);
                    }

                    // Update indicators - adjust for cloned slides
                    updateIndicators();

                    // Reset the timer when manually changing slides
                    if (intervalId) {
                        clearInterval(intervalId);
                        startAutoplay();
                    }
                }

                function updateCarousel(withTransition) {
                    // Enable/disable transition
                    if (!withTransition) {
                        carousel.style.transition = 'none';
                    } else {
                        carousel.style.transition = 'transform 700ms ease-in-out';
                    }

                    // Account for cloned slides in transform calculation
                    // First cloned slide is at index 0, real slides start at index 1
                    carousel.style.transform = `translateX(-${currentPage * 100}%)`;

                    if (!withTransition) {
                        // Force a reflow to make the non-transition take effect immediately
                        carousel.offsetHeight;
                    }
                }

                function updateIndicators() {
                    // Map currentPage to indicator index (accounting for clones)
                    let indicatorIndex;

                    if (currentPage === 0) {
                        // We're at the cloned last slide (appearing before the first)
                        indicatorIndex = pageCount - 1;
                    } else if (currentPage === pageCount + 1) {
                        // We're at the cloned first slide (appearing after the last)
                        indicatorIndex = 0;
                    } else {
                        // We're at a real slide
                        indicatorIndex = currentPage - 1;
                    }

                    // Update indicator classes
                    indicators.forEach((indicator, index) => {
                        if (index === indicatorIndex) {
                            indicator.classList.add('bg-pink-500');
                            indicator.classList.remove('bg-gray-300');
                            indicator.classList.add('scale-110'); // Slightly enlarge active indicator
                        } else {
                            indicator.classList.remove('bg-pink-500');
                            indicator.classList.add('bg-gray-300');
                            indicator.classList.remove('scale-110');
                        }
                    });
                }

                // Add keyboard navigation
                document.addEventListener('keydown', (e) => {
                    // Only respond to keyboard if carousel is in viewport
                    const rect = carouselContainer.getBoundingClientRect();
                    const isInViewport = (
                        rect.top >= 0 &&
                        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)
                    );

                    if (isInViewport && !isTransitioning) {
                        if (e.key === 'ArrowLeft') {
                            goToPage(currentPage - 1);
                        } else if (e.key === 'ArrowRight') {
                            goToPage(currentPage + 1);
                        }
                    }
                });
            }
        });
    </script>
@endpush
