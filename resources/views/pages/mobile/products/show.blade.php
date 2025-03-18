@extends('pages.mobile.layouts.app')

@section('title', $product->name . ' - Premium Everyday')

@section('content')
    <div class="bg-white py-4">
        <div class="container mx-auto px-4">
            <!-- Breadcrumb -->
            <nav class="flex py-2 overflow-x-auto whitespace-nowrap mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-primary">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('products.index') }}"
                                class="text-sm text-gray-500 hover:text-primary ml-1">Products</a>
                        </div>
                    </li>
                    @if ($product->category)
                        <li>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('categories.show', $product->category) }}"
                                    class="text-sm text-gray-500 hover:text-primary ml-1">{{ $product->category->name }}</a>
                            </div>
                        </li>
                    @endif
                </ol>
            </nav>

            <!-- Product Image -->
            <div class="relative mb-4">
                <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                    class="w-full h-64 object-cover rounded-lg">
                @if ($product->is_on_sale)
                    <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                        SALE
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $product->name }}</h1>

                <div class="flex flex-wrap items-center gap-2 mb-3">
                    @if ($product->category)
                        <span class="bg-primary-50 text-primary-700 text-xs font-medium px-2 py-0.5 rounded-full">
                            {{ $product->category->name }}
                        </span>
                    @endif

                    @if ($product->is_featured)
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded-full">
                            Featured
                        </span>
                    @endif

                    @if ($product->created_at->diffInDays(now()) <= 7)
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full">
                            New
                        </span>
                    @endif
                </div>

                <div class="mb-4">
                    <div class="flex items-center space-x-2 mb-1">
                        @if ($product->is_on_sale)
                            <span class="text-2xl font-bold text-primary">Rp
                                {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                            <span class="text-sm text-gray-500 line-through">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span
                                class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-0.5 rounded">{{ $product->sharing_discount }}%
                                OFF</span>
                        @else
                            <span class="text-2xl font-bold text-primary">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</span>
                        @endif
                    </div>

                    @if ($product->is_on_sale && $product->sale_ends_at)
                        <p class="text-xs text-red-600">Sale ends: {{ $product->sale_ends_at->format('d M Y') }}</p>
                    @endif
                </div>

                <div class="mb-6">
                    <h3 class="text-md font-semibold text-gray-900 mb-1">Description</h3>
                    <p class="text-sm text-gray-600">{{ $product->description }}</p>
                </div>

                @if ($product->features)
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-gray-900 mb-1">Key Features</h3>
                        <div class="text-sm text-gray-600">{{ $product->features }}</div>
                    </div>
                @endif

                @if ($product->requirements)
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-gray-900 mb-1">Requirements</h3>
                        <div class="text-sm text-gray-600">{{ $product->requirements }}</div>
                    </div>
                @endif
            </div>

            <!-- Subscription Options -->
            <div class="mb-8">
                <h3 class="text-md font-semibold text-gray-900 mb-2">Purchase Options</h3>

                <!-- Purchase Type Tabs -->
                <div class="mb-4">
                    <div class="flex border-b border-gray-200 mb-4">
                        <button id="tab-sharing-mobile" onclick="showTabMobile('sharing')"
                            class="tab-button-mobile active py-2 px-3 text-sm font-medium border-b-2 border-primary text-primary">
                            Sharing Account
                        </button>
                        <button id="tab-private-mobile" onclick="showTabMobile('private')"
                            class="tab-button-mobile py-2 px-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                            Private Account
                        </button>
                    </div>

                    <!-- Sharing Account Options -->
                    <div id="content-sharing-mobile" class="tab-content-mobile">
                        <p class="text-xs text-gray-600 mb-3">
                            {{ $product->sharing_description ?? 'Share your account with multiple users. Lower price but limited to specific regions.' }}
                        </p>

                        <div class="space-y-4">
                            <!-- 1 Month Plan -->
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-gray-900">1 Month Plan</h4>
                                        <p class="text-gray-500 text-xs">Basic sharing access</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-lg font-bold text-primary">Rp
                                            {{ number_format($product->actual_sharing_price ?? $product->price, 0, ',', '.') }}</span>
                                        @if ($product->is_promo && ($product->sharing_discount ?? 0) > 0)
                                            <span class="text-xs text-gray-500 line-through block">Rp
                                                {{ number_format($product->sharing_price ?? $product->price, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="subscription_type" value="monthly">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="duration" value="1">
                                    <input type="hidden" name="account_type" value="sharing">

                                    @auth
                                        <button type="submit"
                                            class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Add to Cart
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                            class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Login to Purchase
                                        </a>
                                    @endauth
                                </form>
                            </div>

                            <!-- 3 Month Plan -->
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-gray-900">3 Month Plan</h4>
                                        <p class="text-gray-500 text-xs">Extended sharing access (save 10%)</p>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $sharingPrice = $product->actual_sharing_price ?? $product->price;
                                            $sharingPrice3Month = $sharingPrice * 3 * 0.9;
                                            $sharingRegularPrice3Month =
                                                ($product->sharing_price ?? $product->price) * 3;
                                        @endphp
                                        <span class="text-lg font-bold text-primary">Rp
                                            {{ number_format($sharingPrice3Month, 0, ',', '.') }}</span>
                                        <span class="text-xs text-gray-500 line-through block">Rp
                                            {{ number_format($sharingRegularPrice3Month, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="subscription_type" value="quarterly">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="duration" value="3">
                                    <input type="hidden" name="account_type" value="sharing">

                                    @auth
                                        <button type="submit"
                                            class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Add to Cart
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                            class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Login to Purchase
                                        </a>
                                    @endauth
                                </form>
                            </div>

                            <!-- 6 Month Plan -->
                            <div class="border-2 border-primary rounded-lg p-4 bg-primary-50 relative">
                                <div
                                    class="absolute top-0 right-0 bg-primary text-white text-xs font-bold px-2 py-1 rounded-bl-lg">
                                    BEST VALUE
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-gray-900">6 Month Plan</h4>
                                        <p class="text-gray-500 text-xs">Premium sharing access (save 20%)</p>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $sharingPrice = $product->actual_sharing_price ?? $product->price;
                                            $sharingPrice6Month = $sharingPrice * 6 * 0.8;
                                            $sharingRegularPrice6Month =
                                                ($product->sharing_price ?? $product->price) * 6;
                                        @endphp
                                        <span class="text-lg font-bold text-primary">Rp
                                            {{ number_format($sharingPrice6Month, 0, ',', '.') }}</span>
                                        <span class="text-xs text-gray-500 line-through block">Rp
                                            {{ number_format($sharingRegularPrice6Month, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="subscription_type" value="semiannual">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="duration" value="6">
                                    <input type="hidden" name="account_type" value="sharing">

                                    @auth
                                        <button type="submit"
                                            class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Add to Cart
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                            class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Login to Purchase
                                        </a>
                                    @endauth
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Private Account Options -->
                    <div id="content-private-mobile" class="tab-content-mobile hidden">
                        <p class="text-xs text-gray-600 mb-3">
                            {{ $product->private_description ?? 'Exclusive private account for single user. Higher price but available in all regions with premium features.' }}
                        </p>

                        <div class="space-y-4">
                            <!-- 1 Month Plan -->
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-gray-900">1 Month Plan</h4>
                                        <p class="text-gray-500 text-xs">Basic private access</p>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $privatePrice = $product->actual_private_price ?? $product->price * 1.5;
                                            $privateRegularPrice = $product->private_price ?? $product->price * 1.5;
                                        @endphp
                                        <span class="text-lg font-bold text-primary">Rp
                                            {{ number_format($privatePrice, 0, ',', '.') }}</span>
                                        @if ($product->is_promo && ($product->private_discount ?? 0) > 0)
                                            <span class="text-xs text-gray-500 line-through block">Rp
                                                {{ number_format($privateRegularPrice, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="subscription_type" value="monthly">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="duration" value="1">
                                    <input type="hidden" name="account_type" value="private">

                                    @auth
                                        <button type="submit"
                                            class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Add to Cart
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                            class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Login to Purchase
                                        </a>
                                    @endauth
                                </form>
                            </div>

                            <!-- 3 Month Plan -->
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-gray-900">3 Month Plan</h4>
                                        <p class="text-gray-500 text-xs">Extended private access (save 10%)</p>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $privatePrice = $product->actual_private_price ?? $product->price * 1.5;
                                            $privatePrice3Month = $privatePrice * 3 * 0.9;
                                            $privateRegularPrice3Month =
                                                ($product->private_price ?? $product->price * 1.5) * 3;
                                        @endphp
                                        <span class="text-lg font-bold text-primary">Rp
                                            {{ number_format($privatePrice3Month, 0, ',', '.') }}</span>
                                        <span class="text-xs text-gray-500 line-through block">Rp
                                            {{ number_format($privateRegularPrice3Month, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="subscription_type" value="quarterly">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="duration" value="3">
                                    <input type="hidden" name="account_type" value="private">

                                    @auth
                                        <button type="submit"
                                            class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Add to Cart
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                            class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Login to Purchase
                                        </a>
                                    @endauth
                                </form>
                            </div>

                            <!-- 6 Month Plan -->
                            <div class="border-2 border-primary rounded-lg p-4 bg-primary-50 relative">
                                <div
                                    class="absolute top-0 right-0 bg-primary text-white text-xs font-bold px-2 py-1 rounded-bl-lg">
                                    BEST VALUE
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-gray-900">6 Month Plan</h4>
                                        <p class="text-gray-500 text-xs">Premium private access (save 20%)</p>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $privatePrice = $product->actual_private_price ?? $product->price * 1.5;
                                            $privatePrice6Month = $privatePrice * 6 * 0.8;
                                            $privateRegularPrice6Month =
                                                ($product->private_price ?? $product->price * 1.5) * 6;
                                        @endphp
                                        <span class="text-lg font-bold text-primary">Rp
                                            {{ number_format($privatePrice6Month, 0, ',', '.') }}</span>
                                        <span class="text-xs text-gray-500 line-through block">Rp
                                            {{ number_format($privateRegularPrice6Month, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="subscription_type" value="semiannual">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="duration" value="6">
                                    <input type="hidden" name="account_type" value="private">

                                    @auth
                                        <button type="submit"
                                            class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Add to Cart
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                            class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                            Login to Purchase
                                        </a>
                                    @endauth
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        function showTabMobile(tabName) {
                            // Hide all tab contents
                            document.querySelectorAll('.tab-content-mobile').forEach(content => {
                                content.classList.add('hidden');
                            });

                            // Show selected tab content
                            document.getElementById('content-' + tabName + '-mobile').classList.remove('hidden');

                            // Update tab buttons
                            document.querySelectorAll('.tab-button-mobile').forEach(button => {
                                button.classList.remove('active', 'border-primary', 'text-primary');
                                button.classList.add('border-transparent', 'text-gray-500');
                            });

                            document.getElementById('tab-' + tabName + '-mobile').classList.add('active', 'border-primary', 'text-primary');
                            document.getElementById('tab-' + tabName + '-mobile').classList.remove('border-transparent', 'text-gray-500');
                        }
                    </script>
                </div>
            </div>

            <!-- Feedback/Reviews -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Customer Reviews</h2>

                @if ($feedback && $feedback->count() > 0)
                    <div class="space-y-4">
                        @foreach ($feedback as $review)
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary font-bold text-sm">
                                        {{ substr($review->name, 0, 1) }}
                                    </div>
                                    <div class="ml-2">
                                        <p class="text-sm font-medium text-gray-900">{{ $review->name }}</p>
                                        <div class="flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endfor
                                            <span
                                                class="text-xs text-gray-500 ml-1">{{ $review->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600">{{ $review->content }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <p class="text-sm text-gray-600">No reviews yet. Be the first to review this product after
                            purchase!</p>
                    </div>
                @endif

                @auth
                    @if (auth()->user()->orders()->whereHas('items', function ($query) use ($product) {
                                $query->whereHasMorph('orderable', [\App\Models\DigitalProduct::class], function ($q) use ($product) {
                                    $q->where('id', $product->id);
                                });
                            })->where('status', 'completed')->exists() &&
                            !$product->feedback()->where('user_id', auth()->id())->exists())
                        <div class="mt-6">
                            <h3 class="text-md font-semibold text-gray-900 mb-3">Write a Review</h3>
                            <form action="{{ route('feedback.store') }}" method="POST"
                                class="bg-white p-4 rounded-lg border border-gray-200">
                                @csrf
                                <input type="hidden" name="feedbackable_id" value="{{ $product->id }}">
                                <input type="hidden" name="feedbackable_type" value="App\Models\DigitalProduct">

                                <div class="mb-3">
                                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                                    <div class="flex items-center">
                                        <div class="flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <input type="radio" id="rating-{{ $i }}" name="rating"
                                                    value="{{ $i }}" class="hidden peer" required>
                                                <label for="rating-{{ $i }}"
                                                    class="cursor-pointer text-gray-300 peer-checked:text-yellow-400">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Your
                                        Review</label>
                                    <textarea id="content" name="content" rows="3"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm" required></textarea>
                                </div>

                                <button type="submit"
                                    class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition text-sm">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Related Products -->
            @if ($relatedProducts && $relatedProducts->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Related Products</h2>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach ($relatedProducts as $related)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                                <a href="{{ route('products.show', $related) }}">
                                    <div class="relative">
                                        <img src="{{ $related->thumbnail_url }}" alt="{{ $related->name }}"
                                            class="w-full h-28 object-cover">
                                        @if ($related->is_on_sale)
                                            <div
                                                class="absolute top-1 right-1 bg-red-500 text-white text-xxs font-bold px-1.5 py-0.5 rounded">
                                                SALE
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-2">
                                        <h3 class="text-sm font-bold text-gray-900 truncate">{{ $related->name }}</h3>
                                        <div class="mt-1">
                                            @if ($related->is_on_sale)
                                                <span class="text-gray-400 line-through text-xs">Rp
                                                    {{ number_format($related->price, 0, ',', '.') }}</span>
                                                <span class="text-sm font-bold text-primary block">Rp
                                                    {{ number_format($related->sale_price, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-sm font-bold text-primary">Rp
                                                    {{ number_format($related->price, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
