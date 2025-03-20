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
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .product-description h2,
        .product-features h2,
        .product-requirements h2 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
    </style>
@endsection

@section('content')
    <div class="bg-white py-4">
        <div class="container mx-auto px-4">
            <!-- Breadcrumb -->
            <nav class="flex py-2 overflow-x-auto whitespace-nowrap mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-primary">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('products.index') }}"
                                class="text-sm text-gray-500 hover:text-primary ml-1">Products</a>
                        </div>
                    </li>
                    @if ($product->category)
                        <li>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('categories.show', $product->category) }}"
                                    class="text-sm text-gray-500 hover:text-primary ml-1">{{ $product->category->name }}</a>
                            </div>
                        </li>
                    @endif
                </ol>
            </nav>

            <!-- Product Image -->
            <div class="relative mb-4">
                <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                    class="w-full h-64 object-cover rounded-lg"
                    onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}'; console.log('Image failed to load: ' + this.alt);">
                @if ($product->is_on_sale)
                    <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                        SALE
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
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
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{!! $product->description !!}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Price</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Subscription Options -->
            <div class="mb-8">
                <h3 class="text-md font-semibold text-gray-900 mb-2">Purchase Options</h3>

                <!-- Purchase Type Tabs -->
                <div class="mb-4">
                    <div class="flex border-b border-gray-200 mb-4">
                        <button id="tab-sharing-mobile" onclick="showTabMobile('sharing')"
                            class="tab-button-mobile active py-2 px-3 text-sm font-medium border-b-2 border-primary text-primary">
                            Sharing Account
                        </button>
                        <button id="tab-private-mobile" onclick="showTabMobile('private')"
                            class="tab-button-mobile py-2 px-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                            Private Account
                        </button>
                    </div>

                    <!-- Sharing Account Options -->
                    <div id="content-sharing-mobile" class="tab-content-mobile">
                        <p class="text-xs text-gray-600 mb-3">
                            {{ $product->sharing_description ?? 'Share your account with multiple users. Lower price but limited to specific regions.' }}
                        </p>

                        <div class="space-y-4">
                            <!-- 1 Month Plan -->
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-gray-900">1 Month Plan</h4>
                                        <p class="text-gray-500 text-xs">Basic sharing access</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-lg font-bold text-primary">Rp
                                            {{ number_format($product->actual_sharing_price ?? $product->price, 0, ',', '.') }}</span>
                                        @if ($product->is_promo && ($product->sharing_discount ?? 0) > 0)
                                            <span class="text-xs text-gray-500 line-through block">Rp
                                                {{ number_format($product->sharing_price ?? $product->price, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="subscription_type" value="monthly">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="duration" value="1">
                                    <input type="hidden" name="account_type" value="sharing">

                                    @auth
                                        <button type="submit"
                                            class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Add to Cart
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                            class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
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
                                        <p class="text-gray-500 text-xs">Extended sharing access (save 10%)</p>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $sharingPrice = $product->actual_sharing_price ?? $product->price;
                                            $sharingPrice3Month = $sharingPrice * 3 * 0.9;
                                            $sharingRegularPrice3Month =
                                                ($product->sharing_price ?? $product->price) * 3;
                                        @endphp
                                        <span class="text-lg font-bold text-primary">Rp
                                            {{ number_format($sharingPrice3Month, 0, ',', '.') }}</span>
                                        <span class="text-xs text-gray-500 line-through block">Rp
                                            {{ number_format($sharingRegularPrice3Month, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="subscription_type" value="quarterly">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="duration" value="3">
                                    <input type="hidden" name="account_type" value="sharing">

                                    @auth
                                        <button type="submit"
                                            class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Add to Cart
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                            class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
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
                                        <p class="text-gray-500 text-xs">Premium sharing access (save 20%)</p>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $sharingPrice = $product->actual_sharing_price ?? $product->price;
                                            $sharingPrice6Month = $sharingPrice * 6 * 0.8;
                                            $sharingRegularPrice6Month =
                                                ($product->sharing_price ?? $product->price) * 6;
                                        @endphp
                                        <span class="text-lg font-bold text-primary">Rp
                                            {{ number_format($sharingPrice6Month, 0, ',', '.') }}</span>
                                        <span class="text-xs text-gray-500 line-through block">Rp
                                            {{ number_format($sharingRegularPrice6Month, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="subscription_type" value="semiannual">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="duration" value="6">
                                    <input type="hidden" name="account_type" value="sharing">

                                    @auth
                                        <button type="submit"
                                            class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Add to Cart
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                            class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Login to Purchase
                                        </a>
                                    @endauth
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Private Account Options -->
                    <div id="content-private-mobile" class="tab-content-mobile hidden">
                        <p class="text-xs text-gray-600 mb-3">
                            {{ $product->private_description ?? 'Exclusive private account for single user. Higher price but available in all regions with premium features.' }}
                        </p>

                        <div class="space-y-4">
                            <!-- 1 Month Plan -->
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-gray-900">1 Month Plan</h4>
                                        <p class="text-gray-500 text-xs">Basic private access</p>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $privatePrice = $product->actual_private_price ?? $product->price * 1.5;
                                            $privateRegularPrice = $product->private_price ?? $product->price * 1.5;
                                        @endphp
                                        <span class="text-lg font-bold text-primary">Rp
                                            {{ number_format($privatePrice, 0, ',', '.') }}</span>
                                        @if ($product->is_promo && ($product->private_discount ?? 0) > 0)
                                            <span class="text-xs text-gray-500 line-through block">Rp
                                                {{ number_format($privateRegularPrice, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="subscription_type" value="monthly">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="duration" value="1">
                                    <input type="hidden" name="account_type" value="private">

                                    @auth
                                        <button type="submit"
                                            class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Add to Cart
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                            class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
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
                                        <p class="text-gray-500 text-xs">Extended private access (save 10%)</p>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $privatePrice = $product->actual_private_price ?? $product->price * 1.5;
                                            $privatePrice3Month = $privatePrice * 3 * 0.9;
                                            $privateRegularPrice3Month =
                                                ($product->private_price ?? $product->price * 1.5) * 3;
                                        @endphp
                                        <span class="text-lg font-bold text-primary">Rp
                                            {{ number_format($privatePrice3Month, 0, ',', '.') }}</span>
                                        <span class="text-xs text-gray-500 line-through block">Rp
                                            {{ number_format($privateRegularPrice3Month, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="subscription_type" value="quarterly">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="duration" value="3">
                                    <input type="hidden" name="account_type" value="private">

                                    @auth
                                        <button type="submit"
                                            class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Add to Cart
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                            class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
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
                                        <p class="text-gray-500 text-xs">Premium private access (save 20%)</p>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $privatePrice = $product->actual_private_price ?? $product->price * 1.5;
                                            $privatePrice6Month = $privatePrice * 6 * 0.8;
                                            $privateRegularPrice6Month =
                                                ($product->private_price ?? $product->price * 1.5) * 6;
                                        @endphp
                                        <span class="text-lg font-bold text-primary">Rp
                                            {{ number_format($privatePrice6Month, 0, ',', '.') }}</span>
                                        <span class="text-xs text-gray-500 line-through block">Rp
                                            {{ number_format($privateRegularPrice6Month, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="subscription_type" value="semiannual">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="duration" value="6">
                                    <input type="hidden" name="account_type" value="private">

                                    @auth
                                        <button type="submit"
                                            class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Add to Cart
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                            class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Login to Purchase
                                        </a>
                                    @endauth
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        function showTabMobile(tabName) {
                            // Hide all tab contents
                            document.querySelectorAll('.tab-content-mobile').forEach(content => {
                                content.classList.add('hidden');
                            });

                            // Show selected tab content
                            document.getElementById('content-' + tabName + '-mobile').classList.remove('hidden');

                            // Update tab buttons
                            document.querySelectorAll('.tab-button-mobile').forEach(button => {
                                button.classList.remove('active', 'border-primary', 'text-primary');
                                button.classList.add('border-transparent', 'text-gray-500');
                            });

                            document.getElementById('tab-' + tabName + '-mobile').classList.add('active', 'border-primary', 'text-primary');
                            document.getElementById('tab-' + tabName + '-mobile').classList.remove('border-transparent', 'text-gray-500');
                        }
                    </script>
                </div>
            </div>

            <!-- Related Products -->
            @if ($relatedProducts && $relatedProducts->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Related Products</h2>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach ($relatedProducts as $related)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                                <a href="{{ route('products.show', $related) }}">
                                    <div class="relative">
                                        <img src="{{ $related->thumbnail_url }}" alt="{{ $related->name }}"
                                            class="w-full h-28 object-cover"
                                            onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}'; console.log('Related image failed to load: ' + this.alt);">
                                        @if ($related->is_on_sale)
                                            <div
                                                class="absolute top-1 right-1 bg-red-500 text-white text-xxs font-bold px-1.5 py-0.5 rounded">
                                                SALE
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-2">
                                        <h3 class="text-sm font-bold text-gray-900 truncate">{{ $related->name }}</h3>
                                        <div class="mt-1">
                                            @if ($related->is_on_sale)
                                                <span class="text-gray-400 line-through text-xs">Rp
                                                    {{ number_format($related->price, 0, ',', '.') }}</span>
                                                <span class="text-sm font-bold text-primary block">Rp
                                                    {{ number_format($related->sale_price, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-sm font-bold text-primary">Rp
                                                    {{ number_format($related->price, 0, ',', '.') }}</span>
                                            @endif
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
