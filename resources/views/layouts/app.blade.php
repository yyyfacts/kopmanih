<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Koperasi Mahasiswa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Styles -->
    @stack('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        :root {
            --primary: #047857;
            --primary-dark: #065f46;
            --primary-light: #10b981;
            --secondary: #6B7280;
            --success: #059669;
            --danger: #DC2626;
            --warning: #FBBF24;
            --info: #3B82F6;
            --background: #f9fafb;
            --sidebar-width: 280px;
            --header-height: 70px;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--background);
            color: #1F2937;
            min-height: 100vh;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            border-right: 1px solid #E5E7EB;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 50;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            border-bottom: 1px solid #E5E7EB;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .sidebar-logo img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .sidebar-logo h1 {
            color: var(--primary);
            font-size: 20px;
            font-weight: 700;
        }

        .sidebar-menu {
            padding: 24px 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            color: var(--secondary);
            text-decoration: none;
            transition: all 0.2s;
            position: relative;
        }

        .menu-item:hover {
            color: var(--primary);
            background: #F3F4F6;
        }

        .menu-item.active {
            color: var(--primary);
            background: #F3F4F6;
            font-weight: 600;
        }

        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--primary);
        }

        .menu-item i {
            width: 20px;
            text-align: center;
        }

        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: var(--header-height);
            background: white;
            border-bottom: 1px solid #E5E7EB;
            z-index: 40;
            transition: all 0.3s ease;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
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
            background: #F3F4F6;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .user-info {
            text-align: left;
        }

        .user-name {
            font-weight: 600;
            color: #1F2937;
            font-size: 0.875rem;
        }

        .user-email {
            color: var(--secondary);
            font-size: 0.75rem;
        }

        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            width: 240px;
            background: white;
            border-radius: 8px;
            box-shadow: var(--shadow-lg);
            margin-top: 8px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s;
            z-index: 50;
        }

        .user-dropdown.show {
            opacity: 1;
            visibility: visible;
        }

        .dropdown-header {
            padding: 16px;
            border-bottom: 1px solid #E5E7EB;
        }

        .dropdown-user-info {
            font-size: 0.875rem;
        }

        .dropdown-user-info strong {
            display: block;
            color: #1F2937;
            margin-bottom: 4px;
        }

        .dropdown-user-info span {
            color: var(--secondary);
            font-size: 0.75rem;
        }

        .dropdown-menu {
            padding: 8px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            color: #1F2937;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background: #F3F4F6;
        }

        .dropdown-item i {
            color: var(--secondary);
            font-size: 1rem;
            width: 20px;
        }

        .dropdown-divider {
            height: 1px;
            background: #E5E7EB;
            margin: 8px -8px;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 24px;
            width: calc(100% - var(--sidebar-width));
            min-height: calc(100vh - var(--header-height));
        }

        /* Card Styles */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 24px;
            margin-bottom: 24px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: #F3F4F6;
            color: #4B5563;
        }

        .btn-secondary:hover {
            background: #E5E7EB;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #B91C1C;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid #E5E7EB;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #F9FAFB;
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
            border-bottom: 1px solid #E5E7EB;
        }

        td {
            padding: 12px 16px;
            border-bottom: 1px solid #E5E7EB;
            font-size: 14px;
        }

        tr:hover {
            background: #F9FAFB;
        }

        /* Badge Styles */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-success {
            background: #ECFDF5;
            color: var(--success);
        }

        .badge-warning {
            background: #FFFBEB;
            color: #B45309;
        }

        .badge-danger {
            background: #FEF2F2;
            color: var(--danger);
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(4, 120, 87, 0.1);
        }

        /* Stats Card */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: var(--shadow);
        }

        .stats-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .stats-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stats-card-title {
            font-size: 14px;
            color: var(--secondary);
        }

        .stats-card-value {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
        }

        .stats-card-footer {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
            font-size: 14px;
        }

        .stats-trend-up {
            color: var(--success);
        }

        .stats-trend-down {
            color: var(--danger);
        }

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .header {
                left: 0;
            }

            .main {
                margin-left: 0;
            }

            .mobile-sidebar-toggle {
                display: block;
            }
        }

        @media (max-width: 640px) {
            .header {
                padding: 0 16px;
            }

            .content {
                padding: 16px;
            }

            .user-info {
                display: none;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal.show {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid #E5E7EB;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #E5E7EB;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="/dashboard" class="sidebar-logo">
                    <img src="{{ asset('images/logokopma.png') }}" alt="Logo Koperasi">
                    <h1>KOPMA</h1>
                </a>
            </div>
            <nav class="sidebar-menu">
                <a href="/dashboard" class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <a href="/pinjaman" class="menu-item {{ request()->is('pinjaman') ? 'active' : '' }}">
                    <i class="fas fa-hand-holding-usd"></i>
                    Pinjaman
                </a>
                <a href="/simpanan" class="menu-item {{ request()->is('simpanan') ? 'active' : '' }}">
                    <i class="fas fa-piggy-bank"></i>
                    Simpanan
                </a>
                <a href="/profil" class="menu-item {{ request()->is('profil') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    Profil
                </a>
                <a href="/feedback" class="menu-item {{ request()->is('feedback') ? 'active' : '' }}">
                    <i class="fas fa-comments"></i>
                    Feedback
                </a>
                <a href="/about" class="menu-item {{ request()->is('about') ? 'active' : '' }}">
                    <i class="fas fa-info-circle"></i>
                    Tentang Kami
                </a>
            </nav>
        </aside>

        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <h1 class="page-title">@yield('title')</h1>
            </div>

            <div class="header-right">
                <div class="user-menu">
                    <div class="user-trigger" id="userMenuTrigger">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-info">
                            <div class="user-name" id="userName">Loading...</div>
                            <div class="user-email" id="userEmail">Loading...</div>
                        </div>
                        <i class="fas fa-chevron-down text-secondary"></i>
                    </div>

                    <div class="user-dropdown" id="userDropdown">
                        <div class="dropdown-header">
                            <div class="dropdown-user-info">
                                <strong id="dropdownUserName">Loading...</strong>
                                <span id="dropdownUserEmail">Loading...</span>
                            </div>
                        </div>

                        <div class="dropdown-menu">
                            <a href="/profil" class="dropdown-item">
                                <i class="fas fa-user"></i>
                                Profil Saya
                            </a>
                            <a href="/pengaturan" class="dropdown-item">
                                <i class="fas fa-cog"></i>
                                Pengaturan
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item text-danger" onclick="logout()">
                                <i class="fas fa-sign-out-alt"></i>
                                Keluar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
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
                // Get user data
                const userDoc = await getDoc(doc(db, "users", user.uid));
                const userData = userDoc.exists() ? userDoc.data() : {};
                
                // Update displayed name and email
                const displayName = userData.nama || user.email.split('@')[0];
                document.getElementById('userName').textContent = displayName;
                document.getElementById('userEmail').textContent = user.email;
                document.getElementById('dropdownUserName').textContent = displayName;
                document.getElementById('dropdownUserEmail').textContent = user.email;
            } else {
                window.location.href = '/login';
            }
        });

        // Logout function
        window.logout = async () => {
            try {
                await signOut(auth);
                window.location.href = '/login';
            } catch (error) {
                console.error('Logout error:', error);
            }
        };
    </script>
    @stack('scripts')
</body>
</html>
