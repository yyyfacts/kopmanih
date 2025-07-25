<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BendaharaTopsisController extends Controller
{
    public function index()
    {
        return view('bendahara.topsis.index');
    }

    public function hitung(Request $request)
    {
        try {
            // Implement TOPSIS calculation logic here
            return redirect()->route('bendahara.topsis.index')
                ->with('success', 'Perhitungan TOPSIS berhasil');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat melakukan perhitungan');
        }
    }

    public function eksporPdf()
    {
        try {
            // Implement PDF export logic here
            return response()->download('path/to/pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengekspor PDF');
        }
    }
}
