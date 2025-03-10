@extends('layouts.mobile.app')

@section('title', 'Kontak')

@section('content')
    <div class="bg-gradient-to-r from-pink-500 to-pink-600 py-8">
        <div class="px-4">
            <h1 class="text-3xl font-extrabold text-white text-center">
                Hubungi Kami
            </h1>
            <p class="mt-4 text-lg text-pink-100 text-center">
                Kami siap membantu Anda dengan layanan terbaik
            </p>
        </div>
    </div>

    <div class="px-4 py-8">
        <!-- Contact Methods -->
        <h2 class="text-xl font-bold text-gray-900 mb-4">Metode Kontak</h2>
        <div class="space-y-4">
            @foreach($contacts as $contact)
                <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 bg-pink-100 text-pink-600 rounded-lg flex items-center justify-center">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    {!! $contact['icon'] !!}
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-base font-medium text-gray-900">{{ $contact['title'] }}</h3>
                            <p class="text-sm text-gray-600">{{ $contact['value'] }}</p>
                        </div>
                    </div>
                    <p class="mt-3 text-xs text-gray-500">{{ $contact['description'] }}</p>
                    <div class="mt-4">
                        <a href="{{ $contact['link'] }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-pink-600 hover:bg-pink-700">
                            Hubungi via {{ $contact['title'] }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Business Hours -->
        <h2 class="text-xl font-bold text-gray-900 mb-4 mt-8">Jam Operasional</h2>
        <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
            <div class="space-y-3">
                @foreach($businessHours as $schedule)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ $schedule['day'] }}</span>
                        <span class="text-sm text-gray-900 font-medium">{{ $schedule['hours'] }}</span>
                    </div>
                    @if(!$loop->last)
                        <hr class="border-gray-200">
                    @endif
                @endforeach
            </div>

            <div class="mt-6">
                <div class="rounded-md bg-pink-50 p-3">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-pink-800">Catatan</h3>
                            <div class="mt-2 text-xs text-pink-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Respon lebih cepat pada jam operasional</li>
                                    <li>Aktivasi akun dilakukan pada jam operasional</li>
                                    <li>Hari libur nasional menyesuaikan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 