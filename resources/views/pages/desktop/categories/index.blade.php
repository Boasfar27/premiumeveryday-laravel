@extends('pages.desktop.layouts.app')

@section('title', 'Kategori Produk')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <!-- Hero section -->
        <div class="relative overflow-hidden bg-gradient-to-r from-pink-600 to-pink-700 text-white">
            <!-- Background pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0,0 L100,0 L100,100 L0,100 Z" fill="url(#grid)" />
                    <defs>
                        <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                            <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5" />
                        </pattern>
                    </defs>
                </svg>
            </div>

            <div class="max-w-7xl mx-auto px-4 py-12 mt-8 relative">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-800 bg-opacity-50 text-pink-100 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                    </svg>
                    KATEGORI PRODUK
                </span>

                <div class="md:w-2/3 xl:w-1/2">
                    <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-3 drop-shadow-sm">
                        Semua Kategori
                    </h1>

                    <div class="h-1 w-24 bg-pink-400 mb-4 rounded-full"></div>

                    <p class="text-pink-100 text-lg mb-8 max-w-xl">
                        Temukan berbagai jenis produk digital premium berdasarkan kategori yang Anda butuhkan.
                    </p>
                </div>
            </div>

            <!-- Simple divider instead of wave -->
            <div class="h-5 bg-gray-50 rounded-t-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category) }}"
                        class="group bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col border border-gray-100 transform hover:-translate-y-1">
                        <div class="relative bg-gray-200 overflow-hidden">
                            <div class="aspect-w-4 aspect-h-3 w-full">
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                    class="h-full w-full object-cover object-center transform group-hover:scale-105 transition-transform duration-500"
                                    onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}';">
                            </div>

                            <!-- Product count badge -->
                            <div
                                class="absolute bottom-0 left-0 bg-gray-900 bg-opacity-75 text-white text-xs font-medium px-3 py-1">
                                {{ $category->activeProducts()->count() }} Produk
                            </div>
                        </div>

                        <div class="p-5 flex-grow flex flex-col">
                            <h2
                                class="text-xl font-bold text-gray-900 group-hover:text-pink-600 transition-colors duration-200 mb-2">
                                {{ $category->name }}
                            </h2>

                            <p class="text-sm text-gray-500 mb-4 line-clamp-2 flex-grow">
                                {{ Str::limit($category->description, 120) }}
                            </p>

                            <div class="mt-auto flex items-center text-pink-600">
                                <span class="text-sm font-medium">Lihat Produk</span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
