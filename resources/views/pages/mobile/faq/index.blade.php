@extends('pages.mobile.layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 pt-4">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h1>

        <div class="space-y-4">
            @foreach ($faqs as $faq)
                <div x-data="{ open: false }" class="bg-white rounded-lg shadow-sm">
                    <button @click="open = !open" class="w-full flex justify-between items-center p-4 focus:outline-none">
                        <span class="text-base font-medium text-gray-900">{{ $faq->question }}</span>
                        <svg class="w-5 h-5 text-gray-500" :class="{ 'transform rotate-180': open }" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-4 pb-4">
                        <p class="text-sm text-gray-600">{{ $faq->answer }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <p class="text-gray-600">Still have questions?</p>
            <a href="{{ route('contact') }}" class="inline-flex items-center mt-2 text-primary hover:text-primary-dark">
                Contact us
                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
@endsection
