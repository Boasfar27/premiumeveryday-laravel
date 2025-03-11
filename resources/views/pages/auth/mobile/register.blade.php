@extends('pages.layouts.app')

@section('content')
<div class="sm:hidden min-h-screen bg-white">
    <!-- Header -->
    <div class="bg-primary px-4 py-8 text-center">
        <h1 class="text-2xl font-bold text-white mb-2">Daftar Akun Baru</h1>
        <p class="text-gray-200">Bergabung dengan Premium Everyday</p>
    </div>

    <!-- Main Content -->
    <div class="px-4 py-6">
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-md bg-red-50">
                <div class="text-sm font-medium text-red-700">
                    {{ __('Oops! Ada yang salah.') }}
                </div>
                <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Social Register Buttons -->
        <div class="space-y-3 mb-6">
            <a href="{{ route('auth.google') }}" 
               class="flex items-center justify-center w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12.545,12.151L12.545,12.151c0,1.054,0.855,1.909,1.909,1.909h3.536c-0.367,1.719-1.159,3.25-2.27,4.401 c-1.647,1.647-3.924,2.667-6.436,2.667c-5.042,0-9.636-4.595-9.636-9.636s4.595-9.636,9.636-9.636c2.799,0,5.419,1.131,7.322,3.037 l-3.984,3.984c-0.849-0.849-2.012-1.376-3.299-1.376c-2.545,0-4.545,2-4.545,4.545s2,4.545,4.545,4.545 c1.287,0,2.45-0.527,3.299-1.376L12.545,12.151z M23.5,12.151L23.5,12.151c0,0.532-0.468,0.909-1,0.909h-8.046l-1.909-1.909h9.955 C23.032,11.151,23.5,11.619,23.5,12.151z"/>
                </svg>
                Daftar dengan Google
            </a>
        </div>

        <div class="relative mb-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">
                    Atau daftar dengan email
                </span>
            </div>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Lengkap
                </label>
                <input id="name" name="name" type="text" required 
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-secondary focus:border-secondary text-sm"
                       value="{{ old('name') }}">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Alamat Email
                </label>
                <input id="email" name="email" type="email" autocomplete="email" required 
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-secondary focus:border-secondary text-sm"
                       value="{{ old('email') }}">
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                    Nomor Telepon
                </label>
                <input id="phone" name="phone" type="tel" required 
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-secondary focus:border-secondary text-sm"
                       value="{{ old('phone') }}">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Kata Sandi
                </label>
                <input id="password" name="password" type="password" required 
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-secondary focus:border-secondary text-sm">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Konfirmasi Kata Sandi
                </label>
                <input id="password_confirmation" name="password_confirmation" type="password" required 
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-secondary focus:border-secondary text-sm">
            </div>

            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-4 w-4 text-secondary focus:ring-secondary border-gray-300 rounded">
                </div>
                <div class="ml-2 text-sm">
                    <label for="terms" class="font-medium text-gray-700">
                        Saya setuju dengan
                    </label>
                    <a href="{{ route('terms') }}" class="text-secondary hover:text-secondary-light"> Syarat dan Ketentuan</a>
                    serta
                    <a href="{{ route('privacy') }}" class="text-secondary hover:text-secondary-light">Kebijakan Privasi</a>
                </div>
            </div>

            <button type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-secondary hover:bg-secondary-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary transition-colors duration-200">
                Daftar Sekarang
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="font-medium text-secondary hover:text-secondary-light transition-colors duration-200">
                Masuk disini
            </a>
        </p>
    </div>
</div>
@endsection 