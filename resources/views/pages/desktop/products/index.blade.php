<div class="bg-white">
    <div class="max-w-2xl px-4 py-16 mx-auto sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Our Products</h2>

        <!-- Filter & Sort -->
        <div class="flex items-center justify-between mt-4 mb-6">
            <div class="flex items-center space-x-4">
                <select name="sort" id="sort"
                    class="block w-full px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    <option value="latest">Latest</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
            @forelse ($products as $product)
                <a href="{{ route('products.show', $product) }}" class="group">
                    <div
                        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="h-full w-full object-cover object-center group-hover:opacity-75">
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">{{ $product->name }}</h3>
                    <div class="flex items-center justify-between">
                        <p class="mt-1 text-lg font-medium text-gray-900">
                            @if ($product->is_promo && $product->promo_ends_at > now())
                                <span class="line-through text-gray-500 text-sm">Rp
                                    {{ number_format($product->sharing_price, 0, ',', '.') }}</span>
                                <span class="text-primary">Rp
                                    {{ number_format($product->actual_sharing_price, 0, ',', '.') }}</span>
                            @else
                                Rp {{ number_format($product->sharing_price, 0, ',', '.') }}
                            @endif
                        </p>
                        @if ($product->is_promo && $product->promo_ends_at > now())
                            <span
                                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                -{{ $product->sharing_discount }}%
                            </span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No products found</h3>
                    <p class="mt-1 text-sm text-gray-500">Check back later for new products.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</div>
