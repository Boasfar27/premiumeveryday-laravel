@extends('pages.desktop.layouts.app')

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
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    PREMIUM SELECTION
                </span>

                <div class="md:w-2/3 xl:w-1/2">
                    <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-3 drop-shadow-sm">
                        @if (isset($currentCategory))
                            {{ $currentCategory->name }}
                        @else
                            Premium Digital Products
                        @endif
                    </h1>

                    <div class="h-1 w-24 bg-pink-400 mb-4 rounded-full"></div>

                    <p class="text-pink-100 text-lg mb-8 max-w-xl">
                        @if (isset($currentCategory))
                            {{ $currentCategory->description ?? 'Discover our handpicked selection of premium digital products to enhance your digital lifestyle.' }}
                        @else
                            Discover our handpicked selection of premium digital products to enhance your digital lifestyle.
                        @endif
                    </p>

                    <!-- Search -->
                    <form action="{{ route('products.index') }}" method="GET" class="flex max-w-lg mb-1 relative group">
                        @if (request()->has('category'))
                            <input type="hidden" name="category" value="{{ request()->category }}">
                        @endif
                        @if (request()->has('sort'))
                            <input type="hidden" name="sort" value="{{ request()->sort }}">
                        @endif
                        <div class="relative flex-1 z-0">
                            <input type="text" name="search" id="search" value="{{ request()->search }}"
                                placeholder="Search premium products..."
                                class="block w-full pl-5 pr-10 py-3 text-gray-900 bg-white border-0 rounded-l-lg focus:ring-2 focus:ring-pink-500 focus:outline-none shadow-sm group-hover:shadow-md transition-shadow duration-200">

                            <div
                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <button type="submit"
                            class="relative inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-r-lg text-white bg-pink-800 hover:bg-pink-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 overflow-hidden transition-all duration-200">
                            <span class="relative z-10">Search</span>
                            <div
                                class="absolute inset-0 bg-pink-700 transform scale-x-0 origin-left transition-transform duration-200 group-hover:scale-x-100">
                            </div>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Simple divider instead of wave -->
            <div class="h-5 bg-gray-50 rounded-t-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 pb-16">
            <!-- Category tabs -->
            <div class="py-6">
                <div class="flex flex-wrap items-center -mx-1 overflow-x-auto hide-scrollbar">
                    <a href="{{ route('products.index') }}"
                        class="flex items-center px-4 py-2 m-1 text-sm font-medium rounded-lg {{ !request()->has('category') ? 'bg-pink-600 text-white shadow-md transform scale-105' : 'bg-white text-gray-900 hover:bg-gray-100 shadow hover:shadow-md' }} transition-all duration-200">
                        <span
                            class="w-8 h-8 flex items-center justify-center bg-pink-100 text-pink-900 rounded-full mr-2 transform transition-transform duration-200 hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </span>
                        All Products
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                            class="flex items-center px-4 py-2 m-1 text-sm font-medium rounded-lg {{ request()->category == $category->slug ? 'bg-pink-600 text-white shadow-md transform scale-105' : 'bg-white text-gray-900 hover:bg-gray-100 shadow hover:shadow-md' }} transition-all duration-200">
                            <span
                                class="w-8 h-8 flex items-center justify-center bg-pink-100 text-pink-900 rounded-full mr-2 transform transition-transform duration-200 hover:scale-110">
                                @if ($category->icon)
                                    <i class="{{ $category->icon }}"></i>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                @endif
                            </span>
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col md:flex-row">
                <!-- Filters -->
                <div class="md:w-1/4 lg:w-1/5 mb-6 md:mb-0 md:pr-6">
                    <div class="sticky top-24">
                        <div
                            class="bg-white rounded-lg shadow-sm hover:shadow transition-shadow duration-200 mb-4 overflow-hidden border border-gray-100">
                            <div class="bg-gray-50 py-3 px-4 border-b border-gray-100">
                                <h3 class="text-gray-800 font-medium flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                        </path>
                                    </svg>
                                    Filter Products
                                </h3>
                            </div>
                            <div class="p-4">
                                <div class="mb-4">
                                    <label for="category-desktop"
                                        class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <div class="relative">
                                        <select name="category" id="category-desktop"
                                            onchange="window.location.href=this.value"
                                            class="block w-full pl-3 py-2 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 cursor-pointer appearance-none pr-8">
                                            <option value="{{ route('products.index') }}">All Categories</option>
                                            @foreach ($categories as $category)
                                                <option
                                                    value="{{ route('products.index', ['category' => $category->slug]) }}"
                                                    {{ request()->category == $category->slug ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="sort-desktop" class="block text-sm font-medium text-gray-700 mb-1">Sort
                                        By</label>
                                    <div class="relative">
                                        <select name="sort" id="sort-desktop"
                                            onchange="updateQueryParam('sort', this.value)"
                                            class="block w-full pl-3 py-2 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 cursor-pointer appearance-none pr-8">
                                            <option value="newest" {{ request()->sort == 'newest' ? 'selected' : '' }}>
                                                Latest</option>
                                            <option value="price_low"
                                                {{ request()->sort == 'price_low' ? 'selected' : '' }}>Price: Low to High
                                            </option>
                                            <option value="price_high"
                                                {{ request()->sort == 'price_high' ? 'selected' : '' }}>Price: High to Low
                                            </option>
                                            <option value="name" {{ request()->sort == 'name' ? 'selected' : '' }}>Name
                                            </option>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product grid -->
                <div class="md:w-3/4 lg:w-4/5">
                    <!-- Results info -->
                    <div class="flex flex-wrap items-center justify-between mb-4">
                        <div class="text-sm text-gray-500 mb-2 md:mb-0 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            Menampilkan <span
                                class="font-medium">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span>
                            dari <span class="font-medium">{{ $products->total() }}</span> produk
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4 md:gap-6">
                        @forelse ($products as $product)
                            <div
                                class="bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col border border-gray-100 group transform hover:-translate-y-1">
                                <a href="{{ route('products.show', $product) }}"
                                    class="relative bg-gray-200 overflow-hidden">
                                    <div class="aspect-w-4 aspect-h-3 w-full">
                                        <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                            class="h-full w-full object-cover object-center transform group-hover:scale-105 transition-transform duration-500"
                                            onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}'; console.log('Loading placeholder for ' + '{{ $product->name }}' + ' (ID: {{ $product->id }})');">

                                        @if (config('app.debug'))
                                            <div
                                                class="absolute top-0 right-0 bg-black bg-opacity-75 text-white text-xs px-1 py-1">
                                                {{ $product->thumbnail ? '✓' : '✗' }}
                                            </div>
                                        @endif

                                        <!-- Product badges -->
                                        <div class="absolute top-0 right-0">
                                            @if ($product->is_on_sale)
                                                <span
                                                    class="inline-flex items-center bg-gradient-to-l from-pink-500 to-red-600 px-3 py-1 text-xs font-medium text-white shadow-sm">
                                                    Hemat {{ $product->discount_percentage }}%
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Category badge -->
                                        @if ($product->category)
                                            <div
                                                class="absolute bottom-0 left-0 bg-gray-900 bg-opacity-75 text-white text-xs font-medium px-3 py-1">
                                                {{ $product->category->name }}
                                            </div>
                                        @endif

                                        <!-- New badge -->
                                        @if ($product->isNew())
                                            <div
                                                class="absolute top-0 left-0 bg-blue-600 text-white text-xs font-medium px-3 py-1">
                                                Baru
                                            </div>
                                        @endif
                                    </div>
                                </a>

                                <div class="p-4 flex-grow flex flex-col">
                                    <!-- Product info -->
                                    <div class="flex justify-between items-start mb-2">
                                        <h3
                                            class="text-sm md:text-base font-medium text-gray-900 group-hover:text-pink-600 transition-colors duration-200">
                                            <a href="{{ route('products.show', $product) }}" class="hover:underline">
                                                {{ $product->name }}
                                            </a>
                                        </h3>

                                        @if ($product->average_rating)
                                            <div class="flex items-center">
                                                <span class="text-amber-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </span>
                                                <span
                                                    class="text-xs text-gray-600 ml-1">{{ number_format($product->average_rating, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Short description -->
                                    <p class="text-xs text-gray-500 mb-3 line-clamp-2 flex-grow">
                                        {{ Str::limit(strip_tags($product->short_description ?? $product->description), 80) }}
                                    </p>

                                    <!-- Price and action -->
                                    <div class="mt-auto">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                @if ($product->is_on_sale)
                                                    <span
                                                        class="text-lg font-bold text-pink-600">{{ format_currency($product->sale_price) }}</span>
                                                    <span
                                                        class="text-sm text-gray-500 line-through ml-2">{{ format_currency($product->price) }}</span>
                                                @else
                                                    <span
                                                        class="text-lg font-bold text-pink-600">{{ format_currency($product->price) }}</span>
                                                @endif
                                            </div>

                                            <a href="{{ route('products.show', $product) }}"
                                                class="ml-2 inline-flex items-center rounded-full p-1.5 text-pink-600 hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada produk</h3>
                                    <p class="text-gray-500 mb-4">Belum ada produk yang tersedia dalam kategori ini.</p>
                                    <a href="{{ route('products.index') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                        Lihat semua produk
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateQueryParam(key, value) {
            const url = new URL(window.location.href);
            url.searchParams.set(key, value);
            window.location.href = url.toString();
        }
    </script>

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .pattern-dots {
            background-image: radial-gradient(currentColor 1px, transparent 1px);
            background-size: calc(10 * 1px) calc(10 * 1px);
        }

        @keyframes ping-once {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .animate-ping-once {
            animation: ping-once 0.3s cubic-bezier(0, 0, 0.2, 1);
        }

        /* Ensure no default dropdown arrow in any browser */
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: none !important;
        }

        select::-ms-expand {
            display: none;
        }
    </style>
@endsection
