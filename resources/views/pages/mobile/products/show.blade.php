@extends('pages.mobile.layouts.app')

@section('title', $product->name . ' - Premium Everyday')

@section('styles')
    <style>
        .product-description ul,
        .product-features ul,
        .product-requirements ul {
            list-style-type: disc;
            margin-left: 1rem;
            margin-bottom: 1rem;
        }

        .product-description ol,
        .product-features ol,
        .product-requirements ol {
            list-style-type: decimal;
            margin-left: 1rem;
            margin-bottom: 1rem;
        }

        .product-description p,
        .product-features p,
        .product-requirements p {
            margin-bottom: 0.75rem;
        }

        .product-description h1,
        .product-features h1,
        .product-requirements h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .product-description h2,
        .product-features h2,
        .product-requirements h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        /* Style for custom select */
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: none !important;
        }

        select::-ms-expand {
            display: none;
        }

        /* Line clamp utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection

@section('content')
    <div class="bg-gray-50 py-4">
        <div class="container mx-auto px-4">
            <!-- Breadcrumb -->
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-pink-600 transition-colors text-sm">
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('products.index') }}"
                                class="ml-1 text-gray-500 hover:text-pink-600 transition-colors text-sm">Products</a>
                        </div>
                    </li>
                    @if ($product->category)
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('categories.show', $product->category) }}"
                                    class="ml-1 text-gray-500 hover:text-pink-600 transition-colors text-sm">{{ $product->category->name }}</a>
                            </div>
                        </li>
                    @endif
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 text-sm truncate">{{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Product Details -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
                <!-- Product Image -->
                <div class="relative">
                    <div class="aspect-w-1 aspect-h-1 w-full">
                        <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                            class="h-full w-full object-cover object-center"
                            onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}';">
                    </div>

                    <!-- Product badges -->
                    <div class="absolute top-3 left-3 flex flex-col gap-1">
                        @if ($product->is_on_sale)
                            <span
                                class="inline-flex items-center rounded-full bg-pink-100 px-2 py-0.5 text-xs font-semibold text-pink-700 shadow-sm">
                                -{{ $product->discount_percentage }}%
                            </span>
                        @endif
                        @if ($product->isNew())
                            <span
                                class="inline-flex items-center rounded-full bg-pink-100 px-2 py-0.5 text-xs font-semibold text-pink-700 shadow-sm">
                                New
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-4">
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $product->name }}</h1>

                    <div class="flex items-center mb-4">
                        @if ($product->category)
                            <span class="bg-pink-50 text-pink-700 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $product->category->name }}
                            </span>
                        @endif

                        @if ($product->is_featured)
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium ml-2 px-2.5 py-0.5 rounded-full">
                                Featured
                            </span>
                        @endif

                        @if ($product->created_at->diffInDays(now()) <= 7)
                            <span class="bg-pink-100 text-pink-700 text-xs font-medium ml-2 px-2.5 py-0.5 rounded-full">
                                New
                            </span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center space-x-2 mb-2">
                            @if ($product->is_on_sale)
                                <span class="text-2xl font-bold text-pink-700">Rp
                                    {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                <span class="text-base text-gray-500 line-through">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span
                                    class="bg-pink-100 text-pink-700 text-xs font-semibold px-2 py-0.5 rounded">{{ $product->discount_percentage }}%
                                    OFF</span>
                            @else
                                <span class="text-2xl font-bold text-pink-700">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>

                        @if ($product->is_on_sale && $product->sale_ends_at)
                            <p class="text-sm text-pink-600">Sale ends: {{ $product->sale_ends_at->format('d M Y') }}</p>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <div class="text-sm text-gray-600 product-description">{!! $product->description !!}</div>
                    </div>

                    <!-- Features -->
                    @if ($product->features)
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Key Features</h3>
                            <div class="text-sm text-gray-600 product-features">{!! $product->features !!}</div>
                        </div>
                    @endif

                    <!-- Requirements -->
                    @if ($product->requirements)
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Requirements</h3>
                            <div class="text-sm text-gray-600 product-requirements">{!! $product->requirements !!}</div>
                        </div>
                    @endif

                    <!-- Purchase Options -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Purchase Options</h3>

                        <!-- Tab Navigation -->
                        <div class="flex border-b border-gray-200 mb-4">
                            <button id="tab-sharing-mobile" onclick="showTabMobile('sharing')"
                                class="tab-button-mobile active py-2 px-4 text-sm font-medium border-b-2 border-pink-600 text-pink-600">
                                Sharing Account
                            </button>
                            <button id="tab-private-mobile" onclick="showTabMobile('private')"
                                class="tab-button-mobile py-2 px-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                                Private Account
                            </button>
                        </div>

                        <!-- Sharing Account Options -->
                        <div id="content-sharing-mobile" class="tab-content-mobile">
                            <p class="text-sm text-gray-600 mb-4">
                                {{ $product->sharing_description ?? 'Share your account with multiple users. Lower price but limited to specific regions.' }}
                            </p>

                            <div class="space-y-4">
                                <!-- 1 Month Plan -->
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-pink-500 transition">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-900">1 Month Plan</h4>
                                            <p class="text-gray-500 text-xs">Basic sharing access</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-lg font-bold text-pink-700">Rp
                                                {{ number_format($product->current_price, 0, ',', '.') }}</span>
                                            @if ($product->is_on_sale && $product->discount_percentage > 0)
                                                <span class="text-xs text-gray-500 line-through block">Rp
                                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="subscription_type" value="monthly">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="duration" value="1">
                                        <input type="hidden" name="account_type" value="sharing">

                                        @auth
                                            <button type="submit"
                                                class="w-full bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded transition">
                                                Add to Cart
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                class="block text-center w-full bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded transition">
                                                Login to Purchase
                                            </a>
                                        @endauth
                                    </form>
                                </div>

                                <!-- 3 Month Plan -->
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-pink-500 transition">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-900">3 Month Plan</h4>
                                            <p class="text-gray-500 text-xs">Extended sharing access (save 10%)</p>
                                        </div>
                                        <div class="text-right">
                                            @php
                                                $basePrice = $product->current_price;
                                                $regularPrice = $product->price;
                                                $discountedPrice3Month = $basePrice * 3 * 0.9;
                                                $regularPrice3Month = $regularPrice * 3;
                                            @endphp
                                            <span class="text-lg font-bold text-pink-700">Rp
                                                {{ number_format($discountedPrice3Month, 0, ',', '.') }}</span>
                                            <span class="text-xs text-gray-500 line-through block">Rp
                                                {{ number_format($regularPrice3Month, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="subscription_type" value="quarterly">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="duration" value="3">
                                        <input type="hidden" name="account_type" value="sharing">

                                        @auth
                                            <button type="submit"
                                                class="w-full bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded transition">
                                                Add to Cart
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                class="block text-center w-full bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded transition">
                                                Login to Purchase
                                            </a>
                                        @endauth
                                    </form>
                                </div>

                                <!-- 6 Month Plan -->
                                <div
                                    class="border border-gray-200 rounded-lg p-4 hover:border-pink-500 transition relative overflow-hidden">
                                    <div
                                        class="absolute -right-10 top-3 bg-pink-600 text-white text-xs font-bold px-10 py-1 transform rotate-45">
                                        BEST DEAL
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-900">6 Month Plan</h4>
                                            <p class="text-gray-500 text-xs">Premium sharing access (save 20%)</p>
                                        </div>
                                        <div class="text-right">
                                            @php
                                                $discountedPrice6Month = $basePrice * 6 * 0.8;
                                                $regularPrice6Month = $regularPrice * 6;
                                            @endphp
                                            <span class="text-lg font-bold text-pink-700">Rp
                                                {{ number_format($discountedPrice6Month, 0, ',', '.') }}</span>
                                            <span class="text-xs text-gray-500 line-through block">Rp
                                                {{ number_format($regularPrice6Month, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="subscription_type" value="biannual">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="duration" value="6">
                                        <input type="hidden" name="account_type" value="sharing">

                                        @auth
                                            <button type="submit"
                                                class="w-full bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded transition">
                                                Add to Cart
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                class="block text-center w-full bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded transition">
                                                Login to Purchase
                                            </a>
                                        @endauth
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Private Account Options -->
                        <div id="content-private-mobile" class="tab-content-mobile hidden">
                            <p class="text-sm text-gray-600 mb-4">
                                {{ $product->private_description ?? 'Get your own private account. Higher price but available in all regions and fully private.' }}
                            </p>

                            <div class="space-y-4">
                                <!-- 1 Month Plan -->
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-pink-500 transition">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-900">1 Month Plan</h4>
                                            <p class="text-gray-500 text-xs">Basic private access</p>
                                        </div>
                                        <div class="text-right">
                                            @php
                                                $privatePrice = $product->current_price * 1.5;
                                                $privateRegularPrice = $product->price * 1.5;
                                            @endphp
                                            <span class="text-lg font-bold text-pink-700">Rp
                                                {{ number_format($privatePrice, 0, ',', '.') }}</span>
                                            @if ($product->is_on_sale && $product->discount_percentage > 0)
                                                <span class="text-xs text-gray-500 line-through block">Rp
                                                    {{ number_format($privateRegularPrice, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="subscription_type" value="monthly">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="duration" value="1">
                                        <input type="hidden" name="account_type" value="private">

                                        @auth
                                            <button type="submit"
                                                class="w-full bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded transition">
                                                Add to Cart
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                class="block text-center w-full bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded transition">
                                                Login to Purchase
                                            </a>
                                        @endauth
                                    </form>
                                </div>

                                <!-- 3 Month Plan -->
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-pink-500 transition">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-900">3 Month Plan</h4>
                                            <p class="text-gray-500 text-xs">Extended private access (save 10%)</p>
                                        </div>
                                        <div class="text-right">
                                            @php
                                                $discountedPrivatePrice3Month = $privatePrice * 3 * 0.9;
                                                $regularPrivatePrice3Month = $privateRegularPrice * 3;
                                            @endphp
                                            <span class="text-lg font-bold text-pink-700">Rp
                                                {{ number_format($discountedPrivatePrice3Month, 0, ',', '.') }}</span>
                                            <span class="text-xs text-gray-500 line-through block">Rp
                                                {{ number_format($regularPrivatePrice3Month, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="subscription_type" value="quarterly">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="duration" value="3">
                                        <input type="hidden" name="account_type" value="private">

                                        @auth
                                            <button type="submit"
                                                class="w-full bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded transition">
                                                Add to Cart
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                class="block text-center w-full bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded transition">
                                                Login to Purchase
                                            </a>
                                        @endauth
                                    </form>
                                </div>

                                <!-- 6 Month Plan -->
                                <div
                                    class="border border-gray-200 rounded-lg p-4 hover:border-pink-500 transition relative overflow-hidden">
                                    <div
                                        class="absolute -right-10 top-3 bg-pink-600 text-white text-xs font-bold px-10 py-1 transform rotate-45">
                                        BEST DEAL
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-900">6 Month Plan</h4>
                                            <p class="text-gray-500 text-xs">Premium private access (save 20%)</p>
                                        </div>
                                        <div class="text-right">
                                            @php
                                                $discountedPrivatePrice6Month = $privatePrice * 6 * 0.8;
                                                $regularPrivatePrice6Month = $privateRegularPrice * 6;
                                            @endphp
                                            <span class="text-lg font-bold text-pink-700">Rp
                                                {{ number_format($discountedPrivatePrice6Month, 0, ',', '.') }}</span>
                                            <span class="text-xs text-gray-500 line-through block">Rp
                                                {{ number_format($regularPrivatePrice6Month, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="subscription_type" value="biannual">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="duration" value="6">
                                        <input type="hidden" name="account_type" value="private">

                                        @auth
                                            <button type="submit"
                                                class="w-full bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded transition">
                                                Add to Cart
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                class="block text-center w-full bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded transition">
                                                Login to Purchase
                                            </a>
                                        @endauth
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if (count($relatedProducts) > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">You May Also Like</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div
                                class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100 group transform transition-transform hover:-translate-y-1 flex flex-col h-full">
                                <a href="{{ route('products.show', $relatedProduct) }}"
                                    class="relative bg-gray-200 overflow-hidden">
                                    <div class="aspect-w-1 aspect-h-1 w-full">
                                        <img src="{{ $relatedProduct->thumbnail_url }}"
                                            alt="{{ $relatedProduct->name }}"
                                            class="h-full w-full object-cover object-center transform group-hover:scale-105 transition-transform duration-500"
                                            onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}';">

                                        <!-- Product badges -->
                                        <div class="absolute top-2 left-2 flex flex-col gap-1">
                                            @if ($relatedProduct->is_on_sale)
                                                <span
                                                    class="inline-flex items-center rounded-full bg-pink-100 px-2 py-0.5 text-xs font-semibold text-pink-700 shadow-sm">
                                                    -{{ $relatedProduct->discount_percentage }}%
                                                </span>
                                            @endif
                                            @if ($relatedProduct->isNew())
                                                <span
                                                    class="inline-flex items-center rounded-full bg-pink-100 px-2 py-0.5 text-xs font-semibold text-pink-700 shadow-sm">
                                                    New
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </a>

                                <div class="p-3 flex-1 flex flex-col">
                                    <a href="{{ route('products.show', $relatedProduct) }}"
                                        class="block group-hover:text-pink-600 transition-colors duration-200">
                                        <h3 class="text-sm font-medium text-gray-900 mb-1 line-clamp-2">
                                            {{ $relatedProduct->name }}</h3>
                                    </a>

                                    <div class="mt-auto flex items-center justify-between text-xs">
                                        <div>
                                            @if ($relatedProduct->is_on_sale)
                                                <span class="line-through text-gray-400">Rp
                                                    {{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                                                <div class="text-pink-700 font-bold">Rp
                                                    {{ number_format($relatedProduct->getDiscountedPrice(), 0, ',', '.') }}
                                                </div>
                                            @else
                                                <div class="text-pink-700 font-bold">Rp
                                                    {{ number_format($relatedProduct->price, 0, ',', '.') }}</div>
                                            @endif
                                        </div>

                                        <a href="{{ route('products.show', $relatedProduct) }}"
                                            class="inline-flex items-center justify-center rounded-full px-2.5 py-1 bg-pink-50 text-pink-600 hover:bg-pink-600 hover:text-white transition-all duration-200 text-xs font-medium">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function showTabMobile(tabName) {
            const tabs = document.querySelectorAll('.tab-button-mobile');
            const contents = document.querySelectorAll('.tab-content-mobile');

            // Hide all contents
            contents.forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all tabs
            tabs.forEach(tab => {
                tab.classList.remove('active');
                tab.classList.remove('border-pink-600');
                tab.classList.remove('text-pink-600');
                tab.classList.add('border-transparent');
                tab.classList.add('text-gray-500');
            });

            // Show selected content
            document.getElementById('content-' + tabName + '-mobile').classList.remove('hidden');

            // Add active class to selected tab
            document.getElementById('tab-' + tabName + '-mobile').classList.add('active');
            document.getElementById('tab-' + tabName + '-mobile').classList.add('border-pink-600');
            document.getElementById('tab-' + tabName + '-mobile').classList.add('text-pink-600');
            document.getElementById('tab-' + tabName + '-mobile').classList.remove('border-transparent');
            document.getElementById('tab-' + tabName + '-mobile').classList.remove('text-gray-500');
        }
    </script>
@endsection
