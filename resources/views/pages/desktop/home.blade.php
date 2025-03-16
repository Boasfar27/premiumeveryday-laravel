@extends('pages.desktop.layouts.app')

@section('title', 'Premium Everyday - Solusi Kebutuhan Premium Anda')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="bg-primary text-white min-h-screen flex items-center mt-16">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-screen flex items-center">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center w-full">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-6">Premium Products for Your Everyday Life</h1>
                    <p class="text-lg mb-8">Discover our curated selection of high-quality products designed to enhance your
                        daily experience.</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-primary bg-white hover:bg-gray-50 transition">
                        Browse Products
                        <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <div class="hidden md:block">
                    <img src="{{ asset('images/amico.webp') }}" alt="Premium Products" class="w-full h-auto rounded-lg">
                </div>
            </div>
        </div>
    </section>


    <!-- Products Section -->
    <section id="products" class="py-16 bg-gray-50">
        @php
            $activeProducts = \App\Models\Product::active()->latest()->take(6)->get();
        @endphp
        @include('pages.desktop.products.featured', ['products' => $activeProducts])
    </section>

    <!-- Timeline Section -->
    <section id="timeline" class="py-16">
        @php
            $timelines = \App\Models\Timeline::active()->latest()->take(3)->get();
        @endphp
        @include('pages.desktop.timeline.featured', ['timelines' => $timelines])
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-16 bg-gray-50">
        @php
            $faqs = \App\Models\Faq::active()->take(4)->get();
        @endphp
        @include('pages.desktop.faq.featured', ['faqs' => $faqs])
    </section>

    <!-- Feedback Section -->
    <section id="feedback" class="py-16">
        @php
            $feedbacks = \App\Models\Feedback::active()->with('product')->latest()->take(6)->get();
        @endphp
        @include('pages.desktop.feedback.featured', ['feedbacks' => $feedbacks])
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-gray-50">
        @include('pages.desktop.contact.index')
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
