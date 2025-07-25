@if(auth()->user()->role === 'pengurus')
<nav>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('pengurus.dashboard') }}" class="nav-link {{ request()->routeIs('pengurus.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pengurus.barang-masuk.index') }}" class="nav-link {{ request()->routeIs('pengurus.barang-masuk.*') ? 'active' : '' }}">
                <i class="fas fa-box-open"></i>
                <span>Barang Masuk</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pengurus.barang-keluar.index') }}" class="nav-link {{ request()->routeIs('pengurus.barang-keluar.*') ? 'active' : '' }}">
                <i class="fas fa-dolly"></i>
                <span>Barang Keluar</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pengurus.pengajuan.create') }}" class="nav-link {{ request()->routeIs('pengurus.pengajuan.create') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i>
                <span>Ajukan Pengadaan Barang</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pengurus.pengajuan.index') }}" class="nav-link {{ request()->routeIs('pengurus.pengajuan.index') ? 'active' : '' }}">
                <i class="fas fa-history"></i>
                <span>Riwayat Pengajuan</span>
            </a>
        </li>
    </ul>
</nav>
@endif
