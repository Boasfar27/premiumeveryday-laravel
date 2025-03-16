@extends('pages.mobile.layouts.app')

@section('title', 'Shopping Cart - Premium Everyday')

@section('content')
    <div class="bg-white min-h-screen pb-24">
        <!-- Header -->
        <div class="bg-white px-4 py-4 border-b border-gray-200 sticky top-0 z-10">
            <div class="flex items-center justify-between">
                <a href="{{ url()->previous() }}" class="text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-lg font-bold text-gray-900">Shopping Cart</h1>
                <div class="w-6"></div> <!-- Empty div for alignment -->
            </div>
        </div>

        @if (count($products) > 0)
            <!-- Cart Items -->
            <div class="px-4 py-4">
                @foreach ($products as $item)
                    <div class="flex py-4 border-b border-gray-200">
                        <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                            <img src="{{ $item['product']->thumbnail_url }}" alt="{{ $item['product']->name }}"
                                class="h-full w-full object-cover object-center">
                        </div>
                        <div class="ml-4 flex flex-1 flex-col">
                            <div>
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <h3 class="pr-2">{{ $item['product']->name }}</h3>
                                    <p class="ml-4">Rp
                                        {{ number_format($item['product']->getDiscountedPrice(), 0, ',', '.') }}</p>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Digital Download</p>
                            </div>
                            <div class="flex flex-1 items-end justify-between text-sm">
                                <div class="flex items-center border border-gray-300 rounded-md">
                                    <button type="button" class="p-1 text-gray-500"
                                        onclick="decrementCartQuantityMobile('{{ $item['id'] }}')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <input type="number" id="cart-quantity-mobile-{{ $item['id'] }}" name="quantity"
                                        min="1" value="{{ $item['quantity'] }}"
                                        class="w-8 text-center border-0 focus:ring-0 text-sm">
                                    <button type="button" class="p-1 text-gray-500"
                                        onclick="incrementCartQuantityMobile('{{ $item['id'] }}')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex">
                                    <button type="button" class="font-medium text-red-600 hover:text-red-500"
                                        onclick="removeCartItemMobile('{{ $item['id'] }}')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Continue Shopping Button -->
                <div class="mt-4">
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center text-primary hover:text-primary-dark text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Coupon Code -->
            <div class="px-4 py-4 bg-gray-50">
                <div class="flex">
                    <input type="text" id="coupon-mobile" name="coupon"
                        class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm"
                        placeholder="Enter coupon code">
                    <button type="button" onclick="applyCouponMobile()"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-r-md border border-gray-300 border-l-0 text-sm transition-colors">
                        Apply
                    </button>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="px-4 py-4">
                <h2 class="text-base font-medium text-gray-900 mb-4">Order Summary</h2>

                <div class="space-y-2">
                    <!-- Subtotal -->
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="text-gray-900 font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <!-- Discount -->
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Discount</span>
                        <span class="text-green-600">- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                    </div>

                    <!-- Tax -->
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax (11%)</span>
                        <span class="text-gray-900 font-medium">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                    </div>

                    <!-- Total -->
                    <div class="flex justify-between pt-2 border-t border-gray-200 mt-2">
                        <span class="text-base font-medium text-gray-900">Total</span>
                        <span class="text-base font-bold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Recently Viewed Products -->
            @if ($recentProducts && $recentProducts->count() > 0)
                <div class="px-4 py-4 bg-gray-50">
                    <h2 class="text-base font-medium text-gray-900 mb-4">Recently Viewed</h2>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach ($recentProducts->take(2) as $recentProduct)
                            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                                <div class="aspect-w-1 aspect-h-1">
                                    <img src="{{ $recentProduct->thumbnail_url }}" alt="{{ $recentProduct->name }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="p-2">
                                    <h3 class="text-xs font-medium text-gray-900 line-clamp-1">{{ $recentProduct->name }}
                                    </h3>
                                    <p class="text-sm font-bold text-gray-900 mt-1">Rp
                                        {{ number_format($recentProduct->getDiscountedPrice(), 0, ',', '.') }}</p>
                                    <button type="button"
                                        onclick="addToCartFromRecentMobile('{{ $recentProduct->id }}')"
                                        class="mt-1 w-full text-xs text-primary border border-primary rounded-md py-1">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Sticky Checkout Bar -->
            <div
                class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-3 flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Total</p>
                    <p class="text-base font-bold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</p>
                </div>
                <button type="button" onclick="proceedToCheckoutMobile()"
                    class="bg-primary hover:bg-primary-dark text-white py-2 px-6 rounded-md text-sm font-medium transition-colors">
                    Checkout
                </button>
            </div>
        @else
            <!-- Empty Cart State -->
            <div class="px-4 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Your cart is empty</h3>
                <p class="mt-1 text-sm text-gray-500">Start shopping to add items to your cart.</p>
                <div class="mt-6">
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Browse Products
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function incrementCartQuantityMobile(id) {
            const input = document.getElementById('cart-quantity-mobile-' + id);
            input.value = parseInt(input.value) + 1;
            updateCartItemMobile(id, input.value);
        }

        function decrementCartQuantityMobile(id) {
            const input = document.getElementById('cart-quantity-mobile-' + id);
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateCartItemMobile(id, input.value);
            }
        }

        function updateCartItemMobile(id, quantity) {
            fetch('{{ route('cart.update') }}', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: id,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page to update totals
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update cart',
                        confirmButtonText: 'OK'
                    });
                });
        }

        function removeCartItemMobile(id) {
            Swal.fire({
                title: 'Remove item?',
                text: 'Are you sure you want to remove this item from your cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove it',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ route('cart.remove') }}', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: id
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Reload the page to update cart
                                window.location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to remove item from cart',
                                confirmButtonText: 'OK'
                            });
                        });
                }
            });
        }

        function applyCouponMobile() {
            const couponCode = document.getElementById('coupon-mobile').value;

            if (!couponCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Empty Coupon',
                    text: 'Please enter a coupon code',
                    confirmButtonText: 'OK'
                });
                return;
            }

            fetch('{{ route('cart.apply-coupon') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        coupon: couponCode
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Reload the page to update totals
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to apply coupon',
                        confirmButtonText: 'OK'
                    });
                });
        }

        function addToCartFromRecentMobile(productId) {
            fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Product added to cart',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Reload the page to update cart
                            window.location.reload();
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to add product to cart',
                        confirmButtonText: 'OK'
                    });
                });
        }

        function proceedToCheckoutMobile() {
            // Redirect to checkout page
            window.location.href = '{{ route('user.orders.create') }}';
        }
    </script>
@endpush
