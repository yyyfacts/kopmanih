<aside class="w-64 h-full bg-[#256D85] text-white flex flex-col">
    <div class="p-6 font-bold text-xl">HKBP Inventory</div>
    <nav class="flex-1">
        <ul class="space-y-2">
            @if(auth()->check())
                <li><a href="{{ route('dashboard') }}" class="block py-2 px-4 hover:bg-[#00B2FF] rounded">Dashboard</a></li>
            @endif
            {{-- Tambahkan menu lain sesuai role lain jika diperlukan --}}
        </ul>
    </nav>
</aside>
