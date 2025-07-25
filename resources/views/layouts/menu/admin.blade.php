@if(auth()->user()->role === 'admin')
<nav>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Manajemen Pengguna</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.barang.index') }}" class="nav-link {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                <i class="fas fa-boxes"></i>
                <span>Manajemen Barang</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span>Laporan Sistem</span>
            </a>
        </li>
    </ul>
</nav>
@endif
