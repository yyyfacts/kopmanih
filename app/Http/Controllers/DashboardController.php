<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Barang;
use App\Models\Admin\BarangMasuk;
use App\Models\Admin\BarangKeluar;
use App\Models\Admin\Pengajuan;
use App\Models\Bendahara\Anggaran;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];
        
        // Common data for all roles
        $data['pengajuanPending'] = Pengajuan::where('status', 'menunggu')->count();
        
        switch($user->role) {
            case 'admin':
                // Total barang tersedia
                $data['totalBarang'] = Barang::count();
                
                // Stok barang kritis
                $data['stokKritis'] = Barang::whereColumn('stok', '<=', 'stok_minimum')->count();
                $data['lowStockItems'] = Barang::whereColumn('stok', '<=', 'stok_minimum')
                    ->with('kategori')
                    ->get();
                
                // Jumlah transaksi hari ini
                $data['transaksiHariIni'] = [
                    'masuk' => BarangMasuk::whereDate('tanggal_masuk', now()->toDateString())->count(),
                    'keluar' => BarangKeluar::whereDate('tanggal_keluar', now()->toDateString())->count(),
                    'total' => BarangMasuk::whereDate('tanggal_masuk', now()->toDateString())->count() +
                              BarangKeluar::whereDate('tanggal_keluar', now()->toDateString())->count()
                ];
                
                // Jumlah pengajuan yang perlu ditinjau
                $data['pengajuanMasuk'] = Pengajuan::where('status', 'menunggu')->count();
                
                // Data untuk Bar Chart Transaksi Bulanan
                $data['transaksi_bulanan'] = [
                    'barang_masuk' => BarangMasuk::selectRaw('MONTH(tanggal_masuk) as bulan, COUNT(*) as total')
                        ->whereYear('tanggal_masuk', now()->year)
                        ->groupBy('bulan')
                        ->orderBy('bulan')
                        ->pluck('total', 'bulan')
                        ->toArray(),
                    'barang_keluar' => BarangKeluar::selectRaw('MONTH(tanggal_keluar) as bulan, COUNT(*) as total')
                        ->whereYear('tanggal_keluar', now()->year)
                        ->groupBy('bulan')
                        ->orderBy('bulan')
                        ->pluck('total', 'bulan')
                        ->toArray()
                ];
                
                // Data untuk Pie Chart Distribusi Kategori
                $data['kategoriDistribusi'] = \App\Models\Admin\Kategori::withCount('barangs')
                    ->having('barangs_count', '>', 0)
                    ->get();
                
                // Pengajuan terbaru
                $data['pengajuanTerbaru'] = Pengajuan::with(['user'])
                    ->latest()
                    ->take(10)
                    ->get();

                // Notifikasi sistem
                $data['notifikasi'] = collect([
                    // Stok kritis
                    ...$data['lowStockItems']->map(function($item) {
                        return [
                            'type' => 'warning',
                            'message' => "Stok {$item->nama_barang} kritis (tersisa {$item->stok})",
                            'time' => now()
                        ];
                    }),
                    // Pengajuan baru
                    ...$data['pengajuanTerbaru']
                        ->where('status', 'menunggu')
                        ->map(function($item) {
                            return [
                                'type' => 'info',
                                'message' => "Pengajuan baru dari {$item->user->name}",
                                'time' => $item->created_at
                            ];
                        })
                ])->sortByDesc('time')->take(5);
                
                return view('admin.dashboard', $data);

            case 'pengurus':
                // Pengurus sees inventory movement stats
                $data['barangMasuk'] = BarangMasuk::whereDate('tanggal_masuk', now()->toDateString())->count();
                $data['barangKeluar'] = BarangKeluar::whereDate('tanggal_keluar', now()->toDateString())->count();
                $data['stokKritis'] = Barang::whereColumn('stok', '<=', 'stok_minimum')->count();
                $data['lowStockItems'] = Barang::whereColumn('stok', '<=', 'stok_minimum')->get();
                $data['recentBarangMasuk'] = BarangMasuk::with('barang')
                    ->latest()
                    ->take(5)
                    ->get();
                $data['recentBarangKeluar'] = BarangKeluar::with('barang')
                    ->latest()
                    ->take(5)
                    ->get();
                return view('pengurus.dashboard', $data);

            case 'bendahara':
                // Bendahara sees financial stats and TOPSIS analysis
                $data['totalAnggaran'] = Anggaran::sum('jumlah');
                $data['pengajuanBelumDisetujui'] = Pengajuan::where('status', 'menunggu')
                    ->count();
                $data['pengajuanDisetujui'] = Pengajuan::where('status', 'disetujui')
                    ->count();
                $data['pengajuanDitolak'] = Pengajuan::where('status', 'ditolak')
                    ->count();
                $data['recentPengajuan'] = Pengajuan::with(['user'])
                    ->latest()
                    ->take(5)
                    ->get();
                $data['latestTopsisAnalysis'] = \App\Models\Admin\Topsis::latest()
                    ->first();
                return view('bendahara.dashboard', $data);

            default:
                return redirect()->route('login');
        }
    }
}
