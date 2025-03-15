<!-- Mobile Featured Timeline -->
<section class="bg-white py-8">
    <div class="px-4">
        <!-- Section Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Our Journey</h2>
            <p class="text-gray-600">Key milestones in our company's history</p>
        </div>

        <!-- Timeline -->
        @if ($timelines->count() > 0)
            <div class="relative">
                <!-- Timeline Line -->
                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                <!-- Timeline Items -->
                <div class="space-y-8">
                    @foreach ($timelines as $timeline)
                        <div class="relative pl-12">
                            <!-- Timeline Dot -->
                            <div
                                class="absolute left-2 -translate-x-1/2 w-5 h-5 rounded-full border-4 border-white bg-primary">
                            </div>

                            <!-- Timeline Content -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                                <div class="flex flex-col">
                                    <time class="text-sm font-medium text-primary">
                                        {{ $timeline->formatted_date }}
                                    </time>
                                    <h3 class="mt-2 text-lg font-medium text-gray-900">
                                        {{ $timeline->title }}
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-600">
                                        {{ $timeline->description }}
                                    </p>
                                    @if ($timeline->image)
                                        <div class="mt-4">
                                            <img src="{{ asset($timeline->image) }}" alt="{{ $timeline->title }}"
                                                class="w-full h-48 object-cover rounded-md">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- View Full Timeline Button -->
            <div class="mt-8 text-center">
                <a href="{{ route('timeline') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    View Full Timeline
                </a>
            </div>
        @else
            <!-- No Timeline State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No timeline entries yet</h3>
                <p class="mt-1 text-sm text-gray-500">Check back soon for updates!</p>
            </div>
        @endif
    </div>
</section>
