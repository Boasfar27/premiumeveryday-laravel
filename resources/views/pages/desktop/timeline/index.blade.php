@extends('pages.layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Our Journey</h1>

        <div class="relative">
            <!-- Timeline line -->
            <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-0.5 bg-gray-200"></div>

            <!-- Timeline items -->
            @foreach ($timelines as $timeline)
                <div class="relative mb-12">
                    <div class="flex items-center justify-between">
                        <!-- Left content (even items) -->
                        @if ($loop->iteration % 2 == 0)
                            <div class="w-5/12 pr-8 text-right">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $timeline->title }}</h3>
                                <p class="mt-2 text-gray-600">{{ $timeline->description }}</p>
                                <span class="block mt-2 text-sm text-gray-500">{{ $timeline->date->format('F Y') }}</span>
                            </div>
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 flex items-center justify-center w-8 h-8 bg-primary rounded-full">
                                <span class="text-white">{{ $loop->iteration }}</span>
                            </div>
                            <div class="w-5/12"></div>
                        @else
                            <!-- Right content (odd items) -->
                            <div class="w-5/12"></div>
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 flex items-center justify-center w-8 h-8 bg-primary rounded-full">
                                <span class="text-white">{{ $loop->iteration }}</span>
                            </div>
                            <div class="w-5/12 pl-8">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $timeline->title }}</h3>
                                <p class="mt-2 text-gray-600">{{ $timeline->description }}</p>
                                <span class="block mt-2 text-sm text-gray-500">{{ $timeline->date->format('F Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
