@extends('pages.desktop.layouts.app')

@section('title', 'Shopping Cart - Premium Everyday')

@section('content')
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items (2/3 width on large screens) -->
                <div class="lg:col-span-2">
                    <!-- Cart Items Table -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        @if (count($products) > 0)
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Product
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Price
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Quantity
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($products as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-md overflow-hidden">
                                                        <img src="{{ $item['product']->thumbnail_url }}"
                                                            alt="{{ $item['product']->name }}"
                                                            class="h-full w-full object-cover">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $item['product']->name }}</div>
                                                        <div class="text-xs text-gray-500">Digital Download</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Rp
                                                    {{ number_format($item['product']->getDiscountedPrice(), 0, ',', '.') }}
                                                </div>
                                                @if ($item['product']->is_on_sale && $item['product']->sale_price < $item['product']->price)
                                                    <div class="text-xs text-green-600">Save Rp
                                                        {{ number_format($item['product']->price - $item['product']->sale_price, 0, ',', '.') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center border border-gray-300 rounded-md w-24">
                                                    <button type="button" class="p-1 text-gray-500 hover:text-primary"
                                                        onclick="decrementCartQuantity('{{ $item['id'] }}')">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    <input type="number" id="cart-quantity-{{ $item['id'] }}"
                                                        name="quantity" min="1" value="{{ $item['quantity'] }}"
                                                        class="w-10 text-center border-0 focus:ring-0">
                                                    <button type="button" class="p-1 text-gray-500 hover:text-primary"
                                                        onclick="incrementCartQuantity('{{ $item['id'] }}')">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                Rp {{ number_format($item['total'], 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button" class="text-red-600 hover:text-red-900"
                                                    onclick="removeCartItem('{{ $item['id'] }}')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Your cart is empty</h3>
                                <p class="mt-1 text-sm text-gray-500">Start shopping to add items to your cart.</p>
                                <div class="mt-6">
                                    <a href="{{ route('products.index') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
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

                    @if (count($products) > 0)
                        <!-- Continue Shopping Button -->
                        <div class="mt-6">
                            <a href="{{ route('products.index') }}"
                                class="inline-flex items-center text-primary hover:text-primary-dark">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Continue Shopping
                            </a>
                        </div>
                    @endif
                </div>

                @if (count($products) > 0)
                    <!-- Order Summary (1/3 width on large screens) -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>

                            <!-- Subtotal -->
                            <div class="flex justify-between py-2 text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-gray-900 font-medium">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>

                            <!-- Discount -->
                            <div class="flex justify-between py-2 text-sm">
                                <span class="text-gray-600">Discount</span>
                                <span class="text-green-600">- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                            </div>

                            <!-- Tax -->
                            <div class="flex justify-between py-2 text-sm">
                                <span class="text-gray-600">Tax (11%)</span>
                                <span class="text-gray-900 font-medium">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                            </div>

                            <!-- Total -->
                            <div class="flex justify-between py-2 border-t border-gray-200 mt-2 mb-4">
                                <span class="text-base font-medium text-gray-900">Total</span>
                                <span class="text-base font-bold text-gray-900">Rp
                                    {{ number_format($total, 0, ',', '.') }}</span>
                            </div>

                            <!-- Coupon Code -->
                            <div class="mb-4">
                                <label for="coupon" class="block text-sm font-medium text-gray-700 mb-1">Coupon
                                    Code</label>
                                <div class="flex">
                                    <input type="text" id="coupon" name="coupon"
                                        class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm"
                                        placeholder="Enter coupon code">
                                    <button type="button" onclick="applyCoupon()"
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-r-md border border-gray-300 border-l-0 text-sm transition-colors">
                                        Apply
                                    </button>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <button type="button" onclick="proceedToCheckout()"
                                class="w-full bg-primary hover:bg-primary-dark text-white py-3 px-4 rounded-md font-medium transition-colors">
                                Proceed to Checkout
                            </button>

                            <!-- Secure Checkout Message -->
                            <div class="flex items-center justify-center mt-4 text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                Secure Checkout
                            </div>

                            <!-- Payment Methods -->
                            <div class="mt-4 flex justify-center space-x-2">
                                <img src="{{ asset('images/payment/visa.png') }}" alt="Visa" class="h-6">
                                <img src="{{ asset('images/payment/mastercard.png') }}" alt="Mastercard" class="h-6">
                                <img src="{{ asset('images/payment/paypal.png') }}" alt="PayPal" class="h-6">
                                <img src="{{ asset('images/payment/bank-transfer.png') }}" alt="Bank Transfer"
                                    class="h-6">
                            </div>
                        </div>

                        <!-- Recently Viewed Products -->
                        @if ($recentProducts && $recentProducts->count() > 0)
                            <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Recently Viewed</h2>

                                <div class="space-y-4">
                                    @foreach ($recentProducts as $recentProduct)
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-md overflow-hidden">
                                                <img src="{{ $recentProduct->thumbnail_url }}"
                                                    alt="{{ $recentProduct->name }}" class="h-full w-full object-cover">
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <h3 class="text-sm font-medium text-gray-900">{{ $recentProduct->name }}
                                                </h3>
                                                <p class="text-sm font-bold text-gray-900 mt-1">Rp
                                                    {{ number_format($recentProduct->getDiscountedPrice(), 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <button type="button"
                                                onclick="addToCartFromRecent('{{ $recentProduct->id }}')"
                                                class="ml-4 text-primary hover:text-primary-dark">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function incrementCartQuantity(id) {
            const input = document.getElementById('cart-quantity-' + id);
            input.value = parseInt(input.value) + 1;
            updateCartItem(id, input.value);
        }

        function decrementCartQuantity(id) {
            const input = document.getElementById('cart-quantity-' + id);
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateCartItem(id, input.value);
            }
        }

        function updateCartItem(id, quantity) {
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

        function removeCartItem(id) {
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

        function applyCoupon() {
            const couponCode = document.getElementById('coupon').value;

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

        function addToCartFromRecent(productId) {
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

        function proceedToCheckout() {
            // Redirect to checkout page
            window.location.href = '{{ route('user.orders.create') }}';
        }
    </script>
@endpush
