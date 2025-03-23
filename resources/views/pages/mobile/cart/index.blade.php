@extends('pages.mobile.layouts.app')

@section('title', 'Shopping Cart - Premium Everyday')

@section('content')
    <div class="bg-gray-50 min-h-screen pb-24">
        <!-- Header -->
        <div class="bg-white px-4 py-4 border-b border-gray-200 sticky top-0 z-10 shadow-sm">
            <div class="flex items-center justify-between">
                <a href="{{ url()->previous() }}" class="text-gray-500 hover:bg-gray-100 p-2 rounded-full transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-lg font-bold text-gray-900">Shopping Cart</h1>
                <div class="w-10"></div>
            </div>
        </div>

        @if (session('success'))
            <div class="mx-4 my-2 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mx-4 my-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if (count($products) > 0)
            <!-- Cart Items -->
            <div class="px-4 py-4">
                <div class="space-y-3">
                    @foreach ($products as $item)
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 cart-item animate__animated animate__fadeIn"
                            data-product-id="{{ $item['id'] }}">
                            <div class="p-4">
                                <div class="flex gap-3">
                                    <!-- Product Image -->
                                    <div class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden">
                                        <img src="{{ $item['product']->thumbnail_url ?? asset($item['product']->thumbnail) }}"
                                            alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between">
                                            <div>
                                                <h3 class="text-sm font-medium text-gray-900 line-clamp-1">
                                                    {{ $item['product']->name }}</h3>
                                                <p class="mt-1 text-xs text-gray-500">
                                                    {{ ucfirst($item['subscription_type'] ?? 'monthly') }} |
                                                    {{ $item['duration'] ?? 1 }}
                                                    {{ Str::plural('Month', $item['duration']) }} |
                                                    {{ ucfirst($item['account_type'] ?? 'sharing') }} Account
                                                </p>
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                                    {{ $item['product']->category->name ?? 'Digital Product' }}
                                                </span>
                                            </div>

                                            <!-- Remove Button -->
                                            <form method="POST" action="{{ route('cart.remove') }}"
                                                class="remove-cart-form">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                                <button type="submit" class="text-red-500 p-1 cart-btn">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Price -->
                                        <div class="mt-2">
                                            @if (isset($item['discounted_price']))
                                                <p class="text-xs text-gray-500 line-through">
                                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                </p>
                                                <p class="text-sm font-semibold text-primary">
                                                    Rp {{ number_format($item['discounted_price'], 0, ',', '.') }}
                                                </p>
                                            @else
                                                <p class="text-sm font-semibold text-primary">
                                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100">
                                    <!-- Quantity Controls -->
                                    <div class="flex items-center space-x-1">
                                        <form method="POST" action="{{ route('cart.update') }}" class="update-cart-form">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                            <input type="hidden" name="cart_action" value="decrement">
                                            <input type="hidden" name="quantity" value="{{ $item['quantity'] }}">
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 cart-btn">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                        </form>

                                        <span class="w-8 text-center text-sm font-medium">{{ $item['quantity'] }}</span>

                                        <form method="POST" action="{{ route('cart.update') }}" class="update-cart-form">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                            <input type="hidden" name="cart_action" value="increment">
                                            <input type="hidden" name="quantity" value="{{ $item['quantity'] }}">
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 cart-btn">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Item Total -->
                                    <div class="text-right">
                                        <p class="text-sm text-gray-900 font-medium">
                                            Total: <span class="font-semibold text-primary">Rp
                                                {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Continue Shopping -->
                <div class="mt-4 mb-8">
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center text-primary hover:text-primary-dark text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-t-xl shadow-sm">
                <!-- Coupon Section -->
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-900 mb-3">Have a Coupon?</h3>
                    <form method="POST" action="{{ route('cart.apply-coupon') }}" class="coupon-form">
                        @csrf
                        <div class="flex gap-2">
                            <input type="text" id="coupon_code" name="coupon_code" placeholder="Enter coupon code"
                                class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                            <button type="submit"
                                class="bg-primary hover:bg-primary-dark text-white px-4 rounded-lg text-sm font-medium transition-colors cart-btn">
                                Apply
                            </button>
                        </div>
                        @if (session('error'))
                            <p class="mt-2 text-xs text-red-600">{{ session('error') }}</p>
                        @endif
                    </form>
                </div>

                <!-- Price Summary -->
                <div class="p-4 space-y-3">
                    <h3 class="text-base font-semibold text-gray-900 mb-3">Order Summary</h3>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    @if (session('coupon'))
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 flex items-center">
                                Discount ({{ session('coupon')['code'] }})
                                <form action="{{ route('cart.remove-coupon') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="ml-2 text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-50 transition-colors"
                                        title="Remove coupon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            </span>
                            <span class="font-medium text-green-600">- Rp
                                {{ number_format(session('coupon')['discount'], 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax ({{ App\Models\Setting::get('tax_rate', 5) }}%)</span>
                        <span class="font-medium">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                    </div>

                    <div class="pt-3 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-semibold text-gray-900">Total</span>
                            <span class="text-xl font-bold text-primary">Rp
                                {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkout Button -->
            <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t border-gray-200 shadow-lg z-10">
                <form method="GET" action="{{ route('checkout') }}">
                    <button type="submit"
                        class="w-full bg-primary hover:bg-primary-dark text-white py-3 rounded-lg text-base font-semibold transition-colors cart-btn">
                        Proceed to Checkout
                    </button>
                </form>
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
                    <div class="mt-6 px-4 pb-28">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">You May Also Like</h2>

                        <div class="overflow-x-auto pb-4 hide-scrollbar">
                            <div class="flex gap-3 w-max">
                                @foreach ($relatedProducts as $product)
                                    <div class="w-48 flex-shrink-0 bg-white rounded-xl shadow-md overflow-hidden">
                                        <div class="relative">
                                            <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->name }}"
                                                class="w-full h-32 object-cover">
                                            @if ($product->is_on_sale)
                                                <div
                                                    class="absolute top-0 left-0 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-br-lg">
                                                    SALE
                                                </div>
                                            @endif
                                            <div
                                                class="absolute bottom-0 left-0 right-0 p-2 bg-gradient-to-t from-black/70 to-transparent">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $product->category->name }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="p-3">
                                            <h3 class="text-sm font-medium text-gray-900 line-clamp-1">
                                                {{ $product->name }}
                                            </h3>

                                            <div class="mt-2 flex justify-between items-end">
                                                <div>
                                                    @if ($product->is_on_sale)
                                                        <p class="text-xs text-gray-500 line-through">
                                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                                        </p>
                                                        <p class="text-sm font-bold text-primary">
                                                            Rp {{ number_format($product->sale_price, 0, ',', '.') }}
                                                        </p>
                                                    @else
                                                        <p class="text-sm font-bold text-primary">
                                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <a href="{{ route('products.show', $product) }}"
                                                    class="block text-center bg-primary hover:bg-primary-dark text-white py-2 rounded-lg text-xs font-medium transition-colors">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        @else
            <!-- Empty Cart -->
            <div class="flex flex-col items-center justify-center px-4 py-12">
                <div class="w-full max-w-sm text-center">
                    <div class="mx-auto w-20 h-20 rounded-full bg-pink-100 flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                    <p class="text-gray-500 mb-6">Start exploring our premium products to add to your cart</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-pink-600 hover:bg-pink-700 text-white font-medium rounded-lg transition-colors">
                        Browse Products
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>
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
