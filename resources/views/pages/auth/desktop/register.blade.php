@extends('pages.layouts.app')

@section('content')
<div class="hidden sm:flex min-h-screen items-center justify-center bg-gray-50">
    <div class="flex w-full max-w-6xl mx-auto shadow-lg rounded-lg overflow-hidden">
        <!-- Left Side - Image/Banner -->
        <div class="hidden lg:block w-1/2 bg-primary relative">
            <div class="absolute inset-0 bg-gradient-to-r from-primary to-secondary opacity-90"></div>
            <div class="relative z-10 p-12 text-white">
                <h2 class="text-4xl font-bold mb-6">Bergabung dengan Kami</h2>
                <p class="text-lg mb-8">Dapatkan akses ke berbagai layanan premium kami dengan mendaftar sekarang.</p>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Produk berkualitas premium</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Pengiriman cepat ke seluruh Indonesia</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Layanan pelanggan 24/7</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="w-full lg:w-1/2 bg-white p-12">
            <div class="max-w-md mx-auto">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Daftar Akun Baru</h2>
                    <p class="text-gray-600">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-secondary hover:text-secondary-light transition-colors duration-200">
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
                        <input id="name" name="name" type="text" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-secondary focus:border-secondary sm:text-sm"
                               value="{{ old('name') }}">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Alamat Email
                        </label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-secondary focus:border-secondary sm:text-sm"
                               value="{{ old('email') }}">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">
                            Nomor Telepon
                        </label>
                        <input id="phone" name="phone" type="tel" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-secondary focus:border-secondary sm:text-sm"
                               value="{{ old('phone') }}">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Kata Sandi
                        </label>
                        <input id="password" name="password" type="password" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-secondary focus:border-secondary sm:text-sm">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            Konfirmasi Kata Sandi
                        </label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-secondary focus:border-secondary sm:text-sm">
                    </div>

                    <div class="flex items-center">
                        <input id="terms" name="terms" type="checkbox" required
                               class="h-4 w-4 text-secondary focus:ring-secondary border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-gray-900">
                            Saya setuju dengan <a href="{{ route('terms') }}" class="text-secondary hover:text-secondary-light">Syarat dan Ketentuan</a> serta <a href="{{ route('privacy') }}" class="text-secondary hover:text-secondary-light">Kebijakan Privasi</a>
                        </label>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-secondary hover:bg-secondary-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary transition-colors duration-200">
                            Daftar Sekarang
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

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <a href="{{ route('auth.google') }}" 
                           class="flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.545,12.151L12.545,12.151c0,1.054,0.855,1.909,1.909,1.909h3.536c-0.367,1.719-1.159,3.25-2.27,4.401 c-1.647,1.647-3.924,2.667-6.436,2.667c-5.042,0-9.636-4.595-9.636-9.636s4.595-9.636,9.636-9.636c2.799,0,5.419,1.131,7.322,3.037 l-3.984,3.984c-0.849-0.849-2.012-1.376-3.299-1.376c-2.545,0-4.545,2-4.545,4.545s2,4.545,4.545,4.545 c1.287,0,2.45-0.527,3.299-1.376L12.545,12.151z M23.5,12.151L23.5,12.151c0,0.532-0.468,0.909-1,0.909h-8.046l-1.909-1.909h9.955 C23.032,11.151,23.5,11.619,23.5,12.151z"/>
                            </svg>
                            Google
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 