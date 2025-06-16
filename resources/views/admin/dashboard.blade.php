<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard Admin – Koperasi Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"></link>
    <style>
        /* Custom font import for a professional look */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background: #f8fafc; /* Lighter, subtle background */
            color: #333;
        }
        #root {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        /* Custom scrollbar for a cleaner feel */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #94a3b8; /* Muted scrollbar color */
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* Redesigned Select Element for charts */
        .bulan-select {
            padding: 8px 24px 8px 12px; /* Adjust padding for better look, reduced vertical padding */
            border: 1px solid #cbd5e1; /* Lighter, subtle border */
            border-radius: 8px; /* Slightly more rounded corners */
            background-color: #ffffff; /* White background */
            color: #334155; /* Darker text */
            font-size: 0.875em; /* Smaller font size (equivalent to Tailwind's text-sm) */
            font-weight: 500;
            cursor: pointer;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); /* Softer shadow */
            -webkit-appearance: none; /* Remove default dropdown arrow */
            -moz-appearance: none;
            appearance: none;
        }
        .bulan-select:hover {
            border-color: #94a3b8; /* Muted hover border */
        }
        .bulan-select:focus {
            border-color: #059669; /* Emerald focus */
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.2);
        }
        .custom-dropdown-arrow {
            position: absolute;
            right: 10px; /* Adjusted right position */
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #64748b; /* Muted arrow color */
            font-size: 0.7em; /* Slightly smaller arrow */
        }

        /* Redesigned Transaction List Item for a professional feed */
        .transaction-list-item {
            background: #ffffff;
            padding: 1.25rem; /* More padding */
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06); /* Stronger, softer shadow */
            display: flex;
            align-items: flex-start;
            gap: 1.25rem; /* Increased gap */
            border: 1px solid #e2e8f0;
            position: relative;
            transition: all 0.2s ease-in-out; /* Smooth transition for hover effects */
        }
        .transaction-list-item:hover {
            background: #f0fdf4; /* Light emerald hover background */
            border-color: #a7f3d0; /* Subtle green hover border */
            transform: translateY(-2px); /* Slight lift effect */
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        }
        .transaction-icon {
            color: #059669; /* Emerald color for icon */
            font-size: 2.25rem; /* Larger icon */
            flex-shrink: 0;
            width: 56px;
            height: 56px; /* Larger container */
            display: flex;
            align-items: center;
            justify-content: center;
            background: #d1fae5; /* Lighter emerald background */
            border-radius: 12px; /* More rounded */
        }
        .transaction-amount-label {
            font-size: 1rem;
            font-weight: 600;
            color: #475569; /* Muted label text */
        }
        .transaction-amount {
            font-size: 1.5rem;
            font-weight: bold;
            color: #047857; /* Darker emerald for amount */
            margin-left: 8px;
        }
        .transaction-date-top-right {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
        }
        .transaction-status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 9999px;
            font-size: 0.75rem; /* Smaller font for badge */
            font-weight: 600;
            text-transform: uppercase; /* Uppercase for a more corporate look */
            letter-spacing: 0.05em;
        }
        /* Muted and professional status badge colors */
        .status-Disetujui, .status-Aktif {
            background: #dcfce7;
            color: #15803d;
        } /* Light green, dark green text */
        .status-Menunggu {
            background: #fefce8;
            color: #a16207;
        } /* Light yellow, dark yellow text */
        .status-Ditolak {
            background: #fee2e2;
            color: #b91c1c;
        } /* Light red, dark red text */

        /* Logout Modal Specific Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
            text-align: center;
        }
        .modal-buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 1.5rem;
            gap: 1rem;
        }

        /* Sidebar styles */
        .sidebar {
            width: 250px;
            min-width: 220px;
            background: linear-gradient(to bottom, #047857, #065f46);
            color: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 40;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }
        .sidebar-collapsed {
            transform: translateX(-100%);
        }
        .sidebar-header {
            padding: 2rem 1.5rem 1rem 1.5rem;
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(5, 150, 105, 0.2); /* Adjusted opacity for lighter border */
        }
        .sidebar-menu {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 1.5rem 1rem 1rem 1.5rem;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: #d1fae5;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
        }
        .sidebar-menu a.active, .sidebar-menu a:hover {
            background: #059669;
            color: #fff;
        }
        .sidebar-user {
            margin: 1.5rem 1rem 1rem 1.5rem;
            border-top: 1px solid rgba(5, 150, 105, 0.2); /* Adjusted opacity for lighter border */
            padding-top: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            justify-content: space-between;
        }
        .sidebar-user-btn {
            background: none;
            border: none;
            color: #d1fae5;
            font-size: 1.1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            transition: background 0.2s, color 0.2s;
        }
        .sidebar-user-btn:hover {
            background: #059669;
            color: #fff;
        }
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 1.25rem;
            left: 1.25rem;
            z-index: 50;
            background: #047857;
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .sidebar-toggle {
                display: block;
            }
            .main-content {
                margin-left: 0 !important;
            }
        }
        @media (min-width: 1025px) {
            .sidebar {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 250px;
            }
        }
    </style>
