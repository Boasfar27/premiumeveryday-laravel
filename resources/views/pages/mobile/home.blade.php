@extends('pages.layouts.app')

@section('title', 'Premium Everyday - Solusi Kebutuhan Premium Anda')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-primary">
        <div class="px-4 py-12">
            <div class="text-center">
                <h1 class="text-3xl font-extrabold tracking-tight text-white">
                    Premium Everyday
                </h1>
                <p class="mt-3 text-base text-gray-300">
                    Solusi terbaik untuk kebutuhan premium Anda setiap hari.
                </p>
                <div class="mt-5">
                    <a href="{{ route('products') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-primary bg-white hover:bg-gray-100">
                        Lihat Produk
                    </a>
                </div>
            </div>
        </div>  
    </div>

    <!-- Featured Products Section -->
    <div class="px-4 py-8">
        <h2 class="text-xl font-bold text-gray-900">Produk Unggulan</h2>
        <div class="mt-6 grid grid-cols-2 gap-4">
            @foreach($featuredProducts as $product)
            <div class="group relative">
                <div class="w-full bg-gray-200 rounded-md overflow-hidden aspect-w-1 aspect-h-1">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover">
                </div>
                <div class="mt-2">
                    <h3 class="text-sm font-medium text-gray-700">
                        <a href="{{ route('products.show', $product->id) }}">
                            {{ $product->name }}
                        </a>
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">{{ $product->category }}</p>
                    <p class="mt-1 text-sm font-medium text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection 