<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index() { return view('bendahara.laporan.index'); }
    public function eksporPdf() { return response()->download('path/to/laporan.pdf'); }
}
