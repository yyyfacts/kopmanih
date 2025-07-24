@extends('layouts.app')

@section('content')
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6             if (chartLabels.length === 0) {
                ctx.canvas.style.height = '100px';
                ctx.fillStyle = '#666';
                ctx.font = '14px Arial';
                ctx.textAlign = 'center';
                ctx.fillText('Belum ada data pengeluaran', ctx.canvas.width / 2, 50);
                return;
            }        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
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
                Nilai total inventaris
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Pengajuan</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalPengajuan }}</h3>
                </div>
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-file-alt text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ $pengajuanBulanIni }} pengajuan bulan ini
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Pengeluaran</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                    <i class="fas fa-money-bill-wave text-red-600 dark:text-red-400"></i>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Bulan {{ now()->format('F Y') }}
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Barang Keluar</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalBarangKeluar }}</h3>
                </div>
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                    <i class="fas fa-arrow-circle-up text-yellow-600 dark:text-yellow-400"></i>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Bulan {{ now()->format('F Y') }}
            </p>
        </div>
    </div>

    <!-- Grafik dan Laporan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Grafik Pengeluaran -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Grafik Pengeluaran</h3>
            </div>
            <div class="p-6">
                <canvas id="expenseChart" 
                    data-labels='@json($chartData->pluck("bulan"))'
                    data-values='@json($chartData->pluck("total"))'
                    style="height: 300px;">
                </canvas>
            </div>
        </div>

        <!-- Laporan Terbaru -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Laporan Terbaru</h3>
                    <a href="{{ route('bendahara.laporan.index') }}" class="text-sm text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($laporanTerbaru as $laporan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                {{ $laporan->keterangan }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                Rp {{ number_format($laporan->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($laporan->status === 'disetujui')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Disetujui
                                    </span>
                                @elseif($laporan->status === 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Pending
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
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('expenseChart');
            const ctx = canvas.getContext('2d');
            const chartLabels = JSON.parse(canvas.dataset.labels);
            const chartValues = JSON.parse(canvas.dataset.values);

            if (chartData.labels.length === 0) {
                ctx.canvas.style.height = '100px';
                ctx.fillStyle = '#666';
                ctx.font = '14px Arial';
                ctx.textAlign = 'center';
                ctx.fillText('Belum ada data pengeluaran', ctx.canvas.width / 2, 50);
                return;
            }

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Pengeluaran',
                        data: chartValues,
                        backgroundColor: '#10B981',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            },
                            grid: {
                                drawBorder: false,
                                color: theme => theme.dark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
@endsection
