<!DOCTYPE html>
<nav style="background:#1b5e20; padding:10px 20px; display:flex; justify-content:space-between; align-items:center; color:#fff;">
  <div style="font-size:1.2rem;font-weight:bold;">Koperasi Mahasiswa</div>
  <div style="display:flex; gap:16px;">
    <a href="/admin" style="color:#fff; text-decoration:none;">Dashboard</a>
    <a href="/transaksi" style="color:#fff; text-decoration:none;">Kelola Transaksi</a>
    <a href="/daftar" style="color:#fff; text-decoration:none;">Daftar Feedback</a>
  </div>
</nav>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Feedback Pengguna – Koperasi Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Menggunakan Tailwind CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif; /* Font Inter untuk tampilan profesional */
            margin: 0;
            background: #f5f5f5; /* Background abu-abu muda yang bersih */
        }
        header {
            background-color: #2e7d32; /* Warna hijau gelap untuk header */
            color: white;
            padding: 16px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Sedikit bayangan di header */
        }
        .container {
            padding: 20px;
            max-width: 1200px; /* Lebar container lebih luas untuk kartu */
            margin: 20px auto; /* Pusatkan container */
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); /* Bayangan yang lebih menonjol */
        }
        h2 {
            color: #2e7d32; /* Warna hijau gelap untuk judul bagian */
            margin-bottom: 24px; /* Tambah jarak bawah judul */
            text-align: center;
            font-size: 2em;
            font-weight: 600;
        }

        /* Styling untuk setiap item feedback individual (kartu) */
        .feedback-item-card {
            background-color: #f8fcf8; /* Latar belakang hijau sangat muda */
            border-radius: 8px; /* Lebih bulat dari sebelumnya */
            padding: 20px; /* Tambah padding */
            border: 1px solid #d4edda; /* Border hijau lebih gelap */
            box-shadow: 0 2px 6px rgba(0,0,0,0.05); /* Bayangan lebih jelas */
            display: flex;
            flex-direction: column;
            gap: 10px; /* Jarak antar elemen di dalam kartu */
            position: relative; /* Diperlukan untuk penempatan waktu absolut */
            padding-top: 40px; /* Memberi ruang untuk waktu di pojok kanan atas */
        }
        .feedback-item-card p {
            margin: 0; /* Hapus margin default pada paragraf */
            line-height: 1.5;
            color: #4a4a4a;
        }
        .feedback-item-card .label {
            font-weight: 600;
            color:rgb(28, 33, 28); /* Warna hijau untuk label */
            display: inline-block; /* Memastikan label tetap di baris yang sama dengan nilai */
            width: 80px; /* Lebar tetap untuk label */
            flex-shrink: 0; /* Cegah label menyusut */
        }
        .feedback-item-card .value-wrapper {
            display: flex;
            align-items: flex-start;
        }
        .feedback-item-card .value {
            font-weight: 400;
            color: #666;
            flex-grow: 1; /* Biarkan nilai mengambil sisa ruang */
        }
        .feedback-item-card .feedback-text {
            color: #333;
            font-style: italic;
            word-break: break-word; /* Memastikan teks panjang tidak meluber */
        }
        /* Kelas .sentiment-text akan diatur warnanya secara dinamis melalui JavaScript */
        .sentiment-text {
            font-weight: 700;
        }

        /* Styling untuk waktu di pojok kanan atas kartu */
        .card-time {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 0.85em;
            color: #777; /* Warna abu-abu yang lebih lembut untuk waktu */
            font-weight: 500;
        }


        /* Styling untuk dropdown sorting */
        .sort-dropdown-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }
        .sort-dropdown {
            padding: 10px 24px;
            border: 1px solid #d4edda; /* Border hijau lebih gelap */
            border-radius: 6px;
            background-color: #f8fcf8; /* Latar belakang hijau sangat muda */
            color: #2e7d32; /* Teks hijau gelap */
            font-size: 1em;
            font-weight: 500;
            cursor: pointer;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .sort-dropdown:hover {
            border-color: #388E3C; /* Hijau gelap saat hover */
        }
        .sort-dropdown:focus {
            border-color: #2E7D32;
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.2); /* Ring fokus hijau */
        }
    </style>
</head>
<body>
    <header>
        <h1>Feedback Pengguna</h1>
    </header>

    <div class="container">
        <h2>Daftar Masukan dan Sentimen</h2>

        <!-- Sorting Dropdown -->
        <div class="sort-dropdown-container">
            <label for="sortOrder" class="text-gray-700 font-medium">Urutkan berdasarkan:</label>
            <select id="sortOrder" class="sort-dropdown">
                <option value="newest">Terbaru</option>
                <option value="oldest">Terlama</option>
            </select>
        </div>

        <!-- Container for feedback cards, using CSS Grid from Tailwind -->
        <div id="feedbackCards" class="grid grid-cols-1 gap-6">
            <!-- Data will be loaded here by JavaScript -->
            <p class="col-span-full text-center text-gray-500">Memuat data...</p>
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
        const sortOrderDropdown = document.getElementById('sortOrder'); // Reference to the new dropdown

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
                    const sentiment = data.sentiment ? String(data.sentiment).toLowerCase() : 'netral'; // Pastikan string lowercase
                    let sentimentColorClass = 'text-gray-700'; // Default color

                    // Tentukan kelas warna berdasarkan sentimen
                    if (sentiment.includes('positif') || sentiment.includes('positive')) {
                        sentimentColorClass = 'text-green-600'; // Hijau untuk positif
                    } else if (sentiment.includes('negatif') || sentiment.includes('negative')) {
                        sentimentColorClass = 'text-red-600'; // Merah untuk negatif
                    } else { // Jika netral atau tidak terdefinisi
                        sentimentColorClass = 'text-orange-500'; // Oranye untuk netral
                    }

                    html += `
                        <div class="feedback-item-card">
                            <span class="card-time">${formatTanggal(data.createdAt)}</span> <!-- Waktu dipindahkan ke sini -->
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
            // Create a copy to avoid modifying the original array directly if needed elsewhere
            let sortedData = [...allFeedbackData];

            sortedData.sort((a, b) => {
                // Safely get date objects; use a very old date for invalid timestamps
                const dateA = a.createdAt?.toDate ? a.createdAt.toDate() : new Date(0);
                const dateB = b.createdAt?.toDate ? b.createdAt.toDate() : new Date(0);

                if (order === 'oldest') {
                    return dateA.getTime() - dateB.getTime(); // Ascending order
                } else { // 'newest'
                    return dateB.getTime() - dateA.getTime(); // Descending order
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
                allFeedbackData = []; // Clear previous data

                snapshot.forEach(doc => {
                    allFeedbackData.push(doc.data());
                });

                // Initially sort and display by the currently selected dropdown value (default: 'newest')
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
