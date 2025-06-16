<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kelola Transaksi – Koperasi Mahasiswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"></link>
  <style>
    /* Styling dasar */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      background: #047857 !important; /* Hijau koperasi */
      color: #fff;
    }
    /* Mengatur tinggi minimum untuk memastikan footer tidak naik saat konten pendek */
    #root {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Kustomisasi scrollbar untuk tampilan yang lebih bersih, konsisten dashboard */
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

    /* Modal Styling (konsisten dengan halaman dashboard & feedback) */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6); /* Lebih gelap untuk fokus */
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .modal-overlay.show {
      opacity: 1;
      visibility: visible;
    }
    .modal-content {
      background: white;
      padding: 2rem; /* Adjusted padding to match dashboard modal */
      border-radius: 0.75rem; /* Adjusted border-radius */
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); /* Adjusted shadow */
      text-align: center;
      max-width: 400px;
      width: 90%;
      transform: translateY(-20px);
      transition: transform 0.3s ease;
    }
    .modal-overlay.show .modal-content {
      transform: translateY(0);
    }
    .modal-content p {
      margin-bottom: 1.5rem; /* Adjusted margin-bottom */
      font-size: 1rem; /* Adjusted font size */
      color: #4a5568;
    }
    .modal-buttons {
      display: flex;
      justify-content: center;
      gap: 1rem; /* Adjusted gap */
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
      border-bottom: 1px solid #05966933;
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
      border-top: 1px solid #05966933;
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

    /* Styling untuk setiap item transaksi individual (kartu) */
    .manage-transaction-card { /* New class name for clarity on this page */
      background: #ffffff;
      padding: 1.5rem; /* Slightly more padding for a richer feel */
      border-radius: 0.75rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.06);
      border: 1px solid #e2e8f0;
      display: flex;
      flex-direction: column;
      gap: 1.25rem; /* Consistent spacing */
      transition: all 0.2s ease-in-out;
    }
    .manage-transaction-card:hover {
      background: #f0fdf4; /* Light emerald hover */
      border-color: #a7f3d0;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(0,0,0,0.08);
    }
    .manage-transaction-card .transaction-card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-bottom: 1rem; /* Consistent padding */
      margin-bottom: 1rem;
      border-bottom: 1px solid #e2e8f0; /* Softer border */
    }
    .manage-transaction-card .transaction-card-header .amount-display {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .manage-transaction-card .transaction-card-detail {
      display: flex;
      align-items: flex-start; /* Align to top for multi-line content */
      gap: 0.75rem; /* Gap between icon and text */
      font-size: 0.95rem; /* Slightly smaller for details */
      color: #475569; /* Muted text color */
    }
    .manage-transaction-card .transaction-card-detail i {
      color: #64748b; /* Muted icon color */
      font-size: 1.1rem; /* Slightly larger icon for detail lines */
      flex-shrink: 0; /* Prevent icon from shrinking */
    }
    .manage-transaction-card .transaction-card-detail span {
      flex-grow: 1;
      word-break: break-word; /* Ensure text wraps */
      line-height: 1.4;
    }
    .manage-transaction-card .transaction-card-actions {
      display: flex;
      flex-wrap: wrap;
      justify-content: flex-end;
      gap: 0.75rem; /* Consistent gap for buttons */
      margin-top: 1rem;
      padding-top: 1rem;
      border-top: 1px solid #e2e8f0;
    }
    /* Redefine btn-card styles to match new aesthetic */
    .btn-card {
      @apply py-2 px-4 rounded-md font-semibold transition duration-200 shadow-sm; /* Smaller padding, rounded-md */
    }
    .btn-card i {
        margin-right: 0.35rem; /* Small margin for icons */
    }
    .btn-card-approve {
      @apply bg-emerald-600 hover:bg-emerald-700 text-white; /* Emerald green */
    }
    .btn-card-reject {
      @apply bg-red-600 hover:bg-red-700 text-white;
    }
    .btn-card-edit { /* Not used in current rendering, but good to have */
      @apply bg-blue-500 hover:bg-blue-600 text-white;
    }
    .btn-card-delete {
      @apply bg-rose-600 hover:bg-rose-700 text-white; /* More professional red for delete */
    }
    /* Status badge styles are already consistent */
    .status-badge {
      @apply py-1 px-3 rounded-full text-xs font-semibold; /* Reduced font size for badges */
    }
    .status-Menunggu { /* Tailwind equivalent for the old classes */
      @apply bg-yellow-100 text-yellow-800;
    }
    .status-Disetujui, .status-Aktif { /* Added Active status for consistency */
      @apply bg-emerald-100 text-emerald-800;
    }
    .status-Ditolak {
      @apply bg-red-100 text-red-800;
    }

    /* Styling untuk dropdown (konsisten dengan halaman dashboard & feedback) */
    .bulan-select { /* Reusing class name for consistency */
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
      padding-right: 36px; /* Ruang untuk panah kustom */
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
      <a href="/admin"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
      <a href="/transaksi" class="active"><i class="fas fa-exchange-alt"></i> Kelola Transaksi</a>
      <a href="/daftar"><i class="fas fa-comments"></i> Daftar Feedback</a>
    </nav>
    <div class="sidebar-user">
      <span class="flex items-center gap-2"><i class="fas fa-user-circle text-2xl"></i> Admin</span>
      <button id="sidebarLogoutBtn" class="sidebar-user-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </div>
  </div>
  <div id="root" class="main-content">
    <header class="bg-gradient-to-r from-emerald-600 to-emerald-800 text-white p-8 text-center shadow-md">
      <h1 class="text-4xl font-extrabold mb-2">Kelola Transaksi</h1>
      <p class="text-lg opacity-90">Manajemen Simpanan dan Pinjaman Anggota Koperasi</p>
    </header>

    <main class="container mx-auto p-6 flex-grow">
      <div class="flex justify-center mb-8 bg-white p-2 rounded-xl shadow-lg border border-gray-100">
        <button id="simpananTabBtn" class="flex-1 px-8 py-3 rounded-lg text-lg font-semibold transition-all duration-300 ease-in-out focus:outline-none bg-emerald-600 text-white shadow-md">
          Daftar Transaksi Simpanan
        </button>
        <button id="pinjamanTabBtn" class="flex-1 px-8 py-3 rounded-lg text-lg font-semibold ml-4 transition-all duration-300 ease-in-out focus:outline-none text-gray-700 hover:bg-emerald-100">
          Daftar Transaksi Pinjaman
        </button>
      </div>

      <section id="simpananSection" class="flex flex-col gap-6 bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
          <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-0">Daftar Transaksi Simpanan</h2>
          <div class="flex items-center relative">
            <label for="sortSimpanan" class="mr-2 text-gray-700 font-medium whitespace-nowrap">Urutkan berdasarkan :</label>
            <select id="sortSimpanan" class="bulan-select">
              <option value="terbaru">Terbaru</option>
              <option value="terlama">Terlama</option>
            </select>
            <span class="custom-dropdown-arrow">&#9660;</span>
          </div>
        </div>
        <div id="simpananCardsContainer" class="flex flex-col gap-6">
          <p class="text-center text-gray-500 py-8">Memuat data simpanan...</p>
        </div>
      </section>

      <section id="pinjamanSection" class="flex flex-col gap-6 hidden bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
          <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-0">Daftar Transaksi Pinjaman</h2>
          <div class="flex items-center relative">
            <label for="sortPinjaman" class="mr-2 text-gray-700 font-medium whitespace-nowrap">Urutkan berdasarkan :</label>
            <select id="sortPinjaman" class="bulan-select">
              <option value="terbaru">Terbaru</option>
              <option value="terlama">Terlama</option>
            </select>
            <span class="custom-dropdown-arrow">&#9660;</span>
          </div>
        </div>
        <div id="pinjamanCardsContainer" class="flex flex-col gap-6">
          <p class="text-center text-gray-500 py-8">Memuat data pinjaman...</p>
        </div>
      </section>
    </main>

    <div id="confirmationModal" class="modal-overlay">
      <div class="modal-content">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Konfirmasi</h3>
        <p id="modalMessage">Apakah Anda yakin?</p>
        <div class="modal-buttons">
          <button id="modalConfirmBtn" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition duration-200 font-medium">Ya</button>
          <button id="modalCancelBtn" class="px-6 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition duration-200 font-medium">Batal</button>
        </div>
      </div>
    </div>

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
    import { getFirestore, collection, getDocs, deleteDoc, updateDoc, doc } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

    // Konfigurasi Firebase Anda
    const firebaseConfig = {
      apiKey: "AIzaSyAuq0JEjnEOagJnONPemkMP0bbgqepiFp8",
      authDomain: "koperasimahasiswaapp.firebaseapp.com",
      projectId: "koperasimahasiswaapp",
      storageBucket: "koperasimahasiswaapp.appspot.com",
      messagingSenderId: "812843080953",
      appId: "1:812843080953:web:9a931f89186182660bd628"
    };

    // Inisialisasi Firebase
    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app); // Initialize auth
    const db = getFirestore(app);

    // Ambil referensi ke elemen HTML
    const simpananSection = document.getElementById('simpananSection');
    const pinjamanSection = document.getElementById('pinjamanSection');
    const simpananTabBtn = document.getElementById('simpananTabBtn');
    const pinjamanTabBtn = document.getElementById('pinjamanTabBtn');
    // const transaksiNavLink = document.getElementById('transaksiNavLink'); // This element is not in the HTML for direct event listening
    const sortSimpananDropdown = document.getElementById('sortSimpanan');
    const sortPinjamanDropdown = document.getElementById('sortPinjaman');
    const simpananCardsContainer = document.getElementById('simpananCardsContainer'); // New container
    const pinjamanCardsContainer = document.getElementById('pinjamanCardsContainer'); // New container

    // Referensi untuk modal konfirmasi
    const confirmationModal = document.getElementById('confirmationModal');
    const modalMessage = document.getElementById('modalMessage');
    const modalConfirmBtn = document.getElementById('modalConfirmBtn');
    const modalCancelBtn = document.getElementById('modalCancelBtn');

    // References for Logout Modal (consistent with dashboard/feedback)
    const logoutButton = document.getElementById('logoutButton');
    const logoutModal = document.getElementById('logoutModal');
    const cancelLogout = document.getElementById('cancelLogout');
    const confirmLogout = document.getElementById('confirmLogout');
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenuDropdown = document.getElementById('userMenuDropdown');


    let resolveModalPromise; // Variabel untuk menyimpan fungsi resolve dari Promise

    // Authentication check on page load
    onAuthStateChanged(auth, user => {
      if (!user) {
        window.location.href = '/login'; // Redirect to login if not authenticated
      } else {
        // Load initial data (display simpanan tab by default)
        switchTab('simpanan');
      }
    });

    /**
     * Menampilkan modal konfirmasi dengan pesan tertentu.
     * @param {string} message Pesan yang akan ditampilkan di modal.
     * @returns {Promise<boolean>} Promise yang akan di-resolve dengan true jika dikonfirmasi, false jika dibatalkan.
     */
    function showConfirmationModal(message) {
      modalMessage.textContent = message;
      confirmationModal.classList.add('show');

      return new Promise((resolve) => {
        resolveModalPromise = resolve; // Simpan fungsi resolve
      });
    }

    // Event listener untuk tombol 'Ya' di modal
    modalConfirmBtn.onclick = () => {
      confirmationModal.classList.remove('show');
      if (resolveModalPromise) {
        resolveModalPromise(true);
      }
    };

    // Event listener untuk tombol 'Batal' di modal
    modalCancelBtn.onclick = () => {
      confirmationModal.classList.remove('show');
      if (resolveModalPromise) {
        resolveModalPromise(false);
      }
    };

    // Mengubah format angka menjadi Rupiah
    function formatRupiah(num) {
      return 'Rp ' + (num || 0).toLocaleString('id-ID');
    }

    /**
     * Mengembalikan kelas Tailwind untuk status badge.
     * @param {string} status Status transaksi.
     * @returns {string} Kelas CSS untuk styling badge.
     */
    function getStatusBadgeClass(status) {
      switch (status) {
        case 'Menunggu':
          return 'status-Menunggu'; // Refers to the custom class
        case 'Disetujui':
          return 'status-Disetujui'; // Refers to the custom class
        case 'Aktif': // Added Active status for pinjaman
          return 'status-Aktif'; // Refers to the custom class
        case 'Ditolak':
          return 'status-Ditolak'; // Refers to the custom class
        default:
          return 'bg-gray-200 text-gray-800'; // Default styling
      }
    }

    /**
     * Helper function to get a date object from either `createdAt` (Timestamp) or `tanggal` (string).
     * @param {object} data The document data.
     * @returns {Date} A Date object, or a new Date if no valid date field is found.
     */
    function getDateFromDoc(data) {
        if (data.createdAt && typeof data.createdAt.toDate === 'function') {
            return data.createdAt.toDate();
        } else if (data.tanggal && typeof data.tanggal === 'string') {
            // Attempt to parse string date, handle potential errors
            const date = new Date(data.tanggal);
            return isNaN(date.getTime()) ? new Date() : date;
        }
        return new Date(); // Fallback to current date
    }


    /**
     * Memuat dan menampilkan data transaksi simpanan dari Firestore dalam bentuk kartu.
     */
    async function loadSimpanan() {
      simpananCardsContainer.innerHTML = '<p class="text-center text-gray-500 py-8">Memuat data simpanan...</p>'; // Show loading state
      try {
        const snapshot = await getDocs(collection(db, 'simpanan'));
        let dataArray = [];
        snapshot.forEach(docu => {
          dataArray.push({ id: docu.id, ...docu.data() });
        });

        // Sort data based on dropdown selection using getDateFromDoc
        const sortBy = sortSimpananDropdown.value;
        dataArray.sort((a, b) => {
          const dateA = getDateFromDoc(a).getTime();
          const dateB = getDateFromDoc(b).getTime();
          return sortBy === 'terlama' ? dateA - dateB : dateB - dateA;
        });

        let html = '';
        if (dataArray.length === 0) {
          html = '<p class="text-center text-gray-500 py-8">Tidak ada data simpanan.</p>';
        } else {
          dataArray.forEach(data => {
            // Use getDateFromDoc for consistent date display
            const displayDate = getDateFromDoc(data);
            const formattedHeaderDate = displayDate.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

            html += `
              <div class="manage-transaction-card">
                <div class="transaction-card-header">
                  <div class="amount-display">
                    <i class="fas fa-user-circle text-emerald-700 text-3xl"></i>
                    <span class="text-xl font-bold text-emerald-700">${formatRupiah(data.jumlah)}</span>
                  </div>
                  <span class="text-gray-600 text-sm font-medium">${formattedHeaderDate}</span>
                </div>
                <div class="flex flex-col gap-2">
                    <div class="transaction-card-detail">
                        <i class="fas fa-envelope"></i>
                        <span>Pengaju: ${data.userEmail || '-'}</span>
                    </div>
                    <div class="transaction-card-detail">
                        <i class="fas fa-info-circle"></i>
                        <span>Keterangan: ${data.keterangan || '-'}</span>
                    </div>
                    <div class="transaction-card-detail">
                        <i class="fas fa-tasks"></i>
                        <span>Status: <span class="status-badge ${getStatusBadgeClass(data.status)}">${data.status || '-'}</span></span>
                    </div>
                </div>
                <div class="transaction-card-actions">
                  <button class="btn-card btn-card-approve" onclick="ubahStatusSimpanan('${data.id}', 'Disetujui')">
                    <i class="fas fa-check"></i> Setujui
                  </button>
                  <button class="btn-card btn-card-reject" onclick="ubahStatusSimpanan('${data.id}', 'Ditolak')">
                    <i class="fas fa-times"></i> Tolak
                  </button>
                  <button class="btn-card btn-card-delete" onclick="deleteSimpanan('${data.id}')">
                    <i class="fas fa-trash"></i> Hapus
                  </button>
                </div>
              </div>
            `;
          });
        }
        simpananCardsContainer.innerHTML = html;
      } catch (error) {
        console.error("Error loading simpanan data:", error);
        simpananCardsContainer.innerHTML = '<p class="text-center text-red-500 py-8">Gagal memuat data simpanan.</p>';
      }
    }

    /**
     * Memuat dan menampilkan data transaksi pinjaman dari Firestore dalam bentuk kartu.
     */
    async function loadPinjaman() {
      pinjamanCardsContainer.innerHTML = '<p class="text-center text-gray-500 py-8">Memuat data pinjaman...</p>'; // Show loading state
      try {
        const snapshot = await getDocs(collection(db, 'pinjaman'));
        let dataArray = [];
        snapshot.forEach(docu => {
          dataArray.push({ id: docu.id, ...docu.data() });
        });

        // Sort data based on dropdown selection using getDateFromDoc
        const sortBy = sortPinjamanDropdown.value;
        dataArray.sort((a, b) => {
          const dateA = getDateFromDoc(a).getTime();
          const dateB = getDateFromDoc(b).getTime();
          return sortBy === 'terlama' ? dateA - dateB : dateB - dateA;
        });

        let html = '';
        if (dataArray.length === 0) {
          html = '<p class="text-center text-gray-500 py-8">Tidak ada data pinjaman.</p>';
        } else {
          dataArray.forEach(data => {
            // Use getDateFromDoc for consistent date display
            const displayDate = getDateFromDoc(data);
            const formattedHeaderDate = displayDate.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

            html += `
              <div class="manage-transaction-card">
                <div class="transaction-card-header">
                  <div class="amount-display">
                    <i class="fas fa-user-circle text-emerald-700 text-3xl"></i>
                    <span class="text-xl font-bold text-emerald-700">${formatRupiah(data.jumlah)}</span>
                  </div>
                  <span class="text-gray-600 text-sm font-medium">${formattedHeaderDate}</span>
                </div>
                <div class="flex flex-col gap-2">
                    <div class="transaction-card-detail">
                        <i class="fas fa-envelope"></i>
                        <span>Pengaju: ${data.userEmail || '-'}</span>
                    </div>
                    <div class="transaction-card-detail">
                        <i class="fas fa-bullseye"></i>
                        <span>Tujuan: ${data.tujuan || '-'}</span>
                    </div>
                    <div class="transaction-card-detail">
                        <i class="fas fa-tasks"></i>
                        <span>Status: <span class="status-badge ${getStatusBadgeClass(data.status)}">${data.status || '-'}</span></span>
                    </div>
                </div>
                <div class="transaction-card-actions">
                  <button class="btn-card btn-card-approve" onclick="ubahStatusPinjaman('${data.id}', 'Disetujui')">
                    <i class="fas fa-check"></i> Setujui
                  </button>
                  <button class="btn-card btn-card-reject" onclick="ubahStatusPinjaman('${data.id}', 'Ditolak')">
                    <i class="fas fa-times"></i> Tolak
                  </button>
                  <button class="btn-card btn-card-delete" onclick="deletePinjaman('${data.id}')">
                    <i class="fas fa-trash"></i> Hapus
                  </button>
                </div>
              </div>
            `;
          });
        }
        pinjamanCardsContainer.innerHTML = html;
      } catch (error) {
        console.error("Error loading pinjaman data:", error);
        pinjamanCardsContainer.innerHTML = '<p class="text-center text-red-500 py-8">Gagal memuat data pinjaman.</p>';
      }
    }

    /**
     * Fungsi global untuk menghapus transaksi simpanan.
     * @param {string} id ID dokumen simpanan yang akan dihapus.
     */
    window.deleteSimpanan = async function(id) {
      const confirmed = await showConfirmationModal("Yakin ingin menghapus transaksi simpanan ini?");
      if (confirmed) {
        try {
          await deleteDoc(doc(db, 'simpanan', id));
          loadSimpanan();
        } catch (error) {
          console.error("Error deleting simpanan:", error);
        }
      }
    }

    /**
     * Fungsi global untuk menghapus transaksi pinjaman.
     * @param {string} id ID dokumen pinjaman yang akan dihapus.
     */
    window.deletePinjaman = async function(id) {
      const confirmed = await showConfirmationModal("Yakin ingin menghapus transaksi pinjaman ini?");
      if (confirmed) {
        try {
          await deleteDoc(doc(db, 'pinjaman', id));
          loadPinjaman();
        } catch (error) {
          console.error("Error deleting pinjaman:", error);
        }
      }
    }

    /**
     * Fungsi global untuk mengubah status transaksi pinjaman.
     * @param {string} id ID dokumen pinjaman yang akan diubah.
     * @param {string} statusBaru Status baru (e.g., 'Disetujui', 'Ditolak', 'Aktif').
     */
    window.ubahStatusPinjaman = async function(id, statusBaru) {
      const confirmed = await showConfirmationModal(`Ubah status pinjaman menjadi ${statusBaru}?`);
      if (confirmed) {
        try {
          await updateDoc(doc(db, 'pinjaman', id), { status: statusBaru });
          loadPinjaman();
        } catch (error) {
          console.error("Error updating pinjaman status:", error);
        }
      }
    }

    /**
     * Fungsi global untuk mengubah status transaksi simpanan.
     * @param {string} id ID dokumen simpanan yang akan diubah.
     * @param {string} statusBaru Status baru (e.g., 'Disetujui', 'Ditolak').
     */
    window.ubahStatusSimpanan = async function(id, statusBaru) {
      const confirmed = await showConfirmationModal(`Ubah status simpanan menjadi ${statusBaru}?`);
      if (confirmed) {
        try {
          await updateDoc(doc(db, 'simpanan', id), { status: statusBaru });
          loadSimpanan();
        } catch (error) {
          console.error("Error updating simpanan status:", error);
        }
      }
    }

    // Fungsi dummy edit pinjaman, tidak lagi dipanggil di UI.
    window.editPinjaman = async function(id) {
        // alert("Fungsi edit pinjaman untuk ID: " + id + " akan datang segera!");
    }

    /**
     * Mengelola pergantian tab antara Simpanan dan Pinjaman.
     * @param {string} activeTab 'simpanan' atau 'pinjaman'.
     */
    function switchTab(activeTab) {
      if (activeTab === 'simpanan') {
        simpananSection.classList.remove('hidden');
        pinjamanSection.classList.add('hidden');
        simpananTabBtn.classList.add('bg-emerald-600', 'text-white', 'shadow-md');
        simpananTabBtn.classList.remove('text-gray-700', 'hover:bg-emerald-100');
        pinjamanTabBtn.classList.remove('bg-emerald-600', 'text-white', 'shadow-md');
        pinjamanTabBtn.classList.add('text-gray-700', 'hover:bg-emerald-100');
        loadSimpanan(); // Muat ulang data simpanan saat tab aktif
      } else {
        pinjamanSection.classList.remove('hidden');
        simpananSection.classList.add('hidden');
        pinjamanTabBtn.classList.add('bg-emerald-600', 'text-white', 'shadow-md');
        pinjamanTabBtn.classList.remove('text-gray-700', 'hover:bg-emerald-100');
        simpananTabBtn.classList.remove('bg-emerald-600', 'text-white', 'shadow-md');
        simpananTabBtn.classList.add('text-gray-700', 'hover:bg-emerald-100');
        loadPinjaman(); // Muat ulang data pinjaman saat tab aktif
      }
    }

    // Event listeners untuk tombol tab
    simpananTabBtn.addEventListener('click', () => switchTab('simpanan'));
    pinjamanTabBtn.addEventListener('click', () => switchTab('pinjaman'));

    // Event listener untuk dropdown sorting
    sortSimpananDropdown.addEventListener('change', loadSimpanan);
    sortPinjamanDropdown.addEventListener('change', loadPinjaman);

    // --- Logout Modal Logic (Copied from Dashboard) ---
    logoutButton.addEventListener('click', (e) => {
      e.preventDefault();
      logoutModal.classList.remove('hidden');
    });

    cancelLogout.addEventListener('click', () => {
      logoutModal.classList.add('hidden');
    });

    confirmLogout.addEventListener('click', async () => {
      try {
        await signOut(auth);
        window.location.href = '/login';
      } catch (error) {
        console.error("Error signing out: ", error);
        alert("Gagal logout. Silakan coba lagi.");
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
    if (userMenuDropdown) userMenuDropdown.style.display = 'none';
    // --- End Logout Modal Logic ---

  </script>
</body>
</html>