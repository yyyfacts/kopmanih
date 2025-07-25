<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengurusBarangController extends Controller
{
    public function index()
    {
        return view('pengurus.barang.index');
    }

    public function show($id)
    {
        return view('pengurus.barang.show', compact('id'));
    }
}
