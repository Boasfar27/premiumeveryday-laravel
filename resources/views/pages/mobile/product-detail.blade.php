@extends('layouts.mobile.app')

@section('title', $product['name'])

@section('content')
    <div class="bg-gradient-to-r from-pink-500 to-pink-600 py-8">
        <div class="px-4">
            <div class="text-center">
                <h1 class="text-3xl font-extrabold text-white">
                    {{ $product['name'] }}
                </h1>
                <p class="mt-4 text-lg text-pink-100">
                    {{ $product['description'] }}
                </p>
            </div>
        </div>
    </div>

    <div class="px-4 py-8">
        <!-- Product info -->
        <div class="bg-white rounded-lg shadow-lg p-6 border border-pink-100">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-bold text-black">Detail Harga</h2>
                    <p class="text-3xl font-bold text-pink-600 mt-2">
                        Rp {{ number_format($product['price'], 0, ',', '.') }}
                    </p>
                    <p class="text-gray-500 mt-1">Sharing Account</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-800">
                    {{ $product['status'] }}
                </span>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-medium text-black">Fitur yang Didapat:</h3>
                <ul class="mt-4 space-y-3">
                    @foreach($product['features'] as $feature)
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="ml-3 text-gray-700">{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-6 space-y-3">
                <a href="https://wa.me/6281234567890?text=Halo, saya tertarik dengan {{ urlencode($product['name']) }}" class="w-full inline-flex justify-center items-center px-4 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-black hover:bg-gray-900">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    Pesan via WhatsApp
                </a>
                <a href="{{ route('products') }}" class="w-full inline-flex justify-center items-center px-4 py-3 border-2 border-pink-600 rounded-md shadow-sm text-base font-medium text-pink-600 bg-white hover:bg-pink-50">
                    Kembali ke Daftar Produk
                </a>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-8">
            <div class="bg-white rounded-lg shadow-lg p-6 border border-pink-100">
                <h2 class="text-xl font-bold text-black">Informasi Tambahan</h2>
                
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-black">Cara Berlangganan:</h3>
                    <ol class="mt-4 space-y-4">
                        <li class="flex">
                            <span class="flex-shrink-0 flex items-center justify-center h-7 w-7 rounded-full bg-pink-600 text-white font-bold text-sm">1</span>
                            <p class="ml-3 text-gray-700">Klik tombol "Pesan via WhatsApp" di atas</p>
                        </li>
                        <li class="flex">
                            <span class="flex-shrink-0 flex items-center justify-center h-7 w-7 rounded-full bg-pink-600 text-white font-bold text-sm">2</span>
                            <p class="ml-3 text-gray-700">Customer service kami akan membantu proses pemesanan</p>
                        </li>
                        <li class="flex">
                            <span class="flex-shrink-0 flex items-center justify-center h-7 w-7 rounded-full bg-pink-600 text-white font-bold text-sm">3</span>
                            <p class="ml-3 text-gray-700">Lakukan pembayaran sesuai instruksi</p>
                        </li>
                        <li class="flex">
                            <span class="flex-shrink-0 flex items-center justify-center h-7 w-7 rounded-full bg-pink-600 text-white font-bold text-sm">4</span>
                            <p class="ml-3 text-gray-700">Akun akan diaktivasi setelah pembayaran dikonfirmasi</p>
                        </li>
                    </ol>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-medium text-black">Catatan Penting:</h3>
                    <ul class="mt-4 space-y-2 text-gray-700 text-sm">
                        <li>• Pastikan menggunakan akun sesuai ketentuan</li>
                        <li>• Jangan mengubah password atau informasi akun</li>
                        <li>• Hubungi CS jika mengalami kendala</li>
                        <li>• Perpanjangan dapat dilakukan sebelum masa aktif habis</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection 