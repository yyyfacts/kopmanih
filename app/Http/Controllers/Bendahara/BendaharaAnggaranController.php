<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BendaharaAnggaranController extends Controller
{
    public function index()
    {
        return view('bendahara.anggaran.index');
    }

    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string|max:255',
        ]);

        // Save anggaran
        try {
            // Implement anggaran saving logic here
            return redirect()->route('bendahara.anggaran.index')
                ->with('success', 'Anggaran berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan anggaran');
        }
    }

    public function riwayat()
    {
        return view('bendahara.anggaran.riwayat');
    }
}
