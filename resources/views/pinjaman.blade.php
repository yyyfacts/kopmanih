@extends('layouts.app')

@section('title', 'Pinjaman')

@section('content')
    <div class="content-wrapper">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h1 class="page-title">Manajemen Pinjaman</h1>
                <div class="page-actions">
                    <button type="button" class="btn-primary" onclick="openModal()">
                        <i class="fas fa-plus"></i>
                        <span>Ajukan Pinjaman</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stats-card">
                <div class="stats-card-content">
                    <div class="stats-card-header">
                        <h3>Total Pinjaman</h3>
                        <div class="stats-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                    <div class="stats-card-body">
                        <div class="stats-value" id="totalPinjaman">Rp 0</div>
                        <div class="stats-label">Total nilai pinjaman yang diajukan</div>
                    </div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-card-content">
                    <div class="stats-card-header">
                        <h3>Pinjaman Aktif</h3>
                        <div class="stats-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="stats-card-body">
                        <div class="stats-value" id="pinjamanDiterima">0</div>
                        <div class="stats-label">Pinjaman yang sedang berjalan</div>
                    </div>
                </div>
            </div>
            <div class="stats-card">
                <div class="stats-card-content">
                    <div class="stats-card-header">
                        <h3>Menunggu Persetujuan</h3>
                        <div class="stats-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="stats-card-body">
                        <div class="stats-value" id="pinjamanMenunggu">0</div>
                        <div class="stats-label">Pinjaman dalam proses review</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content-card">
            <div class="card-header">
                <div class="card-title-wrapper">
                    <h2 class="card-title">Daftar Pinjaman</h2>
                </div>
                <div class="card-tools">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Cari pinjaman..." class="search-input">
                    </div>
                    <div class="filter-wrapper">
                        <select class="select-filter" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Diterima">Disetujui</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                        <select class="select-filter" id="sortFilter">
                            <option value="amount-high">Nominal Tertinggi</option>
                            <option value="amount-low">Nominal Terendah</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Keterangan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Jumlah</th>
                            <th>Tujuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="loanTableBody">
                        <!-- Data will be inserted here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal" id="loanModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title">Ajukan Pinjaman</h3>
                    <button type="button" class="btn-close" onclick="closeModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="loanForm" onsubmit="handleSubmitLoan(event)">
                        <input type="hidden" id="loanId" name="loanId">
                        
                        <div class="form-group">
                            <label for="jumlah">Jumlah Pinjaman</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" 
                                       required min="100000" step="1000">
                            </div>
                            <div class="form-text">Minimal Rp 100.000</div>
                        </div>

                        <div class="form-group">
                            <label for="tujuan">Tujuan Pinjaman</label>
                            <select class="form-select" id="tujuan" name="tujuan" required>
                                <option value="">Pilih tujuan pinjaman</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Modal Usaha">Modal Usaha</option>
                                <option value="Keperluan Mendadak">Keperluan Mendadak</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" 
                                      rows="4" required></textarea>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn-secondary" onclick="closeModal()">Batal</button>
                            <button type="submit" class="btn-primary" id="submitBtn">
                                <i class="fas fa-paper-plane"></i>
                                <span>Ajukan Pinjaman</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
      import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
      import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";
      import {
        getFirestore, collection, doc, addDoc, updateDoc, deleteDoc,
        query, where, onSnapshot, getDoc, serverTimestamp
      } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

      const firebaseConfig = {
        apiKey: "AIzaSyAuq0JEjnEOagJnONPemkMP0bbgqepiFp8",
        authDomain: "koperasimahasiswaapp.firebaseapp.com",
        projectId: "koperasimahasiswaapp",
        storageBucket: "koperasimahasiswaapp.appspot.com",
        messagingSenderId: "812843080953",
        appId: "1:812843080953:web:9a931f89186182660bd628"
      };

      const app  = initializeApp(firebaseConfig);
      const auth = getAuth(app);
      const db   = getFirestore(app);

      const tbody       = document.getElementById("tbody");
      const modal       = document.getElementById("modal");
      const modalTitle  = document.getElementById("modal-title");
      const tujuanInput = document.getElementById("tujuanInput");
      const jumlahInput = document.getElementById("jumlahInput");
      const ketInput    = document.getElementById("ketInput");
      const saveBtn     = document.getElementById("saveBtn");

      let currentUid  = null;
      let currentRole = "mahasiswa";
      let editId      = null;

      onAuthStateChanged(auth, async user => {
        if (!user) { window.location.href = "/login"; return; }
        currentUid = user.uid;

        const usrSnap = await getDoc(doc(db,"users",currentUid));
        if (usrSnap.exists()) currentRole = usrSnap.data().role || "mahasiswa";

        const col = collection(db,"pinjaman");
        const q   = currentRole === "admin" ? col : query(col, where("userId","==",currentUid));

        onSnapshot(q, snap => {
          let html = "";
          let i    = 1;
          snap.forEach(d => { html += rowTemplate({...d.data(), id:d.id}, i++); });
          tbody.innerHTML = html || `<tr><td colspan="6">Tidak ada data</td></tr>`;
        });
      });

      function openModal(data=null){
        modal.classList.add("show");
        if (data){
          modalTitle.textContent = "Edit Pinjaman";
          tujuanInput.value  = data.tujuan;
          jumlahInput.value  = data.jumlah;
          ketInput.value     = data.keterangan || "";
          editId = data.id;
        } else {
          modalTitle.textContent = "Ajukan Pinjaman";
          tujuanInput.value  = "p";
          jumlahInput.value  = "";
          ketInput.value     = "";
          editId = null;
        }
      }
      function closeModal(){ modal.classList.remove("show"); }

      saveBtn.onclick = async () => {
        const nominal = Number(jumlahInput.value);
        if (isNaN(nominal) || nominal <= 0){
          alert("Jumlah harus lebih dari 0");
          return;
        }

        const payload = {
          userId     : currentUid,
          tujuan     : tujuanInput.value,
          jumlah     : nominal,
          keterangan : ketInput.value.trim(),
          status     : "Menunggu",
          tanggal    : new Date().toISOString().slice(0,10),
          createdAt  : serverTimestamp()
        };

        if (editId){
          await updateDoc(doc(db,"pinjaman",editId), payload);
        }else{
          await addDoc(collection(db,"pinjaman"), payload);
        }
        closeModal();
      };

      function rowTemplate(d,i){
        const tujuanCls = d.tujuan?.toLowerCase().includes("usaha") ? "b-u" : "b-p";
        const statCls  = d.status === "Menunggu" ? "s-menunggu"
                       : d.status === "Diterima" ? "s-diterima" : "s-ditolak";
        const tgl = d.createdAt?.seconds
                  ? new Date(d.createdAt.seconds*1000).toLocaleDateString("id-ID")
                  : d.tanggal || "-";

        const adminBtn = `
          <button class="btn-edit" onclick="editRow('${d.id}')">Edit</button>
          <button class="btn-status" onclick="toggleStatus('${d.id}','${d.status}')">Status</button>`;
        const delBtn = `<button class="btn-del" onclick="delRow('${d.id}')">Hapus</button>`;

        return `
          <tr>
            <td>${i}</td>
           <td><span class="badge ${tujuanCls}">${d.tujuan}</span></td>
            <td>Rp ${Number(d.jumlah).toLocaleString("id-ID")}</td>
            <td>${tgl}</td>
            <td><span class="badge ${statCls}">${d.status}</span></td>
            <td>${currentRole==="admin" ? adminBtn+delBtn : delBtn}</td>
          </tr>`;
      }

      window.editRow = async id => {
        if (currentRole !== "admin") return;
        const snap = await getDoc(doc(db,"pinjaman",id));
        if (snap.exists()) openModal({id, ...snap.data()});
      };
      window.delRow = id => {
        if (confirm("Hapus pinjaman ini?")) deleteDoc(doc(db,"pinjaman",id));
      };
      window.toggleStatus = (id,cur) => {
        if (currentRole !== "admin") return;
        const next = cur === "Menunggu" ? "Diterima"
                   : cur === "Diterima" ? "Ditolak" : "Menunggu";
        updateDoc(doc(db,"pinjaman",id), {status:next});
      };

      window.openModal  = openModal;
      window.closeModal = closeModal;
    </script>
