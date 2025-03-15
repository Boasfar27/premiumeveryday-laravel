<!-- Timeline Section -->
<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">Our Journey</h2>
            <p class="text-lg text-gray-600 mb-12">Key milestones in our growth and development</p>
        </div>

        <div class="relative">
            <!-- Timeline Line -->
            <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-0.5 bg-gray-200"></div>

            <!-- Timeline Items -->
            <div class="space-y-12">
                @forelse ($timelines as $timeline)
                    <div class="relative">
                        <!-- Timeline Point -->
                        <div class="absolute left-1/2 transform -translate-x-1/2 -mt-2">
                            <div class="w-4 h-4 rounded-full bg-primary border-4 border-white"></div>
                        </div>

                        <!-- Timeline Content -->
                        <div
                            class="relative {{ $loop->iteration % 2 == 0 ? 'pl-12 lg:pl-0 lg:pr-12 lg:ml-auto lg:w-1/2 text-left' : 'pr-12 lg:w-1/2 text-right' }}">
                            <div class="bg-white p-6 rounded-lg shadow-sm">
                                <div
                                    class="flex items-center {{ $loop->iteration % 2 == 0 ? '' : 'justify-end' }} mb-2">
                                    @if ($timeline->icon)
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 text-primary-600 mr-2">
                                            <i class="{{ $timeline->icon }}"></i>
                                        </span>
                                    @endif
                                    <time class="text-sm text-gray-500">{{ $timeline->date->format('F Y') }}</time>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $timeline->title }}</h3>
                                <p class="text-gray-600">{{ $timeline->description }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No timeline entries available</h3>
                        <p class="text-gray-500">Check back later for updates on our journey.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
