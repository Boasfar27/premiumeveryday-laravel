<div class="bg-white">
    <div class="px-4 py-8">
        <h2 class="text-xl font-bold tracking-tight text-gray-900">Our Products</h2>

        <!-- Filter & Sort -->
        <div class="mt-4 mb-6">
            <select name="sort" id="sort"
                class="block w-full px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                <option value="latest">Latest</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
            </select>
        </div>

        <div class="grid grid-cols-2 gap-x-4 gap-y-6">
            @forelse ($products as $product)
                <a href="{{ route('products.show', $product) }}" class="group">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="h-full w-full object-cover object-center group-hover:opacity-75">
                    </div>
                    <h3 class="mt-2 text-sm text-gray-700">{{ $product->name }}</h3>
                    <div class="flex items-center justify-between">
                        <p class="mt-1 text-sm font-medium text-gray-900">
                            @if ($product->is_promo && $product->promo_ends_at > now())
                                <span class="line-through text-gray-500 text-xs">Rp
                                    {{ number_format($product->sharing_price, 0, ',', '.') }}</span>
                                <br>
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
                <div class="col-span-2 text-center py-8">
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No products found</h3>
                    <p class="mt-1 text-sm text-gray-500">Check back later for new products.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</div>
