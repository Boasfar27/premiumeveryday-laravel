@extends('pages.desktop.layouts.app')

@section('title', $product->name . ' - Premium Everyday')

@section('content')
    <div class="bg-white py-16 pt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary">
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('products.index') }}"
                                class="text-gray-500 hover:text-primary ml-1 md:ml-2">Products</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-500 ml-1 md:ml-2">{{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Product Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div>
                    <div class="bg-gray-100 rounded-lg overflow-hidden mb-4">
                        <img id="main-image" src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="w-full h-auto object-cover">
                    </div>

                    @if ($product->gallery && count($product->gallery) > 0)
                        <div class="grid grid-cols-5 gap-2">
                            <div class="cursor-pointer rounded-md overflow-hidden border-2 border-primary">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                    class="w-full h-auto object-cover thumbnail-image" onclick="changeMainImage(this.src)">
                            </div>
                            @foreach ($product->gallery as $image)
                                <div
                                    class="cursor-pointer rounded-md overflow-hidden border-2 border-transparent hover:border-primary">
                                    <img src="{{ asset($image) }}" alt="{{ $product->name }}"
                                        class="w-full h-auto object-cover thumbnail-image"
                                        onclick="changeMainImage(this.src)">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div>
                    @if ($product->category)
                        <div class="text-sm text-primary mb-2">{{ $product->category->name }}</div>
                    @endif

                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                    <!-- Rating -->
                    <div class="flex items-center mb-4">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                        <span class="text-sm text-gray-500 ml-2">({{ rand(10, 100) }} reviews)</span>
                    </div>

                    <!-- Price -->
                    <div class="mb-6">
                        @if ($product->is_promo && $product->promo_ends_at > now())
                            <div class="flex items-center">
                                <p class="text-lg text-gray-500 line-through mr-2">
                                    Rp {{ number_format($product->sharing_price, 0, ',', '.') }}
                                </p>
                                <span
                                    class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                    -{{ $product->sharing_discount }}%
                                </span>
                            </div>
                            <p class="text-3xl font-bold text-primary">
                                Rp {{ number_format($product->actual_sharing_price, 0, ',', '.') }}
                            </p>
                            <div class="text-sm text-red-600 mt-1">
                                Sale ends in: <span id="countdown">Loading...</span>
                            </div>
                        @else
                            <p class="text-3xl font-bold text-gray-900">
                                Rp {{ number_format($product->sharing_price, 0, ',', '.') }}
                            </p>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="prose prose-sm text-gray-500 mb-6">
                        <p>{{ $product->description }}</p>
                    </div>

                    <!-- Version -->
                    @if ($product->version)
                        <div class="mb-6">
                            <span class="text-sm font-medium text-gray-900">Version:</span>
                            <span class="ml-2 text-sm text-gray-500">{{ $product->version }}</span>
                        </div>
                    @endif

                    <!-- Add to Cart -->
                    <div class="mt-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center border border-gray-300 rounded-md">
                                <button type="button" class="p-2 text-gray-500" onclick="decrementQuantity()">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                        </path>
                                    </svg>
                                </button>
                                <input type="number" id="product-quantity" name="quantity" min="1" value="1"
                                    class="w-12 text-center border-0 focus:ring-0">
                                <button type="button" class="p-2 text-gray-500" onclick="incrementQuantity()">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                            <button type="button" onclick="addToCart({{ $product->id }})"
                                class="flex-1 bg-primary hover:bg-primary-dark text-white py-3 px-6 rounded-md font-medium transition-colors">
                                Add to Cart
                            </button>
                            <button type="button"
                                class="p-3 text-gray-500 hover:text-primary border border-gray-300 rounded-md transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Product Meta -->
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1.5 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            In stock and ready to ship
                        </div>

                        <div class="flex items-center mt-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Usually ships within 24 hours
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Tabs -->
            <div class="mt-16" x-data="{ activeTab: 'features' }">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px space-x-8">
                        <button @click="activeTab = 'features'"
                            :class="{ 'border-primary text-primary': activeTab === 'features', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'features' }"
                            class="py-4 px-1 border-b-2 font-medium text-sm">
                            Features
                        </button>
                        <button @click="activeTab = 'requirements'"
                            :class="{ 'border-primary text-primary': activeTab === 'requirements', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'requirements' }"
                            class="py-4 px-1 border-b-2 font-medium text-sm">
                            Requirements
                        </button>
                        <button @click="activeTab = 'reviews'"
                            :class="{ 'border-primary text-primary': activeTab === 'reviews', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'reviews' }"
                            class="py-4 px-1 border-b-2 font-medium text-sm">
                            Reviews
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="py-6">
                    <!-- Features Tab -->
                    <div x-show="activeTab === 'features'" class="prose prose-sm max-w-none text-gray-500">
                        @if ($product->features)
                            <ul class="space-y-4">
                                @foreach (explode("\n", $product->features) as $feature)
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-green-500 mt-0.5 flex-shrink-0" fill="none"
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
                    </div>

                    <!-- Requirements Tab -->
                    <div x-show="activeTab === 'requirements'" class="prose prose-sm max-w-none text-gray-500">
                        @if ($product->requirements)
                            <ul class="space-y-4">
                                @foreach (explode("\n", $product->requirements) as $requirement)
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="ml-2">{{ $requirement }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No requirements specified for this product.</p>
                        @endif
                    </div>

                    <!-- Reviews Tab -->
                    <div x-show="activeTab === 'reviews'" class="prose prose-sm max-w-none text-gray-500">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <div class="lg:col-span-1">
                                <div class="text-center p-6 bg-gray-50 rounded-lg">
                                    <div class="text-4xl font-bold text-primary mb-2">4.5</div>
                                    <div class="flex justify-center mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <p class="text-sm text-gray-500">Based on {{ rand(50, 200) }} reviews</p>

                                    <button type="button"
                                        class="mt-4 inline-flex items-center px-4 py-2 border border-primary text-sm font-medium rounded-md text-primary hover:bg-primary-50 transition">
                                        Write a Review
                                    </button>
                                </div>
                            </div>

                            <div class="lg:col-span-2">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Reviews</h3>

                                <div class="space-y-4">
                                    @if (isset($feedback) && $feedback->count() > 0)
                                        @foreach ($feedback as $review)
                                            <div class="border-b border-gray-200 pb-4">
                                                <div class="flex items-center mb-2">
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary font-bold">
                                                            {{ substr($review->name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h4 class="text-sm font-medium text-gray-900">{{ $review->name }}
                                                        </h4>
                                                        <div class="flex items-center">
                                                            <div class="flex">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                        fill="currentColor" viewBox="0 0 20 20">
                                                                        <path
                                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                    </svg>
                                                                @endfor
                                                            </div>
                                                            <span
                                                                class="text-xs text-gray-500 ml-2">{{ $review->created_at->diffForHumans() }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-sm text-gray-600">{{ $review->content }}</p>
                                            </div>
                                        @endforeach
                                        <button type="button"
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                                            Load More Reviews
                                        </button>
                                    @else
                                        <div class="border-b border-gray-200 pb-4">
                                            <div class="flex items-center mb-2">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary font-bold">
                                                        J
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <h4 class="text-sm font-medium text-gray-900">John Doe</h4>
                                                    <div class="flex items-center">
                                                        <div class="flex">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <svg class="w-4 h-4 {{ $i <= 5 ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @endfor
                                                        </div>
                                                        <span class="text-xs text-gray-500 ml-2">2 weeks ago</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-600">This product exceeded my expectations! The
                                                quality
                                                is outstanding and it has all the features I needed.</p>
                                        </div>

                                        <div class="border-b border-gray-200 pb-4">
                                            <div class="flex items-center mb-2">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary font-bold">
                                                        J
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <h4 class="text-sm font-medium text-gray-900">Jane Smith</h4>
                                                    <div class="flex items-center">
                                                        <div class="flex">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <svg class="w-4 h-4 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @endfor
                                                        </div>
                                                        <span class="text-xs text-gray-500 ml-2">1 month ago</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-600">Great product for the price. Fast delivery and
                                                excellent customer service.</p>
                                        </div>

                                        <button type="button"
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                                            Load More Reviews
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if (isset($relatedProducts) && $relatedProducts->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">You May Also Like</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div
                                class="group relative bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                                <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-t-lg bg-gray-200">
                                    <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}"
                                        class="h-full w-full object-cover object-center group-hover:opacity-75 transition-opacity">
                                </div>
                                <div class="p-4">
                                    <h3 class="text-sm font-medium text-gray-900 mb-1">
                                        <a href="{{ route('products.show', $relatedProduct) }}"
                                            class="hover:text-primary">
                                            {{ $relatedProduct->name }}
                                        </a>
                                    </h3>
                                    <p class="text-base font-bold text-gray-900">
                                        Rp {{ number_format($relatedProduct->current_price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function changeMainImage(src) {
            document.getElementById('main-image').src = src;

            // Update border of selected thumbnail
            const thumbnails = document.querySelectorAll('.thumbnail-image');
            thumbnails.forEach(thumbnail => {
                const parentDiv = thumbnail.parentElement;
                if (thumbnail.src === src) {
                    parentDiv.classList.add('border-primary');
                    parentDiv.classList.remove('border-transparent');
                } else {
                    parentDiv.classList.remove('border-primary');
                    parentDiv.classList.add('border-transparent');
                }
            });
        }

        function incrementQuantity() {
            const input = document.getElementById('product-quantity');
            input.value = parseInt(input.value) + 1;
        }

        function decrementQuantity() {
            const input = document.getElementById('product-quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function addToCart(productId) {
            const quantity = document.getElementById('product-quantity').value;

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
                        const cartCountElement = document.getElementById('cart-count');
                        if (cartCountElement) {
                            cartCountElement.textContent = data.cart_count;
                        }
                    } else {
                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Failed to add product to cart',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
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

        document.addEventListener('DOMContentLoaded', function() {
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

                    document.getElementById("countdown").innerHTML = days + "d " + hours + "h " +
                        minutes + "m " + seconds + "s";

                    if (distance < 0) {
                        clearInterval(countdownTimer);
                        document.getElementById("countdown").innerHTML = "EXPIRED";
                    }
                }, 1000);
            @endif
        });
    </script>
@endpush
