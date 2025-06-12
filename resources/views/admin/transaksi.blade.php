<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kelola Transaksi – Koperasi Mahasiswa</title>
  <style>
    body { font-family: sans-serif; margin: 0; background: #f9f9f9; }
    header { background-color: #2e7d32; color: white; padding: 16px; text-align: center; }
    .container { padding: 20px; }
    h2 { color: #2e7d32; margin-top: 32px; }
    table { width: 100%; border-collapse: collapse; background: white; margin-top: 10px; box-shadow: 0 1px 6px rgba(0,0,0,0.1); }
    th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
    th { background: #f0f0f0; color: #333; }
    tr:hover { background-color: #f5f5f5; }
    .btn-delete {
      color: red;
      cursor: pointer;
      border: none;
      background: transparent;
    }
  </style>
</head>
<body>
  <header>
    <h1>Kelola Transaksi</h1>
  </header>

  <div class="container">
    <h2>Daftar Transaksi Simpanan</h2>
    <table>
      <thead>
        <tr>
          <th>Email</th>
          <th>Tanggal</th>
          <th>Jumlah</th>
          <th>Keterangan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="simpananTable">
        <tr><td colspan="5">Memuat data...</td></tr>
      </tbody>
    </table>

    <h2>Daftar Transaksi Pinjaman</h2>
    <table>
      <thead>
        <tr>
          <th>Email</th>
          <th>Tanggal</th>
          <th>Jumlah</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="pinjamanTable">
        <tr><td colspan="5">Memuat data...</td></tr>
      </tbody>
    </table>
  </div>

  <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
    import { getFirestore, collection, getDocs, deleteDoc, updateDoc, doc } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

    const firebaseConfig = {
      apiKey: "AIzaSyAuq0JEjnEOagJnONPemkMP0bbgqepiFp8",
      authDomain: "koperasimahasiswaapp.firebaseapp.com",
      projectId: "koperasimahasiswaapp",
      storageBucket: "koperasimahasiswaapp.appspot.com",
      messagingSenderId: "812843080953",
      appId: "1:812843080953:web:9a931f89186182660bd628"
    };

    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);

    const simpananTable = document.getElementById('simpananTable');
    const pinjamanTable = document.getElementById('pinjamanTable');

    function formatRupiah(num) {
      return 'Rp ' + (num || 0).toLocaleString('id-ID');
    }

    async function loadSimpanan() {
      const snapshot = await getDocs(collection(db, 'simpanan'));
      let html = '';
      snapshot.forEach(docu => {
        const data = docu.data();
        const tgl = data.tanggal?.toDate?.() || new Date();
        html += `<tr>
          <td>${data.userEmail || '-'}</td>
          <td>${tgl.toLocaleDateString('id-ID')}</td>
          <td>${formatRupiah(data.jumlah)}</td>
          <td>${data.status || '-'}</td>
          <td>
            <button class="btn btn-setujui" onclick="ubahStatusSimpanan('${docu.id}', 'Disetujui')">Setujui</button>
            <button class="btn btn-tolak" onclick="ubahStatusSimpanan('${docu.id}', 'Ditolak')">Tolak</button>
            <button class="btn-delete" onclick="deleteSimpanan('${docu.id}')">Hapus</button>
          </td>
        </tr>`;
      });
      simpananTable.innerHTML = html || '<tr><td colspan="5">Tidak ada data simpanan.</td></tr>';
    }

    async function loadPinjaman() {
      const snapshot = await getDocs(collection(db, 'pinjaman'));
      let html = '';
      snapshot.forEach(docu => {
        const data = docu.data();
        const tgl = data.tanggal?.toDate?.() || new Date();
        html += `<tr>
          <td>${data.userEmail || '-'}</td>
          <td>${tgl.toLocaleDateString('id-ID')}</td>
          <td>${formatRupiah(data.jumlah)}</td>
          <td>${data.status || '-'}</td>
            <td>
            <button onclick="ubahBaru('${docu.id}', 'Disetujui')">Setujui</button>
            <button onclick="ubahBaru('${docu.id}', 'Ditolak')">Tolak</button>
            <button class="btn-delete" onclick="deletePinjaman('${docu.id}')">Hapus</button>
            </td>
        </tr>`;
      });
      pinjamanTable.innerHTML = html || '<tr><td colspan="5">Tidak ada data pinjaman.</td></tr>';
    }

    window.deleteSimpanan = async function(id) {
      if (confirm("Yakin ingin menghapus transaksi simpanan ini?")) {
        await deleteDoc(doc(db, 'simpanan', id));
        loadSimpanan();
      }
    }

    window.deletePinjaman = async function(id) {
      if (confirm("Yakin ingin menghapus transaksi pinjaman ini?")) {
        await deleteDoc(doc(db, 'pinjaman', id));
        loadPinjaman();
      }
    }

    window.ubahStatusPinjaman = async function(id, statusBaru) {
      if (confirm(`Ubah status pinjaman menjadi ${statusBaru}?`)) {
        await updateDoc(doc(db, 'pinjaman', id), { status: statusBaru });
        loadPinjaman();
      }
    }

    window.ubahStatusSimpanan = async function(id, statusBaru) {
      if (confirm(`Ubah status simpanan menjadi ${statusBaru}?`)) {
        await updateDoc(doc(db, 'simpanan', id), { status: statusBaru });
        loadSimpanan();
      }
    }

    // Load semua data
    loadSimpanan();
    loadPinjaman();
  </script>
</body>
</html>
