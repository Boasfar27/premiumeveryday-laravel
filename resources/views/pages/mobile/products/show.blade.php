@extends('pages.mobile.layouts.app')

@section('title', $product->name . ' - Premium Everyday')

@section('content')
    <div class="bg-white min-h-screen">
        <!-- Product Images Slider -->
        <div class="relative">
            <div class="swiper-container product-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                    </div>
                    @if ($product->gallery && count($product->gallery) > 0)
                        @foreach ($product->gallery as $image)
                            <div class="swiper-slide">
                                <img src="{{ asset($image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="swiper-pagination"></div>
            </div>

            <!-- Back Button -->
            <a href="{{ url()->previous() }}" class="absolute top-4 left-4 z-10 bg-white bg-opacity-70 p-2 rounded-full">
                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>

            <!-- Share Button -->
            <button class="absolute top-4 right-4 z-10 bg-white bg-opacity-70 p-2 rounded-full">
                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                    </path>
                </svg>
            </button>

            <!-- Product Badges -->
            <div class="absolute bottom-4 left-4 z-10 flex space-x-2">
                @if ($product->created_at > now()->subDays(7))
                    <span class="bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded">NEW</span>
                @endif

                @if ($product->is_promo && $product->promo_ends_at > now())
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">SALE</span>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="px-4 py-5">
            <!-- Category -->
            @if ($product->category)
                <div class="text-sm text-primary mb-1">{{ $product->category->name }}</div>
            @endif

            <!-- Product Name -->
            <h1 class="text-xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

            <!-- Rating -->
            <div class="flex items-center mb-3">
                <div class="flex">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    @endfor
                </div>
                <span class="text-xs text-gray-500 ml-1">({{ rand(10, 100) }} reviews)</span>
            </div>

            <!-- Price -->
            <div class="mb-4">
                @if ($product->is_promo && $product->promo_ends_at > now())
                    <div class="flex items-center">
                        <p class="text-sm text-gray-500 line-through mr-2">
                            Rp {{ number_format($product->sharing_price, 0, ',', '.') }}
                        </p>
                        <span
                            class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                            -{{ $product->sharing_discount }}%
                        </span>
                    </div>
                    <p class="text-xl font-bold text-primary">
                        Rp {{ number_format($product->actual_sharing_price, 0, ',', '.') }}
                    </p>
                    <div class="text-xs text-red-600 mt-1">
                        Sale ends in: <span id="countdown-mobile">Loading...</span>
                    </div>
                @else
                    <p class="text-xl font-bold text-gray-900">
                        Rp {{ number_format($product->sharing_price, 0, ',', '.') }}
                    </p>
                @endif
            </div>

            <!-- Quantity Selector -->
            <div class="flex items-center mt-4">
                <div class="flex items-center border border-gray-300 rounded-md">
                    <button type="button" class="p-1 text-gray-500" onclick="decrementQuantityMobile()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>
                    <input type="number" id="product-quantity-mobile" name="quantity" min="1" value="1"
                        class="w-10 text-center border-0 focus:ring-0 text-sm">
                    <button type="button" class="p-1 text-gray-500" onclick="incrementQuantityMobile()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                </div>
                <button type="button" onclick="addToCartMobile({{ $product->id }})"
                    class="ml-4 flex-1 bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded-md text-sm font-medium transition-colors">
                    Add to Cart
                </button>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="border-t border-gray-200" x-data="{ activeTab: 'description' }">
            <!-- Tab Navigation -->
            <div class="flex border-b border-gray-200">
                <button @click="activeTab = 'description'"
                    :class="{ 'border-primary text-primary': activeTab === 'description', 'border-transparent text-gray-500': activeTab !== 'description' }"
                    class="flex-1 py-3 text-center text-sm font-medium border-b-2">
                    Description
                </button>
                <button @click="activeTab = 'features'"
                    :class="{ 'border-primary text-primary': activeTab === 'features', 'border-transparent text-gray-500': activeTab !== 'features' }"
                    class="flex-1 py-3 text-center text-sm font-medium border-b-2">
                    Features
                </button>
                <button @click="activeTab = 'reviews'"
                    :class="{ 'border-primary text-primary': activeTab === 'reviews', 'border-transparent text-gray-500': activeTab !== 'reviews' }"
                    class="flex-1 py-3 text-center text-sm font-medium border-b-2">
                    Reviews
                </button>
            </div>

            <!-- Tab Content -->
            <div class="px-4 py-5">
                <!-- Description Tab -->
                <div x-show="activeTab === 'description'" class="text-sm text-gray-600">
                    <p>{{ $product->description }}</p>

                    @if ($product->version)
                        <div class="mt-4 flex">
                            <span class="text-xs font-medium text-gray-900">Version:</span>
                            <span class="ml-2 text-xs text-gray-500">{{ $product->version }}</span>
                        </div>
                    @endif
                </div>

                <!-- Features Tab -->
                <div x-show="activeTab === 'features'" class="text-sm text-gray-600">
                    @if ($product->features)
                        <ul class="space-y-3">
                            @foreach (explode("\n", $product->features) as $feature)
                                <li class="flex items-start">
                                    <svg class="h-4 w-4 text-green-500 mt-0.5 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="ml-2">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No features specified for this product.</p>
                    @endif

                    @if ($product->requirements)
                        <div class="mt-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Requirements</h3>
                            <ul class="space-y-3">
                                @foreach (explode("\n", $product->requirements) as $requirement)
                                    <li class="flex items-start">
                                        <svg class="h-4 w-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="ml-2">{{ $requirement }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Reviews Tab -->
                <div x-show="activeTab === 'reviews'" class="text-sm text-gray-600">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-medium text-gray-900">Customer Reviews</h3>
                        <button type="button" class="text-xs text-primary font-medium">Write a Review</button>
                    </div>

                    <!-- Sample Reviews -->
                    <div class="space-y-4">
                        <div class="border-b border-gray-200 pb-4">
                            <div class="flex items-center mb-2">
                                <div class="flex">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= 5 ? 'text-yellow-400' : 'text-gray-300' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="ml-2 text-xs text-gray-500">John D. • 2 weeks ago</p>
                            </div>
                            <p class="text-xs">This product exceeded my expectations! The quality is outstanding and it has
                                all the features I needed.</p>
                        </div>

                        <div class="border-b border-gray-200 pb-4">
                            <div class="flex items-center mb-2">
                                <div class="flex">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="ml-2 text-xs text-gray-500">Jane S. • 1 month ago</p>
                            </div>
                            <p class="text-xs">Great product for the price. Fast delivery and excellent customer service.
                            </p>
                        </div>

                        <button type="button"
                            class="w-full py-2 text-xs text-primary font-medium text-center border border-gray-200 rounded-md">
                            Load More Reviews
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if (isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="mt-6 px-4 pb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4">You May Also Like</h2>

                <div class="grid grid-cols-2 gap-3">
                    @foreach ($relatedProducts->take(4) as $relatedProduct)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                            <div class="aspect-w-1 aspect-h-1">
                                <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="p-2">
                                <h3 class="text-xs font-medium text-gray-900 line-clamp-1">
                                    {{ $relatedProduct->name }}
                                </h3>
                                <p class="text-sm font-bold text-gray-900 mt-1">
                                    Rp {{ number_format($relatedProduct->current_price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Sticky Buy Now Bar -->
        <div
            class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-3 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Price</p>
                @if (
                    $product->is_on_promotion &&
                        $product->promotion_price > 0 &&
                        now()->between($product->promotion_start_date, $product->promotion_end_date))
                    <p class="text-base font-bold text-gray-900">Rp
                        {{ number_format($product->promotion_price, 0, ',', '.') }}</p>
                @else
                    <p class="text-base font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                @endif
            </div>
            <button type="button" onclick="addToCartMobile({{ $product->id }})"
                class="bg-primary hover:bg-primary-dark text-white py-2 px-6 rounded-md text-sm font-medium transition-colors">
                Buy Now
            </button>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Swiper
            new Swiper('.product-slider', {
                pagination: {
                    el: '.swiper-pagination',
                    dynamicBullets: true,
                },
            });

            // Quantity functions
            window.incrementQuantityMobile = function() {
                const input = document.getElementById('product-quantity-mobile');
                input.value = parseInt(input.value) + 1;
            }

            window.decrementQuantityMobile = function() {
                const input = document.getElementById('product-quantity-mobile');
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            }

            // Countdown timer for promo
            @if ($product->is_promo && $product->promo_ends_at > now())
                const countDownDate = new Date("{{ $product->promo_ends_at->format('Y-m-d H:i:s') }}").getTime();

                const countdownTimer = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = countDownDate - now;

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById("countdown-mobile").innerHTML = days + "d " + hours + "h " +
                        minutes + "m " + seconds + "s";

                    if (distance < 0) {
                        clearInterval(countdownTimer);
                        document.getElementById("countdown-mobile").innerHTML = "EXPIRED";
                    }
                }, 1000);
            @endif
        });

        function addToCartMobile(productId) {
            const quantity = document.getElementById('product-quantity-mobile').value;

            fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        Swal.fire({
                            title: 'Success!',
                            text: 'Product added to cart',
                            icon: 'success',
                            confirmButtonText: 'Continue Shopping',
                            showCancelButton: true,
                            cancelButtonText: 'View Cart'
                        }).then((result) => {
                            if (!result.isConfirmed) {
                                window.location.href = '{{ route('cart.index') }}';
                            }
                        });

                        // Update cart count in header if exists
                        const cartCountElement = document.getElementById('cart-count-mobile');
                        if (cartCountElement) {
                            cartCountElement.textContent = data.cart_count;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to add product to cart',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
        .swiper-container {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            background: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-pagination-bullet-active {
            background-color: #ec4899 !important;
        }
    </style>
@endpush
