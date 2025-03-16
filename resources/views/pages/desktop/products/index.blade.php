@extends('pages.desktop.layouts.app')

@section('content')
    <div class="bg-white pt-16">
        <div class="max-w-2xl px-4 py-16 mx-auto sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                @if (isset($currentCategory))
                    {{ $currentCategory->name }}
                @else
                    Our Digital Products
                @endif
            </h2>

            <!-- Filter & Sort -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mt-4 mb-6 space-y-4 md:space-y-0">
                <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category" id="category" onchange="window.location.href=this.value"
                            class="block w-full px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
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
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <select name="sort" id="sort" onchange="updateQueryParam('sort', this.value)"
                            class="block w-full px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            <option value="newest" {{ request()->sort == 'newest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request()->sort == 'price_low' ? 'selected' : '' }}>Price: Low to
                                High</option>
                            <option value="price_high" {{ request()->sort == 'price_high' ? 'selected' : '' }}>Price: High
                                to Low</option>
                            <option value="name" {{ request()->sort == 'name' ? 'selected' : '' }}>Name</option>
                        </select>
                    </div>
                </div>

                <!-- Search -->
                <div class="w-full md:w-64">
                    <form action="{{ route('products.index') }}" method="GET">
                        @if (request()->has('category'))
                            <input type="hidden" name="category" value="{{ request()->category }}">
                        @endif
                        @if (request()->has('sort'))
                            <input type="hidden" name="sort" value="{{ request()->sort }}">
                        @endif
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
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
            </div>

            <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                @forelse ($products as $product)
                    <a href="{{ route('products.show', $product) }}" class="group">
                        <div
                            class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                class="h-full w-full object-cover object-center group-hover:opacity-75">
                        </div>
                        <h3 class="mt-4 text-sm text-gray-700">{{ $product->name }}</h3>
                        <div class="flex items-center justify-between">
                            <p class="mt-1 text-lg font-medium text-gray-900">
                                @if ($product->is_on_sale)
                                    <span class="line-through text-gray-500 text-sm">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</span>
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
                    <div class="col-span-full text-center py-12">
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">No products found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter to find what you're
                            looking for.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
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
