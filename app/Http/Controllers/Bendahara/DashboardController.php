<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $totalBarang = \App\Models\Admin\Barang::count();
        $totalPengajuan = \App\Models\Admin\Pengajuan::count();
        $pengajuanBulanIni = \App\Models\Admin\Pengajuan::whereMonth('created_at', now()->month)->count();
        $totalPengeluaran = \App\Models\Bendahara\Anggaran::sum('jumlah');
        $totalBarangKeluar = \App\Models\Admin\BarangKeluar::count();

        // Laporan terbaru (misal ambil 5 terakhir)
        $laporanTerbaru = \App\Models\Bendahara\Anggaran::orderBy('created_at', 'desc')->take(5)->get();

        // Data chart pengeluaran per bulan (6 bulan terakhir)
        $chartData = \App\Models\Bendahara\Anggaran::selectRaw('DATE_FORMAT(tanggal, "%m") as bulan_angka, DATE_FORMAT(tanggal, "%M") as bulan, SUM(jumlah) as total')
            ->where('tanggal', '>=', now()->subMonths(6))
            ->groupBy('bulan_angka', 'bulan')
            ->orderBy('bulan_angka')
            ->get();
        
        // Format nama bulan ke bahasa Indonesia
        $chartData = $chartData->map(function ($item) {
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
    }
}
