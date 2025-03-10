@extends('layouts.mobile.app')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-pink-500 to-pink-600 overflow-hidden">
        <div class="px-4 py-12">
            <div class="text-center">
                <h1 class="text-3xl tracking-tight font-extrabold text-white sm:text-4xl">
                    <span class="block">Premium Everyday</span>
                    <span class="block text-pink-100 text-2xl mt-2">Dengan layanan terpercaya untuk setiap kebutuhan Anda!</span>
                </h1>
                <p class="mt-4 text-base text-gray-100">
                    Nikmati berbagai layanan premium dengan harga terjangkau. Mulai dari Netflix, Spotify, YouTube Premium, dan banyak lagi!
                </p>
                <div class="mt-8 space-y-4">
                    <a href="{{ route('products') }}" class="w-full inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-pink-600 bg-white hover:bg-gray-50">
                        Lihat Produk
                    </a>
                    <a href="https://wa.me/6281234567890" class="w-full inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-black hover:bg-gray-900">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        Chat WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products Section -->
    <div class="bg-white py-8">
        <div class="px-4">
            <div class="text-center">
                <h2 class="text-2xl font-extrabold tracking-tight text-black">
                    Produk Unggulan
                </h2>
                <p class="mt-4 text-base text-gray-600">
                    Pilih layanan premium favorit Anda dengan harga terbaik
                </p>
            </div>

            <div class="mt-8 space-y-6">
                <!-- Netflix -->
                <div class="bg-white overflow-hidden shadow rounded-lg border border-pink-100">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-black">Netflix</h3>
                        <div class="mt-4 flex justify-between items-baseline">
                            <div class="flex flex-col">
                                <span class="text-2xl font-semibold text-pink-600">Rp 24.999</span>
                                <span class="text-sm text-gray-500">Sharing Account</span>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-800">
                                Tersedia
                            </span>
                        </div>
                        <p class="mt-4 text-gray-600">
                            Akses Netflix Premium dengan akun sharing. Nikmati semua konten tanpa iklan!
                        </p>
                        <a href="{{ route('products') }}" class="mt-6 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-pink-600 hover:bg-pink-700">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>

                <!-- Spotify -->
                <div class="bg-white overflow-hidden shadow rounded-lg border border-pink-100">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-black">Spotify Premium</h3>
                        <div class="mt-4 flex justify-between items-baseline">
                            <div class="flex flex-col">
                                <span class="text-2xl font-semibold text-pink-600">Rp 19.999</span>
                                <span class="text-sm text-gray-500">Sharing Account</span>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-800">
                                Tersedia
                            </span>
                        </div>
                        <p class="mt-4 text-gray-600">
                            Dengarkan musik tanpa iklan dan download untuk didengarkan offline!
                        </p>
                        <a href="{{ route('products') }}" class="mt-6 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-pink-600 hover:bg-pink-700">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>

                <!-- YouTube Premium -->
                <div class="bg-white overflow-hidden shadow rounded-lg border border-pink-100">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-black">YouTube Premium</h3>
                        <div class="mt-4 flex justify-between items-baseline">
                            <div class="flex flex-col">
                                <span class="text-2xl font-semibold text-pink-600">Rp 9.999</span>
                                <span class="text-sm text-gray-500">Sharing Account</span>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-800">
                                Tersedia
                            </span>
                        </div>
                        <p class="mt-4 text-gray-600">
                            Tonton YouTube tanpa iklan dan putar di background!
                        </p>
                        <a href="{{ route('products') }}" class="mt-6 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-pink-600 hover:bg-pink-700">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('products') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700">
                    Lihat Semua Produk
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="bg-black py-8">
        <div class="px-4">
            <div class="text-center">
                <h2 class="text-2xl font-extrabold tracking-tight text-white">
                    Cara Kerja
                </h2>
                <p class="mt-4 text-base text-gray-300">
                    Proses pembelian yang mudah dan cepat
                </p>
            </div>

            <div class="mt-8 space-y-8">
                <!-- Step 1 -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-pink-600 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-white">1. Pilih Produk</h3>
                        <p class="mt-2 text-base text-gray-300">
                            Pilih produk yang Anda inginkan dari katalog kami
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-pink-600 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-white">2. Pembayaran</h3>
                        <p class="mt-2 text-base text-gray-300">
                            Lakukan pembayaran melalui metode yang tersedia
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-pink-600 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-white">3. Aktivasi</h3>
                        <p class="mt-2 text-base text-gray-300">
                            Akun Anda akan diaktivasi setelah pembayaran
                        </p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-pink-600 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-white">4. Nikmati</h3>
                        <p class="mt-2 text-base text-gray-300">
                            Nikmati layanan premium Anda
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="bg-white py-8">
        <div class="px-4">
            <div class="text-center">
                <h2 class="text-2xl font-extrabold tracking-tight text-black">
                    Apa Kata Mereka?
                </h2>
                <p class="mt-4 text-base text-gray-600">
                    Testimoni dari pelanggan setia kami
                </p>
            </div>

            <div class="mt-8 space-y-6">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-lg p-6 shadow-lg border border-pink-100">
                    <div class="flex items-center">
                        <img class="h-12 w-12 rounded-full" src="https://ui-avatars.com/api/?name=John+Doe" alt="John Doe">
                        <div class="ml-4">
                            <h4 class="text-lg font-bold">John Doe</h4>
                            <p class="text-gray-500">Customer</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600">
                        "Pelayanan sangat cepat dan responsif. Harga juga sangat terjangkau!"
                    </p>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-lg p-6 shadow-lg border border-pink-100">
                    <div class="flex items-center">
                        <img class="h-12 w-12 rounded-full" src="https://ui-avatars.com/api/?name=Jane+Smith" alt="Jane Smith">
                        <div class="ml-4">
                            <h4 class="text-lg font-bold">Jane Smith</h4>
                            <p class="text-gray-500">Customer</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600">
                        "Sudah berlangganan Netflix di sini selama 6 bulan, tidak pernah ada masalah!"
                    </p>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white rounded-lg p-6 shadow-lg border border-pink-100">
                    <div class="flex items-center">
                        <img class="h-12 w-12 rounded-full" src="https://ui-avatars.com/api/?name=Mike+Johnson" alt="Mike Johnson">
                        <div class="ml-4">
                            <h4 class="text-lg font-bold">Mike Johnson</h4>
                            <p class="text-gray-500">Customer</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600">
                        "Recommended banget! CS ramah dan selalu siap membantu."
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection 