<!-- FAQ Section -->
<div class="bg-gray-100 py-8 md:py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl md:text-4xl font-bold text-center mb-6 md:mb-12">Pertanyaan yang Sering Diajukan</h2>

        <div class="max-w-3xl mx-auto space-y-4">
            @foreach ($faqs as $faq)
                <div x-data="{ open: false }" class="bg-white rounded-lg shadow-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full p-4 text-left">
                        <span class="text-base md:text-lg font-semibold">{{ $faq->question }}</span>
                        <svg class="w-5 h-5 md:w-6 md:h-6 transform transition-transform" :class="{ 'rotate-180': open }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95" class="p-4 pt-0 border-t">
                        <p class="text-gray-600 text-sm md:text-base">{{ $faq->answer }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
