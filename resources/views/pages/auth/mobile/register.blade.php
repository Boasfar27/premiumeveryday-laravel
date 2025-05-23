@extends('pages.mobile.layouts.app')

@section('title', 'Register - Premium Everyday')

@section('content')
    <div class="min-h-screen bg-white">
        <!-- Header -->
        {{-- <div class="py-6 px-4 bg-pink-600">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img class="h-8 w-auto" src="{{ asset('images/logo.webp') }}" alt="Premium Everyday">
                </a>
            </div>
        </div> --}}

        <!-- Registration Form -->
        <div class="px-4 py-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Daftar Akun</h2>
                <p class="text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-pink-600 hover:text-pink-700 font-medium">
                        Masuk disini
                    </a>
                </p>
            </div>

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

            <form class="space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Nama Lengkap
                    </label>
                    <input id="name" name="name" type="text" autocomplete="name" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm"
                        value="{{ old('name') }}">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Alamat Email
                    </label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm"
                        value="{{ old('email') }}">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        Nomor Telepon
                    </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span
                            class="inline-flex items-center px-3 py-2 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                            08
                        </span>
                        <input id="phone" name="phone" type="tel" autocomplete="tel"
                            class="flex-1 block w-full px-3 py-2 rounded-none rounded-r-md border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm"
                            value="{{ old('phone') ? substr(old('phone'), 2) : '' }}" placeholder="XXXXXXXXXX">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Kata Sandi
                    </label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Konfirmasi Kata Sandi
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        autocomplete="new-password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                        Daftar
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">
                            Atau daftar dengan
                        </span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('auth.google') }}"
                        class="w-full inline-flex justify-center items-center px-4 py-3 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48">
                            <path fill="#FFC107"
                                d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
                            <path fill="#FF3D00"
                                d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
                            <path fill="#4CAF50"
                                d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z" />
                            <path fill="#1976D2"
                                d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z" />
                        </svg>
                        Daftar dengan Google
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
