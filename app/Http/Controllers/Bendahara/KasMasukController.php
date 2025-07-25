<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KasMasuk;

class KasMasukController extends Controller
{
    public function index()
    {
        $kasMasuks = KasMasuk::latest()->paginate(10);
        return view('bendahara.kas-masuk.index', compact('kasMasuks'));
    }

    public function create()
    {
        return view('bendahara.kas-masuk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('bukti')) {
            $bukti = $request->file('bukti');
            $path = $bukti->store('kas-masuk', 'public');
            $validated['bukti'] = $path;
        }

        KasMasuk::create($validated);

        return redirect()->route('bendahara.kas-masuk.index')
            ->with('success', 'Kas masuk berhasil ditambahkan');
    }

    public function show(KasMasuk $kasMasuk)
    {
        return view('bendahara.kas-masuk.show', compact('kasMasuk'));
    }

    public function destroy(KasMasuk $kasMasuk)
    {
        $kasMasuk->delete();
        return redirect()->route('bendahara.kas-masuk.index')
            ->with('success', 'Kas masuk berhasil dihapus');
    }
}
