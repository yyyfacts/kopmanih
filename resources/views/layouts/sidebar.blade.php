<aside class="w-64 h-full bg-[#256D85] text-white flex flex-col">
    <div class="p-6 font-bold text-xl">HKBP Inventory</div>
    <nav class="flex-1">
        <ul class="space-y-2">
            @if(auth()->user()->role === 'bendahara')
                <li><a href="{{ route('bendahara.dashboard') }}" class="block py-2 px-4 hover:bg-[#00B2FF] rounded">Dashboard</a></li>
                <li><a href="{{ route('bendahara.anggaran.index') }}" class="block py-2 px-4 hover:bg-[#00B2FF] rounded">Input Anggaran</a></li>
                <li><a href="{{ route('bendahara.topsis.index') }}" class="block py-2 px-4 hover:bg-[#00B2FF] rounded">Analisis TOPSIS</a></li>
                <li><a href="{{ route('bendahara.validasi.index') }}" class="block py-2 px-4 hover:bg-[#00B2FF] rounded">Validasi Pengajuan</a></li>
                <li><a href="{{ route('bendahara.laporan.index') }}" class="block py-2 px-4 hover:bg-[#00B2FF] rounded">Laporan Keuangan</a></li>
            @endif
            {{-- Tambahkan menu lain sesuai role lain jika diperlukan --}}
        </ul>
    </nav>
</aside>
