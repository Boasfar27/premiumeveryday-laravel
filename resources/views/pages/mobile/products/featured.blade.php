<!-- Mobile Featured Products -->
<section class="bg-white py-8">
    <div class="px-4">
        <!-- Section Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Featured Products</h2>
            <p class="text-gray-600">Discover our best-selling premium products</p>
        </div>

        <!-- Products Grid -->
        @if ($products->count() > 0)
            <div class="space-y-6">
                @foreach ($products as $product)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Product Image -->
                        @if ($product->image)
                            <div class="aspect-w-16 aspect-h-9">
                                <img class="w-full h-full object-cover" src="{{ asset($product->image) }}"
                                    alt="{{ $product->name }}">
                            </div>
                        @endif

                        <!-- Product Info -->
                        <div class="p-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ $product->short_description }}</p>
                                </div>
                                <div class="ml-4">
                                    <span class="text-lg font-bold text-primary">
                                        {{ $product->formatted_price }}
                                    </span>
                                </div>
                            </div>

                            <!-- Product Features -->
                            @if ($product->features)
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-900">Key Features:</h4>
                                    <ul class="mt-2 space-y-2">
                                        @foreach (json_decode($product->features) as $feature)
                                            <li class="flex items-start">
                                                <svg class="h-5 w-5 text-primary-500 mt-0.5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span class="ml-2 text-sm text-gray-600">{{ $feature }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="mt-6 flex space-x-3">
                                <a href="{{ route('products.show', $product) }}"
                                    class="flex-1 text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    View Details
                                </a>
                                <button type="button" onclick="addToCart({{ $product->id }})"
                                    class="flex-1 px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View All Products Button -->
            <div class="mt-8 text-center">
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    View All Products
                </a>
            </div>
        @else
            <!-- No Products State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No products available</h3>
                <p class="mt-1 text-sm text-gray-500">Check back soon for new products!</p>
            </div>
        @endif
    </div>
</section>
