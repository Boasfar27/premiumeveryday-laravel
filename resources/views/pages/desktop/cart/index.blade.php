@extends('pages.desktop.layouts.app')

@section('title', 'Shopping Cart - Premium Everyday')

@section('content')
    <div class="bg-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if (count($products) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                            <div class="p-6">
                                <div class="space-y-6">
                                    @foreach ($products as $item)
                                        <div class="cart-item" data-product-id="{{ $item['id'] }}">
                                            @if (!$loop->first)
                                                <div class="border-t border-gray-200 mb-6"></div>
                                            @endif

                                            <div class="flex gap-6">
                                                <!-- Product Image -->
                                                <div class="w-24 h-24 flex-shrink-0">
                                                    <img src="{{ $item['product']->thumbnail_url ?? asset($item['product']->thumbnail) }}"
                                                        alt="{{ $item['product']->name }}"
                                                        class="w-full h-full object-cover rounded-md">
                                                </div>

                                                <!-- Product Details -->
                                                <div class="flex-1">
                                                    <div class="flex justify-between">
                                                        <div>
                                                            <div class="flex flex-col">
                                                                <a href="{{ route('products.show', $item['product']->slug) }}"
                                                                    class="text-lg font-semibold text-gray-800 hover:text-pink-600">{{ $item['product']->name }}</a>
                                                                <div class="text-sm text-gray-500">
                                                                    <span
                                                                        class="capitalize">{{ $item['subscription_type'] }}</span>
                                                                    |
                                                                    <span>{{ $item['duration'] }}
                                                                        {{ Str::plural('Month', $item['duration']) }}</span>
                                                                    |
                                                                    <span class="capitalize">{{ $item['account_type'] }}
                                                                        Account</span>
                                                                </div>
                                                            </div>

                                                            <!-- Price -->
                                                            <div class="mt-1">
                                                                @if (isset($item['discounted_price']))
                                                                    <p class="text-sm text-gray-500 line-through">
                                                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                                    </p>
                                                                    <p class="text-lg font-semibold text-pink-600">
                                                                        Rp
                                                                        {{ number_format($item['discounted_price'], 0, ',', '.') }}
                                                                    </p>
                                                                @else
                                                                    <p class="text-lg font-semibold text-pink-600">
                                                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <!-- Quantity Controls -->
                                                        <div class="flex items-start space-x-6">
                                                            <div class="flex items-center space-x-2">
                                                                <form method="POST" action="{{ route('cart.update') }}"
                                                                    class="update-cart-form">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="product_id"
                                                                        value="{{ $item['id'] }}">
                                                                    <input type="hidden" name="cart_action"
                                                                        value="decrement">
                                                                    <input type="hidden" name="quantity"
                                                                        value="{{ $item['quantity'] }}">
                                                                    <button type="submit"
                                                                        class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-600 hover:bg-pink-50 hover:border-pink-300 hover:text-pink-600 cart-btn">
                                                                        <svg class="w-4 h-4" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M20 12H4"></path>
                                                                        </svg>
                                                                    </button>
                                                                </form>

                                                                <span
                                                                    class="w-10 text-center text-base font-medium">{{ $item['quantity'] }}</span>

                                                                <form method="POST" action="{{ route('cart.update') }}"
                                                                    class="update-cart-form">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="product_id"
                                                                        value="{{ $item['id'] }}">
                                                                    <input type="hidden" name="cart_action"
                                                                        value="increment">
                                                                    <input type="hidden" name="quantity"
                                                                        value="{{ $item['quantity'] }}">
                                                                    <button type="submit"
                                                                        class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-600 hover:bg-pink-50 hover:border-pink-300 hover:text-pink-600 cart-btn">
                                                                        <svg class="w-4 h-4" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M12 4v16m8-8H4"></path>
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                            </div>

                                                            <!-- Remove Button -->
                                                            <form method="POST" action="{{ route('cart.remove') }}"
                                                                class="remove-cart-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="product_id"
                                                                    value="{{ $item['id'] }}">
                                                                <button type="submit"
                                                                    class="text-red-500 hover:text-red-700 p-2 hover:bg-red-50 rounded-full cart-btn">
                                                                    <svg class="w-5 h-5" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                        </path>
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <!-- Item Total -->
                                                    <div class="mt-4 text-right">
                                                        <p class="text-sm text-gray-600">
                                                            Total: <span class="font-semibold text-pink-600">Rp
                                                                {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Continue Shopping -->
                                <div class="mt-8 pt-6 border-t border-gray-200">
                                    <a href="{{ route('products.index') }}"
                                        class="inline-flex items-center text-pink-600 hover:text-pink-700">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                        </svg>
                                        Continue Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 sticky top-24">
                            <div class="p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-6">Order Summary</h2>

                                <!-- Coupon Section -->
                                <div class="mb-6 pb-6 border-b border-gray-200">
                                    <form method="POST" action="{{ route('cart.apply-coupon') }}" class="coupon-form">
                                        @csrf
                                        <label for="coupon" class="block text-sm font-medium text-gray-700 mb-2">
                                            Coupon Code
                                        </label>
                                        <div class="flex gap-2">
                                            <input type="text" id="coupon" name="coupon" placeholder="Enter code"
                                                class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm">
                                            <button type="submit"
                                                class="bg-gray-100 hover:bg-pink-50 text-gray-800 hover:text-pink-600 font-medium px-4 rounded-lg text-sm transition-colors cart-btn">
                                                Apply
                                            </button>
                                        </div>
                                        @if (session('coupon_error'))
                                            <p class="mt-2 text-xs text-red-600">{{ session('coupon_error') }}</p>
                                        @endif
                                    </form>
                                </div>

                                <!-- Price Summary -->
                                <div class="space-y-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Subtotal</span>
                                        <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                    </div>

                                    @if (session('applied_coupon'))
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 flex items-center">
                                                Discount ({{ session('applied_coupon')['code'] }})
                                                <form action="{{ route('cart.remove-coupon') }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="ml-2 text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-50 transition-colors"
                                                        title="Remove coupon">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </span>
                                            <span class="font-medium text-green-600">- Rp
                                                {{ number_format($discount, 0, ',', '.') }}</span>
                                        </div>
                                    @endif

                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tax
                                            ({{ App\Models\Setting::get('tax_rate', 5) }}%)</span>
                                        <span class="font-medium">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                                    </div>

                                    <div class="pt-4 border-t border-gray-200">
                                        <div class="flex justify-between items-center">
                                            <span class="text-base font-semibold text-gray-900">Total</span>
                                            <span class="text-xl font-bold text-pink-600">Rp
                                                {{ number_format($total, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <!-- Checkout Button -->
                                    <div class="mt-6">
                                        <form method="GET" action="{{ route('checkout') }}">
                                            <button type="submit"
                                                class="w-full bg-pink-600 hover:bg-pink-700 text-white py-3 rounded-lg text-base font-semibold transition-colors cart-btn">
                                                Proceed to Checkout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Products By Category -->
                @if (count($products) > 0)
                    @php
                        $categoryIds = collect($products)
                            ->map(function ($item) {
                                return $item['product']->category_id ?? null;
                            })
                            ->filter()
                            ->unique()
                            ->values();

                        $relatedProducts = App\Models\DigitalProduct::whereIn('category_id', $categoryIds)
                            ->where('is_active', true)
                            ->whereNotIn('id', collect($products)->pluck('id'))
                            ->inRandomOrder()
                            ->limit(4)
                            ->get();
                    @endphp

                    @if ($relatedProducts->count() > 0)
                        <div class="mt-16">
                            <h2 class="text-2xl font-bold text-gray-900 mb-8">You May Also Like</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                @foreach ($relatedProducts as $product)
                                    <div
                                        class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 transition-all duration-300 hover:shadow-lg group">
                                        <div class="relative overflow-hidden aspect-w-16 aspect-h-9">
                                            <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->name }}"
                                                class="w-full h-48 object-cover object-center group-hover:scale-105 transition-transform duration-500">
                                            @if ($product->is_on_sale)
                                                <div
                                                    class="absolute top-0 left-0 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-br-lg">
                                                    SALE
                                                </div>
                                            @endif
                                            <div
                                                class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/70 to-transparent">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $product->category->name }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="p-4">
                                            <h3 class="text-lg font-medium text-gray-900 line-clamp-1 mb-2">
                                                {{ $product->name }}
                                            </h3>

                                            <div class="mt-2">
                                                @if ($product->is_on_sale)
                                                    <p class="text-sm text-gray-500 line-through">
                                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                                    </p>
                                                    <p class="text-lg font-bold text-pink-600">
                                                        Rp {{ number_format($product->sale_price, 0, ',', '.') }}
                                                    </p>
                                                @else
                                                    <p class="text-lg font-bold text-pink-600">
                                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                                    </p>
                                                @endif
                                            </div>

                                            <div class="mt-4">
                                                <a href="{{ route('products.show', $product) }}"
                                                    class="block text-center bg-pink-600 hover:bg-pink-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            @else
                <!-- Empty Cart -->
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="w-full max-w-md text-center">
                        <div class="mx-auto w-24 h-24 rounded-full bg-pink-100 flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-pink-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                        <p class="text-gray-500 mb-8">Start exploring our premium products to add to your cart</p>
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-pink-600 hover:bg-pink-700 text-white font-medium rounded-lg transition-colors">
                            Browse Products
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                // Show toast notification
                function showToast(message, type = 'success') {
                    Swal.mixin({
                        toast: true,
                        position: 'top',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    }).fire({
                        icon: type,
                        title: message
                    });
                }

                // Handle form submissions
                $('.update-cart-form, .remove-cart-form, .coupon-form').on('submit', function(e) {
                    e.preventDefault();

                    const form = $(this);
                    const formData = new FormData(form[0]);
                    const productId = form.find('input[name="product_id"]').val();

                    // Show loader for the specific product
                    if (productId) {
                        const cartItem = $(`.cart-item[data-product-id="${productId}"]`);
                        cartItem.addClass('opacity-50');
                        cartItem.find('.cart-btn').prop('disabled', true);
                    } else {
                        // For coupon forms
                        form.find('button[type="submit"]').prop('disabled', true);
                    }

                    // If it's a remove form, show confirmation dialog
                    if (form.hasClass('remove-cart-form')) {
                        Swal.fire({
                            title: 'Remove Item?',
                            text: "Are you sure you want to remove this item from your cart?",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#ec4899',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, remove it!',
                            cancelButtonText: 'No, keep it'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                submitForm(form, formData);
                            } else {
                                // Reset the UI
                                if (productId) {
                                    const cartItem = $(`.cart-item[data-product-id="${productId}"]`);
                                    cartItem.removeClass('opacity-50');
                                    cartItem.find('.cart-btn').prop('disabled', false);
                                } else {
                                    form.find('button[type="submit"]').prop('disabled', false);
                                }
                            }
                        });
                    } else {
                        submitForm(form, formData);
                    }
                });

                function submitForm(form, formData) {
                    $.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.success) {
                                showToast(response.message);

                                // Reload the page to update the cart
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                showToast(response.message, 'error');

                                // Reset the UI
                                const productId = form.find('input[name="product_id"]').val();
                                if (productId) {
                                    const cartItem = $(`.cart-item[data-product-id="${productId}"]`);
                                    cartItem.removeClass('opacity-50');
                                    cartItem.find('.cart-btn').prop('disabled', false);
                                } else {
                                    form.find('button[type="submit"]').prop('disabled', false);
                                }
                            }
                        },
                        error: function(xhr) {
                            let message = 'An error occurred. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            showToast(message, 'error');

                            // Reset the UI
                            const productId = form.find('input[name="product_id"]').val();
                            if (productId) {
                                const cartItem = $(`.cart-item[data-product-id="${productId}"]`);
                                cartItem.removeClass('opacity-50');
                                cartItem.find('.cart-btn').prop('disabled', false);
                            } else {
                                form.find('button[type="submit"]').prop('disabled', false);
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
