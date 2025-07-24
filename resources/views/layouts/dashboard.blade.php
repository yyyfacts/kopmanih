<!DOCTYPE html>
<html lang="en" 
      x-data="{ darkMode: localStorage.getItem('theme') === 'dark', sidebarOpen: true }" 
      :class="{ 'dark': darkMode }" 
      x-init="$watch('darkMode', val => localStorage.setItem('theme', val))">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'E-Inventory HKBP') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="relative z-20 flex flex-col flex-shrink-0 w-64 transition-all duration-300"
               :class="{ '-ml-64': !sidebarOpen }">
            <div class="flex flex-col flex-1 min-h-0 bg-white dark:bg-gray-800 shadow-lg">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 bg-green-600 dark:bg-green-700">
                    <img src="{{ asset('images/logo-hkbp.png') }}" alt="HKBP Logo" class="h-10">
                </div>

                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto">
                    <ul class="p-4 space-y-2">
                        @if(Auth::user()->role === 'admin')
                            <li>
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-300 rounded-lg hover:bg-green-50 dark:hover:bg-green-700/30 {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 dark:bg-green-700/30 text-green-600 dark:text-green-400' : '' }}">
                                    <i class="fas fa-tachometer-alt w-5"></i>
                                    <span class="ml-3">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('users.index') }}"
                                   class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-300 rounded-lg hover:bg-green-50 dark:hover:bg-green-700/30 {{ request()->routeIs('users.*') ? 'bg-green-50 dark:bg-green-700/30 text-green-600 dark:text-green-400' : '' }}">
                                    <i class="fas fa-users w-5"></i>
                                    <span class="ml-3">Manajemen Pengguna</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('barang.index') }}"
                                   class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-300 rounded-lg hover:bg-green-50 dark:hover:bg-green-700/30 {{ request()->routeIs('barang.*') ? 'bg-green-50 dark:bg-green-700/30 text-green-600 dark:text-green-400' : '' }}">
                                    <i class="fas fa-boxes w-5"></i>
                                    <span class="ml-3">Manajemen Barang</span>
                                </a>
                            </li>
                        @endif

                        @if(Auth::user()->role === 'pengurus')
                            <li>
                                <a href="{{ route('pengurus.dashboard') }}"
                                   class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-300 rounded-lg hover:bg-green-50 dark:hover:bg-green-700/30 {{ request()->routeIs('pengurus.dashboard') ? 'bg-green-50 dark:bg-green-700/30 text-green-600 dark:text-green-400' : '' }}">
                                    <i class="fas fa-tachometer-alt w-5"></i>
                                    <span class="ml-3">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pengajuan.index') }}"
                                   class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-300 rounded-lg hover:bg-green-50 dark:hover:bg-green-700/30 {{ request()->routeIs('pengajuan.*') ? 'bg-green-50 dark:bg-green-700/30 text-green-600 dark:text-green-400' : '' }}">
                                    <i class="fas fa-file-alt w-5"></i>
                                    <span class="ml-3">Pengajuan Barang</span>
                                </a>
                            </li>
                        @endif

                        @if(Auth::user()->role === 'bendahara')
                            <li>
                                <a href="{{ route('bendahara.dashboard') }}"
                                   class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-300 rounded-lg hover:bg-green-50 dark:hover:bg-green-700/30 {{ request()->routeIs('bendahara.dashboard') ? 'bg-green-50 dark:bg-green-700/30 text-green-600 dark:text-green-400' : '' }}">
                                    <i class="fas fa-tachometer-alt w-5"></i>
                                    <span class="ml-3">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('laporan.index') }}"
                                   class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-300 rounded-lg hover:bg-green-50 dark:hover:bg-green-700/30 {{ request()->routeIs('laporan.*') ? 'bg-green-50 dark:bg-green-700/30 text-green-600 dark:text-green-400' : '' }}">
                                    <i class="fas fa-chart-bar w-5"></i>
                                    <span class="ml-3">Laporan Keuangan</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>

                <!-- User Profile -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center w-full text-left">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user-circle text-2xl text-gray-500 dark:text-gray-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ ucfirst(Auth::user()->role) }}
                                </p>
                            </div>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute bottom-full left-0 w-full mb-2 origin-bottom-left rounded-lg shadow-lg">
                            <div class="bg-white dark:bg-gray-800 rounded-lg ring-1 ring-black ring-opacity-5">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="relative flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="sticky top-0 z-10 bg-white dark:bg-gray-800 shadow-sm">
                <div class="flex items-center justify-between h-16 px-4">
                    <!-- Toggle Sidebar Button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <div class="flex items-center space-x-4">
                        <!-- Dark Mode Toggle -->
                        <button @click="darkMode = !darkMode" 
                                class="text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300">
                            <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                        </button>

                        <!-- Notifications -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="relative text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300">
                                <i class="fas fa-bell text-xl"></i>
                                @if($lowStockCount ?? 0 > 0)
                                    <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 rounded-full flex items-center justify-center text-xs text-white">
                                        {{ $lowStockCount }}
                                    </span>
                                @endif
                            </button>

                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-80 rounded-lg shadow-lg">
                                <div class="bg-white dark:bg-gray-800 rounded-lg ring-1 ring-black ring-opacity-5">
                                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Notifikasi</h3>
                                    </div>
                                    <div class="max-h-64 overflow-y-auto">
                                        @if($lowStockItems ?? [])
                                            @foreach($lowStockItems as $item)
                                                <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    <p class="text-sm text-red-600 dark:text-red-400">Stok Rendah</p>
                                                    <p class="text-sm text-gray-700 dark:text-gray-200">{{ $item->nama }} ({{ $item->stok }})</p>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="px-4 py-3">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada notifikasi</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-6">
                @if(session('success'))
                    <div x-data="{ show: true }"
                         x-show="show"
                         x-init="setTimeout(() => show = false, 5000)"
                         class="mb-4 p-4 bg-green-100 dark:bg-green-800 border-l-4 border-green-500 text-green-700 dark:text-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }"
                         x-show="show"
                         x-init="setTimeout(() => show = false, 5000)"
                         class="mb-4 p-4 bg-red-100 dark:bg-red-800 border-l-4 border-red-500 text-red-700 dark:text-red-200">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
