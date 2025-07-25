<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BendaharaPengajuanController extends Controller
{
    public function index()
    {
        return view('bendahara.pengajuan.index');
    }

    public function show($id)
    {
        return view('bendahara.pengajuan.show', compact('id'));
    }

    public function verifikasi(Request $request, $id)
    {
        // Validate request
        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string|max:255',
        ]);

        try {
            // Implement verifikasi logic here
            return redirect()->route('bendahara.pengajuan.index')
                ->with('success', 'Pengajuan berhasil diverifikasi');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memverifikasi pengajuan');
        }
    }
}
