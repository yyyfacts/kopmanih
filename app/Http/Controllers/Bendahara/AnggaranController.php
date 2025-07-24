<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    public function index()
    {
        // Tampilkan halaman input anggaran
        return view('bendahara.anggaran.index');
    }

    public function store(Request $request)
    {
        // Simpan data anggaran
        // ...
        return redirect()->route('bendahara.anggaran.index');
    }

    public function riwayat()
    {
        // Tampilkan riwayat anggaran
        return view('bendahara.anggaran.riwayat');
    }
}
