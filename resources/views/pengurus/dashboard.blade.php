@extends('layouts.app')

@section('content')
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Barang</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalBarang }}</h3>
                </div>
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <i class="fas fa-boxes text-green-600 dark:text-green-400"></i>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Total barang inventaris
            </p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400"></p>Pengajuan Dibuat</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalPengajuan }}</h3>
                </div>
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-file-alt text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                <span class="text-blue-600 dark:text-blue-400">
                    <i class="fas fa-arrow-up"></i> {{ $pengajuanBulanIni }}
                </span>
                pengajuan bulan ini
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pengajuan Disetujui</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pengajuanDisetujui }}</h3>
                </div>
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <i class="fas fa-check text-green-600 dark:text-green-400"></i>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Dari total pengajuan
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pengajuan Pending</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pengajuanPending }}</h3>
                </div>
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                    <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Menunggu persetujuan
            </p>
        </div>
    </div>

    <!-- Pengajuan Terbaru & Status -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pengajuan Terbaru -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pengajuan Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Barang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($latestPengajuan as $pengajuan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $pengajuan->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $pengajuan->barang->nama }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $pengajuan->jumlah }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($pengajuan->status === 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Pending
                                    </span>
                                @elseif($pengajuan->status === 'disetujui')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Status Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Status Pengajuan</h3>
            </div>
            <div class="p-6">
                <canvas id="statusChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <script type="text/javascript" nonce="{{ csrf_token() }}">
        var pengajuanData = {
            pending: parseInt("{{ $pengajuanPending }}"),
            disetujui: parseInt("{{ $pengajuanDisetujui }}"),
            ditolak: parseInt("{{ $pengajuanDitolak }}")
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('statusChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Disetujui', 'Ditolak'],
                    datasets: [{
                        data: [
                            pengajuanData.pending,
                            pengajuanData.disetujui,
                            pengajuanData.ditolak
                        ],
                        backgroundColor: [
                            '#FBBF24',
                            '#10B981',
                            '#EF4444'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
@endsection
