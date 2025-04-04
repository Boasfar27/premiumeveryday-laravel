@extends('pages.mobile.layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <!-- Hero section -->
        <div class="bg-gradient-to-r from-pink-600 to-pink-700 text-white overflow-hidden">
            <!-- Background pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                    <path d="M0 4c0-2.2 1.8-4 4-4h24c2.2 0 4 1.8 4 4v24c0 2.2-1.8 4-4 4H4c-2.2 0-4-1.8-4-4V4z" />
                </svg>
            </div>

            <div class="px-4 py-8 relative">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-800 bg-opacity-50 text-pink-100 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    PREMIUM
                </span>

                <h1 class="text-2xl font-bold tracking-tight mb-2 drop-shadow-sm">
                    @if (isset($currentCategory))
                        {{ $currentCategory->name }}
                    @else
                        Premium Digital Products
                    @endif
                </h1>

                <div class="h-1 w-16 bg-pink-400 mb-3 rounded-full"></div>

                <p class="text-pink-100 text-sm mb-5">
                    @if (isset($currentCategory))
                        {{ $currentCategory->description ?? 'Discover our selection of premium digital products.' }}
                    @else
                        Discover our selection of premium digital products.
                    @endif
                </p>

                <!-- Search -->
                <form action="{{ route('products.index') }}" method="GET" class="flex mb-1 relative group">
                    @if (request()->has('category'))
                        <input type="hidden" name="category" value="{{ request()->category }}">
                    @endif
                    @if (request()->has('sort'))
                        <input type="hidden" name="sort" value="{{ request()->sort }}">
                    @endif
                    <div class="relative flex-1 z-0">
                        <input type="text" name="search" id="search" value="{{ request()->search }}"
                            placeholder="Search products..."
                            class="block w-full pl-4 pr-10 py-2.5 text-gray-900 bg-white border-0 rounded-l-md focus:ring-2 focus:ring-pink-500 focus:outline-none shadow-sm group-hover:shadow-md transition-shadow duration-200">

                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <button type="submit"
                        class="relative inline-flex items-center px-4 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-r-md text-white bg-pink-800 hover:bg-pink-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 overflow-hidden transition-all duration-200">
                        <span class="relative z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <div
                            class="absolute inset-0 bg-pink-700 transform scale-x-0 origin-left transition-transform duration-200 group-hover:scale-x-100">
                        </div>
                    </button>
                </form>
            </div>

            <!-- Simple curved divider instead of wave -->
            <div class="h-4 bg-gray-50 rounded-t-3xl"></div>
        </div>

        <!-- Category tabs -->
        <div class="px-4 py-4">
            <div class="flex overflow-x-auto pb-2 hide-scrollbar -mx-4 px-4 space-x-3">
                <a href="{{ route('products.index') }}"
                    class="flex-shrink-0 flex flex-col items-center px-4 py-2 text-xs font-medium rounded-lg {{ !request()->has('category') ? 'bg-pink-600 text-white shadow-md scale-105' : 'bg-white text-gray-900 hover:bg-gray-100 shadow hover:shadow-md' }} transition-all duration-200">
                    <span
                        class="w-10 h-10 flex items-center justify-center bg-pink-100 text-pink-900 rounded-full mb-1 transform transition-transform duration-200 hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
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
                    All
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                        class="flex-shrink-0 flex flex-col items-center px-4 py-2 text-xs font-medium rounded-lg {{ request()->category == $category->slug ? 'bg-pink-600 text-white shadow-md scale-105' : 'bg-white text-gray-900 hover:bg-gray-100 shadow hover:shadow-md' }} transition-all duration-200">
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-pink-100 text-pink-900 rounded-full mb-1 transform transition-transform duration-200 hover:scale-110">
                            @if ($category->icon)
                                <i class="{{ $category->icon }}"></i>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                            @endif
                        </span>
                        {{ \Illuminate\Support\Str::limit($category->name, 10) }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Filter & Sort -->
        <div class="px-4 mb-4">
            <div
                class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 p-3 flex space-x-2 border border-gray-100">
                <!-- Category Filter -->
                <div class="w-1/2 relative">
                    <svg class="w-4 h-4 text-gray-400 absolute left-2 top-1/2 transform -translate-y-1/2 pointer-events-none"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                        </path>
                    </svg>

                    <select name="category" id="category-mobile" onchange="window.location.href=this.value"
                        class="block w-full pl-8 pr-8 py-1.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 appearance-none cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                        <option value="{{ route('products.index') }}">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ route('products.index', ['category' => $category->slug]) }}"
                                {{ request()->category == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                </div>

                <!-- Sort -->
                <div class="w-1/2 relative">
                    <svg class="w-4 h-4 text-gray-400 absolute left-2 top-1/2 transform -translate-y-1/2 pointer-events-none"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                    </svg>

                    <select name="sort" id="sort-mobile" onchange="updateQueryParam('sort', this.value)"
                        class="block w-full pl-8 pr-8 py-1.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500 appearance-none cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                        <option value="newest" {{ request()->sort == 'newest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ request()->sort == 'price_low' ? 'selected' : '' }}>Price: Low to
                            High</option>
                        <option value="price_high" {{ request()->sort == 'price_high' ? 'selected' : '' }}>Price: High to
                            Low</option>
                        <option value="name" {{ request()->sort == 'name' ? 'selected' : '' }}>Name</option>
                    </select>

                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-4 pb-16">
            <!-- Results info -->
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                <span>Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari
                    {{ $products->total() }} produk</span>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-2 gap-4">
                @forelse ($products as $product)
                    <div
                        class="bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col border border-gray-100 transform hover:translate-y-[-2px]">
                        <a href="{{ route('products.show', $product) }}" class="relative bg-gray-200">
                            <div class="aspect-w-4 aspect-h-3 w-full">
                                <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                    class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
                                    onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}';">

                                <!-- Product badges -->
                                <div class="absolute top-0 right-0">
                                    @if ($product->is_on_sale)
                                        <span
                                            class="inline-flex items-center bg-gradient-to-l from-pink-500 to-red-600 px-2 py-0.5 text-xs font-medium text-white shadow-sm">
                                            Hemat {{ $product->discount_percentage }}%
                                        </span>
                                    @endif
                                </div>

                                <!-- Category badge -->
                                @if ($product->category)
                                    <div
                                        class="absolute bottom-0 left-0 bg-gray-900 bg-opacity-75 text-white text-xs font-medium px-2 py-0.5">
                                        {{ $product->category->name }}
                                    </div>
                                @endif

                                <!-- New badge -->
                                @if ($product->isNew())
                                    <div
                                        class="absolute top-0 left-0 bg-blue-600 text-white text-xs font-medium px-2 py-0.5">
                                        Baru
                                    </div>
                                @endif
                            </div>
                        </a>

                        <div class="p-3 flex-grow flex flex-col">
                            <!-- Product info -->
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-sm font-medium text-gray-900 leading-tight line-clamp-2">
                                    <a href="{{ route('products.show', $product) }}"
                                        class="hover:text-pink-600 transition-colors duration-200">
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                @if ($product->average_rating)
                                    <div class="flex items-center ml-1">
                                        <span class="text-amber-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </span>
                                        <span
                                            class="text-xs text-gray-600 ml-0.5">{{ number_format($product->average_rating, 1) }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Short description - only if space allows -->
                            <p class="text-xs text-gray-500 mb-2 line-clamp-1 flex-grow">
                                {{ Str::limit(strip_tags($product->short_description ?? $product->description), 50) }}
                            </p>

                            <!-- Price and action -->
                            <div class="mt-auto">
                                <div class="flex items-center justify-between">
                                    <div class="flex flex-col">
                                        @if ($product->is_on_sale)
                                            <span
                                                class="line-through text-gray-400 text-xs">{{ format_currency($product->price) }}</span>
                                            <span
                                                class="text-pink-600 font-bold text-sm">{{ format_currency($product->sale_price) }}</span>
                                        @else
                                            <span
                                                class="text-pink-600 font-bold text-sm">{{ format_currency($product->price) }}</span>
                                        @endif
                                    </div>

                                    <a href="{{ route('products.show', $product) }}"
                                        class="ml-1 inline-flex items-center rounded-full p-1 text-pink-600 hover:bg-pink-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                            fill="currentColor">
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
                    <div class="col-span-2">
                        <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                            <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            <h3 class="text-base font-medium text-gray-900 mb-2">Tidak ada produk</h3>
                            <p class="text-gray-500 mb-4 text-sm">Belum ada produk yang tersedia dalam kategori ini.</p>
                            <a href="{{ route('products.index') }}"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                Lihat semua produk
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $products->appends(request()->query())->links() }}
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
