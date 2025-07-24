<nav class="flex items-center justify-between bg-white dark:bg-[#181f2a] px-6 py-3 shadow">
    <div class="flex items-center space-x-4">
        <img src="/images/logo-hkbp.png" alt="Logo HKBP" class="h-8">
        <span class="font-bold text-[#256D85] text-lg">HKBP Inventory</span>
    </div>
    <div class="flex items-center space-x-4">
        <span class="text-gray-700 dark:text-gray-100">{{ Auth::user()->name ?? 'User' }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-primary">Logout</button>
        </form>
    </div>
</nav>
