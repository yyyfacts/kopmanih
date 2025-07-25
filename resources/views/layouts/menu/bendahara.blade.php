@if(auth()->user()->role === 'bendahara')
<nav>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('bendahara.dashboard') }}" class="nav-link {{ request()->routeIs('bendahara.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard Kas & Anggaran</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('bendahara.kas-masuk.create') }}" class="nav-link {{ request()->routeIs('bendahara.kas-masuk.*') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i>
                <span>Input Kas Masuk</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('bendahara.verifikasi-pengajuan.index') }}" class="nav-link {{ request()->routeIs('bendahara.verifikasi-pengajuan.*') ? 'active' : '' }}">
                <i class="fas fa-check-double"></i>
                <span>Verifikasi Pengadaan</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('bendahara.analisis-topsis.index') }}" class="nav-link {{ request()->routeIs('bendahara.analisis-topsis.*') ? 'active' : '' }}">
                <i class="fas fa-calculator"></i>
                <span>Analisis Prioritas (TOPSIS)</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('bendahara.laporan.index') }}" class="nav-link {{ request()->routeIs('bendahara.laporan.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Laporan Anggaran & Barang</span>
            </a>
        </li>
    </ul>
</nav>
@endif
