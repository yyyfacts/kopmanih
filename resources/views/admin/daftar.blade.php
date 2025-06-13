<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Feedback Pengguna – Koperasi Mahasiswa</title>
  <!-- Tailwind CSS CDN -->
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

    /* Modal Styling (konsisten dengan halaman transaksi) */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
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
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
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
      margin-bottom: 25px;
      font-size: 1.1rem;
      color: #4a5568;
    }
    .modal-buttons {
      display: flex;
      justify-content: center;
      gap: 15px;
    }

    /* Styling untuk setiap item feedback individual (kartu) */
    /* Diadaptasi dari styling transaction-card untuk konsistensi */
    .feedback-item-card {
      background: white; /* Putih bersih */
      border-radius: 12px; /* Sudut membulat */
      box-shadow: 0 4px 15px rgba(0,0,0,0.1); /* Bayangan lembut */
      padding: 24px; /* Padding seragam */
      margin-bottom: 20px;
      display: flex;
      flex-direction: column;
      gap: 16px; /* Jarak antar elemen di dalam kartu */
      position: relative; /* Diperlukan untuk penempatan waktu absolut */
    }
    .feedback-item-card p {
      margin: 0;
      line-height: 1.5;
      color: #4a4a4a;
    }
    .feedback-item-card .label {
      font-weight: 600;
      color: #2e7d32; /* Warna hijau gelap untuk label */
      display: inline-block;
      width: 90px; /* Lebar tetap untuk label, sedikit lebih besar dari sebelumnya */
      flex-shrink: 0;
    }
    .feedback-item-card .value-wrapper {
      display: flex;
      align-items: flex-start;
    }
    .feedback-item-card .value {
      font-weight: 400;
      color: #666;
      flex-grow: 1;
      word-break: break-word; /* Memastikan teks panjang tidak meluber */
    }
    .feedback-item-card .feedback-text {
      color: #333;
      font-style: italic;
      word-break: break-word;
    }
    .sentiment-text {
      font-weight: 700;
    }

    /* Styling untuk waktu di pojok kanan atas kartu */
    .card-time {
      position: absolute;
      top: 15px; /* Sesuaikan posisi vertikal */
      right: 20px; /* Sesuaikan posisi horizontal */
      font-size: 0.9em; /* Sedikit lebih besar */
      color: #777;
      font-weight: 500;
    }

    /* Styling untuk dropdown sorting (konsisten dengan halaman transaksi) */
    .sort-dropdown-container {
      display: flex;
      justify-content: flex-end; /* Pindahkan ke kanan */
      align-items: center;
      gap: 10px;
      margin-bottom: 24px;
      padding: 0 10px; /* Sedikit padding horizontal agar tidak terlalu mepet */
    }
    .sort-dropdown-label {
      color: #4a5568; /* Warna teks label konsisten */
      font-weight: 500;
    }
    .sort-dropdown-wrapper {
      position: relative;
      display: inline-block;
    }
    .sort-dropdown {
      padding: 10px 24px;
      border: 1px solid #a7d9b4; /* Border hijau muda */
      border-radius: 6px;
      background-color: #e6f7e8; /* Latar belakang hijau sangat muda */
      color: #2e7d32; /* Teks hijau gelap */
      font-size: 1em;
      font-weight: 500;
      cursor: pointer;
      outline: none;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      -webkit-appearance: none; /* Hapus panah default di Webkit */
      -moz-appearance: none; /* Hapus panah default di Mozilla */
      appearance: none; /* Hapus panah default */
      padding-right: 36px; /* Ruang untuk panah kustom */
    }
    .sort-dropdown:hover {
      border-color: #388E3C;
    }
    .sort-dropdown:focus {
      border-color: #2E7D32;
      box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.2);
    }
    .custom-dropdown-arrow {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      pointer-events: none;
      color: #2e7d32; /* Warna panah */
      font-size: 0.8em;
    }
  </style>
