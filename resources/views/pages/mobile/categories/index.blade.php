@extends('pages.mobile.layouts.app')

@section('title', 'Kategori Produk')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <!-- Hero section -->
        <div class="bg-gradient-to-r from-pink-600 to-pink-700 text-white px-4 py-6">
            <div class="mb-2">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-800 bg-opacity-50 text-pink-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                    </svg>
                    KATEGORI
                </span>
            </div>

            <h1 class="text-2xl font-bold mb-2">Semua Kategori</h1>
            <div class="h-1 w-16 bg-pink-400 mb-3 rounded-full"></div>
            <p class="text-pink-100 text-sm">
                Temukan berbagai jenis produk digital premium berdasarkan kategori yang Anda butuhkan.
            </p>
        </div>

        <div class="px-4 py-6">
            <div class="grid grid-cols-1 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category) }}"
                        class="group bg-white rounded-lg shadow-sm overflow-hidden flex border border-gray-100">
                        <div class="relative bg-gray-200 w-1/3">
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                class="h-full w-full object-cover object-center"
                                onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}';">

                            <!-- Product count badge -->
                            <div
                                class="absolute bottom-0 left-0 bg-gray-900 bg-opacity-75 text-white text-xs font-medium px-2 py-1">
                                {{ $category->activeProducts()->count() }}
                            </div>
                        </div>

                        <div class="p-4 flex-grow flex flex-col">
                            <h2
                                class="text-lg font-bold text-gray-900 group-hover:text-pink-600 transition-colors duration-200 mb-1">
                                {{ $category->name }}
                            </h2>

                            <p class="text-xs text-gray-500 mb-2 line-clamp-2 flex-grow">
                                {{ Str::limit($category->description, 80) }}
                            </p>

                            <div class="flex items-center text-pink-600 text-xs">
                                <span class="font-medium">Lihat Produk</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" viewBox="0 0 20 20"
                                    fill="currentColor">
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
