<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BendaharaLaporanController extends Controller
{
    public function index()
    {
        return view('bendahara.laporan.index');
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
