@extends('pages.mobile.layouts.app')

@section('content')
    <div class="bg-white pt-4">
        <div class="px-4 py-8">
            <h2 class="text-xl font-bold tracking-tight text-gray-900">
                @if (isset($currentCategory))
                    {{ $currentCategory->name }}
                @else
                    Our Digital Products
                @endif
            </h2>

            <!-- Search -->
            <div class="mt-4 mb-4">
                <form action="{{ route('products.index') }}" method="GET">
                    @if (request()->has('category'))
                        <input type="hidden" name="category" value="{{ request()->category }}">
                    @endif
                    @if (request()->has('sort'))
                        <input type="hidden" name="sort" value="{{ request()->sort }}">
                    @endif
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request()->search }}"
                            placeholder="Search products..."
                            class="block w-full px-3 py-2 pr-10 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Filter & Sort -->
            <div class="flex space-x-2 mb-6">
                <!-- Category Filter -->
                <div class="w-1/2">
                    <select name="category" id="category-mobile" onchange="window.location.href=this.value"
                        class="block w-full px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <option value="{{ route('products.index') }}">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ route('products.index', ['category' => $category->slug]) }}"
                                {{ request()->category == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div class="w-1/2">
                    <select name="sort" id="sort-mobile" onchange="updateQueryParam('sort', this.value)"
                        class="block w-full px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <option value="newest" {{ request()->sort == 'newest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ request()->sort == 'price_low' ? 'selected' : '' }}>Price: Low to High
                        </option>
                        <option value="price_high" {{ request()->sort == 'price_high' ? 'selected' : '' }}>Price: High to
                            Low</option>
                        <option value="name" {{ request()->sort == 'name' ? 'selected' : '' }}>Name</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                @forelse ($products as $product)
                    <a href="{{ route('products.show', $product) }}" class="group">
                        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200">
                            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                class="h-full w-full object-cover object-center group-hover:opacity-75">
                        </div>
                        <h3 class="mt-2 text-sm text-gray-700">{{ $product->name }}</h3>
                        <div class="flex items-center justify-between">
                            <p class="mt-1 text-sm font-medium text-gray-900">
                                @if ($product->is_on_sale)
                                    <span class="line-through text-gray-500 text-xs">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <br>
                                    <span class="text-primary">Rp
                                        {{ number_format($product->getDiscountedPrice(), 0, ',', '.') }}</span>
                                @else
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                @endif
                            </p>
                            @if ($product->is_on_sale)
                                <span
                                    class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            @endif
                            @if ($product->isNew())
                                <span
                                    class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/10">
                                    New
                                </span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="col-span-2 text-center py-8">
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">No products found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter to find what you're
                            looking for.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <script>
        function updateQueryParam(key, value) {
            const url = new URL(window.location.href);
            url.searchParams.set(key, value);
            window.location.href = url.toString();
        }
    </script>
@endsection
