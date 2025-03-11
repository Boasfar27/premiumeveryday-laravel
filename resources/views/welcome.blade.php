@extends('pages.layouts.app')

@section('title', 'Premium Everyday - Solusi Layanan Premium Anda')

@section('content')
<div class="bg-black min-h-screen">
    <!-- Hero Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">
                    <span class="text-pink-500">Premium</span>
                    <span class="text-white">Everyday</span>
                </h1>
                <p class="text-xl mb-8">Dengan Layanan Tercepat</p>
            </div>
            <div class="md:w-1/2 mt-8 md:mt-0">
                <img src="/images/hero-illustration.svg" alt="Hero Illustration" class="w-full">
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold text-center text-white mb-12">PRODUCT</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Netflix -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <img src="/images/netflix.png" alt="Netflix" class="w-16 h-16 mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-center mb-2">Netflix sharing Harian</h3>
                    <p class="text-gray-600 text-center mb-4">private 1 bulan</p>
                    <p class="text-pink-500 text-center font-bold mb-4">Rp. 24.999</p>
                    <button class="w-full bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600 transition">Beli Sekarang</button>
                </div>
            </div>

            <!-- YouTube -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <img src="/images/youtube.png" alt="YouTube" class="w-16 h-16 mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-center mb-2">YouTube Harian</h3>
                    <p class="text-gray-600 text-center mb-4">3 bulan</p>
                    <p class="text-pink-500 text-center font-bold mb-4">Rp. 35.999</p>
                    <button class="w-full bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600 transition">Beli Sekarang</button>
                </div>
            </div>

            <!-- Spotify -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <img src="/images/spotify.png" alt="Spotify" class="w-16 h-16 mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-center mb-2">Spotify Harian</h3>
                    <p class="text-gray-600 text-center mb-4">3 bulan</p>
                    <p class="text-pink-500 text-center font-bold mb-4">Rp. 19.999</p>
                    <button class="w-full bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600 transition">Beli Sekarang</button>
                </div>
            </div>

            <!-- Prime Video -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <img src="/images/prime.png" alt="Prime Video" class="w-16 h-16 mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-center mb-2">Prime Video sharing Harian</h3>
                    <p class="text-gray-600 text-center mb-4">private 1 bulan</p>
                    <p class="text-pink-500 text-center font-bold mb-4">Rp. 24.999</p>
                    <button class="w-full bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600 transition">Beli Sekarang</button>
                </div>
            </div>

            <!-- Apple Music -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <img src="/images/apple-music.png" alt="Apple Music" class="w-16 h-16 mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-center mb-2">Apple Music</h3>
                    <p class="text-gray-600 text-center mb-4">3 bulan</p>
                    <p class="text-pink-500 text-center font-bold mb-4">Rp. 35.999</p>
                    <button class="w-full bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600 transition">Beli Sekarang</button>
                </div>
            </div>

            <!-- HBO Max -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <img src="/images/hbo.png" alt="HBO Max" class="w-16 h-16 mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-center mb-2">HBO Max sharing Harian</h3>
                    <p class="text-gray-600 text-center mb-4">private 1 bulan</p>
                    <p class="text-pink-500 text-center font-bold mb-4">Rp. 24.999</p>
                    <button class="w-full bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600 transition">Beli Sekarang</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Section -->
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold text-center text-white mb-12">TIMELINE</h2>
        <div class="relative">
            <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-px bg-pink-500"></div>
            <div class="space-y-12">
                <div class="flex items-center justify-center">
                    <div class="bg-pink-500 rounded-full w-8 h-8 flex items-center justify-center text-white font-bold">1</div>
                </div>
                <div class="flex items-center justify-center">
                    <div class="bg-pink-500 rounded-full w-8 h-8 flex items-center justify-center text-white font-bold">2</div>
                </div>
                <div class="flex items-center justify-center">
                    <div class="bg-pink-500 rounded-full w-8 h-8 flex items-center justify-center text-white font-bold">3</div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold text-center text-white mb-12">FAQ</h2>
        <div class="space-y-4 max-w-3xl mx-auto">
            <div class="bg-white rounded-lg p-4">
                <button class="flex justify-between items-center w-full">
                    <span class="font-semibold">Pertanyaan yang Sering Ditanyakan</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold text-center text-white mb-12">CONTACT</h2>
        <div class="max-w-lg mx-auto">
            <form class="space-y-6">
                <div>
                    <input type="text" placeholder="Your Name" class="w-full px-4 py-2 rounded-lg bg-white">
                </div>
                <div>
                    <input type="email" placeholder="Your Email" class="w-full px-4 py-2 rounded-lg bg-white">
                </div>
                <div>
                    <textarea placeholder="Your Message" rows="4" class="w-full px-4 py-2 rounded-lg bg-white"></textarea>
                </div>
                <div>
                    <button type="submit" class="w-full bg-pink-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-pink-600 transition">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 