<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Pengajuan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $stokKritis = Barang::whereColumn('stok', '<=', 'stok_minimum')->count();
        $barangMasuk = BarangMasuk::whereMonth('tanggal_masuk', now()->month)->count();
        $barangKeluar = BarangKeluar::whereMonth('tanggal_keluar', now()->month)->count();
        $pengajuanPending = Pengajuan::where('status', 'menunggu')->count();

        return view('dashboard', compact('totalBarang', 'stokKritis', 'barangMasuk', 'barangKeluar', 'pengajuanPending'));
    }
}
