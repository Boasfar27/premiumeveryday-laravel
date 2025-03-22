<x-filament-panels::page>
    <x-filament::section>
        <h2 class="text-xl font-bold tracking-tight mb-4">
            Ekspor Laporan Keuangan
        </h2>

        <p class="text-gray-500 mb-6">
            Gunakan formulir di bawah ini untuk mengekspor data keuangan dan laporan berdasarkan kriteria yang Anda
            pilih. Laporan dapat diekspor dalam format CSV atau Excel.
        </p>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            {{ $this->form }}

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <x-filament::button color="primary" icon="heroicon-m-arrow-down-tray" wire:click="exportReport">
                    Ekspor Data
                </x-filament::button>
            </div>
        </div>

        <div class="mt-8 bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-2">Tips untuk Ekspor Laporan:</h3>
            <ul class="list-disc ml-5 text-gray-600 space-y-1">
                <li>Pilih rentang tanggal yang lebih pendek untuk laporan yang besar untuk mempercepat waktu pemrosesan
                </li>
                <li>Format CSV cocok untuk impor ke spreadsheet atau alat analisis lainnya</li>
                <li>Format Excel menyediakan laporan yang diformat dengan judul dan pemformatan yang lebih baik</li>
                <li>Anda dapat mengekspor laporan secara terpisah untuk setiap kategori atau jenis produk</li>
                <li>Untuk laporan penjualan, aktifkan opsi "Sertakan Detail Produk" untuk melihat produk yang dibeli di
                    setiap pesanan</li>
            </ul>
        </div>
    </x-filament::section>
</x-filament-panels::page>
