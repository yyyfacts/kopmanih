<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengurusPengajuanController extends Controller
{
    public function index()
    {
        return view('pengurus.pengajuan.index');
    }

    public function create()
    {
        return view('pengurus.pengajuan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
        ]);

        try {
            // Implement pengajuan saving logic here
            return redirect()->route('pengurus.pengajuan.index')
                ->with('success', 'Pengajuan berhasil dibuat');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat membuat pengajuan');
        }
    }

    public function show($id)
    {
        return view('pengurus.pengajuan.show', compact('id'));
    }

    public function edit($id)
    {
        return view('pengurus.pengajuan.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
        ]);

        try {
            // Implement pengajuan update logic here
            return redirect()->route('pengurus.pengajuan.index')
                ->with('success', 'Pengajuan berhasil diupdate');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengupdate pengajuan');
        }
    }

    public function destroy($id)
    {
        try {
            // Implement pengajuan deletion logic here
            return redirect()->route('pengurus.pengajuan.index')
                ->with('success', 'Pengajuan berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus pengajuan');
        }
    }
}
