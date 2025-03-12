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

        .dashboard-menu {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .dashboard-menu:hover {
            transform: translateY(-2px);
        }

        .menu-item {
            padding: 1rem;
            border-bottom: 1px solid #edf2f7;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            background-color: rgba(176, 48, 82, 0.1);
        }

        .menu-item svg {
            width: 1.5rem;
            height: 1.5rem;
            margin-right: 1rem;
        }

        .menu-item:last-child {
            border-bottom: none;
        }
    </style>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ $user->name }}!</h2>
                    </div>

                    @if (session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="dashboard-menu">
                        <a href="{{ route('user.profile') }}" class="menu-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profil Saya
                        </a>
                        <a href="{{ route('user.orders') }}" class="menu-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Pesanan Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="menu-item hover:bg-red-50">
                            @csrf
                            <button type="submit" class="w-full flex items-center text-left text-red-600">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6 mr-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
