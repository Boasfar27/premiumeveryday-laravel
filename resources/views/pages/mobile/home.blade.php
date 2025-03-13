@extends('pages.layouts.app')

@section('title', 'Premium Everyday - Solusi Kebutuhan Premium Anda')

@section('content')
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative bg-primary min-h-screen flex items-center">
            <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/50 to-primary/30"></div>
            <div class="relative w-full px-4">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                        Premium Everyday
                    </h1>
                    <p class="mt-6 text-lg text-gray-100 mx-auto max-w-sm">
                        Solusi terbaik untuk kebutuhan premium Anda setiap hari.
                    </p>
                    <div class="mt-8">
                        <a href="#products"
                            class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-md text-primary bg-white hover:bg-gray-100 transition duration-300 ease-in-out transform hover:scale-105">
                            Lihat Produk
                        </a>
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
        <section id="products" class="mt-8">
            @include('components.product.index')
        </section>

        <!-- Timeline Section -->
        <section id="timeline" class="mt-8">
            @include('components.timeline.index')
        </section>

        <!-- FAQ Section -->
        <section id="faq" class="mt-8">
            @include('components.faq.index')
        </section>

        <!-- Feedback Section -->
        <section id="feedback" class="mt-8">
            @include('components.feedback.index')
        </section>

        <!-- Contact Section -->
        <section id="contact" class="mt-8">
            @include('components.contact.index')
        </section>
    </div>
@endsection
