@extends('pages.desktop.layouts.app')

@section('title', $product->name . ' - Premium Everyday')

@section('content')
    <div class="bg-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary">
                            {{-- <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg> --}}
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('products.index') }}"
                                class="ml-1 text-gray-500 hover:text-primary md:ml-2">Products</a>
                        </div>
                    </li>
                    @if ($product->category)
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('categories.show', $product->category) }}"
                                    class="ml-1 text-gray-500 hover:text-primary md:ml-2">{{ $product->category->name }}</a>
                            </div>
                        </li>
                    @endif
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2">{{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Product Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Left Column - Images -->
                <div>
                    <div class="mb-4 overflow-hidden rounded-lg">
                        <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                            class="w-full h-auto object-cover">
                    </div>
                    @if ($product->gallery && count($product->gallery) > 0)
                        <div class="grid grid-cols-4 gap-2">
                            @foreach ($product->gallery as $image)
                                <div class="overflow-hidden rounded-lg">
                                    <img src="{{ asset($image) }}" alt="{{ $product->name }}"
                                        class="w-full h-20 object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Right Column - Details -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

                    <div class="flex items-center mb-4">
                        @if ($product->category)
                            <span class="bg-primary-50 text-primary-700 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $product->category->name }}
                            </span>
                        @endif

                        @if ($product->is_featured)
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium ml-2 px-2.5 py-0.5 rounded-full">
                                Featured
                            </span>
                        @endif

                        @if ($product->created_at->diffInDays(now()) <= 7)
                            <span class="bg-green-100 text-green-800 text-xs font-medium ml-2 px-2.5 py-0.5 rounded-full">
                                New
                            </span>
                        @endif
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center space-x-2 mb-2">
                            @if ($product->is_on_sale)
                                <span class="text-3xl font-bold text-primary">Rp
                                    {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                <span class="text-xl text-gray-500 line-through">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span
                                    class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $product->sharing_discount }}%
                                    OFF</span>
                            @else
                                <span class="text-3xl font-bold text-primary">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>

                        @if ($product->is_on_sale && $product->sale_ends_at)
                            <p class="text-sm text-red-600">Sale ends: {{ $product->sale_ends_at->format('d M Y') }}</p>
                        @endif
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-600">{{ $product->description }}</p>
                    </div>

                    @if ($product->features)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Key Features</h3>
                            <div class="text-gray-600">{{ $product->features }}</div>
                        </div>
                    @endif

                    @if ($product->requirements)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Requirements</h3>
                            <div class="text-gray-600">{{ $product->requirements }}</div>
                        </div>
                    @endif

                    <!-- Subscription Options -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Purchase Options</h3>

                        <!-- Purchase Type Tabs -->
                        <div class="mb-6">
                            <div class="flex border-b border-gray-200 mb-4">
                                <button id="tab-sharing" onclick="showTab('sharing')"
                                    class="tab-button active py-2 px-4 font-medium border-b-2 border-primary text-primary">
                                    Sharing Account
                                </button>
                                <button id="tab-private" onclick="showTab('private')"
                                    class="tab-button py-2 px-4 font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                                    Private Account
                                </button>
                            </div>

                            <!-- Sharing Account Options -->
                            <div id="content-sharing" class="tab-content">
                                <p class="text-sm text-gray-600 mb-4">
                                    {{ $product->sharing_description ?? 'Share your account with multiple users. Lower price but limited to specific regions.' }}
                                </p>

                                <div class="grid grid-cols-1 gap-4 mt-4">
                                    <!-- 1 Month Plan -->
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">1 Month Plan</h4>
                                                <p class="text-gray-500 text-sm">Basic sharing access</p>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-xl font-bold text-primary">Rp
                                                    {{ number_format($product->actual_sharing_price ?? $product->price, 0, ',', '.') }}</span>
                                                @if ($product->is_promo && ($product->sharing_discount ?? 0) > 0)
                                                    <span class="text-sm text-gray-500 line-through block">Rp
                                                        {{ number_format($product->sharing_price ?? $product->price, 0, ',', '.') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="subscription_type" value="monthly">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="duration" value="1">
                                            <input type="hidden" name="account_type" value="sharing">

                                            @auth
                                                <button type="submit"
                                                    class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Add to Cart
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                    class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
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
                                                <p class="text-gray-500 text-sm">Extended sharing access (save 10%)</p>
                                            </div>
                                            <div class="text-right">
                                                @php
                                                    $sharingPrice = $product->actual_sharing_price ?? $product->price;
                                                    $sharingPrice3Month = $sharingPrice * 3 * 0.9;
                                                    $sharingRegularPrice3Month =
                                                        ($product->sharing_price ?? $product->price) * 3;
                                                @endphp
                                                <span class="text-xl font-bold text-primary">Rp
                                                    {{ number_format($sharingPrice3Month, 0, ',', '.') }}</span>
                                                <span class="text-sm text-gray-500 line-through block">Rp
                                                    {{ number_format($sharingRegularPrice3Month, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="subscription_type" value="quarterly">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="duration" value="3">
                                            <input type="hidden" name="account_type" value="sharing">

                                            @auth
                                                <button type="submit"
                                                    class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Add to Cart
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                    class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
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
                                                <p class="text-gray-500 text-sm">Premium sharing access (save a total of
                                                    20%)</p>
                                            </div>
                                            <div class="text-right">
                                                @php
                                                    $sharingPrice = $product->actual_sharing_price ?? $product->price;
                                                    $sharingPrice6Month = $sharingPrice * 6 * 0.8;
                                                    $sharingRegularPrice6Month =
                                                        ($product->sharing_price ?? $product->price) * 6;
                                                @endphp
                                                <span class="text-xl font-bold text-primary">Rp
                                                    {{ number_format($sharingPrice6Month, 0, ',', '.') }}</span>
                                                <span class="text-sm text-gray-500 line-through block">Rp
                                                    {{ number_format($sharingRegularPrice6Month, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="subscription_type" value="semiannual">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="duration" value="6">
                                            <input type="hidden" name="account_type" value="sharing">

                                            @auth
                                                <button type="submit"
                                                    class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Add to Cart
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                    class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Login to Purchase
                                                </a>
                                            @endauth
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Private Account Options -->
                            <div id="content-private" class="tab-content hidden">
                                <p class="text-sm text-gray-600 mb-4">
                                    {{ $product->private_description ?? 'Exclusive private account for single user. Higher price but available in all regions with premium features.' }}
                                </p>

                                <div class="grid grid-cols-1 gap-4 mt-4">
                                    <!-- 1 Month Plan -->
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">1 Month Plan</h4>
                                                <p class="text-gray-500 text-sm">Basic private access</p>
                                            </div>
                                            <div class="text-right">
                                                @php
                                                    $privatePrice =
                                                        $product->actual_private_price ?? $product->price * 1.5;
                                                    $privateRegularPrice =
                                                        $product->private_price ?? $product->price * 1.5;
                                                @endphp
                                                <span class="text-xl font-bold text-primary">Rp
                                                    {{ number_format($privatePrice, 0, ',', '.') }}</span>
                                                @if ($product->is_promo && ($product->private_discount ?? 0) > 0)
                                                    <span class="text-sm text-gray-500 line-through block">Rp
                                                        {{ number_format($privateRegularPrice, 0, ',', '.') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="subscription_type" value="monthly">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="duration" value="1">
                                            <input type="hidden" name="account_type" value="private">

                                            @auth
                                                <button type="submit"
                                                    class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Add to Cart
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                    class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
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
                                                <p class="text-gray-500 text-sm">Extended private access (save 10%)</p>
                                            </div>
                                            <div class="text-right">
                                                @php
                                                    $privatePrice =
                                                        $product->actual_private_price ?? $product->price * 1.5;
                                                    $privatePrice3Month = $privatePrice * 3 * 0.9;
                                                    $privateRegularPrice3Month =
                                                        ($product->private_price ?? $product->price * 1.5) * 3;
                                                @endphp
                                                <span class="text-xl font-bold text-primary">Rp
                                                    {{ number_format($privatePrice3Month, 0, ',', '.') }}</span>
                                                <span class="text-sm text-gray-500 line-through block">Rp
                                                    {{ number_format($privateRegularPrice3Month, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="subscription_type" value="quarterly">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="duration" value="3">
                                            <input type="hidden" name="account_type" value="private">

                                            @auth
                                                <button type="submit"
                                                    class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Add to Cart
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                    class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
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
                                                <p class="text-gray-500 text-sm">Premium private access (save a total of
                                                    20%)</p>
                                            </div>
                                            <div class="text-right">
                                                @php
                                                    $privatePrice =
                                                        $product->actual_private_price ?? $product->price * 1.5;
                                                    $privatePrice6Month = $privatePrice * 6 * 0.8;
                                                    $privateRegularPrice6Month =
                                                        ($product->private_price ?? $product->price * 1.5) * 6;
                                                @endphp
                                                <span class="text-xl font-bold text-primary">Rp
                                                    {{ number_format($privatePrice6Month, 0, ',', '.') }}</span>
                                                <span class="text-sm text-gray-500 line-through block">Rp
                                                    {{ number_format($privateRegularPrice6Month, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="subscription_type" value="semiannual">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="duration" value="6">
                                            <input type="hidden" name="account_type" value="private">

                                            @auth
                                                <button type="submit"
                                                    class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Add to Cart
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}?redirect={{ route('products.show', $product) }}"
                                                    class="block text-center w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                                    Login to Purchase
                                                </a>
                                            @endauth
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function showTab(tabName) {
                            // Hide all tab contents
                            document.querySelectorAll('.tab-content').forEach(content => {
                                content.classList.add('hidden');
                            });

                            // Show selected tab content
                            document.getElementById('content-' + tabName).classList.remove('hidden');

                            // Update tab buttons
                            document.querySelectorAll('.tab-button').forEach(button => {
                                button.classList.remove('active', 'border-primary', 'text-primary');
                                button.classList.add('border-transparent', 'text-gray-500');
                            });

                            document.getElementById('tab-' + tabName).classList.add('active', 'border-primary', 'text-primary');
                            document.getElementById('tab-' + tabName).classList.remove('border-transparent', 'text-gray-500');
                        }
                    </script>
                </div>
            </div>

            <!-- Feedback/Reviews -->
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Customer Reviews</h2>

                @if ($feedback && $feedback->count() > 0)
                    <div class="space-y-6">
                        @foreach ($feedback as $review)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <div
                                        class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary font-bold">
                                        {{ substr($review->name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $review->name }}</p>
                                        <div class="flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endfor
                                            <span
                                                class="text-xs text-gray-500 ml-2">{{ $review->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-600">{{ $review->content }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 p-6 rounded-lg text-center">
                        <p class="text-gray-600">No reviews yet. Be the first to review this product after purchase!</p>
                    </div>
                @endif

                @auth
                    @if (auth()->user()->orders()->whereHas('items', function ($query) use ($product) {
                                $query->whereHasMorph('orderable', [\App\Models\DigitalProduct::class], function ($q) use ($product) {
                                    $q->where('id', $product->id);
                                });
                            })->where('status', 'completed')->exists() &&
                            !$product->feedback()->where('user_id', auth()->id())->exists())
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Write a Review</h3>
                            <form action="{{ route('feedback.store') }}" method="POST"
                                class="bg-white p-6 rounded-lg border border-gray-200">
                                @csrf
                                <input type="hidden" name="feedbackable_id" value="{{ $product->id }}">
                                <input type="hidden" name="feedbackable_type" value="App\Models\DigitalProduct">

                                <div class="mb-4">
                                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                                    <div class="flex items-center">
                                        <div class="flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <input type="radio" id="rating-{{ $i }}" name="rating"
                                                    value="{{ $i }}" class="hidden peer" required>
                                                <label for="rating-{{ $i }}"
                                                    class="cursor-pointer text-gray-300 peer-checked:text-yellow-400">
                                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Your
                                        Review</label>
                                    <textarea id="content" name="content" rows="4"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required></textarea>
                                </div>

                                <button type="submit"
                                    class="bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded transition">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Related Products -->
            @if ($relatedProducts && $relatedProducts->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Products</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedProducts as $related)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                                <a href="{{ route('products.show', $related) }}">
                                    <div class="relative">
                                        <img src="{{ $related->thumbnail_url }}" alt="{{ $related->name }}"
                                            class="w-full h-40 object-cover">
                                        @if ($related->is_on_sale)
                                            <div
                                                class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                                SALE
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-md font-bold text-gray-900 mb-1">{{ $related->name }}</h3>
                                        <div class="flex items-center justify-between mt-2">
                                            <div>
                                                @if ($related->is_on_sale)
                                                    <span class="text-gray-400 line-through text-xs">Rp
                                                        {{ number_format($related->price, 0, ',', '.') }}</span>
                                                    <span class="text-md font-bold text-primary">Rp
                                                        {{ number_format($related->sale_price, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="text-md font-bold text-primary">Rp
                                                        {{ number_format($related->price, 0, ',', '.') }}</span>
                                                @endif
                                            </div>
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
