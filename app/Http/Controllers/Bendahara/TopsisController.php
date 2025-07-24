<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopsisController extends Controller
{
    public function index() { return view('bendahara.topsis.index'); }
    public function hitung(Request $request) { return redirect()->route('bendahara.topsis.index'); }
    public function eksporPdf() { return response()->download('path/to/topsis.pdf'); }
}