</head>
<body>
  <div id="root">
    <!-- Navbar (konsisten dengan halaman transaksi) -->
    <nav class="bg-emerald-700 p-4 shadow-lg flex justify-between items-center text-white">
      <div class="text-2xl font-bold tracking-wide">Koperasi Mahasiswa</div>
      <div class="flex gap-6">
        <a href="/admin" class="text-white hover:text-emerald-200 transition duration-300 ease-in-out font-medium">Dashboard</a>
        <a href="/transaksi" class="text-white hover:text-emerald-200 transition duration-300 ease-in-out font-medium">Kelola Transaksi</a>
        <a href="#" class="text-white hover:text-emerald-200 transition duration-300 ease-in-out font-medium">Daftar Feedback</a>
      </div>
    </nav>

    <!-- Header (konsisten dengan halaman transaksi) -->
    <header class="bg-gradient-to-r from-emerald-600 to-emerald-800 text-white p-8 text-center shadow-md">
      <h1 class="text-4xl font-extrabold mb-2">Daftar Feedback Pengguna</h1>
      <p class="text-lg opacity-90">Masukan dan Sentimen dari Anggota Koperasi</p>
    </header>

    <main class="container mx-auto p-6 flex-grow bg-white rounded-xl shadow-lg mt-8 mb-8">
      <!-- Judul Bagian dan Dropdown Sorting -->
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-emerald-700">Daftar Masukan dan Sentimen</h2>
        <div class="flex items-center">
          <label for="sortOrder" class="mr-2 text-gray-700 font-medium">Urutkan berdasarkan :</label>
          <div class="relative">
            <select id="sortOrder" class="sort-dropdown">
              <option value="newest">Terbaru</option>
              <option value="oldest">Terlama</option>
            </select>
            <span class="custom-dropdown-arrow">&#9660;</span>
          </div>
        </div>
      </div>

      <!-- Container for feedback cards -->
      <div id="feedbackCards" class="grid grid-cols-1 gap-6">
        <p class="col-span-full text-center text-gray-500 py-8">Memuat data...</p>
      </div>
    </main>

    <!-- Custom Confirmation Modal (konsisten dengan halaman transaksi) -->
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
    import { getFirestore, collection, getDocs } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

    // Global variables for Firebase config and app ID provided by the Canvas environment.
    // Fallback to default values if not defined (e.g., when running locally).
    const appId = typeof __app_id !== 'undefined' ? __app_id : 'default-app-id';
    const firebaseConfig = typeof __firebase_config !== 'undefined' ? JSON.parse(__firebase_config) : {
        apiKey: "AIzaSyAuq0JEjnEOagJnONPemkMP0bbgqepiFp8",
        authDomain: "koperasimahasiswaapp.firebaseapp.com",
        projectId: "koperasimahasiswaapp",
        storageBucket: "koperasimahasiswaapp.appspot.com",
        messagingSenderId: "812843080953",
        appId: "1:812843080953:web:9a931f89186182660bd628",
        measurementId: "G-ES6G76W66D"
    };

    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);

    // Get references to HTML elements
    const feedbackCardsContainer = document.getElementById('feedbackCards');
    const sortOrderDropdown = document.getElementById('sortOrder');

    let allFeedbackData = []; // Array to store all fetched feedback data for sorting

    /**
     * Formats a Firebase Timestamp object into a localized date and time string.
     * @param {object} timestamp - The Firebase Timestamp object.
     * @returns {string} Formatted date and time string or '-' if invalid.
     */
    function formatTanggal(timestamp) {
        if (!timestamp?.toDate) return '-';
        const date = timestamp.toDate();
        return `${date.toLocaleDateString('id-ID')} ${date.toLocaleTimeString('id-ID')}`;
    }

    /**
     * Renders the feedback cards based on the provided array of feedback data.
     * @param {Array<Object>} feedbackArray - An array of feedback data objects to display.
     */
    function renderFeedbackCards(feedbackArray) {
        let html = '';
        if (feedbackArray.length === 0) {
            html = '<p class="col-span-full text-center text-gray-500 py-8">Belum ada data feedback.</p>';
        } else {
            feedbackArray.forEach(data => {
                const sentiment = data.sentiment ? String(data.sentiment).toLowerCase() : 'netral';
                let sentimentColorClass = 'text-gray-700';

                if (sentiment.includes('positif') || sentiment.includes('positive')) {
                    sentimentColorClass = 'text-green-600';
                } else if (sentiment.includes('negatif') || sentiment.includes('negative')) {
                    sentimentColorClass = 'text-red-600';
                } else {
                    sentimentColorClass = 'text-orange-500';
                }

                html += `
                    <div class="feedback-item-card">
                        <span class="card-time">${formatTanggal(data.createdAt)}</span>
                        <p class="value-wrapper"><span class="label">Email:</span> <span class="value">${data.userEmail || 'Anonim'}</span></p>
                        <p class="value-wrapper"><span class="label">Feedback:</span> <span class="feedback-text">${data.feedback || '-'}</span></p>
                        <p class="value-wrapper"><span class="label">Sentimen:</span> <span class="sentiment-text ${sentimentColorClass}">${data.sentiment || '-'}</span></p>
                    </div>
                `;
            });
        }
        feedbackCardsContainer.innerHTML = html;
    }

    /**
     * Sorts the global allFeedbackData array and re-renders the cards.
     * @param {string} order - 'oldest' for ascending order, 'newest' for descending order.
     */
    function sortFeedback(order) {
        let sortedData = [...allFeedbackData];

        sortedData.sort((a, b) => {
            const dateA = a.createdAt?.toDate ? a.createdAt.toDate() : new Date(0);
            const dateB = b.createdAt?.toDate ? b.createdAt.toDate() : new Date(0);

            if (order === 'oldest') {
                return dateA.getTime() - dateB.getTime();
            } else {
                return dateB.getTime() - dateA.getTime();
            }
        });
        renderFeedbackCards(sortedData);
    }

    /**
     * Loads feedback data from Firestore, stores it, and initially displays it.
     * Includes error handling for robustness.
     */
    async function loadFeedback() {
        try {
            const snapshot = await getDocs(collection(db, 'feedback'));
            allFeedbackData = [];

            snapshot.forEach(doc => {
                allFeedbackData.push(doc.data());
            });

            sortFeedback(sortOrderDropdown.value);

        } catch (error) {
            console.error("Error loading feedback:", error);
            feedbackCardsContainer.innerHTML = '<p class="col-span-full text-center text-red-500 py-8">Gagal memuat data feedback. Periksa konsol untuk detail.</p>';
        }
    }

    // Add event listener to the dropdown for sorting
    sortOrderDropdown.addEventListener('change', (event) => {
        sortFeedback(event.target.value);
    });

    // Load feedback data when the script executes.
    loadFeedback();
  </script>
</body>
</html>