</head>
<body>
    <button id="sidebarToggle" class="sidebar-toggle lg:hidden" aria-label="Buka Sidebar">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-university text-emerald-300"></i>
            Koperasi Mahasiswa
        </div>
        <nav class="sidebar-menu">
            <a href="{{ url('/admin') }}" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ url('/transaksi') }}"><i class="fas fa-exchange-alt"></i> Kelola Transaksi</a>
            <a href="{{ url('/daftar') }}"><i class="fas fa-comments"></i> Daftar Feedback</a>
        </nav>
        <div class="sidebar-user">
            <span class="flex items-center gap-2"><i class="fas fa-user-circle text-2xl"></i> Admin</span>
            <button id="sidebarLogoutBtn" class="sidebar-user-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </div>
    </div>
    <div id="root" class="main-content">
        <header class="bg-gradient-to-r from-emerald-600 to-emerald-800 text-white p-8 text-center shadow-md">
            <h1 class="text-4xl font-extrabold mb-2">Dashboard Admin</h1>
            <p class="text-lg opacity-90">Ringkasan Operasional Koperasi Mahasiswa</p>
        </header>

        <main class="container mx-auto p-6 flex-grow">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-600 mb-2">Total Pengguna</h4>
                    <h2 id="totalUsers" class="text-4xl font-bold text-emerald-700">...</h2>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-600 mb-2">Total Simpanan</h4>
                    <h2 id="totalSavings" class="text-4xl font-bold text-emerald-700">...</h2>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-600 mb-2">Pinjaman Aktif</h4>
                    <h2 id="activeLoans" class="text-4xl font-bold text-emerald-700">...</h2>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-600 mb-2">Menunggu Verifikasi</h4>
                    <h2 id="pendingLoans" class="text-4xl font-bold text-emerald-700">...</h2>
                </div>
            </div>

            <div id="chartWrapper" class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                    <h4 class="text-xl font-bold text-gray-800 mb-4 sm:mb-0">Statistik Transaksi Bulanan</h4>
                    <div class="relative flex items-center">
                        <select id="bulanSelect" class="bulan-select">
                            <option value="1">1 Bulan Terakhir</option>
                            <option value="2">2 Bulan Terakhir</option>
                            <option value="3">3 Bulan Terakhir</option>
                            <option value="4">4 Bulan Terakhir</option>
                            <option value="5">5 Bulan Terakhir</option>
                            <option value="6">6 Bulan Terakhir</option>
                        </select>
                        <span class="custom-dropdown-arrow">&#9660;</span>
                    </div>
                </div>
                <canvas id="myChart" height="100"></canvas>
                <div id="legendCustom" class="flex flex-wrap justify-center items-center gap-6 mt-6">
                    <span class="flex items-center gap-2 text-sm font-medium text-gray-700">
                        <span class="w-4 h-4 rounded-md inline-block" style="background:#34d399"></span>Pinjaman
                    </span>
                    <span class="flex items-center gap-2 text-sm font-medium text-gray-700">
                        <span class="w-4 h-4 rounded-md inline-block" style="background:#10b981"></span>Simpanan
                    </span>
                </div>
            </div>

            <div id="anomalyAlert" class="mb-8">
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fas fa-exclamation-circle text-2xl text-red-600"></i>
                        <div class="font-bold text-red-700 text-xl">Peringatan Anomali</div>
                    </div>
                    <div class="bg-white bg-opacity-70 rounded-lg p-4 text-center text-gray-600 font-semibold border border-red-100">
                        Memeriksa anomali...
                    </div>
                </div>
            </div>

            <div id="transWrapper" class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-gray-100">
                <h4 class="text-xl font-bold text-gray-800 mb-5">Transaksi Terakhir</h4>
                <div id="latestTransactionsList" class="flex flex-col gap-4">
                    <p class="text-center text-gray-500 py-4">Memuat...</p>
                </div>
            </div>
        </main>

        <div id="logoutModal" class="modal-overlay hidden">
            <div class="modal-content">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Konfirmasi Logout</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin keluar dari akun admin?</p>
                <div class="modal-buttons">
                    <button id="cancelLogout" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 font-medium">Batal</button>
                    <button id="confirmLogout" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 font-medium">Logout</button>
                </div>
            </div>
        </div>

    </div>
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";
        import { getFirestore, collection, query, getDocs, orderBy, limit } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

        // Firebase configuration (replace with your actual config if different)
        const firebaseConfig = {
            apiKey: "AIzaSyAuq0JEjnEOagJnONPemkMP0bbgqepiFp8",
            authDomain: "koperasimahasiswaapp.firebaseapp.com",
            projectId: "koperasimahasiswaapp",
            storageBucket: "koperasimahasiswaapp.appspot.com",
            messagingSenderId: "812843080953",
            appId: "1:812843080953:web:9a931f89186182660bd628",
            measurementId: "G-ES6G76W66D"
        };

        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getFirestore(app);

        // DOM Elements
        const elUsers = document.getElementById('totalUsers');
        const elSavings = document.getElementById('totalSavings');
        const elActive = document.getElementById('activeLoans');
        const elPending = document.getElementById('pendingLoans');
        const latestTransactionsList = document.getElementById('latestTransactionsList');
        const ctx = document.getElementById('myChart').getContext('2d');
        const select = document.getElementById('bulanSelect');
        const logoutButton = document.getElementById('logoutButton'); // This ID doesn't exist in HTML, using sidebarLogoutBtn
        const logoutModal = document.getElementById('logoutModal');
        const cancelLogout = document.getElementById('cancelLogout');
        const confirmLogout = document.getElementById('confirmLogout');
        const userMenuButton = document.getElementById('userMenuButton'); // This ID doesn't exist in HTML
        const userMenuDropdown = document.getElementById('userMenuDropdown');
        const anomalyAlertDiv = document.getElementById('anomalyAlert');


        // Helper function to format currency
        function formatRupiah(num) {
            return 'Rp ' + num.toLocaleString('id-ID');
        }

        let chartInstance = null; // To store Chart.js instance for destruction/update

        // Authentication State Change Listener
        onAuthStateChanged(auth, user => {
            if (!user) {
                window.location.href = "{{ url('/login') }}"; // Redirect to login if not authenticated
            } else {
                // Initialize dashboard components once authenticated
                initDashboard().then(() => {
                    tampilkanTransaksiTerakhir();
                    tampilkanPeringatanAnomali();
                });
            }
        });

        // Initialize Dashboard Data
        async function initDashboard() {
            const usersSnap = await getDocs(collection(db, 'users'));
            elUsers.textContent = usersSnap.size;

            // Initial chart update based on default select value
            await updateChart(parseInt(select.value));
            // Update chart when select value changes
            select.onchange = () => updateChart(parseInt(select.value));
        }

        // Helper to get date from Firestore document
        function getDateFromDoc(data) {
            if (data.createdAt && typeof data.createdAt.toDate === 'function') {
                return data.createdAt.toDate();
            }
            if (typeof data.tanggal === 'string') {
                const date = new Date(data.tanggal);
                if (!isNaN(date.getTime())) return date;
            }
            return new Date(); // Fallback to current date if no valid date found
        }

        // Function to display the latest transactions
        async function tampilkanTransaksiTerakhir() {
            latestTransactionsList.innerHTML = '<p class="text-center text-gray-500 py-4">Memuat...</p>';
            const trSnap = await getDocs(query(collection(db, 'pinjaman'), orderBy('createdAt','desc'), limit(5)));
            let html = '';
            if (trSnap.empty) {
                html = '<p class="text-center text-gray-500 py-4">Tidak ada transaksi terbaru.</p>';
            } else {
                trSnap.forEach(d => {
                    const data = d.data();
                    let dt = getDateFromDoc(data);
                    const formattedDate = dt.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
                    const statusClass = `status-${data.status.replace(/\s+/g, '-')}`;
                    html += `
                        <div class="transaction-list-item">
                            <div class="transaction-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="transaction-content">
                                <div class="flex items-center gap-2">
                                    <span class="transaction-amount-label font-bold">Pinjaman</span>
                                    <span class="transaction-status-badge ${statusClass}">${data.status}</span>
                                </div>
                                <div class="text-gray-500 text-sm mt-1">${data.tujuan || 'Tidak ada tujuan'}</div>
                                <div class="transaction-amount mt-2">${formatRupiah(data.jumlah)}</div>
                            </div>
                            <div class="transaction-date-top-right">${formattedDate}</div>
                        </div>
                    `;
                });
            }
            latestTransactionsList.innerHTML = html;
        }

        // Function to display anomaly warnings
        async function tampilkanPeringatanAnomali() {
            // Set initial loading state
            anomalyAlertDiv.innerHTML = `
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fas fa-exclamation-circle text-2xl text-red-600"></i>
                        <div class="font-bold text-red-700 text-xl">Peringatan Anomali</div>
                    </div>
                    <div class="bg-white bg-opacity-70 rounded-lg p-4 text-center text-gray-600 font-semibold border border-red-100">
                        Memuat anomali...
                    </div>
                </div>
            `;

            // Fetch anomalies from Firestore
            const q = query(collection(db, 'pinjaman'), orderBy('createdAt', 'desc'));
            const snap = await getDocs(q);
            const anomalies = snap.docs.filter(doc => doc.data().isAnomaly === true);

            if (anomalies.length === 0) {
                // If no anomalies, show a positive status
                anomalyAlertDiv.innerHTML = `
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <i class="fas fa-check-circle text-2xl text-emerald-600"></i>
                            <div class="font-bold text-emerald-700 text-xl">Status Sistem</div>
                        </div>
                        <div class="bg-white bg-opacity-70 rounded-lg p-4 text-center text-gray-600 font-semibold border border-emerald-100">
                            Tidak ada anomali terdeteksi saat ini. Sistem berjalan normal.
                        </div>
                    </div>
                `;
                return;
            }

            // Render anomaly details
            anomalyAlertDiv.innerHTML = `
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
                        <div class="font-bold text-red-700 text-xl">Peringatan Anomali</div>
                    </div>
                    <div class="flex flex-col gap-4">
                    ${anomalies.map(doc => {
                        const data = doc.data();
                        const tanggal = (data.createdAt && typeof data.createdAt.toDate === 'function')
                            ? data.createdAt.toDate().toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: '2-digit' })
                            : (typeof data.tanggal === 'string' ? new Date(data.tanggal).toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: '2-digit' }) : '-');
                        return `
                            <div class="flex items-start bg-red-100 rounded-xl p-4 gap-4 border border-red-200 shadow-sm">
                                <div class="flex-shrink-0">
                                    <div class="bg-red-200 rounded-lg w-12 h-12 flex items-center justify-center">
                                        <i class="fas fa-bug text-2xl text-red-600"></i>
                                    </div>
                                </div>
                                <div class="flex-grow">
                                    <div class="font-semibold text-gray-800 mb-1">Anomali pengajuan dari:</div>
                                    <div class="font-bold text-gray-800 mb-1 text-lg">${data.userEmail || 'N/A'}</div>
                                    <div class="mb-1 text-gray-700">Jumlah: <span class="font-semibold">${formatRupiah(data.jumlah)}</span></div>
                                    ${(Array.isArray(data.anomalyReasons) && data.anomalyReasons.length > 0)
                                        ? `<div class="text-sm text-red-800 font-medium mt-2">Penyebab:</div>` + data.anomalyReasons.map(r => `<div class="text-sm text-red-700">• ${r}</div>`).join('')
                                        : '<div class="text-sm text-red-700">Tidak ada detail alasan anomali.</div>'}
                                </div>
                                <div class="text-gray-500 font-medium text-xs mt-1 self-start">${tanggal}</div>
                            </div>
                        `;
                    }).join('')}
                    </div>
                </div>
            `;
        }

        // Function to update the chart data and render
        async function updateChart(jumlahBulan) {
            const now = new Date();
            const months = [];
            for(let i=jumlahBulan-1; i>=0; i--) {
                const d = new Date(now.getFullYear(), now.getMonth()-i, 1);
                months.push({
                    key: `${d.getFullYear()}-${d.getMonth()+1}`,
                    label: d.toLocaleString('id-ID', { month: 'short', year: '2-digit' })
                });
            }

            let totalSavingsSum = 0;
            let activeLoansCount = 0;
            let pendingLoansCount = 0;
            const transactionsPerMonth = { simpanan: months.map(_=>0), pinjaman: months.map(_=>0) };

            // Fetch and process simpanan data
            const simSnap = await getDocs(collection(db, 'simpanan'));
            simSnap.forEach(d => {
                const data = d.data();
                totalSavingsSum += data.jumlah || 0;
                let transactionDate = null;
                if (data.createdAt && typeof data.createdAt.toDate === 'function') {
                    transactionDate = data.createdAt.toDate();
                } else if (data.tanggal && typeof data.tanggal === 'string') {
                    const parsedDate = new Date(data.tanggal);
                    if (!isNaN(parsedDate.getTime())) transactionDate = parsedDate;
                }
                if (transactionDate) {
                    const key = `${transactionDate.getFullYear()}-${transactionDate.getMonth()+1}`;
                    const idx = months.findIndex(m => m.key === key);
                    if (idx >= 0) transactionsPerMonth.simpanan[idx] += 1;
                }
            });
            elSavings.textContent = formatRupiah(totalSavingsSum);

            // Fetch and process pinjaman data
            const pinSnap = await getDocs(collection(db, 'pinjaman'));
            pinSnap.forEach(d => {
                const data = d.data();
                if (data.status === 'Disetujui' || data.status === 'Aktif') activeLoansCount++;
                if (data.status === 'Menunggu') pendingLoansCount++;
                let transactionDate = null;
                if (data.createdAt && typeof data.createdAt.toDate === 'function') {
                    transactionDate = data.createdAt.toDate();
                } else if (data.tanggal && typeof data.tanggal === 'string') {
                    const parsedDate = new Date(data.tanggal);
                    if (!isNaN(parsedDate.getTime())) transactionDate = parsedDate;
                }
                if (transactionDate) {
                    const key = `${transactionDate.getFullYear()}-${transactionDate.getMonth()+1}`;
                    const idx = months.findIndex(m => m.key === key);
                    if (idx >= 0) transactionsPerMonth.pinjaman[idx] += 1;
                }
            });
            elActive.textContent = activeLoansCount;
            elPending.textContent = pendingLoansCount;

            const xLabels = months.map(m=>m.label);

            // Destroy previous chart instance before creating a new one
            if(chartInstance) chartInstance.destroy();

            // Create new Chart.js instance
            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: xLabels,
                    datasets: [
                        { label: 'Pinjaman', data: transactionsPerMonth.pinjaman, backgroundColor: '#34d399', borderRadius: 6, barPercentage: 0.6, categoryPercentage: 0.7 }, // Emerald 400
                        { label: 'Simpanan', data: transactionsPerMonth.simpanan, backgroundColor: '#10b981', borderRadius: 6, barPercentage: 0.6, categoryPercentage: 0.7 }  // Emerald 600
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false } // Custom legend is used in HTML
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            title: { display: false },
                            ticks: {
                                font: {
                                    size: 11 // Adjusted font size for X-axis labels
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0,
                                font: {
                                    size: 11 // Adjusted font size for Y-axis labels
                                }
                            },
                            suggestedMax: Math.max(...transactionsPerMonth.simpanan, ...transactionsPerMonth.pinjaman, 1) + 2 // Added buffer for max
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        }

        // Logout Modal Logic
        // This is a direct reference to the button in the main HTML body, not the sidebarLogoutBtn
        // Removed `logoutButton.addEventListener('click', ...)` as it's not present in the HTML structure given.
        
        cancelLogout.addEventListener('click', () => {
            logoutModal.classList.add('hidden'); // Hide the modal
        });

        confirmLogout.addEventListener('click', async () => {
            try {
                await signOut(auth); // Perform Firebase logout
                window.location.href = "{{ url('/login') }}"; // Redirect to login page after successful logout
            } catch (error) {
                console.error("Error signing out: ", error);
                alert("Gagal logout. Silakan coba lagi."); // Alert on error
            }
        });

        // Sidebar toggle logic
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });
        // Close sidebar on outside click (mobile)
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 1024 && sidebar.classList.contains('open')) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });
        // Sidebar logout button triggers modal
        const sidebarLogoutBtn = document.getElementById('sidebarLogoutBtn');
        sidebarLogoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            logoutModal.classList.remove('hidden');
        });
        // Hide user menu dropdown (karena sudah di sidebar)
        // Removed `if (userMenuDropdown) userMenuDropdown.style.display = 'none';` as userMenuDropdown is undefined in provided HTML.
    </script>
</body>
</html>