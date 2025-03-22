@extends('pages.desktop.layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-24">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Our Journey</h1>

        <div class="relative">
            <!-- Timeline line -->
            <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-0.5 bg-pink-200"></div>

            <!-- Timeline items -->
            @foreach ($timelines as $timeline)
                <div class="relative mb-12">
                    <div class="flex items-center justify-between">
                        <!-- Left content (even items) -->
                        @if ($loop->iteration % 2 == 0)
                            <div class="w-5/12 pr-8 text-right">
                                <div
                                    class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $timeline->title }}</h3>
                                    <p class="mt-2 text-gray-600">{{ $timeline->description }}</p>
                                    <span
                                        class="block mt-3 text-sm text-pink-600">{{ $timeline->date->format('F Y') }}</span>
                                </div>
                            </div>
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 flex items-center justify-center w-10 h-10 bg-pink-600 rounded-full shadow-md z-10">
                                <span class="text-white font-medium">{{ $loop->iteration }}</span>
                            </div>
                            <div class="w-5/12"></div>
                        @else
                            <!-- Right content (odd items) -->
                            <div class="w-5/12"></div>
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 flex items-center justify-center w-10 h-10 bg-pink-600 rounded-full shadow-md z-10">
                                <span class="text-white font-medium">{{ $loop->iteration }}</span>
                            </div>
                            <div class="w-5/12 pl-8">
                                <div
                                    class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $timeline->title }}</h3>
                                    <p class="mt-2 text-gray-600">{{ $timeline->description }}</p>
                                    <span
                                        class="block mt-3 text-sm text-pink-600">{{ $timeline->date->format('F Y') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
