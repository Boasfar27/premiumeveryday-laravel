@extends('pages.layouts.app')

@section('title', 'Dashboard - Premium Everyday')

@section('styles')
<style>
    :root {
        --primary-dark: #3D0301;
        --primary: #B03052;
        --secondary: #D76C82;
        --accent: #3D0301;
    }

    .dashboard-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
    }

    .stat-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        border-radius: 10px;
        padding: 20px;
    }

    .nav-pills .nav-link.active {
        background-color: var(--primary);
    }

    .nav-pills .nav-link {
        color: var(--primary-dark);
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(215, 108, 130, 0.1);
    }
</style>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Selamat Datang, {{ $user->name }}!</h2>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
                
                @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Ringkasan Akun -->
                    <div class="md:col-span-2">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Ringkasan Akun</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-600">Nama</p>
                                    <p class="font-medium">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Email</p>
                                    <p class="font-medium">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">No. Telepon</p>
                                    <p class="font-medium">{{ $user->phone }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Status Email</p>
                                    @if($user->email_verified_at)
                                        <p class="text-green-600 font-medium">Terverifikasi</p>
                                    @else
                                        <p class="text-red-600 font-medium">Belum Terverifikasi</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Cepat -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold">Menu Cepat</h3>
                        <a href="{{ route('products') }}" class="flex items-center p-4 bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Lihat Produk
                        </a>
                        <a href="{{ route('user.orders') }}" class="flex items-center p-4 bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Pesanan Saya
                        </a>
                        <a href="{{ route('user.profile') }}" class="flex items-center p-4 bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profil Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 