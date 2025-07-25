<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Admin\Barang;
use App\Models\Admin\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengurusDashboardController extends Controller
{
    public function index()
    {
        try {
            // Statistik
            $totalBarang = Barang::count();
            $totalPengajuan = Pengajuan::where('user_id', Auth::id())->count();
            $pengajuanBulanIni = Pengajuan::where('user_id', Auth::id())
                ->whereMonth('created_at', now()->month)
                ->count();
            $pengajuanDisetujui = Pengajuan::where('user_id', Auth::id())
                ->where('status', 'disetujui')
                ->count();
            $pengajuanPending = Pengajuan::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->count();
            $pengajuanDitolak = Pengajuan::where('user_id', Auth::id())
                ->where('status', 'ditolak')
                ->count();

            // Pengajuan terbaru (ambil 5 terakhir)
            $latestPengajuan = Pengajuan::with('barang')
                ->where('user_id', Auth::id())
                ->latest()
                ->take(5)
                ->get();

            return view('pengurus.dashboard', compact(
                'totalBarang',
                'totalPengajuan',
                'pengajuanBulanIni',
                'pengajuanDisetujui',
                'pengajuanPending',
                'pengajuanDitolak',
                'latestPengajuan'
            ));
        } catch (\Exception $e) {
            Log::error('Pengurus Dashboard Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat data.');
        }
    }
}
