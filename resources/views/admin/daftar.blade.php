<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Feedback Pengguna – Koperasi Mahasiswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"></link>
  <style>
    /* Styling dasar */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    body {
      font-family: 'Inter', sans-serif; /* Menggunakan font Inter */
      margin: 0;
      background: #f8fafc; /* Latar belakang yang lebih terang dan modern, konsisten dashboard */
      color: #333;
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

    /* Modal Styling (konsisten dengan halaman transaksi & dashboard logout) */
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

    /* Styling untuk setiap item feedback individual (kartu) */
    .feedback-item-card {
      background: #ffffff; /* Putih bersih */
      border-radius: 0.75rem; /* Sudut membulat, konsisten dashboard */
      box-shadow: 0 4px 12px rgba(0,0,0,0.06); /* Bayangan lembut, konsisten dashboard */
      border: 1px solid #e2e8f0; /* Border lembut */
      padding: 1.25rem; /* Padding seragam, konsisten dashboard */
      display: flex;
      flex-direction: column;
      gap: 1rem; /* Jarak antar elemen di dalam kartu */
      position: relative; /* Diperlukan untuk penempatan waktu absolut */
      transition: all 0.2s ease-in-out; /* Smooth transition for hover effects */
    }
    .feedback-item-card:hover {
      background: #f0fdf4; /* Light emerald hover background */
      border-color: #a7f3d0; /* Subtle green hover border */
      transform: translateY(-2px); /* Slight lift effect */
      box-shadow: 0 6px 16px rgba(0,0,0,0.08);
    }
    .feedback-item-card p {
      margin: 0;
      line-height: 1.5;
      color: #4a4a4a;
      font-size: 0.95rem; /* Slight adjustment */
    }
    .feedback-item-card .label {
      font-weight: 600;
      color: #475569; /* Neutral label color, consistent with dashboard */
      display: inline-block;
      width: 100px; /* Lebar tetap untuk label, sedikit lebih besar */
      flex-shrink: 0;
    }
    .feedback-item-card .value-wrapper {
      display: flex;
      align-items: flex-start;
      gap: 0.5rem; /* Small gap between label and value */
    }
    .feedback-item-card .value {
      font-weight: 500; /* Slightly bolder for value */
      color: #334155; /* Darker text for value */
      flex-grow: 1;
      word-break: break-word; /* Memastikan teks panjang tidak meluber */
    }
    .feedback-item-card .feedback-text {
      color: #1a202c; /* Darker text for feedback content */
      font-style: italic;
      word-break: break-word;
      line-height: 1.6;
    }
    .sentiment-text {
      font-weight: 700;
      text-transform: capitalize; /* Capitalize sentiment text */
    }

    /* Styling untuk waktu di pojok kanan atas kartu */
    .card-time {
      position: absolute;
      top: 1rem; /* Sesuaikan posisi vertikal */
      right: 1.25rem; /* Sesuaikan posisi horizontal */
      font-size: 0.8rem; /* Lebih kecil, subtle */
      color: #64748b; /* Muted color */
      font-weight: 500;
    }

    /* Styling untuk dropdown sorting (konsisten dengan halaman dashboard) */
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
  <div id="root">
    <nav class="bg-emerald-800 p-4 shadow-lg flex justify-between items-center text-white z-50 relative">
      <div class="text-2xl font-bold tracking-wide flex items-center gap-3">
        <i class="fas fa-university text-emerald-300"></i>
        Koperasi Mahasiswa
      </div>
      <div class="flex items-center gap-6">
        <a href="/admin" class="text-emerald-200 hover:text-white font-medium transition duration-300 ease-in-out">Dashboard</a>
        <a href="/transaksi" class="text-emerald-200 hover:text-white font-medium transition duration-300 ease-in-out">Kelola Transaksi</a>
        <a href="#" class="text-white font-medium transition duration-300 ease-in-out">Daftar Feedback</a>
        <div class="relative group">
          <button id="userMenuButton" class="flex items-center gap-2 text-emerald-200 hover:text-white font-medium transition duration-200 focus:outline-none">
            <i class="fas fa-user-circle text-2xl"></i>
            Admin
            <i class="fas fa-chevron-down text-xs ml-1"></i>
          </button>
          <div id="userMenuDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block transition duration-200 ease-out transform scale-95 group-hover:scale-100 opacity-0 group-hover:opacity-100 origin-top-right">
            <a href="#" id="logoutButton" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
          </div>
        </div>
      </div>
    </nav>

    <header class="bg-gradient-to-r from-emerald-600 to-emerald-800 text-white p-8 text-center shadow-md">
      <h1 class="text-4xl font-extrabold mb-2">Daftar Feedback Pengguna</h1>
      <p class="text-lg opacity-90">Masukan dan Sentimen dari Anggota Koperasi</p>
    </header>

    <main class="container mx-auto p-6 flex-grow bg-white rounded-xl shadow-lg mt-8 mb-8 border border-gray-100">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-0">Daftar Masukan dan Sentimen</h2>
        <div class="flex items-center">
          <label for="sortOrder" class="mr-2 text-gray-700 font-medium whitespace-nowrap">Urutkan berdasarkan :</label>
          <div class="relative">
            <select id="sortOrder" class="bulan-select"> <option value="newest">Terbaru</option>
              <option value="oldest">Terlama</option>
            </select>
            <span class="custom-dropdown-arrow">&#9660;</span>
          </div>
        </div>
      </div>

      <div id="feedbackCards" class="grid grid-cols-1 gap-6">
        <p class="col-span-full text-center text-gray-500 py-8">Memuat data...</p>
      </div>
    </main>

    <div id="confirmationModal" class="modal-overlay">
      <div class="modal-content">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Konfirmasi</h3> <p id="modalMessage">Apakah Anda yakin?</p> <div class="modal-buttons">
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
    import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js"; // Import getAuth and onAuthStateChanged
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
    const auth = getAuth(app); // Initialize auth
    const db = getFirestore(app);

    // Get references to HTML elements
    const feedbackCardsContainer = document.getElementById('feedbackCards');
    const sortOrderDropdown = document.getElementById('sortOrder');
    // Elements for Logout Modal (copied from dashboard)
    const logoutButton = document.getElementById('logoutButton');
    const logoutModal = document.getElementById('logoutModal');
    const cancelLogout = document.getElementById('cancelLogout');
    const confirmLogout = document.getElementById('confirmLogout');
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenuDropdown = document.getElementById('userMenuDropdown');


    let allFeedbackData = []; // Array to store all fetched feedback data for sorting

    // Authentication check on page load
    onAuthStateChanged(auth, user => {
      if (!user) {
        window.location.href = '/login'; // Redirect to login if not authenticated
      } else {
        loadFeedback(); // Load data only if authenticated
      }
    });

    /**
     * Formats a Firebase Timestamp object into a localized date and time string.
     * @param {object} timestamp - The Firebase Timestamp object.
     * @returns {string} Formatted date and time string or '-' if invalid.
     */
    function formatTanggal(timestamp) {
        if (!timestamp?.toDate) return '-';
        const date = timestamp.toDate();
        return `${date.toLocaleDateString('id-ID', {day: '2-digit', month: 'long', year: 'numeric'})} ${date.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}`;
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
                let sentimentIcon = '<i class="fas fa-question-circle text-gray-500 mr-1"></i>'; // Default neutral icon

                if (sentiment.includes('positif') || sentiment.includes('positive')) {
                    sentimentColorClass = 'text-emerald-600'; // Consistent with emerald theme
                    sentimentIcon = '<i class="fas fa-smile text-emerald-600 mr-1"></i>';
                } else if (sentiment.includes('negatif') || sentiment.includes('negative')) {
                    sentimentColorClass = 'text-red-600';
                    sentimentIcon = '<i class="fas fa-frown text-red-600 mr-1"></i>';
                } else {
                    sentimentColorClass = 'text-amber-500'; // Amber for neutral/unsure
                    sentimentIcon = '<i class="fas fa-meh text-amber-500 mr-1"></i>';
                }

                html += `
                    <div class="feedback-item-card">
                        <span class="card-time">${formatTanggal(data.createdAt)}</span>
                        <p class="value-wrapper"><span class="label">Email:</span> <span class="value">${data.userEmail || 'Anonim'}</span></p>
                        <p class="value-wrapper"><span class="label">Feedback:</span> <span class="feedback-text">${data.feedback || '-'}</span></p>
                        <p class="value-wrapper"><span class="label">Sentimen:</span> <span class="sentiment-text ${sentimentColorClass}">${sentimentIcon}${data.sentiment || '-'}</span></p>
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
        feedbackCardsContainer.innerHTML = '<p class="col-span-full text-center text-gray-500 py-8">Memuat data...</p>'; // Show loading state
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

    // Toggle user menu dropdown on button click for better UX
    userMenuButton.addEventListener('click', (e) => {
        e.stopPropagation(); // Prevent click from bubbling to document and closing immediately
        userMenuDropdown.classList.toggle('hidden');
        if (userMenuDropdown.classList.contains('hidden')) {
            userMenuDropdown.classList.remove('opacity-100', 'scale-100');
            userMenuDropdown.classList.add('opacity-0', 'scale-95');
        } else {
            userMenuDropdown.classList.remove('opacity-0', 'scale-95');
            userMenuDropdown.classList.add('opacity-100', 'scale-100');
        }
    });

    // Close dropdown if clicked outside
    document.addEventListener('click', (e) => {
        if (!userMenuButton.contains(e.target) && !userMenuDropdown.contains(e.target)) {
            userMenuDropdown.classList.add('hidden');
            userMenuDropdown.classList.add('opacity-0');
            userMenuDropdown.classList.add('scale-95');
        }
    });
    // --- End Logout Modal Logic ---

  </script>
</body>
</html>