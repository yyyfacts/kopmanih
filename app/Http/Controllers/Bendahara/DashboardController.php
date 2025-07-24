<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data dummy, silakan ganti dengan query sesuai kebutuhan
        $totalBarang = \App\Models\Admin\Barang::count();
        $totalPengajuan = \App\Models\Admin\Pengajuan::count();
        $pengajuanBulanIni = \App\Models\Admin\Pengajuan::whereMonth('created_at', now()->month)->count();
        $totalPengeluaran = \App\Models\Bendahara\Anggaran::sum('jumlah');
        $totalBarangKeluar = \App\Models\Admin\BarangKeluar::count();

        return view('bendahara.dashboard', compact(
            'totalBarang',
            'totalPengajuan',
            'pengajuanBulanIni',
            'totalPengeluaran',
            'totalBarangKeluar'
        ));
    }
}
