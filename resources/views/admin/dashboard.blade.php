<!DOCTYPE html>
<nav style="background:#1b5e20; padding:10px 20px; display:flex; justify-content:space-between; align-items:center; color:#fff;">
  <div style="font-size:1.2rem;font-weight:bold;">Koperasi Mahasiswa</div>
  <div style="display:flex; gap:16px;">
    <a href="/admin" style="color:#fff; text-decoration:none;">Dashboard</a>
    <a href="/transaksi" style="color:#fff; text-decoration:none;">Kelola Transaksi</a>
    <a href="/daftar-feedback.html" style="color:#fff; text-decoration:none;">Daftar Feedback</a>
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
  <h4>Statistik: Simpanan vs Pinjaman (6 bulan)</h4>
  <canvas id="myChart"></canvas>
</div>

<div id="transWrapper" class="card">
  <h4>Transaksi Terakhir</h4>
  <table>
    <thead><tr><th>Tanggal</th><th>Jenis</th><th>Jumlah</th><th>Status</th></tr></thead>
    <tbody id="transTable"><tr><td colspan="4">Memuat...</td></tr></tbody>
  </table>
</div>

<script type="module">
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";
import { getFirestore, collection, query, where,
         getDocs, onSnapshot, orderBy, limit,
         doc, getDoc } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

// --- CONFIG
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

// --- DOM
const elUsers = document.getElementById('totalUsers');
const elSavings = document.getElementById('totalSavings');
const elActive = document.getElementById('activeLoans');
const elPending = document.getElementById('pendingLoans');
const elTrans = document.getElementById('transTable');
const ctx = document.getElementById('myChart').getContext('2d');

// --- UTILS
function formatRupiah(num) {
  return 'Rp ' + num.toLocaleString('id-ID');
}

// --- AUTH
onAuthStateChanged(auth, user => {
  if (!user) window.location.href = '/login';
  else initDashboard();
});

async function initDashboard() {
  // total users
  const usersSnap = await getDocs(collection(db, 'users'));
  elUsers.textContent = usersSnap.size;

  // total simpanan & pinjaman stats
  const months = [...Array(6).keys()].map(i => {
    const d = new Date(); d.setMonth(d.getMonth() - (5 - i));
    return { key: `${d.getFullYear()}-${d.getMonth()+1}`, label: d.toLocaleString('id-ID',{month:'short', year:'2-digit'}) };
  });
  let savingsSum = 0, activeLn = 0, pendingLn = 0;
  const sumPerMonth = { simpanan: months.map(_=>0), pinjaman: months.map(_=>0) };

  // collect simpanan
  const simSnap = await getDocs(collection(db, 'simpanan'));
  simSnap.forEach(d => {
    const data = d.data();
    savingsSum += data.jumlah || 0;
    // bucket month
    const idx = months.findIndex(m => data.tanggal.startsWith(m.key));
    if (idx >= 0) sumPerMonth.simpanan[idx] += data.jumlah;
  });
  elSavings.textContent = formatRupiah(savingsSum);

  // collect pinjaman
  const pinSnap = await getDocs(collection(db, 'pinjaman'));
  pinSnap.forEach(d => {
    const data = d.data();
    if (data.status === 'aktif' || data.status==='Diterima') activeLn++;
    if (data.status === 'Menunggu') pendingLn++;
    const idx = months.findIndex(m => data.tanggal.startsWith(m.key));
    if (idx >= 0) sumPerMonth.pinjaman[idx] += data.jumlah;
  });
  elActive.textContent = activeLn;
  elPending.textContent = pendingLn;

  // Chart
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: months.map(m => m.label),
      datasets: [
        { label: 'Simpanan', data: sumPerMonth.simpanan, backgroundColor: 'rgba(76,175,80,0.6)' },
        { label: 'Pinjaman', data: sumPerMonth.pinjaman, backgroundColor: 'rgba(255,152,0,0.6)' }
      ]
    },
    options:{
      scales: { y: { beginAtZero:true } }
    }
  });

  // transaksi terakhir
  const trSnap = await getDocs(query(collection(db, 'transaksi'),
    orderBy('createdAt','desc'), limit(5)
  ));
  let html = '';
  trSnap.forEach(d => {
    const dta = d.data();
    const dt = dta.createdAt?.seconds ? new Date(dta.createdAt.seconds*1000) : new Date();
    html += `<tr>
      <td>${dt.toLocaleDateString('id-ID')}</td>
      <td>${dta.jenis}</td>
      <td>${formatRupiah(dta.jumlah)}</td>
      <td>${dta.status}</td>
    </tr>`;
  });
  elTrans.innerHTML = html || '<tr><td colspan="4">Tidak ada transaksi</td></tr>';
}
</script>

</body>
</html>
