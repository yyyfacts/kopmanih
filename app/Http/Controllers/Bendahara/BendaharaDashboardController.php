<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Admin\Barang;
use App\Models\Admin\BarangKeluar;
use App\Models\Admin\Pengajuan;
use App\Models\Bendahara\Anggaran;
use Illuminate\Support\Facades\Log;

class BendaharaDashboardController extends Controller
{
    public function index()
    {
        try {
            // Statistik
            $totalBarang = Barang::count();
            $totalPengajuan = Pengajuan::count();
            $pengajuanBulanIni = Pengajuan::whereMonth('created_at', now()->month)->count();
            $totalPengeluaran = Anggaran::sum('jumlah');
            $totalBarangKeluar = BarangKeluar::count();

            // Laporan terbaru (5 terakhir)
            $laporanTerbaru = Anggaran::with(['user'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // Data chart pengeluaran per bulan (6 bulan terakhir)
            $chartData = Anggaran::selectRaw('DATE_FORMAT(tanggal, "%m") as bulan_angka, DATE_FORMAT(tanggal, "%M") as bulan, SUM(jumlah) as total')
                ->where('tanggal', '>=', now()->subMonths(6))
                ->groupBy('bulan_angka', 'bulan')
                ->orderBy('bulan_angka')
                ->get()
                ->map(function ($item) {
                    $namaBulan = [
                        'January' => 'Januari',
                        'February' => 'Februari',
                        'March' => 'Maret',
                        'April' => 'April',
                        'May' => 'Mei',
                        'June' => 'Juni',
                        'July' => 'Juli',
                        'August' => 'Agustus',
                        'September' => 'September',
                        'October' => 'Oktober',
                        'November' => 'November',
                        'December' => 'Desember'
                    ];
                    $item->bulan = $namaBulan[$item->bulan] ?? $item->bulan;
                    return $item;
                });

            return view('bendahara.dashboard', compact(
                'totalBarang',
                'totalPengajuan',
                'pengajuanBulanIni',
                'totalPengeluaran',
                'totalBarangKeluar',
                'laporanTerbaru',
                'chartData'
            ));
        } catch (\Exception $e) {
            Log::error('Bendahara Dashboard Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat data dashboard.');
        }
    }
}
