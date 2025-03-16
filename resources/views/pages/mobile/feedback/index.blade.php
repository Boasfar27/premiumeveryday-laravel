@extends('pages.mobile.layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 pt-4">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Feedback</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('feedback.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-base">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-base">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                <div class="flex justify-between items-center px-4">
                    @for ($i = 1; $i <= 5; $i++)
                        <label class="flex flex-col items-center">
                            <input type="radio" name="rating" value="{{ $i }}"
                                {{ old('rating') == $i ? 'checked' : '' }}
                                class="focus:ring-primary h-5 w-5 text-primary border-gray-300">
                            <span class="mt-1 text-sm text-gray-600">{{ $i }}</span>
                        </label>
                    @endfor
                </div>
                @error('rating')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                <textarea name="message" id="message" rows="4" required
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-base">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Submit Feedback
                </button>
            </div>
        </form>
    </div>
@endsection