@endsection

@push('styles')
<style>
    /* Content Layout */
    .content-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 2rem;
    }

    .page-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    /* Statistics Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stats-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        transition: all 0.2s ease;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .stats-card-content {
        padding: 1.5rem;
    }

    .stats-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .stats-card-header h3 {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-secondary);
        margin: 0;
    }

    .stats-icon {
        width: 2.5rem;
        height: 2.5rem;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stats-value {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .stats-label {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    /* Content Card */
    .content-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .card-tools {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Search Box */
    .search-box {
        position: relative;
        width: 300px;
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
    }

    .search-input {
        width: 100%;
        padding: 0.625rem 1rem 0.625rem 2.5rem;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px var(--primary-light);
    }

    /* Filter Controls */
    .filter-wrapper {
        display: flex;
        gap: 0.75rem;
    }

    .select-filter {
        padding: 0.625rem 2rem 0.625rem 1rem;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        background: var(--surface);
        cursor: pointer;
        transition: all 0.2s;
    }

    .select-filter:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px var(--primary-light);
    }

    /* Table Styles */
    .table-responsive {
        overflow-x: auto;
        margin: 0 -1px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        background: var(--background);
        padding: 1rem 1.5rem;
        text-align: left;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-secondary);
        white-space: nowrap;
    }

    .data-table td {
        padding: 1rem 1.5rem;
        font-size: 0.875rem;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    /* Keterangan Column Style */
    .keterangan-cell {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        position: relative;
    }

    .keterangan-cell.expanded {
        white-space: normal;
        overflow: visible;
    }

    .keterangan-cell .expand-btn {
        position: absolute;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, var(--surface) 40%);
        padding: 0 0.5rem;
        color: var(--primary);
        cursor: pointer;
        font-size: 0.75rem;
    }

    /* Ensure other columns don't wrap */
    .data-table td:not(:first-child) {
        white-space: nowrap;
    }

    /* Action buttons container */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-start;
    }

    .btn-action {
        padding: 0.5rem;
        border-radius: 0.375rem;
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .btn-action:hover {
        background: var(--primary-light);
        color: var(--primary);
        border-color: var(--primary);
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        padding: 2rem;
        overflow-y: auto;
        animation: fadeIn 0.2s ease;
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-dialog {
        width: 100%;
        max-width: 500px;
        margin: auto;
    }

    .modal-content {
        background: var(--surface);
        border-radius: 0.75rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .modal-header {
        padding: 1.25rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .modal-body {
        padding: 1.25rem;
    }

    .modal-footer {
        padding: 1.25rem;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-primary);
    }

    .input-group {
        display: flex;
    }

    .input-group-text {
        padding: 0.625rem 1rem;
        background: var(--background);
        border: 1px solid var(--border);
        border-right: none;
        border-radius: 0.5rem 0 0 0.5rem;
        color: var(--text-secondary);
    }

    .form-control {
        width: 100%;
        padding: 0.625rem 1rem;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .input-group .form-control {
        border-radius: 0 0.5rem 0.5rem 0;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px var(--primary-light);
    }

    .form-select {
        width: 100%;
        padding: 0.625rem 2rem 0.625rem 1rem;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
        appearance: none;
    }

    .form-text {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 0.25rem;
    }

    /* Button Styles */
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        background: var(--surface);
        color: var(--text-primary);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-secondary:hover {
        background: var(--background);
    }

    /* Status Badge Styles */
    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
        text-transform: capitalize;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .status-badge i {
        font-size: 0.75rem;
    }

    .status-approved {
        background-color: #DEF7EC;
        color: #059669;
    }

    .status-pending {
        background-color: #FEF3C7;
        color: #D97706;
    }

    .status-rejected {
        background-color: #FDE2E2;
        color: #DC2626;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1rem;
        }

        .page-header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .card-tools {
            flex-direction: column;
            width: 100%;
        }

        .search-box {
            width: 100%;
        }

        .filter-wrapper {
            width: 100%;
            flex-wrap: wrap;
        }

        .select-filter {
            flex: 1;
        }

        .modal {
            padding: 1rem;
        }
    }

    /* Loan Details View */
    .loan-details {
        padding: 1rem;
    }

    .loan-details .form-group {
        margin-bottom: 1.5rem;
    }

    .loan-details label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }

    .loan-details .form-control-static {
        font-size: 1rem;
        color: var(--text-primary);
        padding: 0.5rem;
        background: var(--background);
        border-radius: 0.375rem;
        min-height: 2.5rem;
        display: flex;
        align-items: center;
    }

    .loan-details .status-badge {
        display: inline-flex;
    }
</style>
@endpush

@push('scripts')
<script type="module">
    // Firebase Imports
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
    import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";
    import {
        getFirestore, collection, addDoc, getDocs, getDoc, doc,
        query, where, orderBy, updateDoc, deleteDoc, serverTimestamp
    } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

    // Firebase Configuration
    const firebaseConfig = {
        apiKey: "AIzaSyAuq0JEjnEOagJnONPemkMP0bbgqepiFp8",
        authDomain: "koperasimahasiswaapp.firebaseapp.com",
        projectId: "koperasimahasiswaapp",
        storageBucket: "koperasimahasiswaapp.appspot.com",
        messagingSenderId: "812843080953",
        appId: "1:812843080953:web:9a931f89186182660bd628"
    };

    // Initialize Firebase Services
    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const db = getFirestore(app);

    // Utility Functions
    const formatCurrency = (amount) => {
        if (!amount || isNaN(amount)) return 'Rp 0';
        return `Rp ${parseInt(amount).toLocaleString('id-ID')}`;
    };

    const formatDate = (timestamp) => {
        if (!timestamp) return '-';
        const date = timestamp.toDate ? timestamp.toDate() : new Date(timestamp);
        return date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    };

    const getStatusBadge = (status) => {
        const statusClasses = {
            'Menunggu': 'status-pending',
            'Diterima': 'status-approved',
            'Ditolak': 'status-rejected'
        };
        const statusIcons = {
            'Menunggu': 'clock',
            'Diterima': 'check-circle',
            'Ditolak': 'times-circle'
        };
        const className = statusClasses[status] || 'status-pending';
        const icon = statusIcons[status] || 'clock';
        
        return `
            <span class="status-badge ${className}">
                <i class="fas fa-${icon}"></i>
                ${status || 'Menunggu'}
            </span>
        `;
    };

    // Load Loans Data
    const loadLoans = async (userId) => {
        try {
            const loansRef = collection(db, "pinjaman");
            const q = query(
                loansRef,
                where("userId", "==", userId),
                orderBy("createdAt", "desc")
            );

            const querySnapshot = await getDocs(q);
            let totalAmount = 0;
            let approvedCount = 0;
            let pendingCount = 0;

            const tableBody = document.getElementById('loanTableBody');
            tableBody.innerHTML = '';

            if (querySnapshot.empty) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data pinjaman</td>
                    </tr>
                `;
                return;
            }

            querySnapshot.forEach((doc) => {
                const loan = doc.data();
                const amount = parseFloat(loan.jumlah) || 0;

                // Update statistics
                totalAmount += amount;
                if (loan.status === 'Diterima') approvedCount++;
                if (loan.status === 'Menunggu') pendingCount++;

                // Create table row
                const row = `
                    <tr>
                        <td class="keterangan-cell">${loan.keterangan ? (loan.keterangan.length > 50 ? loan.keterangan.substring(0, 50) + '...' : loan.keterangan) : '-'}</td>
                        <td>${formatDate(loan.createdAt)}</td>
                        <td>${formatCurrency(amount)}</td>
                        <td>${loan.tujuan || '-'}</td>
                        <td>${getStatusBadge(loan.status)}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action" onclick="window.viewLoan('${doc.id}')" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                ${loan.status === 'Menunggu' ? `
                                    <button class="btn-action" onclick="window.editLoan('${doc.id}')" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action" onclick="window.deleteLoan('${doc.id}')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                ` : ''}
                            </div>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });

            // Update statistics display
            document.getElementById('totalPinjaman').textContent = formatCurrency(totalAmount);
            document.getElementById('pinjamanDiterima').textContent = approvedCount;
            document.getElementById('pinjamanMenunggu').textContent = pendingCount;

        } catch (error) {
            console.error("Error loading loans:", error);
            alert("Terjadi kesalahan saat memuat data pinjaman");
        }
    };

    // Handle Form Submission
    window.handleSubmitLoan = async (event) => {
        event.preventDefault();
        const form = event.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        
        try {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

            const jumlah = parseFloat(form.jumlah.value);
            if (isNaN(jumlah) || jumlah < 100000) {
                throw new Error('Jumlah pinjaman minimal Rp 100.000');
            }

            const loanData = {
                userId: auth.currentUser.uid,
                userName: auth.currentUser.email,
                jumlah: jumlah,
                tujuan: form.tujuan.value,
                keterangan: form.keterangan.value,
                status: 'Menunggu',
                createdAt: serverTimestamp(),
                updatedAt: serverTimestamp()
            };

            const loanId = form.loanId.value;
            if (loanId) {
                // Update existing loan
                await updateDoc(doc(db, "pinjaman", loanId), {
                    ...loanData,
                    updatedAt: serverTimestamp()
                });
            } else {
                // Create new loan
                await addDoc(collection(db, "pinjaman"), loanData);
            }

            await loadLoans(auth.currentUser.uid);
            window.closeModal();
            alert(loanId ? 'Pinjaman berhasil diperbarui' : 'Pinjaman berhasil diajukan');

        } catch (error) {
            console.error("Error submitting loan:", error);
            alert(error.message || "Terjadi kesalahan saat memproses pinjaman");
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Ajukan Pinjaman';
        }
    };

    // View Loan Details
    window.viewLoan = async (loanId) => {
        try {
            const docRef = doc(db, "pinjaman", loanId);
            const docSnap = await getDoc(docRef);
            
            if (docSnap.exists()) {
                const loan = docSnap.data();
                
                // Hide the form and show a custom view
                const modalBody = document.querySelector('.modal-body');
                const modalFooter = document.querySelector('.modal-footer');
                const form = document.getElementById('loanForm');
                
                // Hide form and show detail view
                if (form) form.style.display = 'none';
                
                // Update modal content
                document.getElementById('modal-title').textContent = 'Detail Pinjaman';
                modalBody.innerHTML = `
                    <div class="loan-details">
                        <div class="form-group">
                            <label>Tanggal Pengajuan</label>
                            <div class="form-control-static">${formatDate(loan.createdAt)}</div>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Pinjaman</label>
                            <div class="form-control-static">${formatCurrency(loan.jumlah || 0)}</div>
                        </div>
                        <div class="form-group">
                            <label>Tujuan</label>
                            <div class="form-control-static">${loan.tujuan || '-'}</div>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <div class="form-control-static">${loan.keterangan || '-'}</div>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <div class="form-control-static">${getStatusBadge(loan.status || 'Menunggu')}</div>
                        </div>
                    </div>
                `;

                // Update footer for view mode
                modalFooter.innerHTML = `
                    <button type="button" class="btn-secondary" onclick="closeModal()">Tutup</button>
                `;
                modalFooter.style.display = 'flex';
                
                // Show modal
                document.getElementById('loanModal').classList.add('show');
            } else {
                throw new Error('Data pinjaman tidak ditemukan');
            }
        } catch (error) {
            console.error("Error viewing loan:", error);
            alert("Terjadi kesalahan saat memuat detail pinjaman");
        }
    };

    // Edit Loan
    window.editLoan = async (loanId) => {
        try {
            const docRef = doc(db, "pinjaman", loanId);
            const docSnap = await getDoc(docRef);
            
            if (docSnap.exists()) {
                const loan = docSnap.data();
                
                // Reset and populate form
                const form = document.getElementById('loanForm');
                form.reset();
                
                document.getElementById('modal-title').textContent = 'Edit Pinjaman';
                document.getElementById('loanId').value = loanId;
                document.getElementById('jumlah').value = loan.jumlah;
                document.getElementById('tujuan').value = loan.tujuan;
                document.getElementById('keterangan').value = loan.keterangan;
                
                document.querySelector('.modal-footer').style.display = 'flex';
                document.getElementById('loanModal').classList.add('show');
            }
        } catch (error) {
            console.error("Error editing loan:", error);
            alert("Terjadi kesalahan saat memuat data pinjaman");
        }
    };

    // Delete Loan
    window.deleteLoan = async (loanId) => {
        if (confirm('Apakah Anda yakin ingin menghapus pinjaman ini?')) {
            try {
                await deleteDoc(doc(db, "pinjaman", loanId));
                await loadLoans(auth.currentUser.uid);
                alert('Pinjaman berhasil dihapus');
            } catch (error) {
                console.error("Error deleting loan:", error);
                alert("Terjadi kesalahan saat menghapus pinjaman");
            }
        }
    };

    // Modal Controls
    window.openModal = () => {
        const form = document.getElementById('loanForm');
        form.reset();
        document.getElementById('loanId').value = '';
        document.getElementById('modal-title').textContent = 'Ajukan Pinjaman Baru';
        document.querySelector('.modal-footer').style.display = 'flex';
        document.getElementById('loanModal').classList.add('show');
    };

    window.closeModal = () => {
        const modal = document.getElementById('loanModal');
        modal.classList.remove('show');
        document.getElementById('loanForm').reset();
        document.getElementById('loanId').value = '';
    };

    // Initialize App
    onAuthStateChanged(auth, (user) => {
        if (user) {
            loadLoans(user.uid);
        } else {
            window.location.href = "/login";
        }
    });

    // Search and Filter Functionality
    const setupSearchAndFilter = () => {
        // Search
        document.querySelector('.search-input')?.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#loanTableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Status Filter
        document.getElementById('statusFilter')?.addEventListener('change', (e) => {
            const status = e.target.value;
            const rows = document.querySelectorAll('#loanTableBody tr');
            
            rows.forEach(row => {
                if (!status) {
                    row.style.display = '';
                    return;
                }
                
                const statusCell = row.querySelector('td:nth-child(5)');
                const hasStatus = statusCell?.textContent.includes(status);
                row.style.display = hasStatus ? '' : 'none';
            });
        });

        // Sort
        document.getElementById('sortFilter')?.addEventListener('change', (e) => {
            const sortType = e.target.value;
            const rows = Array.from(document.querySelectorAll('#loanTableBody tr'));
            
            rows.sort((a, b) => {
                const aContent = a.cells[2]?.textContent || '0';
                const bContent = b.cells[2]?.textContent || '0';
                const aAmount = parseFloat(aContent.replace(/[^\d.-]/g, '')) || 0;
                const bAmount = parseFloat(bContent.replace(/[^\d.-]/g, '')) || 0;

                switch (sortType) {
                    case 'amount-high':
                        return bAmount - aAmount;
                    case 'amount-low':
                        return aAmount - bAmount;
                    default:
                        return 0;
                }
            });
            
            const tbody = document.getElementById('loanTableBody');
            rows.forEach(row => tbody.appendChild(row));
        });
    };

    // Setup search and filter when DOM is ready
    document.addEventListener('DOMContentLoaded', setupSearchAndFilter);
</script>
@endpush
