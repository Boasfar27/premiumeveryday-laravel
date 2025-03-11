@extends('pages.layouts.app')

@section('title', 'Verifikasi Email - Premium Everyday')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Verifikasi Email
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Silakan periksa email Anda untuk link verifikasi
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-sm text-red-600 rounded-md p-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-sm text-green-600 rounded-md p-4">
                {{ session('success') }}
            </div>
            @endif

            <div class="text-sm text-gray-700">
                <p>Kami telah mengirimkan link verifikasi ke email Anda. Silakan klik link tersebut untuk memverifikasi akun Anda.</p>
                <p class="mt-2">Tidak menerima email? Klik tombol di bawah untuk mengirim ulang.</p>
            </div>

            <form action="{{ route('verification.resend') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Kirim Ulang Link Verifikasi
                </button>
            </form>

            <div class="mt-6">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 