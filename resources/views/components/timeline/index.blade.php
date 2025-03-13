<!-- Timeline Section -->
<div class="bg-white py-8 md:py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl md:text-4xl font-bold text-center mb-6 md:mb-12">Cara Pemesanan</h2>

        <div class="max-w-4xl mx-auto">
            <div class="relative">
                <!-- Vertical Line -->
                <div class="absolute h-full w-0.5 bg-blue-600 left-6 md:left-1/2 transform -translate-x-1/2"></div>

                <!-- Timeline Items -->
                <div class="space-y-8 md:space-y-12">
                    @foreach ($timelines as $timeline)
                        <div class="relative flex items-center md:justify-between md:odd:flex-row-reverse group">
                            <div class="flex items-center md:w-1/2">
                                <div
                                    class="z-10 flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-blue-600 rounded-full group-hover:bg-blue-700 transition-colors">
                                    @if ($timeline->icon)
                                        <i class="{{ $timeline->icon }} text-white text-lg md:text-xl"></i>
                                    @else
                                        <span
                                            class="text-lg md:text-xl text-white font-bold">{{ $loop->iteration }}</span>
                                    @endif
                                </div>
                                <div class="ml-4 md:ml-0 md:mx-8">
                                    <h3 class="text-lg md:text-xl font-bold mb-2">{{ $timeline->title }}</h3>
                                    <p class="text-gray-600 text-sm md:text-base">{{ $timeline->description }}</p>
                                    <span class="text-sm text-gray-500">{{ $timeline->date->format('d F Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
