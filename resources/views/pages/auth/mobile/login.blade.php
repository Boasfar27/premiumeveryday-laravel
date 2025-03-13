@extends('pages.layouts.app')

@section('title', 'Login')

@section('styles')
    <style>
        :root {
            --primary-dark: #3D0301;
            --primary: #B03052;
            --secondary: #D76C82;
            --accent: #3D0301;
        }

        .auth-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .auth-header {
            color: white;
            padding: 2rem 1rem;
            text-align: center;
        }

        .auth-card {
            background: white;
            border-radius: 20px 20px 0 0;
            padding: 1.5rem;
            min-height: calc(100vh - 150px);
        }

        .form-control {
            border-radius: 10px;
            padding: 0.8rem 1rem;
            font-size: 16px;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(176, 48, 82, 0.25);
        }

        .btn {
            padding: 0.8rem;
            border-radius: 10px;
            font-size: 16px;
        }

        .btn-google {
            background-color: #fff;
            color: #757575;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-google:hover {
            background-color: #f8f9fa;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }

        .divider span {
            padding: 0 1rem;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
    </style>
@endsection

@section('content')
    <div class="sm:hidden min-h-screen bg-white">
        <!-- Header -->
        <div class="bg-primary px-4 py-8 text-center">
            <h1 class="text-2xl font-bold text-white mb-2">Masuk ke Akun Anda</h1>
            <p class="text-gray-200">Nikmati layanan premium kami</p>
        </div>

        <!-- Main Content -->
        <div class="px-4 py-6">
            @if (session('status'))
                <div class="mb-4 p-4 rounded-md bg-green-50 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

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

            <!-- Social Login Buttons -->
            <div class="space-y-3 mb-6">
                <a href="{{ route('auth.google') }}"
                    class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors duration-200">
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
                    Masuk dengan Google
                </a>
            </div>

            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">
                        Atau masuk dengan email
                    </span>
                </div>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Alamat Email
                    </label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-secondary focus:border-secondary text-sm"
                        value="{{ old('email') }}">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Kata Sandi
                    </label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-secondary focus:border-secondary text-sm">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="h-4 w-4 text-secondary focus:ring-secondary border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Ingat Saya
                        </label>
                    </div>

                    <a href="{{ route('password.request') }}"
                        class="text-sm font-medium text-secondary hover:text-secondary-light transition-colors duration-200">
                        Lupa kata sandi?
                    </a>
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-secondary hover:bg-secondary-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary transition-colors duration-200">
                    Masuk
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}"
                    class="font-medium text-secondary hover:text-secondary-light transition-colors duration-200">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </div>
@endsection
