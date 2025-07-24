<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValidasiController extends Controller
{
    public function index() { return view('bendahara.validasi.index'); }
}
