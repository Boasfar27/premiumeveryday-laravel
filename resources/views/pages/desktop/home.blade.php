@extends('pages.desktop.layouts.app')

@section('title', 'Premium Everyday - Layanan Streaming Premium Terpercaya')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="bg-primary text-white min-h-screen flex items-center mt-16">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-screen flex items-center">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center w-full">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-6">Akses Premium ke Layanan Streaming Favorit Anda</h1>
                    <p class="text-lg mb-8">Nikmati Netflix, Disney+, Spotify, dan layanan premium lainnya dengan harga
                        terjangkau dan proses yang mudah.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('products.streaming-video') }}"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-primary bg-white hover:bg-gray-50 transition">
                            Streaming Video
                            <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                        <a href="{{ route('products.streaming-music') }}"
                            class="inline-flex items-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-primary-dark transition">
                            Streaming Musik
                            <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="hidden md:flex justify-end">
                    <div class="grid grid-cols-2 gap-4">
                        <img src="{{ asset('images/products/netflix.webp') }}" alt="Netflix"
                            class="w-32 h-32 object-contain bg-white rounded-lg p-2">
                        <img src="{{ asset('images/products/spotify.webp') }}" alt="Spotify"
                            class="w-32 h-32 object-contain bg-white rounded-lg p-2">
                        <img src="{{ asset('images/products/youtube.webp') }}" alt="YouTube"
                            class="w-32 h-32 object-contain bg-white rounded-lg p-2">
                        <img src="{{ asset('images/products/appletv.webp') }}" alt="Apple TV+"
                            class="w-32 h-32 object-contain bg-white rounded-lg p-2">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="featured-products" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Layanan Premium Terpopuler</h2>
                <p class="mt-4 text-lg text-gray-600">Pilihan terbaik dari layanan streaming premium</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($featuredProducts->take(6) as $product)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                        <div class="relative">
                            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                class="w-full h-48 object-cover">
                            @if ($product->is_on_sale)
                                <div
                                    class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    SALE
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-2">
                                <span class="text-xs font-medium text-primary-dark bg-primary-50 rounded-full px-2 py-1">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                            <div class="flex items-center justify-between">
                                <div>
                                    @if ($product->is_on_sale)
                                        <span class="text-gray-400 line-through text-sm">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-lg font-bold text-primary">Rp
                                            {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-lg font-bold text-primary">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product) }}"
                                    class="text-primary hover:text-primary-dark font-medium">
                                    Detail
                                    <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-6 py-3 border border-primary text-base font-medium rounded-md text-primary hover:bg-primary-50 transition">
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Streaming Video</h2>
                    <p class="mt-2 text-gray-600">Akses ke layanan streaming video premium</p>
                </div>
                <a href="{{ route('products.streaming-video') }}" class="text-primary hover:text-primary-dark font-medium">
                    Lihat Semua
                    <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($streamingVideoProducts as $product)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                        <div class="relative">
                            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                class="w-full h-40 object-cover">
                            @if ($product->is_on_sale)
                                <div
                                    class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    SALE
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-md font-bold text-gray-900 mb-1">{{ $product->name }}</h3>
                            <div class="flex items-center justify-between mt-2">
                                <div>
                                    @if ($product->is_on_sale)
                                        <span class="text-gray-400 line-through text-xs">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-md font-bold text-primary">Rp
                                            {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-md font-bold text-primary">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product) }}"
                                    class="text-primary hover:text-primary-dark text-sm font-medium">
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Streaming Musik</h2>
                    <p class="mt-2 text-gray-600">Akses ke layanan streaming musik premium</p>
                </div>
                <a href="{{ route('products.streaming-music') }}"
                    class="text-primary hover:text-primary-dark font-medium">
                    Lihat Semua
                    <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($streamingMusicProducts as $product)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                        <div class="relative">
                            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                class="w-full h-40 object-cover">
                            @if ($product->is_on_sale)
                                <div
                                    class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    SALE
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-md font-bold text-gray-900 mb-1">{{ $product->name }}</h3>
                            <div class="flex items-center justify-between mt-2">
                                <div>
                                    @if ($product->is_on_sale)
                                        <span class="text-gray-400 line-through text-xs">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-md font-bold text-primary">Rp
                                            {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-md font-bold text-primary">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product) }}"
                                    class="text-primary hover:text-primary-dark text-sm font-medium">
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Mengapa Memilih Kami</h2>
                <p class="mt-4 text-lg text-gray-600">Keunggulan berlangganan layanan streaming melalui Premium Everyday
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div
                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-primary-100 text-primary mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Harga Terjangkau</h3>
                    <p class="text-gray-600">Nikmati layanan premium dengan harga yang lebih terjangkau dibandingkan
                        berlangganan langsung.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div
                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-primary-100 text-primary mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Aman & Terpercaya</h3>
                    <p class="text-gray-600">Transaksi aman dan akun dikelola dengan baik untuk memastikan layanan tetap
                        aktif.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div
                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-primary-100 text-primary mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Dukungan 24/7</h3>
                    <p class="text-gray-600">Tim dukungan kami siap membantu Anda kapan saja dengan respons cepat dan
                        solusi efektif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Apa Kata Pelanggan Kami</h2>
                <p class="mt-4 text-lg text-gray-600">Pengalaman pelanggan yang telah menggunakan layanan kami</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($testimonials->take(6) as $testimonial)
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary font-bold">
                                    {{ substr($testimonial->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-900">{{ $testimonial->name }}</h3>
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm">{{ $testimonial->content }}</p>
                        @if ($testimonial->feedbackable)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <span class="text-xs text-gray-500">Tentang: <a
                                        href="{{ route('products.show', $testimonial->feedbackable) }}"
                                        class="text-primary hover:text-primary-dark">{{ $testimonial->feedbackable->name }}</a></span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Pertanyaan Umum</h2>
                <p class="mt-4 text-lg text-gray-600">Jawaban untuk pertanyaan yang sering diajukan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Umum</h3>
                    @foreach ($generalFaqs as $faq)
                        <div class="mb-4 bg-white rounded-lg shadow-sm overflow-hidden">
                            <details class="group">
                                <summary class="flex items-center justify-between p-4 cursor-pointer">
                                    <h4 class="text-md font-medium text-gray-900">{{ $faq->question }}</h4>
                                    <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </summary>
                                <div class="p-4 pt-0 text-gray-600 text-sm">
                                    {{ $faq->answer }}
                                </div>
                            </details>
                        </div>
                    @endforeach
                </div>

                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Layanan Streaming</h3>
                    @foreach ($streamingFaqs as $faq)
                        <div class="mb-4 bg-white rounded-lg shadow-sm overflow-hidden">
                            <details class="group">
                                <summary class="flex items-center justify-between p-4 cursor-pointer">
                                    <h4 class="text-md font-medium text-gray-900">{{ $faq->question }}</h4>
                                    <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </summary>
                                <div class="p-4 pt-0 text-gray-600 text-sm">
                                    {{ $faq->answer }}
                                </div>
                            </details>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('faq') }}"
                    class="inline-flex items-center text-primary hover:text-primary-dark font-medium">
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Hubungi Kami</h2>
                    <p class="text-gray-600 mb-8">Punya pertanyaan atau butuh bantuan? Jangan ragu untuk menghubungi kami.
                    </p>

                    <div class="space-y-4">
                        @foreach ($contacts as $contact)
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary">
                                        <i class="{{ $contact->icon }}"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-900">{{ ucfirst($contact->type) }}</h3>
                                    <p class="text-gray-600">
                                        @if ($contact->link)
                                            <a href="{{ $contact->link }}"
                                                class="hover:text-primary">{{ $contact->value }}</a>
                                        @else
                                            {{ $contact->value }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Kirim Pesan</h3>
                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                <input type="text" id="name" name="name"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" name="email"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                            </div>
                            <div class="mb-4">
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                                <textarea id="message" name="message" rows="4"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"></textarea>
                            </div>
                            <button type="submit"
                                class="w-full bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded-md font-medium transition-colors">
                                Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
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
                    link.classList.remove('border-primary', 'text-gray-900');
                    link.classList.add('border-transparent', 'text-gray-500');
                    if (link.getAttribute('href').includes(current)) {
                        link.classList.remove('border-transparent', 'text-gray-500');
                        link.classList.add('border-primary', 'text-gray-900');
                    }
                });
            }

            window.addEventListener('scroll', onScroll);
        });
    </script>
@endpush
