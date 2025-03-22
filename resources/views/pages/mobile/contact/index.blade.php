@extends('pages.mobile.layouts.app')

@section('content')
    <div class="px-4 py-8 pt-20 bg-gray-50">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-6">Contact Us</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm mb-6"
                role="alert">
                <span class="block text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Contact Information -->
        <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Get in Touch</h3>
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full">
                            <svg class="h-5 w-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-base font-medium text-gray-900">Phone</p>
                        <p class="mt-1 text-sm text-gray-500">+62 812-3456-7890</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full">
                            <svg class="h-5 w-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-base font-medium text-gray-900">Email</p>
                        <p class="mt-1 text-sm text-gray-500">info@premiumeveryday.com</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full">
                            <svg class="h-5 w-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-base font-medium text-gray-900">Address</p>
                        <p class="mt-1 text-sm text-gray-500">Jl. Example No. 123, Jakarta Selatan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Send us a Message</h3>
            <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 transition-colors text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 transition-colors text-sm">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 transition-colors text-sm">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea name="message" id="message" rows="4" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 transition-colors text-sm">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition duration-300 ease-in-out">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
