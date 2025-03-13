@extends('pages.layouts.app')

@section('title', 'Premium Everyday - Solusi Kebutuhan Premium Anda')

@section('content')
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative bg-primary min-h-screen flex items-center">
            <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/50 to-primary/30"></div>
            <div class="relative w-full max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-5xl font-extrabold tracking-tight text-white sm:text-6xl md:text-7xl">
                        Premium Everyday
                    </h1>
                    <p class="mt-6 max-w-md mx-auto text-lg text-gray-100 sm:text-xl md:mt-8 md:text-2xl md:max-w-3xl">
                        Solusi terbaik untuk kebutuhan premium Anda setiap hari. Temukan berbagai produk berkualitas dengan
                        harga terjangkau.
                    </p>
                    <div class="mt-8 max-w-md mx-auto sm:flex sm:justify-center md:mt-12">
                        <div class="rounded-md shadow">
                            <a href="#products"
                                class="w-full flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-md text-primary bg-white hover:bg-gray-100 transition duration-300 ease-in-out transform hover:scale-105 md:text-xl md:px-12">
                                Lihat Produk
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Scroll Down Indicator -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <a href="#products" class="text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Products Section -->
        <section id="products">
            @include('components.product.index')
        </section>

        <!-- Timeline Section -->
        <section id="timeline">
            @include('components.timeline.index')
        </section>

        <!-- FAQ Section -->
        <section id="faq">
            @include('components.faq.index')
        </section>

        <!-- Feedback Section -->
        <section id="feedback">
            @include('components.feedback.index')
        </section>

        <!-- Contact Section -->
        <section id="contact">
            @include('components.contact.index')
        </section>
    </div>
@endsection
