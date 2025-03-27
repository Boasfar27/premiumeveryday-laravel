@extends('pages.mobile.layouts.app')

@section('styles')
    <style>
        .contact-section {
            background-color: #f9fafb;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23ec4899' fill-opacity='0.05'%3E%3Cpath d='M0 38.59l2.83-2.83 1.41 1.41L1.41 40H0v-1.41zM0 20l2.83-2.83 1.41 1.41L1.41 21.41 0 22.83V20zM0 .59l2.83 2.83 1.41-1.41L1.41 0H0v.59zm40 18l-2.83 2.83-1.41-1.41 2.83-2.83L40 17.17V20zm0 18l-2.83 2.83-1.41-1.41 2.83-2.83L40 37.17V40zm0-37.41l-2.83 2.83-1.41-1.41L37.17 0H40v.59zm-20 0l-2.83 2.83-1.41-1.41L17.17 0H20v.59zm0 40l-2.83-2.83 1.41-1.41 2.83 2.83L20 40h-1.41zM20 20l-2.83 2.83-1.41-1.41 2.83-2.83L20 17.17V20zM0 20v-1.41l2.83 2.83L1.41 22.83 0 21.41V20z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .contact-card {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .contact-card:hover {
            border-left: 3px solid #EC4899;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .contact-icon {
            transition: all 0.3s ease;
        }
    </style>
@endsection

@section('content')
    <div class="contact-section min-h-screen pt-20 pb-8">
        <div class="px-4">
            <!-- Header -->
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Get in Touch</h2>
                <p class="text-sm text-gray-600">Have a question? We're here to help!</p>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm"
                    role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Contact Info Cards -->
            <div class="space-y-4 mb-6">
                <div class="contact-card bg-white p-4 rounded-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="contact-icon w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full">
                                <svg class="h-5 w-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-base font-semibold text-gray-900">Phone</h3>
                            <p class="mt-1 text-sm text-gray-600">+62 812-3456-7890</p>
                            <p class="mt-1 text-xs text-gray-500">Monday - Friday, 9am - 5pm WIB</p>
                        </div>
                    </div>
                </div>

                <div class="contact-card bg-white p-4 rounded-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="contact-icon w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full">
                                <svg class="h-5 w-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-base font-semibold text-gray-900">Email</h3>
                            <p class="mt-1 text-sm text-gray-600">info@premiumeveryday.com</p>
                            <p class="mt-1 text-xs text-gray-500">We'll respond as soon as possible</p>
                        </div>
                    </div>
                </div>

                <div class="contact-card bg-white p-4 rounded-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="contact-icon w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full">
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
                            <h3 class="text-base font-semibold text-gray-900">Address</h3>
                            <p class="mt-1 text-sm text-gray-600">Jl. Example No. 123, Jakarta Selatan</p>
                            <p class="mt-1 text-xs text-gray-500">Jakarta, Indonesia 12345</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="py-6 px-4">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Send us a Message</h3>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                                    required
                                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            </div>
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <textarea name="message" id="message" rows="4" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">{{ old('message') }}</textarea>
                            </div>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
