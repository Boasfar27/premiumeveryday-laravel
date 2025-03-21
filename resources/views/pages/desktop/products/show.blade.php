@extends('pages.desktop.layouts.app')

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
    </style>
@endsection

@section('content')
    <div class="bg-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary">
                            {{-- <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg> --}}
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('products.index') }}"
                                class="ml-1 text-gray-500 hover:text-primary md:ml-2">Products</a>
                        </div>
                    </li>
                    @if ($product->category)
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('categories.show', $product->category) }}"
                                    class="ml-1 text-gray-500 hover:text-primary md:ml-2">{{ $product->category->name }}</a>
                            </div>
                        </li>
                    @endif
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2">{{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Product Details -->
            {{-- <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Product Details</h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->name }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->description }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Price</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                </div>
            </div> --}}

            <!-- Product Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Left Column - Images -->
                <div>
                    <div class="mb-4 overflow-hidden rounded-lg">
                        <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                            class="w-full h-auto object-cover"
                            onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}'; console.log('Image failed to load: ' + this.alt);">
                    </div>
                    @if ($product->gallery && count($product->gallery) > 0)
                        <div class="grid grid-cols-4 gap-2">
                            @foreach ($product->gallery as $image)
                                <div class="overflow-hidden rounded-lg">
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}"
                                        class="w-full h-20 object-cover"
                                        onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}'; console.log('Gallery image failed to load');">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Right Column - Details -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

                    <div class="flex items-center mb-4">
                        @if ($product->category)
                            <span class="bg-primary-50 text-primary-700 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $product->category->name }}
                            </span>
                        @endif

                        @if ($product->is_featured)
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium ml-2 px-2.5 py-0.5 rounded-full">
                                Featured
                            </span>
                        @endif

                        @if ($product->created_at->diffInDays(now()) <= 7)
                            <span class="bg-green-100 text-green-800 text-xs font-medium ml-2 px-2.5 py-0.5 rounded-full">
                                New
                            </span>
                        @endif
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center space-x-2 mb-2">
                            @if ($product->is_on_sale)
                                <span class="text-3xl font-bold text-primary">Rp
                                    {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                <span class="text-xl text-gray-500 line-through">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span
                                    class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $product->discount_percentage }}%
                                    OFF</span>
                            @else
                                <span class="text-3xl font-bold text-primary">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>

                        @if ($product->is_on_sale && $product->sale_ends_at)
                            <p class="text-sm text-red-600">Sale ends: {{ $product->sale_ends_at->format('d M Y') }}</p>
                        @endif
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <div class="text-gray-600 product-description">{!! $product->description !!}</div>
                    </div>

                    @if ($product->features)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Key Features</h3>
                            <div class="text-gray-600 product-features">{!! $product->features !!}</div>
                        </div>
                    @endif

                    @if ($product->requirements)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Requirements</h3>
                            <div class="text-gray-600 product-requirements">{!! $product->requirements !!}</div>
                        </div>
                    @endif

                    <!-- Subscription Options -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Purchase Options</h3>

                        <!-- Purchase Type Tabs -->
                        <div class="mb-6">
                            <div class="flex border-b border-gray-200 mb-4">
                                <button id="tab-sharing" onclick="showTab('sharing')"
                                    class="tab-button active py-2 px-4 font-medium border-b-2 border-primary text-primary">
                                    Sharing Account
                                </button>
                                <button id="tab-private" onclick="showTab('private')"
                                    class="tab-button py-2 px-4 font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                                    Private Account
                                </button>
                            </div>

                            <!-- Sharing Account Options -->
                            <div id="content-sharing" class="tab-content">
                                <p class="text-sm text-gray-600 mb-4">
                                    {{ $product->sharing_description ?? 'Share your account with multiple users. Lower price but limited to specific regions.' }}
                                </p>

                                <div class="grid grid-cols-1 gap-4 mt-4">
                                    <!-- 1 Month Plan -->
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">1 Month Plan</h4>
                                                <p class="text-gray-500 text-sm">Basic sharing access</p>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-xl font-bold text-primary">Rp
                                                    {{ number_format($product->current_price, 0, ',', '.') }}</span>
                                                @if ($product->is_on_sale && $product->discount_percentage > 0)
                                                    <span class="text-sm text-gray-500 line-through block">Rp
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
                                                    class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Add to Cart
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                    class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Login to Purchase
                                                </a>
                                            @endauth
                                        </form>
                                    </div>

                                    <!-- 3 Month Plan -->
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">3 Month Plan</h4>
                                                <p class="text-gray-500 text-sm">Extended sharing access (save 10%)</p>
                                            </div>
                                            <div class="text-right">
                                                @php
                                                    $basePrice = $product->current_price;
                                                    $regularPrice = $product->price;
                                                    $discountedPrice3Month = $basePrice * 3 * 0.9;
                                                    $regularPrice3Month = $regularPrice * 3;
                                                @endphp
                                                <span class="text-xl font-bold text-primary">Rp
                                                    {{ number_format($discountedPrice3Month, 0, ',', '.') }}</span>
                                                <span class="text-sm text-gray-500 line-through block">Rp
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
                                                    class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Add to Cart
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                    class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Login to Purchase
                                                </a>
                                            @endauth
                                        </form>
                                    </div>

                                    <!-- 6 Month Plan -->
                                    <div class="border-2 border-primary rounded-lg p-4 bg-primary-50 relative">
                                        <div
                                            class="absolute top-0 right-0 bg-primary text-white text-xs font-bold px-2 py-1 rounded-bl-lg">
                                            BEST VALUE
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">6 Month Plan</h4>
                                                <p class="text-gray-500 text-sm">Premium sharing access (save a total of
                                                    20%)</p>
                                            </div>
                                            <div class="text-right">
                                                @php
                                                    $basePrice = $product->current_price;
                                                    $regularPrice = $product->price;
                                                    $discountedPrice6Month = $basePrice * 6 * 0.8;
                                                    $regularPrice6Month = $regularPrice * 6;
                                                @endphp
                                                <span class="text-xl font-bold text-primary">Rp
                                                    {{ number_format($discountedPrice6Month, 0, ',', '.') }}</span>
                                                <span class="text-sm text-gray-500 line-through block">Rp
                                                    {{ number_format($regularPrice6Month, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="subscription_type" value="semiannual">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="duration" value="6">
                                            <input type="hidden" name="account_type" value="sharing">

                                            @auth
                                                <button type="submit"
                                                    class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Add to Cart
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                    class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Login to Purchase
                                                </a>
                                            @endauth
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Private Account Options -->
                            <div id="content-private" class="tab-content hidden">
                                <p class="text-sm text-gray-600 mb-4">
                                    {{ $product->private_description ?? 'Exclusive private account for single user. Higher price but available in all regions with premium features.' }}
                                </p>

                                <div class="grid grid-cols-1 gap-4 mt-4">
                                    <!-- 1 Month Plan -->
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">1 Month Plan</h4>
                                                <p class="text-gray-500 text-sm">Basic private access</p>
                                            </div>
                                            <div class="text-right">
                                                @php
                                                    $basePrice = $product->current_price * 1.5; // Private account = 1.5x price
                                                    $regularPrice = $product->price * 1.5;
                                                @endphp
                                                <span class="text-xl font-bold text-primary">Rp
                                                    {{ number_format($basePrice, 0, ',', '.') }}</span>
                                                @if ($product->is_on_sale && $product->discount_percentage > 0)
                                                    <span class="text-sm text-gray-500 line-through block">Rp
                                                        {{ number_format($regularPrice, 0, ',', '.') }}</span>
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
                                                    class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Add to Cart
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                    class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Login to Purchase
                                                </a>
                                            @endauth
                                        </form>
                                    </div>

                                    <!-- 3 Month Plan -->
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">3 Month Plan</h4>
                                                <p class="text-gray-500 text-sm">Extended private access (save 10%)</p>
                                            </div>
                                            <div class="text-right">
                                                @php
                                                    $basePrice = $product->current_price * 1.5; // Private account = 1.5x price
                                                    $regularPrice = $product->price * 1.5;
                                                    $discountedPrice3Month = $basePrice * 3 * 0.9;
                                                    $regularPrice3Month = $regularPrice * 3;
                                                @endphp
                                                <span class="text-xl font-bold text-primary">Rp
                                                    {{ number_format($discountedPrice3Month, 0, ',', '.') }}</span>
                                                <span class="text-sm text-gray-500 line-through block">Rp
                                                    {{ number_format($regularPrice3Month, 0, ',', '.') }}</span>
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
                                                    class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Add to Cart
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                    class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Login to Purchase
                                                </a>
                                            @endauth
                                        </form>
                                    </div>

                                    <!-- 6 Month Plan -->
                                    <div class="border-2 border-primary rounded-lg p-4 bg-primary-50 relative">
                                        <div
                                            class="absolute top-0 right-0 bg-primary text-white text-xs font-bold px-2 py-1 rounded-bl-lg">
                                            BEST VALUE
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">6 Month Plan</h4>
                                                <p class="text-gray-500 text-sm">Premium private access (save a total of
                                                    20%)</p>
                                            </div>
                                            <div class="text-right">
                                                @php
                                                    $basePrice = $product->current_price * 1.5; // Private account = 1.5x price
                                                    $regularPrice = $product->price * 1.5;
                                                    $discountedPrice6Month = $basePrice * 6 * 0.8;
                                                    $regularPrice6Month = $regularPrice * 6;
                                                @endphp
                                                <span class="text-xl font-bold text-primary">Rp
                                                    {{ number_format($discountedPrice6Month, 0, ',', '.') }}</span>
                                                <span class="text-sm text-gray-500 line-through block">Rp
                                                    {{ number_format($regularPrice6Month, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="subscription_type" value="semiannual">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="duration" value="6">
                                            <input type="hidden" name="account_type" value="private">

                                            @auth
                                                <button type="submit"
                                                    class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Add to Cart
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                    class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Login to Purchase
                                                </a>
                                            @endauth
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function showTab(tabName) {
                            // Hide all tab contents
                            document.querySelectorAll('.tab-content').forEach(content => {
                                content.classList.add('hidden');
                            });

                            // Show selected tab content
                            document.getElementById('content-' + tabName).classList.remove('hidden');

                            // Update tab buttons
                            document.querySelectorAll('.tab-button').forEach(button => {
                                button.classList.remove('active', 'border-primary', 'text-primary');
                                button.classList.add('border-transparent', 'text-gray-500');
                            });

                            document.getElementById('tab-' + tabName).classList.add('active', 'border-primary', 'text-primary');
                            document.getElementById('tab-' + tabName).classList.remove('border-transparent', 'text-gray-500');
                        }
                    </script>
                </div>
            </div>

            <!-- Related Products -->
            @if ($relatedProducts && $relatedProducts->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Products</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedProducts as $related)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                                <a href="{{ route('products.show', $related) }}">
                                    <div class="relative">
                                        <img src="{{ $related->thumbnail_url }}" alt="{{ $related->name }}"
                                            class="w-full h-40 object-cover"
                                            onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}'; console.log('Related image failed to load: ' + this.alt);">
                                        @if ($related->is_on_sale)
                                            <div
                                                class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                                SALE
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-md font-bold text-gray-900 mb-1">{{ $related->name }}</h3>
                                        <div class="flex items-center justify-between mt-2">
                                            <div>
                                                @if ($related->is_on_sale)
                                                    <span class="text-gray-400 line-through text-xs">Rp
                                                        {{ number_format($related->price, 0, ',', '.') }}</span>
                                                    <span class="text-md font-bold text-primary">Rp
                                                        {{ number_format($related->current_price, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="text-md font-bold text-primary">Rp
                                                        {{ number_format($related->price, 0, ',', '.') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
