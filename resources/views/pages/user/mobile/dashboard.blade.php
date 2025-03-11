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
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }

    .stat-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .nav-pills .nav-link.active {
        background-color: var(--primary);
    }

    .nav-pills .nav-link {
        color: var(--primary-dark);
        padding: 8px 12px;
        font-size: 14px;
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .order-item {
        border-bottom: 1px solid #eee;
        padding: 10px 0;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .profile-section {
        text-align: center;
        padding: 20px 15px;
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        color: white;
        border-radius: 0 0 20px 20px;
        margin-bottom: 20px;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        padding: 15px;
    }

    .action-button {
        background: white;
        border: 1px solid var(--primary);
        color: var(--primary);
        padding: 10px;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        font-size: 14px;
    }

    .action-button:hover {
        background: var(--primary);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-4">Selamat Datang, {{ $user->name }}!</h2>
                
                @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
                @endif

                <div class="space-y-6">
                    <!-- Ringkasan -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-3">Ringkasan Akun</h3>
                        <div class="space-y-2">
                            <p><span class="font-medium">Nama:</span> {{ $user->name }}</p>
                            <p><span class="font-medium">Email:</span> {{ $user->email }}</p>
                            <p><span class="font-medium">No. Telepon:</span> {{ $user->phone }}</p>
                            <p><span class="font-medium">Status Email:</span> 
                                @if($user->email_verified_at)
                                    <span class="text-green-600">Terverifikasi</span>
                                @else
                                    <span class="text-red-600">Belum Terverifikasi</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Menu Cepat -->
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('products') }}" class="block p-4 bg-primary text-white rounded-lg text-center hover:bg-primary-dark transition">
                            <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Lihat Produk
                        </a>
                        <a href="{{ route('user.orders') }}" class="block p-4 bg-primary text-white rounded-lg text-center hover:bg-primary-dark transition">
                            <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Pesanan Saya
                        </a>
                        <a href="{{ route('user.profile') }}" class="block p-4 bg-primary text-white rounded-lg text-center hover:bg-primary-dark transition">
                            <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profil Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full p-4 bg-red-600 text-white rounded-lg text-center hover:bg-red-700 transition">
                                <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 