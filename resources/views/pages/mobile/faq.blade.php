@extends('layouts.mobile.app')

@section('title', 'FAQ')

@section('content')
    <div class="bg-gradient-to-r from-pink-500 to-pink-600 py-8">
        <div class="px-4">
            <h1 class="text-3xl font-extrabold text-white text-center">
                FAQ
            </h1>
            <p class="mt-4 text-lg text-pink-100 text-center">
                Temukan jawaban untuk pertanyaan yang sering diajukan
            </p>
        </div>
    </div>

    <div class="px-4 py-8">
        <div class="space-y-3">
            @foreach($faqs as $index => $faq)
                <div x-data="{ open: false }" class="border border-gray-200 rounded-lg">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left">
                        <span class="text-base font-medium text-gray-900">{{ $faq['question'] }}</span>
                        <svg class="h-5 w-5 text-gray-500 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse>
                        <div class="px-4 pb-3">
                            <div class="prose prose-pink max-w-none">
                                <p class="text-sm text-gray-700">{{ $faq['answer'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600">
                Masih punya pertanyaan?
            </p>
            <a href="https://wa.me/6281234567890?text=Halo, saya ingin bertanya tentang layanan Premium Everyday" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-pink-600 hover:bg-pink-700">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                Hubungi Kami
            </a>
        </div>
    </div>

    @push('scripts')
        <script src="//unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    @endpush
@endsection 