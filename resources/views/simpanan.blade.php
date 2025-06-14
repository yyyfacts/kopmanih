@extends('layouts.app')

@section('title', 'Simpanan')

@section('content')
<div class="animate-fade-in">
    <!-- Stats Summary -->
    <div class="stats-grid">
        <div class="stats-card">
            <div class="stats-card-header">
                <div class="stats-card-icon" style="background: #ECFDF5; color: #059669;">
                    <i class="fas fa-piggy-bank"></i>
                </div>
                <span class="stats-card-title">Total Simpanan Wajib</span>
            </div>
            <div class="stats-card-value">Rp <span id="totalWajib">0</span></div>
            <div class="stats-card-footer">
                <span class="text-secondary">Akumulasi simpanan wajib</span>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-card-header">
                <div class="stats-card-icon" style="background: #FEF3C7; color: #D97706;">
                    <i class="fas fa-coins"></i>
                </div>
                <span class="stats-card-title">Total Simpanan Sukarela</span>
            </div>
            <div class="stats-card-value">Rp <span id="totalSukarela">0</span></div>
            <div class="stats-card-footer">
                <span class="text-secondary">Akumulasi simpanan sukarela</span>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-card-header">
                <div class="stats-card-icon" style="background: #EFF6FF; color: #3B82F6;">
                    <i class="fas fa-clock"></i>
                </div>
                <span class="stats-card-title">Simpanan Pending</span>
            </div>
            <div class="stats-card-value" id="totalPending">0</div>
            <div class="stats-card-footer">
                <span class="text-secondary">Menunggu verifikasi</span>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-card-header">
                <div class="stats-card-icon" style="background: #F3F4F6; color: #4B5563;">
                    <i class="fas fa-calculator"></i>
                </div>
                <span class="stats-card-title">Total Keseluruhan</span>
            </div>
            <div class="stats-card-value">Rp <span id="totalAll">0</span></div>
            <div class="stats-card-footer">
                <span class="text-secondary">Total semua simpanan</span>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card mt-6">
        <div class="card-header">
            <h2 class="card-title">Riwayat Simpanan</h2>
            <button class="btn btn-primary" onclick="openModal()">
                <i class="fas fa-plus"></i>
                Tambah Simpanan
            </button>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-section p-4 border-b">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="form-group">
                    <label for="statusFilter">Status</label>
                    <select id="statusFilter" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jenisFilter">Jenis Simpanan</label>
                    <select id="jenisFilter" class="form-control">
                        <option value="">Semua Jenis</option>
                        <option value="wajib">Wajib</option>
                        <option value="sukarela">Sukarela</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="minAmount">Jumlah Minimum</label>
                    <input type="number" id="minAmount" class="form-control" placeholder="Minimal Rp">
                </div>
                <div class="form-group">
                    <label for="dateFilter">Tanggal</label>
                    <input type="date" id="dateFilter" class="form-control">
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button class="btn btn-secondary" onclick="resetFilters()">
                    <i class="fas fa-undo"></i>
                    Reset Filter
                </button>
            </div>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="spinner">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                            <p class="text-secondary mt-2">Memuat data...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal" id="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Tambah Simpanan</h3>
                <button type="button" class="btn-close" onclick="closeModal()"></button>
            </div>
            <div class="modal-body">
                <form id="simpananForm">
                    <div class="form-group">
                        <label for="jenisInput">Jenis Simpanan</label>
                        <select id="jenisInput" class="form-control">
                            <option value="wajib">Wajib</option>
                            <option value="sukarela">Sukarela</option>
                        </select>
                    </div>

                    <div class="form-group mt-4">
                        <label for="jumlahInput">Jumlah (Rupiah)</label>
                        <input type="number" id="jumlahInput" class="form-control" min="1" placeholder="Masukkan jumlah" required>
                    </div>

                    <div class="form-group mt-4">
                        <label for="ketInput">Keterangan (Opsional)</label>
                        <textarea id="ketInput" class="form-control" rows="3" placeholder="Tambahkan keterangan jika diperlukan"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
                <button type="button" class="btn btn-primary" id="saveBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
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
        background-color: #DEF7EC !important;
        color: #059669 !important;
    }

    .status-pending {
        background-color: #FEF3C7 !important;
        color: #D97706 !important;
    }

    .status-rejected {
        background-color: #FDE2E2 !important;
        color: #DC2626 !important;
    }

    /* Spinner Animation */
    .spinner > div {
        width: 18px;
        height: 18px;
        background-color: #ddd;
        border-radius: 100%;
        display: inline-block;
        animation: sk-bouncedelay 1.4s infinite ease-in-out both;
    }
    
    .spinner .bounce1 { animation-delay: -0.32s; }
    .spinner .bounce2 { animation-delay: -0.16s; }
    
    @keyframes sk-bouncedelay {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1.0); }
    }
