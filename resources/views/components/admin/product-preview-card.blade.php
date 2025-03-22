<div
    class="rounded-lg border border-gray-200 bg-white overflow-hidden shadow-sm hover:shadow-md transition-all max-w-sm">
    <div class="relative">
        <!-- Product Image -->
        <div class="bg-gray-100 h-52 w-full flex items-center justify-center relative overflow-hidden">
            @if (isset($thumbnailUrl) && $thumbnailUrl)
                <img src="{{ $thumbnailUrl }}" alt="{{ $name }}" class="w-full h-full object-cover"
                    onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}';">
            @else
                <div class="text-gray-300 text-3xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif

            @if ($isOnSale)
                <div
                    class="absolute top-0 right-0 bg-gradient-to-l from-pink-500 to-red-600 text-white text-xs font-bold px-4 py-1 rounded-bl-lg shadow-sm">
                    {{ $discount }}
                </div>
            @endif

            @if (isset($categoryName) && $categoryName)
                <div
                    class="absolute bottom-0 left-0 bg-gray-900 bg-opacity-75 text-white text-xs font-medium px-3 py-1 rounded-tr-lg">
                    {{ $categoryName }}
                </div>
            @endif
        </div>
    </div>

    <div class="p-4">
        <!-- Product info -->
        <div class="flex justify-between items-start mb-2">
            <!-- Product Name -->
            <h3 class="text-base font-semibold text-gray-900 leading-tight">{{ $name }}</h3>

            <!-- Product Rating if available -->
            @if (isset($rating) && $rating)
                <div class="flex items-center ml-2">
                    <span class="text-amber-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </span>
                    <span class="text-xs font-semibold text-gray-700 ml-1">{{ $rating }}</span>
                </div>
            @endif
        </div>

        <!-- Product Description (short) -->
        @if (isset($shortDescription) && $shortDescription)
            <p class="text-xs text-gray-600 mt-1 mb-3 line-clamp-2">{{ $shortDescription }}</p>
        @endif

        <!-- Product Price -->
        <div class="flex items-center mt-2 mb-3">
            @if ($isOnSale && !empty($salePrice))
                <span class="text-lg font-bold text-pink-600">{{ $salePrice }}</span>
                <span class="text-sm text-gray-500 line-through ml-2">{{ $price }}</span>
            @else
                <span class="text-lg font-bold text-pink-600">{{ $price }}</span>
            @endif
        </div>

        <!-- Actions -->
        <div class="mt-3 flex space-x-2">
            <button type="button"
                class="flex-1 text-sm bg-pink-600 hover:bg-pink-700 text-white py-2 px-3 rounded-md font-medium transition">
                Beli Sekarang
            </button>
            <button type="button"
                class="flex-1 text-sm border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 px-3 rounded-md font-medium transition">
                Tambah Keranjang
            </button>
        </div>
    </div>
</div>
