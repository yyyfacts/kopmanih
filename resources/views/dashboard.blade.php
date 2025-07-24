<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-600 text-white rounded-lg shadow p-6">
                            <div class="text-lg font-bold">Total Barang</div>
                            <div class="text-3xl mt-2">{{ $totalBarang ?? '-' }}</div>
                        </div>
                        <div class="bg-red-600 text-white rounded-lg shadow p-6">
                            <div class="text-lg font-bold">Stok Kritis</div>
                            <div class="text-3xl mt-2">{{ $stokKritis ?? '-' }}</div>
                        </div>
                        <div class="bg-green-600 text-white rounded-lg shadow p-6">
                            <div class="text-lg font-bold">Barang Masuk Bulan Ini</div>
                            <div class="text-3xl mt-2">{{ $barangMasuk ?? '-' }}</div>
                        </div>
                        <div class="bg-yellow-600 text-white rounded-lg shadow p-6">
                            <div class="text-lg font-bold">Barang Keluar Bulan Ini</div>
                            <div class="text-3xl mt-2">{{ $barangKeluar ?? '-' }}</div>
                        </div>
                        <div class="bg-purple-600 text-white rounded-lg shadow p-6">
                            <div class="text-lg font-bold">Pengajuan Pending</div>
                            <div class="text-3xl mt-2">{{ $pengajuanPending ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-6 text-gray-900 dark:text-gray-100">
                            Selamat datang di dashboard admin. Silakan gunakan menu di samping untuk mengelola data.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
