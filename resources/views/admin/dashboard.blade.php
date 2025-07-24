<x-dashboard-layout>
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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
                <span class="text-green-600 dark:text-green-400">
                    <i class="fas fa-arrow-up"></i> {{ $barangMasukBulanIni }}
                </span>
                barang masuk bulan ini
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Stok Rendah</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $lowStockCount }}</h3>
                </div>
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                    <i class="fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-400"></i>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Perlu perhatian segera
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Pengguna</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalUsers }}</h3>
                </div>
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-users text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                <span class="text-blue-600 dark:text-blue-400">{{ $totalPengurus }}</span> pengurus,
                <span class="text-blue-600 dark:text-blue-400">{{ $totalBendahara }}</span> bendahara
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pengajuan Pending</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingRequests }}</h3>
                </div>
                <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                    <i class="fas fa-clock text-red-600 dark:text-red-400"></i>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Menunggu persetujuan
            </p>
        </div>
    </div>

    <!-- Recent Activities & Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activities -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
            </div>
            <div class="p-6">
                <div class="flow-root">
                    <ul class="-mb-8">
                        @foreach($recentActivities as $activity)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                            <i class="fas {{ $activity->icon }} text-green-600 dark:text-green-400"></i>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $activity->description }}</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Statistik Barang</h3>
            </div>
            <div class="p-6">
                <canvas id="inventoryChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('inventoryChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData->pluck('bulan')) !!},
                datasets: [{
                    label: 'Barang Masuk',
                    data: {!! json_encode($chartData->pluck('masuk')) !!},
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Barang Keluar',
                    data: {!! json_encode($chartData->pluck('keluar')) !!},
                    borderColor: '#EF4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
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
    </script>
    @endpush
</x-dashboard-layout>
