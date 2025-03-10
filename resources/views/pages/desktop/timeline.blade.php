@extends('layouts.desktop.app')

@section('title', 'Timeline')

@section('content')
    <div class="bg-gradient-to-r from-pink-500 to-pink-600 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold text-white text-center">
                Timeline
            </h1>
            <p class="mt-4 text-xl text-pink-100 text-center">
                Ikuti perkembangan terbaru dari Premium Everyday
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flow-root">
            <ul role="list" class="-mb-8">
                @foreach($timelines as $index => $timeline)
                    <li>
                        <div class="relative pb-8">
                            @if(!$loop->last)
                                <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                            @endif
                            <div class="relative flex items-start space-x-3">
                                <div class="relative">
                                    <img class="h-10 w-10 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white" src="{{ $timeline['image'] }}" alt="">
                                    @switch($timeline['type'])
                                        @case('promo')
                                            <span class="absolute -bottom-0.5 -right-1 bg-pink-600 rounded-full p-0.5">
                                                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 2a.75.75 0 01.75.75v5.59l1.95-2.1a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0L6.2 7.26a.75.75 0 111.1-1.02l1.95 2.1V2.75A.75.75 0 0110 2z"/>
                                                </svg>
                                            </span>
                                            @break
                                        @case('update')
                                            <span class="absolute -bottom-0.5 -right-1 bg-green-500 rounded-full p-0.5">
                                                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
                                                </svg>
                                            </span>
                                            @break
                                        @case('maintenance')
                                            <span class="absolute -bottom-0.5 -right-1 bg-yellow-500 rounded-full p-0.5">
                                                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14.5a6.5 6.5 0 110-13 6.5 6.5 0 010 13zm0-11a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5.5zm0 7a1 1 0 100-2 1 1 0 000 2z"/>
                                                </svg>
                                            </span>
                                            @break
                                        @case('new')
                                            <span class="absolute -bottom-0.5 -right-1 bg-blue-500 rounded-full p-0.5">
                                                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z"/>
                                                </svg>
                                            </span>
                                            @break
                                    @endswitch
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="bg-white rounded-lg shadow-sm px-6 py-4 border border-gray-200">
                                        <div class="flex justify-between items-center mb-1">
                                            <div class="text-sm text-gray-500">{{ $timeline['date'] }}</div>
                                            @switch($timeline['type'])
                                                @case('promo')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                                        Promo
                                                    </span>
                                                    @break
                                                @case('update')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Update
                                                    </span>
                                                    @break
                                                @case('maintenance')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Maintenance
                                                    </span>
                                                    @break
                                                @case('new')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        New
                                                    </span>
                                                    @break
                                            @endswitch
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">{{ $timeline['title'] }}</h3>
                                        <p class="mt-1 text-gray-700">{{ $timeline['description'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection 