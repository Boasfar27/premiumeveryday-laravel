@extends('pages.desktop.layouts.app')

@section('title', 'Lupa Password - Premium Everyday')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 pt-24 md:pt-20">
        <div class="w-full max-w-md mx-auto">
            <div class="bg-white py-8 px-6 shadow-lg rounded-lg">
                <div class="text-center mb-8">
                    <a href="{{ route('home') }}" class="inline-block mb-6">
                        <img class="h-12 w-auto mx-auto" src="{{ asset('images/logo.webp') }}" alt="Premium Everyday">
                    </a>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Lupa Password</h2>
                    <p class="text-gray-600">
                        Masukkan alamat email yang terdaftar untuk menerima link reset password
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-4 p-4 rounded-md bg-green-50 text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 rounded-md bg-red-50">
                        <div class="font-medium text-red-700">
                            {{ __('Oops! Ada yang salah.') }}
                        </div>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="space-y-6" action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Alamat Email
                        </label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm"
                            value="{{ old('email') }}" placeholder="Masukkan email anda">
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                            Kirim Link Reset Password
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-pink-600 hover:text-pink-700">
                        <span class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke halaman login
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
