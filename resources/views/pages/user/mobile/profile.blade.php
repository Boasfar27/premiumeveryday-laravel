@extends('pages.mobile.layouts.app')

@section('title', 'Profil Saya - Premium Everyday')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-primary to-primary-dark p-4">
            <div class="flex flex-col items-center">
                <div
                    class="h-24 w-24 rounded-full bg-white flex items-center justify-center text-3xl font-bold text-primary mb-3">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <h1 class="text-xl font-bold text-white text-center">{{ auth()->user()->name }}</h1>
                <p class="text-primary-light text-sm">Bergabung sejak {{ auth()->user()->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="p-4">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Personal Information Form -->
            <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                <h2 class="text-lg font-semibold mb-4">Informasi Pribadi</h2>
                <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-sm">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" value="{{ auth()->user()->email }}"
                            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 cursor-not-allowed text-sm"
                            disabled>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                        <input type="text" name="phone" id="phone"
                            value="{{ old('phone', auth()->user()->phone) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-sm">
                        @error('phone')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-primary text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <!-- Change Password Form -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h2 class="text-lg font-semibold mb-4">Ubah Password</h2>
                <form action="{{ route('user.password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat
                            Ini</label>
                        <input type="password" name="current_password" id="current_password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-sm">
                        @error('current_password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <input type="password" name="password" id="password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-sm">
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                            Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-sm">
                    </div>

                    <button type="submit"
                        class="w-full bg-primary text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                        Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
