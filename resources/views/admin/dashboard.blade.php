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
  <meta charset="UTF-8">
  <title>Dashboard Admin – Koperasi Mahasiswa</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body{margin:0;font-family:sans-serif;background:#f5f5f5}
    header{padding:16px;background:#2e7d32;color:#fff;text-align:center}
    .stats{display:flex;gap:16px;padding:16px;flex-wrap:wrap}
    .card{background:#fff;padding:16px;border-radius:8px;flex:1 1 200px;box-shadow:0 2px 6px rgba(0,0,0,.1)}
    .card h4{margin:0 0 8px;color:#555}
    .card h2{margin:0;color:#2e7d32}
    #chartWrapper, #transWrapper{padding:0 16px 16px}
    table{width:100%;border-collapse:collapse}
    th,td{padding:8px;border-bottom:1px solid #ddd;text-align:left}
    /* Tambahan styling agar mirip gambar */
    #chartWrapper {
      background: #fdf6fb;
      border-radius: 18px;
      box-shadow: 0 2px 12px 0 rgba(0,0,0,0.04);
      margin-bottom: 24px;
      position: relative;
    }
    #chartHeader {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 0;
      padding-bottom: 0;
    }
    #chartHeader h4 {
      font-size: 1.15rem;
      font-weight: 600;
      color: #222;
      margin: 0;
      padding: 0;
    }
    #bulanSelect {
      border: none;
      background: transparent;
      font-size: 1rem;
      font-weight: 500;
      color: #444;
      outline: none;
      cursor: pointer;
      margin-right: 4px;
    }
    #legendCustom {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 24px;
      margin-top: 12px;
      margin-bottom: 4px;
    }
    .legend-item {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 1rem;
      font-weight: 500;
      color: #222;
    }
    .legend-color {
      width: 16px;
      height: 16px;
      border-radius: 4px;
      display: inline-block;
    }
    @media (max-width: 600px) {
      .stats{flex-direction:column}
      #chartHeader{flex-direction:column;align-items:flex-start}
    }
  </style>
</head>
<body>

<header><h1>Dashboard Admin</h1></header>
<div class="stats">
  <div class="card"><h4>Total Pengguna</h4><h2 id="totalUsers">...</h2></div>
  <div class="card"><h4>Total Simpanan</h4><h2 id="totalSavings">...</h2></div>
  <div class="card"><h4>Pinjaman Aktif</h4><h2 id="activeLoans">...</h2></div>
  <div class="card"><h4>Menunggu Verifikasi</h4><h2 id="pendingLoans">...</h2></div>
</div>

<div id="chartWrapper" class="card">
  <div id="chartHeader">
    <h4>Statistik Koperasi</h4>
    <select id="bulanSelect">
      <option value="1">1 Bulan</option>
      <option value="2">2 Bulan</option>
      <option value="3">3 Bulan</option>
      <option value="4">4 Bulan</option>
      <option value="5">5 Bulan</option>
      <option value="6">6 Bulan</option>
    </select>
  </div>
  <canvas id="myChart" height="100"></canvas>
  <div id="legendCustom">
    <span class="legend-item"><span class="legend-color" style="background:#FFA726"></span>Pinjaman</span>
    <span class="legend-item"><span class="legend-color" style="background:#42A5F5"></span>Simpanan</span>
  </div>
</div>

<div id="transWrapper" class="card">
  <h4>Transaksi Terakhir</h4>
  <table>
    <thead><tr><th>Tanggal</th><th>Jumlah</th><th>Status</th></tr></thead>
    <tbody id="transTable"><tr><td colspan="4">Memuat...</td></tr></tbody>
  </table>
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
const elTrans = document.getElementById('transTable');
const ctx = document.getElementById('myChart').getContext('2d');
const select = document.getElementById('bulanSelect');
const chartWrapper = document.getElementById('chartWrapper');

function formatRupiah(num) {
  return 'Rp ' + num.toLocaleString('id-ID');
}

let chartInstance = null;

onAuthStateChanged(auth, user => {
  if (!user) window.location.href = '/login';
  else initDashboard();
});

async function initDashboard() {
  const usersSnap = await getDocs(collection(db, 'users'));
  elUsers.textContent = usersSnap.size;
  await updateChart(parseInt(select.value));
  select.onchange = () => updateChart(parseInt(select.value));

  // Tabel transaksi tetap
  const trSnap = await getDocs(query(collection(db, 'pinjaman'), orderBy('createdAt','desc'), limit(5)));
  let html = '';
  trSnap.forEach(d => {
    const dta = d.data();
    const dt = dta.createdAt?.seconds ? new Date(dta.createdAt.seconds*1000) : new Date();
    html += `<tr>
      <td>${dt.toLocaleDateString('id-ID')}</td>
      <td>${formatRupiah(dta.jumlah)}</td>
      <td>${dta.status}</td>
    </tr>`;
  });
  elTrans.innerHTML = html || '<tr><td colspan="4">Tidak ada transaksi</td></tr>';
}

// Ganti fungsi updateChart agar grafik menampilkan JUMLAH TRANSAKSI (bukan nominal) per bulan

async function updateChart(jumlahBulan) {
  const now = new Date();
  const months = [];
  for(let i=jumlahBulan-1; i>=0; i--) {
    const d = new Date(now.getFullYear(), now.getMonth()-i, 1);
    months.push({
      key: `${d.getFullYear()}-${d.getMonth()+1}`,
      label: d.toLocaleString('id-ID', { month: 'short' })
    });
  }

  let savingsSum = 0, activeLn = 0, pendingLn = 0;
  // Ganti: simpanan & pinjaman = jumlah transaksi per bulan
  const sumPerMonth = { simpanan: months.map(_=>0), pinjaman: months.map(_=>0) };

  const simSnap = await getDocs(collection(db, 'simpanan'));
  simSnap.forEach(d => {
    const data = d.data();
    savingsSum += data.jumlah || 0;
    const rawTanggal = data.tanggal;
    let tgl = null;
    if (rawTanggal?.toDate) tgl = rawTanggal.toDate();
    else if (rawTanggal instanceof Date) tgl = rawTanggal;
    else if (typeof rawTanggal === 'string') tgl = new Date(rawTanggal);

    if (tgl) {
      const key = `${tgl.getFullYear()}-${tgl.getMonth()+1}`;
      const idx = months.findIndex(m => m.key === key);
      if (idx >= 0) sumPerMonth.simpanan[idx] += 1; // Hitung transaksi, bukan nominal
    }
  });
  elSavings.textContent = formatRupiah(savingsSum);

  const pinSnap = await getDocs(collection(db, 'pinjaman'));
  pinSnap.forEach(d => {
    const data = d.data();
    if (data.status === 'aktif' || data.status === 'Disetujui') activeLn++;
    if (data.status === 'Menunggu') pendingLn++;
    const rawTanggal = data.tanggal;
    let tgl = null;
    if (rawTanggal?.toDate) tgl = rawTanggal.toDate();
    else if (rawTanggal instanceof Date) tgl = rawTanggal;
    else if (typeof rawTanggal === 'string') tgl = new Date(rawTanggal);

    if (tgl) {
      const key = `${tgl.getFullYear()}-${tgl.getMonth()+1}`;
      const idx = months.findIndex(m => m.key === key);
      if (idx >= 0) sumPerMonth.pinjaman[idx] += 1; // Hitung transaksi, bukan nominal
    }
  });
  elActive.textContent = activeLn;
  elPending.textContent = pendingLn;

  // Sumbu X label bulan singkat
  const xLabels = months.map(m=>m.label);

  // Hapus chart lama jika ada
  if(chartInstance) chartInstance.destroy();

  chartInstance = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: xLabels,
      datasets: [
        { label: 'Pinjaman', data: sumPerMonth.pinjaman, backgroundColor: '#FFA726', borderRadius: 6, barPercentage: 0.5, categoryPercentage: 0.5 },
        { label: 'Simpanan', data: sumPerMonth.simpanan, backgroundColor: '#42A5F5', borderRadius: 6, barPercentage: 0.5, categoryPercentage: 0.5 }
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
          suggestedMax: 5
        }
      }
    }
  });
}

</script>

</body>
</html>