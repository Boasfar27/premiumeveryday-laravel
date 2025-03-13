<!-- Contact Section -->
<div class="bg-white py-8 md:py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl md:text-4xl font-bold text-center mb-6 md:mb-12">Hubungi Kami</h2>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                <!-- Contact Information -->
                <div class="bg-blue-600 text-white rounded-lg p-6 md:p-8">
                    <h3 class="text-xl md:text-2xl font-bold mb-6">Informasi Kontak</h3>

                    <div class="space-y-6">
                        @foreach ($contacts as $contact)
                            <div class="flex items-start space-x-4">
                                @if ($contact->icon)
                                    <i class="{{ $contact->icon }} w-5 h-5 md:w-6 md:h-6 mt-1"></i>
                                @else
                                    <svg class="w-5 h-5 md:w-6 md:h-6 mt-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                                <div>
                                    <h4 class="font-semibold text-sm md:text-base">{{ $contact->type }}</h4>
                                    <p class="text-sm md:text-base">
                                        @if ($contact->link)
                                            <a href="{{ $contact->link }}" target="_blank" class="hover:underline">
                                                {{ $contact->value }}
                                            </a>
                                        @else
                                            {{ $contact->value }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-gray-50 rounded-lg p-6 md:p-8">
                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-4 md:space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full px-3 py-2 md:px-4 md:py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm md:text-base @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="w-full px-3 py-2 md:px-4 md:py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm md:text-base @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                            <textarea name="message" id="message" rows="4" required
                                class="w-full px-3 py-2 md:px-4 md:py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm md:text-base @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors text-sm md:text-base">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
