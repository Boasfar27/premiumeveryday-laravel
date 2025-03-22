<!-- Subscription Plan Preview Card -->
<div
    class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 transition-all duration-300 hover:shadow-md">
    <!-- Header -->
    <div class="relative">
        <!-- Product image -->
        <div class="aspect-w-4 aspect-h-3 w-full">
            @if (isset($thumbnailUrl) && $thumbnailUrl)
                <img src="{{ $thumbnailUrl }}" alt="Thumbnail" class="h-full w-full object-cover object-center"
                    onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}';">
            @else
                <div class="h-48 bg-gray-100 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            @endif

            <!-- Badge -->
            @if (isset($isFeatured) && $isFeatured)
                <div
                    class="absolute top-0 right-0 bg-gradient-to-r from-pink-500 to-pink-600 text-white px-4 py-1 rounded-bl-lg font-medium text-sm shadow-sm">
                    Direkomendasikan
                </div>
            @endif
        </div>
    </div>

    <!-- Body -->
    <div class="p-4">
        <!-- Plan name -->
        <h3 class="text-lg font-medium text-gray-900 mb-1">
            {{ $name ?? 'Nama Paket' }}
        </h3>

        <!-- Duration badge -->
        <div class="flex items-center space-x-2 mb-3">
            <span
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ $duration ?? 'Monthly' }}
            </span>

            <span
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                {{ $maxUsers ?? 'Single User' }}
            </span>
        </div>

        <!-- Price -->
        <div class="mt-3 mb-3">
            @if (isset($salePrice) && isset($normalPrice) && $salePrice < $normalPrice)
                <span class="line-through text-sm text-gray-500">{{ App\Models\Setting::get('currency_symbol', 'Rp') }}
                    {{ number_format($normalPrice, 0, ',', '.') }}</span>
                <div class="flex items-center">
                    <span
                        class="text-2xl font-bold text-pink-600">{{ App\Models\Setting::get('currency_symbol', 'Rp') }}
                        {{ number_format($salePrice, 0, ',', '.') }}</span>
                    @php
                        $discountPercentage = round((($normalPrice - $salePrice) / $normalPrice) * 100);
                    @endphp
                    <span
                        class="ml-2 inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Hemat {{ $discountPercentage }}%
                    </span>
                </div>
            @else
                <div class="text-2xl font-bold text-pink-600">{{ App\Models\Setting::get('currency_symbol', 'Rp') }}
                    {{ number_format($normalPrice ?? 0, 0, ',', '.') }}</div>
            @endif
        </div>

        <!-- Features preview (mock) -->
        <div class="mt-3 space-y-2 text-sm">
            <div class="flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Akses penuh ke produk digital</span>
            </div>
            <div class="flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Update selama periode langganan</span>
            </div>
            <div class="flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Dukungan teknis standar</span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
        <div class="text-xs text-gray-500">ID #123456</div>
        <button type="button"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-pink-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
            Preview
        </button>
    </div>
</div>
