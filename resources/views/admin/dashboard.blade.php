<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Admin – Koperasi Mahasiswa</title>
  <!-- Tailwind CSS CDN untuk styling modern dan responsif -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Chart.js untuk grafik -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Font Awesome untuk ikon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"></link>
  <style>
    body { font-family: 'Inter', sans-serif; margin: 0; background: #f0f4f8; color: #333; }
    #root { min-height: 100vh; display: flex; flex-direction: column; }
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #555; }
    .bulan-select {
      padding: 8px 24px; border: 1px solid #a7d9b4; border-radius: 6px;
      background-color: #e6f7e8; color: #2e7d32; font-size: 1em; font-weight: 500;
      cursor: pointer; outline: none; transition: border-color 0.3s, box-shadow 0.3s;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05); -webkit-appearance: none; -moz-appearance: none; appearance: none;
      padding-right: 36px;
    }
    .bulan-select:hover { border-color: #388E3C; }
    .bulan-select:focus { border-color: #2E7D32; box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.2); }
    .custom-dropdown-arrow {
      position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
      pointer-events: none; color: #2e7d32; font-size: 0.8em;
    }
    .transaction-list-item {
      background: #fff; padding: 1rem; border-radius: 0.75rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04);
      display: flex; align-items: flex-start; gap: 1rem; border: 1px solid #e2e8f0; position: relative;
      transition: background 0.2s, border-color 0.2s;
    }
    .transaction-list-item:hover { background: #f0fdf4; border-color: #bbf7d0; }
    .transaction-icon {
      color: #059669; font-size: 2rem; flex-shrink: 0; width: 48px; height: 48px;
      display: flex; align-items: center; justify-content: center; background: #e0f2f7; border-radius: 8px;
    }
    .transaction-content { flex-grow: 1; }
    .transaction-amount-status { display: flex; justify-content: space-between; align-items: center; width: 100%; }
    .transaction-amount-label { font-size: 1rem; font-weight: 600; color: #374151; }
    .transaction-amount { font-size: 1.25rem; font-weight: bold; color: #047857; margin-left: 8px; }
    .transaction-date-top-right { position: absolute; top: 10px; right: 15px; font-size: 0.95rem; color: #6b7280; font-weight: 500; }
    .transaction-status { font-size: 0.95rem; color: #4b5563; margin-top: 4px; }
    .transaction-status-badge { padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 600; }
    .status-Disetujui, .status-Aktif { background: #bbf7d0; color: #166534; }
    .status-Menunggu { background: #fef9c3; color: #a16207; }
    .status-Ditolak { background: #fecaca; color: #991b1b; }
  </style>
</head>
<body>
  <div id="root">
    <nav class="bg-emerald-700 p-4 shadow-lg flex justify-between items-center text-white">
      <div class="text-2xl font-bold tracking-wide">Koperasi Mahasiswa</div>
      <div class="flex gap-6">
        <a href="/admin" class="text-white hover:text-emerald-200 font-medium">Dashboard</a>
        <a href="/transaksi" class="text-white hover:text-emerald-200 font-medium">Kelola Transaksi</a>
        <a href="/daftar" class="text-white hover:text-emerald-200 font-medium">Daftar Feedback</a>
      </div>
    </nav>
    <header class="bg-gradient-to-r from-emerald-600 to-emerald-800 text-white p-8 text-center shadow-md">
      <h1 class="text-4xl font-extrabold mb-2">Dashboard Admin</h1>
      <p class="text-lg opacity-90">Ringkasan Operasional Koperasi Mahasiswa</p>
    </header>
    <main class="container mx-auto p-6 flex-grow">
      <div class="flex flex-wrap gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-lg flex-1 min-w-[200px]">
          <h4 class="text-lg font-semibold text-gray-600 mb-2">Total Pengguna</h4>
          <h2 id="totalUsers" class="text-4xl font-bold text-emerald-700">...</h2>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg flex-1 min-w-[200px]">
          <h4 class="text-lg font-semibold text-gray-600 mb-2">Total Simpanan</h4>
          <h2 id="totalSavings" class="text-4xl font-bold text-emerald-700">...</h2>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg flex-1 min-w-[200px]">
          <h4 class="text-lg font-semibold text-gray-600 mb-2">Pinjaman Aktif</h4>
          <h2 id="activeLoans" class="text-4xl font-bold text-emerald-700">...</h2>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg flex-1 min-w-[200px]">
          <h4 class="text-lg font-semibold text-gray-600 mb-2">Menunggu Verifikasi</h4>
          <h2 id="pendingLoans" class="text-4xl font-bold text-emerald-700">...</h2>
        </div>
      </div>
      <div id="chartWrapper" class="bg-white p-6 rounded-xl shadow-lg mb-8">
        <div class="flex justify-between items-center mb-4">
          <h4 class="text-xl font-bold text-gray-800">Statistik Koperasi</h4>
          <div class="relative flex items-center">
            <select id="bulanSelect" class="bulan-select">
              <option value="1">1 Bulan</option>
              <option value="2">2 Bulan</option>
              <option value="3">3 Bulan</option>
              <option value="4">4 Bulan</option>
              <option value="5">5 Bulan</option>
              <option value="6">6 Bulan</option>
            </select>
            <span class="custom-dropdown-arrow">&#9660;</span>
          </div>
        </div>
        <canvas id="myChart" height="100"></canvas>
        <div id="legendCustom" class="flex justify-center items-center gap-6 mt-4">
          <span class="flex items-center gap-2 text-base font-medium text-gray-700">
            <span class="w-4 h-4 rounded-md inline-block" style="background:#FFA726"></span>Pinjaman
          </span>
          <span class="flex items-center gap-2 text-base font-medium text-gray-700">
            <span class="w-4 h-4 rounded-md inline-block" style="background:#42A5F5"></span>Simpanan
          </span>
        </div>
      </div>
      <!-- Peringatan Anomali -->
      <div id="anomalyAlert" class="mb-6"></div>
      <div id="transWrapper" class="bg-white p-6 rounded-xl shadow-lg mb-8">
        <h4 class="text-xl font-bold text-gray-800 mb-4">Transaksi Terakhir</h4>
        <div id="latestTransactionsList" class="flex flex-col gap-3">
          <p class="text-center text-gray-500 py-4">Memuat...</p>
        </div>
      </div>
    </main>
  </div>
  <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
    import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";
    import { getFirestore, collection, query, getDocs, orderBy, limit } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

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

    const elUsers = document.getElementById('totalUsers');
    const elSavings = document.getElementById('totalSavings');
    const elActive = document.getElementById('activeLoans');
    const elPending = document.getElementById('pendingLoans');
    const latestTransactionsList = document.getElementById('latestTransactionsList');
    const ctx = document.getElementById('myChart').getContext('2d');
    const select = document.getElementById('bulanSelect');

    function formatRupiah(num) {
      return 'Rp ' + num.toLocaleString('id-ID');
    }

    let chartInstance = null;

    onAuthStateChanged(auth, user => {
      if (!user) window.location.href = '/login';
      else {
        initDashboard().then(() => {
          tampilkanTransaksiTerakhir();
          tampilkanPeringatanAnomali();
        });
      }
    });

    async function initDashboard() {
      const usersSnap = await getDocs(collection(db, 'users'));
      elUsers.textContent = usersSnap.size;

      await updateChart(parseInt(select.value));
      select.onchange = () => updateChart(parseInt(select.value));
    }

    function getDateFromDoc(data) {
      if (data.createdAt && typeof data.createdAt.toDate === 'function') {
        return data.createdAt.toDate();
      }
      if (typeof data.tanggal === 'string') {
        const date = new Date(data.tanggal);
        if (!isNaN(date.getTime())) return date;
      }
      return new Date();
    }

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
                <div class="text-gray-500 text-sm mt-1">${data.tujuan || ''}</div>
                <div class="transaction-amount mt-2">${formatRupiah(data.jumlah)}</div>
              </div>
              <div class="transaction-date-top-right">${formattedDate}</div>
            </div>
          `;
        });
      }
      latestTransactionsList.innerHTML = html;
    }

    async function tampilkanPeringatanAnomali() {
      const anomalyAlert = document.getElementById('anomalyAlert');
      // Ambil semua transaksi pinjaman dengan isAnomaly == true, urut terbaru
      const q = query(collection(db, 'pinjaman'), orderBy('createdAt', 'desc'));
      const snap = await getDocs(q);
      const anomalies = snap.docs.filter(doc => doc.data().isAnomaly === true);

      if (anomalies.length === 0) {
        anomalyAlert.innerHTML = `
          <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">
            <div class="font-bold mb-1 text-red-600 text-lg">Peringatan Anomali</div>
            <div class="bg-white bg-opacity-60 rounded-lg p-4 text-center text-gray-600 font-semibold">
              Tidak ada anomali terdeteksi
            </div>
          </div>
        `;
        return;
      }

      anomalyAlert.innerHTML = `
        <div class="font-bold mb-2 text-red-600 text-lg">Peringatan Anomali</div>
        <div class="flex flex-col gap-3">
          ${anomalies.map(doc => {
            const data = doc.data();
            const tanggal = (data.createdAt && typeof data.createdAt.toDate === 'function')
              ? data.createdAt.toDate().toISOString().slice(0,10)
              : (typeof data.tanggal === 'string' ? data.tanggal : '-');
            return `
              <div class="flex items-start bg-red-100 rounded-xl p-4 gap-4">
                <div class="flex-shrink-0">
                  <div class="bg-red-200 rounded-lg w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
                  </div>
                </div>
                <div class="flex-grow">
                  <div class="font-semibold text-gray-800 mb-1">Anomali pengajuan dari</div>
                  <div class="font-bold text-gray-800 mb-1">${data.userEmail}</div>
                  <div class="mb-1">Jumlah: <span class="font-semibold text-gray-700">${formatRupiah(data.jumlah)}</span></div>
                  ${(Array.isArray(data.anomalyReasons) && data.anomalyReasons.length > 0)
                    ? data.anomalyReasons.map(r => `<div class="text-sm text-gray-700">• ${r}</div>`).join('')
                    : ''}
                </div>
                <div class="text-gray-500 font-medium text-sm mt-1">${tanggal}</div>
              </div>
            `;
          }).join('')}
        </div>
      `;
    }

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

      if(chartInstance) chartInstance.destroy();

      chartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: xLabels,
          datasets: [
            { label: 'Pinjaman', data: transactionsPerMonth.pinjaman, backgroundColor: '#FFA726', borderRadius: 6, barPercentage: 0.5, categoryPercentage: 0.5 },
            { label: 'Simpanan', data: transactionsPerMonth.simpanan, backgroundColor: '#42A5F5', borderRadius: 6, barPercentage: 0.5, categoryPercentage: 0.5 }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false }
          },
          scales: {
            x: {
              grid: { display: false },
              title: { display: false }
            },
            y: {
              beginAtZero: true,
              ticks: { stepSize: 1, precision: 0 },
              suggestedMax: Math.max(...transactionsPerMonth.simpanan, ...transactionsPerMonth.pinjaman, 1) + 1
            }
          },
          animation: {
            duration: 1000,
            easing: 'easeOutQuart'
          }
        }
      });
    }
  </script>
</body>
</html>