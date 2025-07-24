@extends('layouts.app')
@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-600 text-white rounded-lg shadow p-6">
                <div class="text-lg font-bold">Total Barang</div>
                <div class="text-3xl mt-2">{{ $totalBarang ?? '-' }}</div>
            </div>
            <div class="bg-green-600 text-white rounded-lg shadow p-6">
                <div class="text-lg font-bold">Barang Masuk Hari Ini</div>
                <div class="text-3xl mt-2">{{ $barangMasuk ?? '-' }}</div>
            </div>
            <div class="bg-yellow-600 text-white rounded-lg shadow p-6">
                <div class="text-lg font-bold">Barang Keluar Hari Ini</div>
                <div class="text-3xl mt-2">{{ $barangKeluar ?? '-' }}</div>
            </div>
            <div class="bg-red-600 text-white rounded-lg shadow p-6">
                <div class="text-lg font-bold">Stok Kritis</div>
                <div class="text-3xl mt-2">{{ $stokKritis ?? '-' }}</div>
            </div>
        </div>

        <!-- Notifikasi Stok Kritis -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-2 text-red-700">Notifikasi Stok Kritis</h2>
            @if($lowStockCount > 0)
                <ul class="list-disc pl-6 text-red-600">
                    @foreach($lowStockItems as $item)
                        <li>{{ $item->nama_barang }} (Stok: {{ $item->stok }})</li>
                    @endforeach
                </ul>
            @else
                <div class="text-green-600">Tidak ada barang dengan stok kritis.</div>
            @endif
        </div>

        <!-- Grafik -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Barang Masuk per Bulan ({{ date('Y') }})</h2>
                <canvas id="barangMasukChart"></canvas>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Distribusi Barang per Kategori</h2>
                <canvas id="kategoriPieChart"></canvas>
            </div>
        </div>

        <div class="mt-8">
            <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-6 text-gray-900 dark:text-gray-100">
                Selamat datang di dashboard admin. Menu dan fitur akan menyesuaikan peran Anda.
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Bar Chart Barang Masuk per Bulan
        const barangMasukData = {
            labels: [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
            ],
            datasets: [{
                label: 'Barang Masuk',
                backgroundColor: '#256D85',
                borderColor: '#256D85',
                data: [
                    @for($i=1;$i<=12;$i++)
                        {{ $barangMasukPerBulan[$i] ?? 0 }},
                    @endfor
                ],
            }]
        };
        new Chart(document.getElementById('barangMasukChart'), {
            type: 'bar',
            data: barangMasukData,
            options: {
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });

        // Pie Chart Distribusi Kategori
        const kategoriLabels = [
            @foreach($kategoriDistribusi as $kategori)
                '{{ $kategori->nama_kategori }}',
            @endforeach
        ];
        const kategoriData = [
            @foreach($kategoriDistribusi as $kategori)
                {{ $kategori->barangs_count }},
            @endforeach
        ];
        new Chart(document.getElementById('kategoriPieChart'), {
            type: 'pie',
            data: {
                labels: kategoriLabels,
                datasets: [{
                    data: kategoriData,
                    backgroundColor: [
                        '#256D85', '#00B2FF', '#38a169', '#e53e3e', '#f6ad55', '#805ad5', '#319795', '#ecc94b', '#718096', '#2d3748', '#4fd1c5', '#f687b3'
                    ]
                }]
            },
            options: { responsive: true }
        });
    </script>
    @endpush
@endsection
