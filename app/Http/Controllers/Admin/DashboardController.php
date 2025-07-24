<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = \App\Models\Admin\Barang::count();
        $barangMasukBulanIni = \App\Models\Admin\BarangMasuk::whereMonth('tanggal_masuk', now()->month)->count();
        $lowStockCount = \App\Models\Admin\Barang::whereColumn('stok', '<=', 'stok_minimum')->count();
        $totalUsers = \App\Models\User::count();
        $totalPengurus = \App\Models\User::where('role', 'pengurus')->count();
        $totalBendahara = \App\Models\User::where('role', 'bendahara')->count();
        $pendingRequests = \App\Models\Admin\Pengajuan::where('status', 'pending')->count();
        $recentActivities = \App\Models\Admin\Pengajuan::latest()->take(5)->get();

        return view('admin.dashboard', [
            'totalBarang' => $totalBarang,
            'barangMasukBulanIni' => $barangMasukBulanIni,
            'lowStockCount' => $lowStockCount,
            'totalUsers' => $totalUsers,
            'totalPengurus' => $totalPengurus,
            'totalBendahara' => $totalBendahara,
            'pendingRequests' => $pendingRequests,
            'recentActivities' => $recentActivities,
        ]);
    }
}
