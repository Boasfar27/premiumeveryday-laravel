@extends('pages.layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Our Journey</h1>

        <div class="relative">
            <!-- Timeline line -->
            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>

            <!-- Timeline items -->
            @foreach ($timelines as $timeline)
                <div class="relative pl-12 pb-8">
                    <!-- Timeline dot -->
                    <div class="absolute left-0 flex items-center justify-center w-8 h-8 bg-primary rounded-full">
                        <span class="text-white">{{ $loop->iteration }}</span>
                    </div>

                    <!-- Content -->
                    <div class="bg-white rounded-lg shadow-sm p-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $timeline->title }}</h3>
                        <p class="mt-2 text-gray-600">{{ $timeline->description }}</p>
                        <span class="block mt-2 text-sm text-gray-500">{{ $timeline->date->format('F Y') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
