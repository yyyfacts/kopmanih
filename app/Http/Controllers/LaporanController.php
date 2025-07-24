<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        // Anda bisa menambahkan logika pengambilan data laporan di sini
        return view('laporan.index');
    }
}