</style>
@endpush

@push('scripts')
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-app.js";
    import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-auth.js";
    import {
        getFirestore, collection, addDoc, getDocs, doc, updateDoc, deleteDoc,
        query, where, orderBy, serverTimestamp
    } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-firestore.js";

    const firebaseConfig = {
        apiKey: "AIzaSyAuq0JEjnEOagJnONPemkMP0bbgqepiFp8",
        authDomain: "koperasimahasiswaapp.firebaseapp.com",
        projectId: "koperasimahasiswaapp",
        storageBucket: "koperasimahasiswaapp.appspot.com",
        messagingSenderId: "812843080953",
        appId: "1:812843080953:web:9a931f89186182660bd628",
        measurementId: "G-ES6G76W66D"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const db = getFirestore(app);

    let currentUid = null;
    let currentNama = null;
    let allSavingsData = [];

    // DOM Elements
    const modal = document.getElementById('modal');
    const modalTitle = document.getElementById('modal-title');
    const jenisInput = document.getElementById('jenisInput');
    const jumlahInput = document.getElementById('jumlahInput');
    const ketInput = document.getElementById('ketInput');
    const saveBtn = document.getElementById('saveBtn');
    const tbody = document.getElementById('tbody');

    // Filter Elements
    const statusFilter = document.getElementById('statusFilter');
    const jenisFilter = document.getElementById('jenisFilter');
    const minAmount = document.getElementById('minAmount');
    const dateFilter = document.getElementById('dateFilter');

    // Add event listeners for automatic filtering
    statusFilter.addEventListener('change', applyFilters);
    jenisFilter.addEventListener('change', applyFilters);
    minAmount.addEventListener('input', applyFilters);
    dateFilter.addEventListener('change', applyFilters);

    // Auth state observer
    onAuthStateChanged(auth, async (user) => {
        if (user) {
            currentUid = user.uid;
            currentNama = user.displayName;
            loadSavings();
        } else {
            window.location.href = '/login';
        }
    });

    // Load savings data
    async function loadSavings() {
        try {
            const q = query(
                collection(db, "simpanan"),
                where("userId", "==", currentUid),
                orderBy("tanggal", "desc")
            );
            const querySnapshot = await getDocs(q);
            
            allSavingsData = querySnapshot.docs.map(doc => ({
                id: doc.id,
                ...doc.data()
            }));
            
            updateStats(allSavingsData);
            renderTable(allSavingsData);
        } catch (error) {
            console.error("Error loading savings:", error);
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-red-500">Error loading data</td></tr>';
        }
    }

    // Render table function
    function renderTable(data) {
        if (data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <p class="text-secondary">Belum ada data simpanan</p>
                    </td>
                </tr>
            `;
            return;
        }

        let html = '';
        let no = 1;

        data.forEach(item => {
            const timestamp = item.tanggal?.toDate ? item.tanggal.toDate() : new Date();
            
            html += `
                <tr>
                    <td>${no++}</td>
                    <td>${capitalizeFirstLetter(item.jenis)}</td>
                    <td>Rp ${Number(item.jumlah).toLocaleString('id-ID')}</td>
                    <td>${timestamp.toLocaleDateString('id-ID')}</td>
                    <td>
                        <span class="status-badge ${getStatusBadgeClass(item.status)}">
                            <i class="fas fa-${getStatusIcon(item.status)}"></i>
                            ${capitalizeFirstLetter(item.status)}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            ${item.status === 'pending' ? `
                                <button class="btn btn-icon btn-warning" onclick="editSavings('${item.id}', ${JSON.stringify(item).replace(/"/g, '&quot;')})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-icon btn-danger" onclick="deleteSavings('${item.id}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            ` : `
                                <button class="btn btn-icon btn-info" onclick="viewDetail('${item.id}')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            `}
                        </div>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
    }

    // Apply filters function
    function applyFilters() {
        let filteredData = [...allSavingsData];

        if (statusFilter.value) {
            filteredData = filteredData.filter(item => item.status.toLowerCase() === statusFilter.value.toLowerCase());
        }

        if (jenisFilter.value) {
            filteredData = filteredData.filter(item => item.jenis === jenisFilter.value);
        }

        if (minAmount.value) {
            const min = Number(minAmount.value);
            filteredData = filteredData.filter(item => Number(item.jumlah) >= min);
        }

        if (dateFilter.value) {
            const selectedDate = new Date(dateFilter.value);
            selectedDate.setHours(0, 0, 0, 0);
            
            filteredData = filteredData.filter(item => {
                if (!item.tanggal) return false;
                const itemDate = item.tanggal.toDate();
                itemDate.setHours(0, 0, 0, 0);
                return itemDate.getTime() === selectedDate.getTime();
            });
        }

        renderTable(filteredData);
        updateStats(filteredData);
    }

    // Reset filters
    window.resetFilters = function() {
        statusFilter.value = '';
        jenisFilter.value = '';
        minAmount.value = '';
        dateFilter.value = '';
        renderTable(allSavingsData);
        updateStats(allSavingsData);
    }

    // Update statistics
    function updateStats(data) {
        let wajib = 0;
        let sukarela = 0;
        let pending = 0;

        data.forEach(item => {
            if (item.status === 'approved') {
                if (item.jenis === 'wajib') {
                    wajib += Number(item.jumlah);
                } else {
                    sukarela += Number(item.jumlah);
                }
            }
            if (item.status === 'pending') {
                pending++;
            }
        });

        document.getElementById('totalWajib').textContent = wajib.toLocaleString('id-ID');
        document.getElementById('totalSukarela').textContent = sukarela.toLocaleString('id-ID');
        document.getElementById('totalPending').textContent = pending;
        document.getElementById('totalAll').textContent = (wajib + sukarela).toLocaleString('id-ID');
    }

    // Helper functions
    function getStatusBadgeClass(status) {
        switch(status.toLowerCase()) {
            case 'approved':
            case 'disetujui': return 'status-approved';
            case 'rejected':
            case 'ditolak': return 'status-rejected';
            case 'pending':
            case 'menunggu': return 'status-pending';
            default: return 'status-pending';
        }
    }

    function getStatusIcon(status) {
        switch(status.toLowerCase()) {
            case 'approved':
            case 'disetujui': return 'check-circle';
            case 'rejected':
            case 'ditolak': return 'times-circle';
            case 'pending':
            case 'menunggu': return 'clock';
            default: return 'clock';
        }
    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    // Modal functions
    window.openModal = function() {
        modal.classList.add('show');
        modal.style.display = 'flex';
        modalTitle.textContent = 'Tambah Simpanan';
        jenisInput.value = 'wajib';
        jumlahInput.value = '';
        ketInput.value = '';
    }

    window.closeModal = function() {
        modal.classList.remove('show');
        setTimeout(() => modal.style.display = 'none', 200);
    }

    // Save data
    saveBtn.onclick = async function() {
        if (!jumlahInput.value) {
            alert('Jumlah simpanan harus diisi');
            return;
        }

        const data = {
            userId: currentUid,
            nama: currentNama,
            jenis: jenisInput.value,
            jumlah: Number(jumlahInput.value),
            keterangan: ketInput.value || '',
            status: 'pending',
            tanggal: serverTimestamp()
        };

        try {
            await addDoc(collection(db, "simpanan"), data);
            closeModal();
            loadSavings();
        } catch (error) {
            console.error("Error saving:", error);
            alert('Gagal menyimpan data: ' + error.message);
        }
    }

    // Make functions available to window object
    window.editSavings = function(id, data) {
        // Implementation...
    }

    window.deleteSavings = async function(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus simpanan ini?')) return;
        
        try {
            await deleteDoc(doc(db, "simpanan", id));
            loadSavings();
        } catch (error) {
            console.error("Error deleting:", error);
            alert('Gagal menghapus data: ' + error.message);
        }
    }

    window.viewDetail = function(id) {
        // Implementation...
    }
</script>
@endpush

@endsection
