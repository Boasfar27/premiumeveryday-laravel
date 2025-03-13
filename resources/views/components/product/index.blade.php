<!-- Product Section -->
<div class="bg-white py-8 md:py-16" x-data="{ activeTab: 'sharing' }">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl md:text-4xl font-bold text-center mb-6 md:mb-12">PRODUK KAMI</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8">
            @foreach ($featuredProducts as $product)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform hover:scale-105">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-48 object-cover">
                    @endif

                    <div class="p-4 md:p-6">
                        <h3 class="text-xl md:text-2xl font-bold mb-4">{{ $product->name }}</h3>

                        @if ($product->description)
                            <p class="text-gray-600 text-sm md:text-base mb-4">{{ $product->description }}</p>
                        @endif

                        <!-- Tab Navigation -->
                        <div class="flex mb-4 border-b">
                            <button @click="activeTab = 'sharing'"
                                :class="{ 'border-b-2 border-blue-600': activeTab === 'sharing' }"
                                class="flex-1 py-2 text-sm md:text-base font-medium focus:outline-none">
                                Sharing
                            </button>
                            <button @click="activeTab = 'private'"
                                :class="{ 'border-b-2 border-blue-600': activeTab === 'private' }"
                                class="flex-1 py-2 text-sm md:text-base font-medium focus:outline-none">
                                Private
                            </button>
                        </div>

                        <!-- Sharing Tab -->
                        <div x-show="activeTab === 'sharing'" class="space-y-4">
                            <div>
                                @if ($product->sharing_description)
                                    <p class="text-gray-600 text-sm md:text-base">{{ $product->sharing_description }}
                                    </p>
                                @endif
                                <p class="text-lg md:text-xl font-bold text-blue-600 mt-2">
                                    Rp {{ number_format($product->sharing_price, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="https://wa.me/your_number?text=Halo, saya ingin berlangganan {{ $product->name }} (Sharing)"
                                class="block text-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors text-sm md:text-base">
                                Pesan Sharing
                            </a>
                        </div>

                        <!-- Private Tab -->
                        <div x-show="activeTab === 'private'" class="space-y-4">
                            <div>
                                @if ($product->private_description)
                                    <p class="text-gray-600 text-sm md:text-base">{{ $product->private_description }}
                                    </p>
                                @endif
                                <p class="text-lg md:text-xl font-bold text-blue-600 mt-2">
                                    Rp {{ number_format($product->private_price, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="https://wa.me/your_number?text=Halo, saya ingin berlangganan {{ $product->name }} (Private)"
                                class="block text-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors text-sm md:text-base">
                                Pesan Private
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
