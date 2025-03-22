@extends('pages.mobile.layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 pt-20">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Our Journey</h1>

        <div class="relative">
            <!-- Timeline line -->
            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-pink-200"></div>

            <!-- Timeline items -->
            @foreach ($timelines as $timeline)
                <div class="relative pl-12 pb-8">
                    <!-- Timeline dot -->
                    <div class="absolute left-0 flex items-center justify-center w-8 h-8 bg-pink-600 rounded-full shadow-md">
                        <span class="text-white font-medium">{{ $loop->iteration }}</span>
                    </div>

                    <!-- Content -->
                    <div
                        class="bg-white rounded-lg shadow-sm p-5 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $timeline->title }}</h3>
                        <p class="mt-2 text-gray-600">{{ $timeline->description }}</p>
                        <span class="block mt-3 text-sm text-pink-600">{{ $timeline->date->format('F Y') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
