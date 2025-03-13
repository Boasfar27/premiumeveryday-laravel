<!-- FAQ Section -->
<div class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12">Pertanyaan yang Sering Diajukan</h2>

        <div class="max-w-3xl mx-auto space-y-4">
            <!-- FAQ Item 1 -->
            <div x-data="{ open: false }" class="bg-white rounded-lg shadow-md">
                <button @click="open = !open" class="flex justify-between items-center w-full p-4 text-left">
                    <span class="text-lg font-semibold">Bagaimana cara melakukan pemesanan?</span>
                    <svg class="w-6 h-6 transform transition-transform" :class="{ 'rotate-180': open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" class="p-4 pt-0 border-t">
                    <p class="text-gray-600">
                        Pemesanan dapat dilakukan melalui WhatsApp kami. Cukup klik tombol "Pesan Sekarang" pada produk
                        yang Anda inginkan, dan Anda akan diarahkan ke WhatsApp kami untuk proses pemesanan lebih
                        lanjut.
                    </p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div x-data="{ open: false }" class="bg-white rounded-lg shadow-md">
                <button @click="open = !open" class="flex justify-between items-center w-full p-4 text-left">
                    <span class="text-lg font-semibold">Metode pembayaran apa saja yang tersedia?</span>
                    <svg class="w-6 h-6 transform transition-transform" :class="{ 'rotate-180': open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" class="p-4 pt-0 border-t">
                    <p class="text-gray-600">
                        Kami menerima pembayaran melalui transfer bank (BCA, Mandiri, BNI) dan e-wallet (DANA, OVO,
                        GoPay). Detail pembayaran akan diberikan setelah konfirmasi pesanan.
                    </p>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div x-data="{ open: false }" class="bg-white rounded-lg shadow-md">
                <button @click="open = !open" class="flex justify-between items-center w-full p-4 text-left">
                    <span class="text-lg font-semibold">Berapa lama proses aktivasi akun?</span>
                    <svg class="w-6 h-6 transform transition-transform" :class="{ 'rotate-180': open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" class="p-4 pt-0 border-t">
                    <p class="text-gray-600">
                        Proses aktivasi akun dilakukan dalam waktu maksimal 15 menit setelah pembayaran dikonfirmasi.
                        Kami akan segera mengirimkan detail akun melalui WhatsApp.
                    </p>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div x-data="{ open: false }" class="bg-white rounded-lg shadow-md">
                <button @click="open = !open" class="flex justify-between items-center w-full p-4 text-left">
                    <span class="text-lg font-semibold">Apakah akun dijamin legal?</span>
                    <svg class="w-6 h-6 transform transition-transform" :class="{ 'rotate-180': open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" class="p-4 pt-0 border-t">
                    <p class="text-gray-600">
                        Ya, semua akun yang kami sediakan 100% legal dan bergaransi. Jika terjadi masalah dengan akun,
                        kami akan memberikan penggantian secara gratis selama masa berlangganan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
