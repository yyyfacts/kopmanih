<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kelola Transaksi – Koperasi Mahasiswa</title>
  <!-- Tailwind CSS CDN untuk styling modern dan responsif -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome untuk ikon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"></link>
  <style>
    /* Styling dasar */
    body {
      font-family: 'Inter', sans-serif; /* Menggunakan font Inter */
      margin: 0;
      background: #f0f4f8; /* Latar belakang yang lebih terang dan modern */
      color: #333;
    }
    /* Mengatur tinggi minimum untuk memastikan footer tidak naik saat konten pendek */
    #root {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Kustomisasi scrollbar untuk tampilan yang lebih bersih */
    ::-webkit-scrollbar {
      width: 8px;
    }
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb {
      background: #888;
      border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }

    /* Modal Styling */
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
      padding: 30px; /* Padding lebih besar */
      border-radius: 12px; /* Lebih bulat */
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2); /* Shadow yang lebih dalam */
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
      margin-bottom: 25px; /* Spasi lebih banyak */
      font-size: 1.1rem;
      color: #4a5568; /* Warna teks yang lebih lembut */
    }
    .modal-buttons {
      display: flex;
      justify-content: center;
      gap: 15px; /* Spasi antar tombol */
    }

    /* Styling tambahan untuk kartu */
    .transaction-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      padding: 24px;
      margin-bottom: 20px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    .transaction-card-header {
      display: flex;
      justify-content: space-between; /* Mengubah kembali ke space-between */
      align-items: center;
      border-bottom: 1px solid #eee;
      padding-bottom: 12px;
      margin-bottom: 12px;
    }
    .transaction-card-detail {
      display: flex;
      align-items: center;
      gap: 10px;
      /* Memastikan detail berada pada satu baris */
      flex-wrap: nowrap; /* Mencegah wrap pada item detail */
      white-space: nowrap; /* Mencegah teks terpotong */
      overflow: hidden; /* Sembunyikan overflow */
      text-overflow: ellipsis; /* Tampilkan elipsis jika terpotong */
    }
    .transaction-card-detail span {
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .transaction-card-actions {
      display: flex;
      justify-content: flex-end; /* Arahkan tombol ke kanan */
      flex-wrap: wrap; /* Izinkan tombol wrap di layar kecil */
      gap: 10px;
      margin-top: 16px;
      border-top: 1px solid #eee;
      padding-top: 16px;
    }
    .btn-card {
      @apply py-2 px-5 rounded-lg font-semibold transition duration-200 shadow-md;
    }
    .btn-card-approve {
      @apply bg-green-600 hover:bg-green-700 text-white;
    }
    .btn-card-reject {
      @apply bg-red-600 hover:bg-red-700 text-white;
    }
    .btn-card-edit {
      @apply bg-blue-500 hover:bg-blue-600 text-white;
    }
    .btn-card-delete {
      @apply bg-orange-500 hover:bg-orange-600 text-white; /* Warna kuning/oranye */
    }
    .status-badge {
      @apply py-1 px-3 rounded-full text-sm font-semibold;
    }
    .status-pending {
      @apply bg-yellow-100 text-yellow-800;
    }
    .status-approved {
      @apply bg-green-100 text-green-800;
    }
    .status-rejected {
      @apply bg-red-100 text-red-800;
    }
  </style>
</head>
<body>
  <div id="root">
    <!-- Navbar (menggunakan Tailwind untuk modernisasi) -->
    <nav class="bg-emerald-700 p-4 shadow-lg flex justify-between items-center text-white">
      <div class="text-2xl font-bold tracking-wide">Koperasi Mahasiswa</div>
      <div class="flex gap-6">
        <a href="/admin" class="text-white hover:text-emerald-200 transition duration-300 ease-in-out font-medium">Dashboard</a>
        <a href="/transaksi" class="text-white hover:text-emerald-200 transition duration-300 ease-in-out font-medium">Kelola Transaksi</a>
        <a href="/daftar" class="text-white hover:text-emerald-200 transition duration-300 ease-in-out font-medium">Daftar Feedback</a>
      </div>
    </nav>

    <header class="bg-gradient-to-r from-emerald-600 to-emerald-800 text-white p-8 text-center shadow-md">
      <h1 class="text-4xl font-extrabold mb-2">Kelola Transaksi</h1>
      <p class="text-lg opacity-90">Manajemen Simpanan dan Pinjaman Anggota Koperasi</p>
    </header>

    <main class="container mx-auto p-6 flex-grow">
      <!-- Tab Selector -->
      <div class="flex justify-center mb-8 bg-white p-2 rounded-lg shadow-sm">
        <button id="simpananTabBtn" class="px-8 py-3 rounded-lg text-lg font-semibold transition-all duration-300 ease-in-out focus:outline-none bg-emerald-600 text-white shadow-md">
          Daftar Transaksi Simpanan
        </button>
        <button id="pinjamanTabBtn" class="px-8 py-3 rounded-lg text-lg font-semibold ml-4 transition-all duration-300 ease-in-out focus:outline-none text-gray-700 hover:bg-emerald-100">
          Daftar Transaksi Pinjaman
        </button>
      </div>

      <!-- Simpanan Section -->
      <section id="simpananSection" class="flex flex-col gap-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-3xl font-bold text-emerald-700">Daftar Transaksi Simpanan</h2>
          <div class="flex items-center">
            <label for="sortSimpanan" class="mr-2 text-gray-700 font-medium">Urutkan berdasarkan :</label>
            <select id="sortSimpanan" class="border border-green-300 bg-green-50 text-green-800 rounded-md p-2 appearance-none pr-8">
              <option value="terbaru">Terbaru</option>
              <option value="terlama">Terlama</option>
            </select>
            <span class="ml-[-24px] pointer-events-none text-gray-700">&#9660;</span>
          </div>
        </div>
        <div id="simpananCardsContainer" class="flex flex-col gap-6">
          <p class="text-center text-gray-500">Memuat data simpanan...</p>
        </div>
      </section>

      <!-- Pinjaman Section (Hidden by default) -->
      <section id="pinjamanSection" class="flex flex-col gap-6 hidden">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-3xl font-bold text-emerald-700">Daftar Transaksi Pinjaman</h2>
          <div class="flex items-center">
            <label for="sortPinjaman" class="mr-2 text-gray-700 font-medium">Urutkan berdasarkan :</label>
            <select id="sortPinjaman" class="border border-green-300 bg-green-50 text-green-800 rounded-md p-2 appearance-none pr-8">
              <option value="terbaru">Terbaru</option>
              <option value="terlama">Terlama</option>
            </select>
            <span class="ml-[-24px] pointer-events-none text-gray-700">&#9660;</span>
          </div>
        </div>
        <div id="pinjamanCardsContainer" class="flex flex-col gap-6">
          <p class="text-center text-gray-500">Memuat data pinjaman...</p>
        </div>
      </section>
    </main>

    <!-- Custom Confirmation Modal -->
    <div id="confirmationModal" class="modal-overlay">
      <div class="modal-content">
        <p id="modalMessage"></p>
        <div class="modal-buttons">
          <button id="modalConfirmBtn" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200 shadow-md">Ya</button>
          <button id="modalCancelBtn" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded-lg transition duration-200 shadow-md">Batal</button>
        </div>
      </div>
    </div>
  </div>

  <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
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
    const db = getFirestore(app);

    // Ambil referensi ke elemen HTML
    const simpananSection = document.getElementById('simpananSection');
    const pinjamanSection = document.getElementById('pinjamanSection');
    const simpananTabBtn = document.getElementById('simpananTabBtn');
    const pinjamanTabBtn = document.getElementById('pinjamanTabBtn');
    const transaksiNavLink = document.getElementById('transaksiNavLink');
    const sortSimpananDropdown = document.getElementById('sortSimpanan');
    const sortPinjamanDropdown = document.getElementById('sortPinjaman');
    const simpananCardsContainer = document.getElementById('simpananCardsContainer'); // New container
    const pinjamanCardsContainer = document.getElementById('pinjamanCardsContainer'); // New container

    // Referensi untuk modal konfirmasi
    const confirmationModal = document.getElementById('confirmationModal');
    const modalMessage = document.getElementById('modalMessage');
    const modalConfirmBtn = document.getElementById('modalConfirmBtn');
    const modalCancelBtn = document.getElementById('modalCancelBtn');

    let resolveModalPromise; // Variabel untuk menyimpan fungsi resolve dari Promise

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
          return 'status-pending';
        case 'Disetujui':
          return 'status-approved';
        case 'Ditolak':
          return 'status-rejected';
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
          html = '<p class="text-center text-gray-500">Tidak ada data simpanan.</p>';
        } else {
          dataArray.forEach(data => {
            // Use getDateFromDoc for consistent date display
            const displayDate = getDateFromDoc(data);
            const formattedDate = displayDate.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
            // Get the date for the top-right corner, formatted as "DD Mon YYYY"
            const formattedHeaderDate = displayDate.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

            html += `
              <div class="transaction-card">
                <div class="transaction-card-header">
                  <div class="flex items-center gap-3">
                    <i class="fas fa-user-circle text-emerald-700 text-3xl"></i> <!-- Icon dan warna hijau -->
                    <span class="text-xl font-bold text-emerald-700">${formatRupiah(data.jumlah)}</span> <!-- Warna hijau -->
                  </div>
                  <span class="text-gray-600 text-sm font-medium">${formattedHeaderDate}</span> <!-- Tanggal di kanan atas, warna abu-abu -->
                </div>
                <div class="flex flex-col gap-2">
                    <div class="transaction-card-detail">
                        <i class="fas fa-envelope text-gray-500"></i>
                        <span>Pengaju: ${data.userEmail || '-'}</span>
                    </div>
                    <div class="transaction-card-detail">
                        <i class="fas fa-info-circle text-gray-500"></i>
                        <span>Keterangan: ${data.keterangan || '-'}</span>
                    </div>
                    <div class="transaction-card-detail">
                        <i class="fas fa-tasks text-gray-500"></i>
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
        simpananCardsContainer.innerHTML = '<p class="text-center text-red-500">Gagal memuat data simpanan.</p>';
      }
    }

    /**
     * Memuat dan menampilkan data transaksi pinjaman dari Firestore dalam bentuk kartu.
     */
    async function loadPinjaman() {
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
          html = '<p class="text-center text-gray-500">Tidak ada data pinjaman.</p>';
        } else {
          dataArray.forEach(data => {
            // Use getDateFromDoc for consistent date display
            const displayDate = getDateFromDoc(data);
            const formattedDate = displayDate.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
            // Get the date for the top-right corner, formatted as "DD Mon YYYY"
            const formattedHeaderDate = displayDate.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

            html += `
              <div class="transaction-card">
                <div class="transaction-card-header">
                  <div class="flex items-center gap-3">
                    <i class="fas fa-user-circle text-emerald-700 text-3xl"></i> <!-- Icon dan warna hijau -->
                    <span class="text-xl font-bold text-emerald-700">${formatRupiah(data.jumlah)}</span> <!-- Warna hijau -->
                  </div>
                  <span class="text-gray-600 text-sm font-medium">${formattedHeaderDate}</span> <!-- Tanggal di kanan atas, warna abu-abu -->
                </div>
                <div class="flex flex-col gap-2">
                    <div class="transaction-card-detail">
                        <i class="fas fa-envelope text-gray-500"></i>
                        <span>Pengaju: ${data.userEmail || '-'}</span>
                    </div>
                    <div class="transaction-card-detail">
                        <i class="fas fa-bullseye text-gray-500"></i>
                        <span>Tujuan: ${data.tujuan || '-'}</span>
                    </div>
                    <div class="transaction-card-detail">
                        <i class="fas fa-tasks text-gray-500"></i>
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
        pinjamanCardsContainer.innerHTML = '<p class="text-center text-red-500">Gagal memuat data pinjaman.</p>';
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
     * @param {string} statusBaru Status baru (e.g., 'Disetujui', 'Ditolak').
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

    /**
     * Fungsi dummy untuk edit pinjaman. Anda bisa menambahkan modal edit di sini.
     * Ini tidak akan dipanggil lagi setelah tombol dihapus dari UI.
     * @param {string} id ID dokumen pinjaman yang akan diedit.
     */
    window.editPinjaman = async function(id) {
        // alert("Fungsi edit pinjaman untuk ID: " + id + " akan datang segera!");
        // Anda bisa menambahkan modal atau form untuk mengedit data pinjaman di sini.
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


    // Event listener untuk navigasi "Kelola Transaksi"
    transaksiNavLink.addEventListener('click', (e) => {
      e.preventDefault(); // Mencegah navigasi default
      // Di sini, Anda bisa mengarahkan ke halaman ini sendiri atau cukup memastikan tab pertama aktif
      switchTab('simpanan'); // Secara default, tampilkan tab simpanan
    });

    // Muat data awal (tampilkan tab simpanan secara default)
    switchTab('simpanan');
  </script>
</body>
</html>
