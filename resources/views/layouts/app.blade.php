<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HKBP Inventory') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        
        <!-- Custom CSS -->
        @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
        
        @stack('styles')
    </head>
    <body>
        <div class="wrapper">
            <!-- Sidebar -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <img src="{{ asset('images/logo-hkbp.png') }}" alt="HKBP Logo" class="img-fluid mb-2">
                    <h5 class="mb-0">E-Inventory</h5>
                    <small>HKBP Setia Mekar</small>
                </div>

                <ul class="list-unstyled components">
                    <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>

                    @if(auth()->user()->role === 'admin')
                    <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}">
                            <i class="fas fa-users"></i> Kelola Pengguna
                        </a>
                    </li>
                    @endif

                    <li class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">
                        <a href="{{ route('barang.index') }}">
                            <i class="fas fa-boxes"></i> Data Barang
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                        <a href="{{ route('kategori.index') }}">
                            <i class="fas fa-tags"></i> Kategori
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('barang-masuk.*') ? 'active' : '' }}">
                        <a href="{{ route('barang-masuk.index') }}">
                            <i class="fas fa-arrow-circle-down"></i> Barang Masuk
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('barang-keluar.*') ? 'active' : '' }}">
                        <a href="{{ route('barang-keluar.index') }}">
                            <i class="fas fa-arrow-circle-up"></i> Barang Keluar
                        </a>
                    </li>

                    @if(in_array(auth()->user()->role, ['admin', 'bendahara']))
                    <li class="{{ request()->routeIs('pengajuan.*') ? 'active' : '' }}">
                        <a href="{{ route('pengajuan.index') }}">
                            <i class="fas fa-file-alt"></i> Pengajuan
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                        <a href="{{ route('laporan.index') }}">
                            <i class="fas fa-chart-bar"></i> Laporan
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>

            <!-- Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="topbar navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-link text-dark">
                            <i class="fas fa-bars"></i>
                        </button>

                        <div class="ms-auto d-flex align-items-center">
                            <!-- Notifications -->
                            <div class="dropdown me-3">
                                <a class="btn btn-link text-dark position-relative" href="#" role="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-bell"></i>
                                    @if($lowStockCount ?? 0 > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $lowStockCount }}
                                    </span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-notifications" aria-labelledby="notificationsDropdown">
                                    @if($lowStockItems ?? [])
                                        @foreach($lowStockItems as $item)
                                        <li>
                                            <div class="notification-item">
                                                <small class="text-danger d-block">Stok Rendah</small>
                                                <p class="mb-0">{{ $item->nama }} ({{ $item->stok }})</p>
                                            </div>
                                        </li>
                                        @endforeach
                                    @else
                                        <li><div class="notification-item">Tidak ada notifikasi</div></li>
                                    @endif
                                </ul>
                            </div>

                            <!-- User Menu -->
                            <div class="dropdown">
                                <a class="btn btn-link text-dark dropdown-toggle d-flex align-items-center" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-2"></i>
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="fas fa-user-edit me-2"></i> Profile
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Main Content -->
                <main class="p-4">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @isset($header)
                        <div class="mb-4">
                            <h1 class="h3 mb-0 text-gray-800">{{ $header }}</h1>
                        </div>
                    @endisset

                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        
        <script>
            $(document).ready(function () {
                // Toggle sidebar
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar, #content').toggleClass('active');
                });

                // Initialize DataTables
                $('.datatable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
                    },
                    pageLength: 10,
                    responsive: true
                });

                // Auto-hide alerts after 5 seconds
                $('.alert').delay(5000).fadeOut(500);
            });
        </script>

        @stack('scripts')
    </body>
</html>
