<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Koperasi Mahasiswa</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background: #f5f5f5;
        }

        /* Navbar */
        .navbar {
            background: #1b5e20;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
        }

        .navbar-brand {
            font-size: 1.2rem;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
        }

        .navbar-nav {
            display: flex;
            gap: 1rem;
        }

        .nav-link {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Content */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Cards */
        .card {
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .table th {
            background: #f9fafb;
            font-weight: 600;
            text-align: left;
            color: #374151;
        }

        .table tr:hover {
            background: #f9fafb;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: #1b5e20;
            color: #fff;
        }

        .btn-primary:hover {
            background: #2e7d32;
        }

        .btn-secondary {
            background: #6b7280;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        /* Status badges */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-success {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* Stats cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stats-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stats-card h3 {
            margin: 0 0 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .stats-card h2 {
            margin: 0;
            color: #111827;
            font-size: 1.5rem;
            font-weight: 600;
        }

        /* Chart wrapper */
        .chart-wrapper {
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .chart-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        /* User Menu Styles */
        .user-menu {
            position: relative;
        }

        .user-trigger {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-trigger:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .user-info {
            text-align: left;
            color: white;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.875rem;
        }

        .user-email {
            font-size: 0.75rem;
            opacity: 0.8;
        }

        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            width: 200px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 8px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s;
        }

        .user-dropdown.show {
            opacity: 1;
            visibility: visible;
        }

        .dropdown-menu {
            padding: 8px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            color: #374151;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.2s;
            border: none;
            background: none;
            width: 100%;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .dropdown-item:hover {
            background: #f3f4f6;
        }

        .dropdown-item i {
            width: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ url('/admin') }}" class="navbar-brand">Koperasi Mahasiswa</a>
        <div class="navbar-nav">
            <a href="{{ url('/admin') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                Dashboard
            </a>
            <a href="{{ url('/admin/transaksi') }}" class="nav-link {{ request()->is('admin/transaksi') ? 'active' : '' }}">
                Kelola Transaksi
            </a>
            <a href="{{ url('/admin/daftar') }}" class="nav-link {{ request()->is('admin/daftar') ? 'active' : '' }}">
                Daftar Feedback
            </a>
            <div class="user-menu">
                <div class="user-trigger" id="userMenuTrigger">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-info">
                        <div class="user-name" id="userName">Loading...</div>
                        <div class="user-email" id="userEmail">Loading...</div>
                    </div>
                </div>
                <div class="user-dropdown" id="userDropdown">
                    <div class="dropdown-menu">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container">
        @yield('content')
    </div>

    @stack('scripts')

    <!-- Firebase Scripts -->
    <script type="module">
        // Firebase imports
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";
        import { getFirestore, doc, getDoc } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

        // Firebase config
        const firebaseConfig = {
            apiKey: "AIzaSyAuq0JEjnEOagJnONPemkMP0bbgqepiFp8",
            authDomain: "koperasimahasiswaapp.firebaseapp.com",
            projectId: "koperasimahasiswaapp",
            storageBucket: "koperasimahasiswaapp.firebasestorage.app",
            messagingSenderId: "812843080953",
            appId: "1:812843080953:web:9a931f89186182660bd628",
            measurementId: "G-ES6G76W66D"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getFirestore(app);

        // User Menu Toggle
        const userMenuTrigger = document.getElementById('userMenuTrigger');
        const userDropdown = document.getElementById('userDropdown');

        userMenuTrigger.addEventListener('click', () => {
            userDropdown.classList.toggle('show');
        });

        document.addEventListener('click', (e) => {
            if (!userMenuTrigger.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });

        // Auth state observer
        onAuthStateChanged(auth, async (user) => {
            if (user) {
                try {
                    // Get user data
                    const userDoc = await getDoc(doc(db, "users", user.uid));
                    const userData = userDoc.exists() ? userDoc.data() : {};
                    
                    // Check if user is admin
                    if (!userData.isAdmin) {
                        // Redirect non-admin users to dashboard
                        window.location.href = '/dashboard';
                        return;
                    }
                    
                    // Update displayed name and email
                    const displayName = userData.nama || user.email.split('@')[0];
                    document.getElementById('userName').textContent = displayName;
                    document.getElementById('userEmail').textContent = user.email;
                } catch (error) {
                    console.error('Error fetching user data:', error);
                }
            } else {
                window.location.href = '/login';
            }
        });
    </script>
</body>
</html>
