<!-- Featured Products Section -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">Featured Products</h2>
            <p class="text-lg text-gray-600 mb-12">Discover our most popular premium products</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($products as $product)
                <div class="group relative bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-t-lg bg-gray-200">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="h-full w-full object-cover object-center group-hover:opacity-75 transition-opacity">
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">
                            <a href="{{ route('products.show', $product) }}" class="hover:text-primary">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $product->description }}</p>
                        <div class="flex items-center justify-between">
                            <div>
                                @if ($product->is_promo && $product->promo_ends_at > now())
                                    <p class="text-sm text-gray-500 line-through">
                                        Rp {{ number_format($product->sharing_price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-lg font-bold text-primary">
                                        Rp {{ number_format($product->actual_sharing_price, 0, ',', '.') }}
                                    </p>
                                @else
                                    <p class="text-lg font-bold text-gray-900">
                                        Rp {{ number_format($product->sharing_price, 0, ',', '.') }}
                                    </p>
                                @endif
                            </div>
                            @if ($product->is_promo && $product->promo_ends_at > now())
                                <span
                                    class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                    -{{ $product->sharing_discount }}%
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products available</h3>
                    <p class="text-gray-500">Check back later for new products.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-dark transition-colors">
                View All Products
                <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
