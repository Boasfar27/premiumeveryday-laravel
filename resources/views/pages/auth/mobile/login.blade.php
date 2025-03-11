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
<div class="auth-container">
    <div class="auth-header">
        <h4 class="mb-0">Masuk ke Premium Everyday</h4>
        <p class="mb-0">Nikmati layanan premium dengan harga terjangkau</p>
    </div>

    <div class="auth-card">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Google Login Button -->
        <a href="{{ route('google.redirect') }}" class="btn btn-google w-100 mb-3">
            <img src="https://www.google.com/favicon.ico" alt="Google" width="20">
            Masuk dengan Google
        </a>

        <div class="divider">
            <span>atau</span>
        </div>

        <!-- Manual Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>

            <div class="d-grid gap-2 mb-3">
                <button type="submit" class="btn btn-primary">Masuk</button>
            </div>

            <div class="text-center mb-3">
                <a href="{{ route('password.request') }}" class="text-decoration-none">
                    Lupa password?
                </a>
            </div>

            <div class="text-center">
                <p class="mb-0">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-decoration-none">Daftar sekarang</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection 