<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index() { return view('bendahara.pengajuan.index'); }
    public function show($id) { return view('bendahara.pengajuan.show', compact('id')); }
    public function verifikasi(Request $request, $id) { return redirect()->route('bendahara.pengajuan.index'); }
}
