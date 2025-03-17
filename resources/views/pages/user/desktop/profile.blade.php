@extends('pages.desktop.layouts.app')

@section('title', 'Profil Saya - Premium Everyday')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 mt-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-primary to-primary-dark p-8">
                <div class="flex items-center">
                    <div
                        class="h-24 w-24 rounded-full bg-white flex items-center justify-center text-2xl font-bold text-primary shadow-md">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="ml-8">
                        <h1 class="text-2xl font-bold text-white">{{ auth()->user()->name }}</h1>
                        <p class="text-primary-light mt-1">Bergabung sejak {{ auth()->user()->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="p-8">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Personal Information Form -->
                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                        <h2 class="text-xl font-semibold mb-6 text-gray-800 pb-2 border-b border-gray-200">Informasi Pribadi
                        </h2>
                        <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', auth()->user()->name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" value="{{ auth()->user()->email }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 cursor-not-allowed"
                                    disabled>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                                <input type="text" name="phone" id="phone"
                                    value="{{ old('phone', auth()->user()->phone) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit"
                                    class="bg-primary text-white px-5 py-2 rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 shadow-sm">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Change Password Form -->
                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                        <h2 class="text-xl font-semibold mb-6 text-gray-800 pb-2 border-b border-gray-200">Ubah Password
                        </h2>
                        <form action="{{ route('user.password.update') }}" method="POST" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat
                                    Ini</label>
                                <input type="password" name="current_password" id="current_password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                                <input type="password" name="password" id="password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700">Konfirmasi
                                    Password Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit"
                                    class="bg-primary text-white px-5 py-2 rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 shadow-sm">
                                    Ubah Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
