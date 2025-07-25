<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Barang;
use App\Models\Admin\BarangMasuk;
use App\Models\Admin\Pengajuan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminDashboardController extends Controller
{
    public function index()
    {
        try {
            // Statistik
            $totalBarang = Barang::count();
            $barangMasukBulanIni = BarangMasuk::whereMonth('tanggal_masuk', now()->month)->count();
            $lowStockCount = Barang::whereColumn('stok', '<=', 'stok_minimum')->count();
            $totalUsers = User::count();
            $totalPengurus = User::where('role', 'pengurus')->count();
            $totalBendahara = User::where('role', 'bendahara')->count();
            $pendingRequests = Pengajuan::where('status', 'pending')->count();

            // Recent Activities
            $recentActivities = Pengajuan::with(['user', 'barang'])
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($pengajuan) {
                    return [
                        'icon' => 'fa-file-alt',
                        'description' => "Pengajuan {$pengajuan->barang->nama} sejumlah {$pengajuan->jumlah} oleh {$pengajuan->user->name}",
                        'created_at' => $pengajuan->created_at
                    ];
                });

            // Chart Data
            $chartData = collect();
            $months = collect(range(0, 5))->map(function ($i) {
                return now()->subMonths($i)->format('Y-m');
            })->reverse();

            foreach ($months as $month) {
                $bulan = \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F');
                $masuk = BarangMasuk::whereYear('tanggal_masuk', substr($month, 0, 4))
                    ->whereMonth('tanggal_masuk', substr($month, 5, 2))->count();
                $keluar = \App\Models\Admin\BarangKeluar::whereYear('tanggal_keluar', substr($month, 0, 4))
                    ->whereMonth('tanggal_keluar', substr($month, 5, 2))->count();
                $chartData->push([
                    'bulan' => $bulan,
                    'masuk' => $masuk,
                    'keluar' => $keluar
                ]);
            }

            return view('admin.dashboard', [
                'totalBarang' => $totalBarang,
                'barangMasukBulanIni' => $barangMasukBulanIni,
                'lowStockCount' => $lowStockCount,
                'totalUsers' => $totalUsers,
                'totalPengurus' => $totalPengurus,
                'totalBendahara' => $totalBendahara,
                'pendingRequests' => $pendingRequests,
                'recentActivities' => $recentActivities,
                'chartData' => $chartData,
            ]);
        } catch (\Exception $e) {
            Log::error('Admin Dashboard Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat data dashboard.');
        }
    }
}
