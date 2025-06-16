@extends('layouts.app')

@section('title', 'Manajemen Simpanan')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-actions">
                    <button type="button" class="btn-primary" onclick="openModal()">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Simpanan</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stats-card">
                <div class="stats-card-content">
                    <div class="stats-card-header">
                        <h3>Total Simpanan</h3>
                        <div class="stats-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                    <div class="stats-card-body">
                        <div class="stats-value" id="totalSimpanan">Rp 0</div>
                        <div class="stats-label">Total nilai simpanan disetujui</div>
                    </div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-card-content">
                    <div class="stats-card-header">
                        <h3>Simpanan Disetujui</h3>
                        <div class="stats-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="stats-card-body">
                        <div class="stats-value" id="simpananApproved">0</div>
                        <div class="stats-label">Jumlah simpanan yang disetujui</div>
                    </div>
                </div>
            </div>
            <div class="stats-card">
                <div class="stats-card-content">
                    <div class="stats-card-header">
                        <h3>Menunggu Persetujuan</h3>
                        <div class="stats-icon">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                    <div class="stats-card-body">
                        <div class="stats-value" id="simpananPending">0</div>
                        <div class="stats-label">Simpanan dalam proses review</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header">
                <div class="card-title-wrapper">
                    <h2 class="card-title">Daftar Simpanan</h2>
                </div>
                <div class="card-tools">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Cari simpanan..." class="search-input">
                    </div>
                    <div class="filter-wrapper">
                        {{-- MODIFIED: Filter options values to match Indonesian status strings --}}
                        <select class="select-filter" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                        <select class="select-filter" id="typeFilter">
                            <option value="">Semua Jenis</option>
                            <option value="wajib">Wajib</option>
                            <option value="sukarela">Sukarela</option>
                        </select>
                        <select class="select-filter" id="sortFilter">
                            <option value="date-desc">Tanggal Terbaru</option>
                            <option value="date-asc">Tanggal Terlama</option>
                            <option value="amount-high">Jumlah Tertinggi</option>
                            <option value="amount-low">Jumlah Terendah</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Pengaju</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="simpananTableBody">
                        <tr><td colspan="8">Memuat…</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" id="simpananModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title">Tambah Simpanan</h3>
                    <button type="button" class="btn-close" onclick="closeModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- The form content will be dynamically loaded/reloaded by openModal function --}}
                    <form id="simpananForm" onsubmit="handleSubmitSimpanan(event)">
                        <input type="hidden" id="simpananId" name="simpananId">
                        
                        <div class="form-group">
                            <label for="jenisInput">Jenis Simpanan</label>
                            <select class="form-select" id="jenisInput" name="jenis" required>
                                <option value="wajib">Wajib</option>
                                <option value="sukarela">Sukarela</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jumlahInput">Jumlah Simpanan</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="jumlahInput" name="jumlah" 
                                        required min="1000" step="1000" placeholder="Minimal Rp 1.000">
                            </div>
                            <div class="form-text">Minimal Rp 1.000</div>
                        </div>

                        <div class="form-group">
                            <label for="ketInput">Keterangan</label>
                            <textarea class="form-control" id="ketInput" name="keterangan" 
                                        rows="3" placeholder="Contoh: Pembayaran iuran bulan Juni" required></textarea>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn-secondary" onclick="closeModal()">Batal</button>
                            <button type="submit" class="btn-primary-form" id="submitBtn">
                                <i class="fas fa-paper-plane"></i>
                                <span>Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Variabel CSS untuk konsistensi tema */
    :root {
        --primary: #2e7d32; /* Hijau Tua */
        --primary-light: #e8f5e9; /* Hijau Sangat Muda */
        --primary-dark: #1b5e20; /* Hijau Lebih Tua */
        --text-primary: #333;
        --text-secondary: #666;
        --surface: #ffffff;
        --background: #f4f6f9;
        --border: #e0e0e0;
        --red: #dc3545;
        --yellow: #ffc107;
        --green: #28a745;
        --blue: #17a2b8;
        --dark-blue: #01579b;
    }

    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: var(--background);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        color: var(--text-primary);
    }

    /* Content Layout */
    .content-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        flex-grow: 1; /* Konten utama akan memanjang */
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

    .page-actions .btn-primary {
        background: var(--primary);
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .page-actions .btn-primary:hover {
        background: var(--primary-dark);
    }

    /* Statistics Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stats-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
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
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
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

    .card-title-wrapper {
        flex-grow: 1; /* Agar judul mengambil sisa ruang */
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
        width: 250px; /* Lebar default */
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
        box-sizing: border-box;
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
        flex-wrap: wrap;
    }

    .select-filter {
        padding: 0.625rem 2rem 0.625rem 1rem;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        background: var(--surface);
        cursor: pointer;
        transition: all 0.2s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }

    .select-filter:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px var(--primary-light);
    }

    /* Table Styles */
    .table-responsive {
        overflow-x: auto;
        margin: 0;
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
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Action buttons container */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-start;
        flex-wrap: wrap;
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
        display: inline-flex;
        align-items: center;
        justify-content: center;
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
        padding: 1rem;
        overflow-y: auto;
        animation: fadeIn 0.2s ease;
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
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
        animation: zoomIn 0.2s ease-out;
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

    .btn-close {
        background: none;
        border: none;
        font-size: 1.2rem;
        color: var(--text-secondary);
        cursor: pointer;
        transition: color 0.2s;
    }

    .btn-close:hover {
        color: var(--text-primary);
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
        width: 100%;
    }

    .input-group-text {
        padding: 0.625rem 1rem;
        background: var(--background);
        border: 1px solid var(--border);
        border-right: none;
        border-radius: 0.5rem 0 0 0.5rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
    }

    .form-control {
        width: 100%;
        padding: 0.625rem 1rem;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.2s;
        box-sizing: border-box;
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
        background: var(--surface);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
        appearance: none;
        cursor: pointer;
        box-sizing: border-box;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }

    .form-text {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 0.25rem;
    }

    /* Button Styles */
    .btn-primary-form {
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

    .btn-primary-form:hover {
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

    /* Jenis Badge Styles (disesuaikan dengan simpanan) */
    .badge-wajib {
        background-color: #E0F7FA;
        color: #00838F;
    }
    .badge-sukarela {
        background-color: #E8F5E9;
        color: #2E7D32;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes zoomIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
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
            padding: 0.5rem;
        }

        /* Responsive Table (Card View) */
        .data-table thead {
            display: none;
        }

        .data-table, .data-table tbody, .data-table tr, .data-table td {
            display: block;
            width: 100%;
        }

        .data-table tr {
            margin-bottom: 1rem;
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .data-table td:last-child {
            border-bottom: none;
        }

        .data-table td::before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            width: calc(50% - 1.5rem);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: left;
            font-weight: 500;
            color: var(--text-secondary);
        }

        /* Labels for mobile view */
        td:nth-of-type(1):before { content: "No"; }
        td:nth-of-type(2):before { content: "Jenis"; }
        td:nth-of-type(3):before { content: "Jumlah"; }
        td:nth-of-type(4):before { content: "Keterangan"; }
        td:nth-of-type(5):before { content: "Pengaju"; }
        td:nth-of-type(6):before { content: "Tanggal"; }
        td:nth-of-type(7):before { content: "Status"; }
        td:nth-of-type(8):before { content: "Aksi"; }
    }

    /* Simpanan Details View (for viewSimpanan function) */
    .simpanan-details {
        padding: 0.5rem;
    }

    .simpanan-details .form-group {
        margin-bottom: 1rem;
    }

    .simpanan-details label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-secondary);
        margin-bottom: 0.4rem;
    }

    .simpanan-details .form-control-static {
        font-size: 1rem;
        color: var(--text-primary);
        padding: 0.625rem 1rem;
        background: var(--background);
        border-radius: 0.375rem;
        min-height: 2.5rem;
        display: flex;
        align-items: center;
    }

    .simpanan-details .status-badge {
        display: inline-flex;
    }
</style>
@endpush

@push('scripts')
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
    import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";
    import {
        getFirestore, collection, doc, addDoc, updateDoc, deleteDoc,
        query, where, onSnapshot, getDoc, serverTimestamp, orderBy
    } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

    // Konfigurasi Firebase Anda - PASTIKAN INI SESUAI DENGAN PROYEK FIREBASE ANDA!
    const firebaseConfig = {
        apiKey: "AIzaSyAuq0JEjnEOagJnONPemkMP0bbgqepiFp8", // Ganti dengan API Key Anda
        authDomain: "koperasimahasiswaapp.firebaseapp.com", // Ganti dengan Auth Domain Anda
        projectId: "koperasimahasiswaapp", // Ganti dengan Project ID Anda
        storageBucket: "koperasimahasiswaapp.firebasestorage.app", 
        messagingSenderId: "812843080953",
        appId: "1:812843080953:web:9a931f89186182660bd628",
        measurementId: "G-ES6G76W66D"
    };

    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const db = getFirestore(app);

    // DOM Elements - PASTIKAN ID INI SESUAI DENGAN HTML ANDA
    const simpananTableBody = document.getElementById("simpananTableBody");
    const simpananModal = document.getElementById("simpananModal");
    const modalTitle = document.getElementById("modal-title");
    const jenisInput = document.getElementById("jenisInput"); 
    const jumlahInput = document.getElementById("jumlahInput"); 
    const ketInput = document.getElementById("ketInput"); 
    const simpananIdInput = document.getElementById("simpananId");
    const submitBtn = document.getElementById("submitBtn"); // Ini adalah button submit di dalam modal

    const totalSimpananEl = document.getElementById("totalSimpanan");
    const simpananApprovedEl = document.getElementById("simpananApproved");
    const simpananPendingEl = document.getElementById("simpananPending");

    const searchInput = document.getElementById("searchInput");
    const statusFilter = document.getElementById("statusFilter");
    const typeFilter = document.getElementById("typeFilter");
    const sortFilter = document.getElementById("sortFilter");

    let currentUid = null;
    let currentRole = "mahasiswa";
    let allSimpananData = [];

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

    // MODIFIED: getStatusBadge function to map Indonesian status to CSS classes and display
    const getStatusBadge = (status) => {
        let className = 'status-pending'; // Default class for 'Menunggu'
        let icon = 'hourglass-half'; // Default icon for 'Menunggu'
        let displayText = 'Menunggu'; // Default display text for 'Menunggu'

        // Map Firebase status values (Indonesian) to CSS classes and icons
        if (status === 'Disetujui') {
            className = 'status-approved';
            icon = 'check-circle';
            displayText = 'Disetujui';
        } else if (status === 'Menunggu') {
            className = 'status-pending';
            icon = 'hourglass-half';
            displayText = 'Menunggu';
        } else if (status === 'Ditolak') {
            className = 'status-rejected';
            icon = 'times-circle';
            displayText = 'Ditolak';
        }
        
        return `
            <span class="status-badge ${className}">
                <i class="fas fa-${icon}"></i>
                ${displayText}
            </span>
        `;
    };

    const getTypeBadge = (type) => {
        const typeClasses = {
            'wajib': 'badge-wajib',
            'sukarela': 'badge-sukarela'
        };
        const className = typeClasses[type] || 'badge-wajib';
        return `
            <span class="status-badge ${className}">
                ${type ? type.charAt(0).toUpperCase() + type.slice(1) : '-'}
            </span>
        `;
    };

    // Main data fetching and rendering function
    const loadSimpanan = async () => {
        try {
            const colRef = collection(db, "simpanan");
            const q = currentRole === "admin" 
                            ? query(colRef, orderBy("createdAt", "desc")) 
                            : query(colRef, where("userId", "==", currentUid), orderBy("createdAt", "desc"));

            onSnapshot(q, (snapshot) => {
                allSimpananData = [];
                let totalAmount = 0;
                let approvedCount = 0;
                let pendingCount = 0;

                snapshot.forEach((doc) => {
                    const data = { ...doc.data(), id: doc.id };
                    allSimpananData.push(data);
                    
                    const amount = parseFloat(data.jumlah) || 0;
                    const currentStatus = data.status; // Get the actual status string from Firebase

                    if (currentStatus === 'Disetujui') { 
                        totalAmount += amount;
                        approvedCount++;
                    } else if (currentStatus === 'Menunggu') { 
                        pendingCount++;
                    }
                });

                // Update the UI elements with calculated values
                totalSimpananEl.textContent = formatCurrency(totalAmount);
                simpananApprovedEl.textContent = approvedCount;
                simpananPendingEl.textContent = pendingCount;
                
                renderTable(); // Re-render table after updating stats
            }, (error) => { 
                console.error("Error listening to simpanan data:", error); 
                simpananTableBody.innerHTML = `<tr><td colspan="8" style="color: red;">Terjadi kesalahan saat memuat data simpanan. Mohon periksa konsol browser untuk detail.</td></tr>`; 
            });

        } catch (error) {
            console.error("Error loading simpanan data (catch outside onSnapshot):", error); 
            alert("Terjadi kesalahan saat memuat data simpanan: " + error.message);
        }
    };

    // Render table based on current filters and sort
    const renderTable = () => {
        let filteredAndSortedData = [...allSimpananData];

        // Apply Search Filter
        const searchTerm = searchInput.value.toLowerCase();
        if (searchTerm) {
            filteredAndSortedData = filteredAndSortedData.filter(d => 
                (d.keterangan && d.keterangan.toLowerCase().includes(searchTerm)) ||
                (d.userEmail && d.userEmail.toLowerCase().includes(searchTerm)) || 
                (d.jenis && d.jenis.toLowerCase().includes(searchTerm)) ||
                (d.jumlah && String(d.jumlah).includes(searchTerm))
            );
        }

        // Apply Status Filter - MODIFIED to use Indonesian status strings
        const selectedStatus = statusFilter.value;
        if (selectedStatus) {
            filteredAndSortedData = filteredAndSortedData.filter(d => d.status === selectedStatus);
        }

        // Apply Type Filter
        const selectedType = typeFilter.value;
        if (selectedType) {
            filteredAndSortedData = filteredAndSortedData.filter(d => d.jenis === selectedType);
        }

        // Apply Sort
        const selectedSort = sortFilter.value;
        filteredAndSortedData.sort((a, b) => {
            if (selectedSort === 'amount-high') {
                return (b.jumlah || 0) - (a.jumlah || 0);
            } else if (selectedSort === 'amount-low') {
                return (a.jumlah || 0) - (b.jumlah || 0);
            } else if (selectedSort === 'date-asc') {
                const dateA = a.createdAt?.seconds || 0;
                const dateB = b.createdAt?.seconds || 0;
                return dateA - dateB;
            } else { // 'date-desc' (default)
                const dateA = a.createdAt?.seconds || 0;
                const dateB = b.createdAt?.seconds || 0;
                return dateB - dateA;
            }
        });

        let html = "";
        if (filteredAndSortedData.length === 0) {
            html = `<tr><td colspan="8" style="text-align: center;">Tidak ada data simpanan yang cocok.</td></tr>`; 
        } else {
            filteredAndSortedData.forEach((d, index) => {
                html += rowTemplate(d, index + 1);
            });
        }
        simpananTableBody.innerHTML = html;
    };

    // Table row template
    function rowTemplate(d, i) {
        return `
            <tr>
                <td data-label="No">${i}</td>
                <td data-label="Jenis">${getTypeBadge(d.jenis)}</td>
                <td data-label="Jumlah">${formatCurrency(d.jumlah)}</td>
                <td data-label="Keterangan" class="keterangan-cell">${d.keterangan || '-'}</td>
                <td data-label="Pengaju">${d.userEmail || '-'}</td>
                <td data-label="Tanggal">${formatDate(d.createdAt || d.tanggal)}</td>
                <td data-label="Status">${getStatusBadge(d.status || 'Menunggu')}</td>
                <td data-label="Aksi">
                    <div class="action-buttons">
                        ${currentRole === "admin" ? `
                            <button class="btn-action" onclick="window.editSimpanan('${d.id}')" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-action" onclick="window.toggleStatus('${d.id}', '${d.status || 'Menunggu'}')" title="Ubah Status">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        ` : `
                            <button class="btn-action" onclick="window.viewSimpanan('${d.id}')" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                        `}
                        <button class="btn-action" onclick="window.deleteSimpanan('${d.id}')" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
    }

    // Handle Form Submission (Add/Edit Simpanan)
    window.handleSubmitSimpanan = async (event) => {
        event.preventDefault();
        
        // RE-GET submitBtn reference after potential modal recreation by openModal
        const currentSubmitBtn = document.getElementById("submitBtn"); 
        if (currentSubmitBtn) {
            currentSubmitBtn.disabled = true;
            currentSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        }

        // RE-GET input references here to ensure they point to the currently active modal elements
        const currentJumlahInput = document.getElementById("jumlahInput");
        const currentJenisInput = document.getElementById("jenisInput");
        const currentKetInput = document.getElementById("ketInput");
        const currentSimpananIdInput = document.getElementById("simpananId");


        const nominal = Number(currentJumlahInput.value); 
        if (isNaN(nominal) || nominal < 1000) {
            alert("Jumlah simpanan minimal Rp 1.000");
            if (currentSubmitBtn) {
                currentSubmitBtn.disabled = false;
                currentSubmitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Simpan';
            }
            return;
        }

        const payloadDasar = {
            userId: currentUid,
            userEmail: auth.currentUser.email,
            jumlah: nominal,
            jenis: currentJenisInput.value, 
            keterangan: currentKetInput.value.trim(), 
            tanggal: new Date().toISOString().slice(0, 10), 
            createdAt: serverTimestamp(),
        };

        try {
            const simpananId = currentSimpananIdInput.value;
            if (simpananId) {
                let updatedPayload = { ...payloadDasar, updatedAt: serverTimestamp() };
                
                const existingDoc = await getDoc(doc(db, "simpanan", simpananId));
                if (existingDoc.exists()) {
                    updatedPayload.status = existingDoc.data().status;
                } else {
                    updatedPayload.status = 'Menunggu'; 
                }
                
                await updateDoc(doc(db, "simpanan", simpananId), updatedPayload);
                alert("Simpanan berhasil diperbarui!");
            } else {
                await addDoc(collection(db, "simpanan"), { ...payloadDasar, status: 'Menunggu' }); 
                alert("Simpanan berhasil ditambahkan!");
            }
            closeModal();
        } catch (error) {
            console.error("Error saving simpanan:", error);
            alert("Terjadi kesalahan saat menyimpan simpanan: " + error.message);
        } finally {
            if (currentSubmitBtn) {
                currentSubmitBtn.disabled = false;
                currentSubmitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Simpan';
            }
        }
    };

    // Open/Close Modal
    window.openModal = async (data = null) => {
        simpananModal.classList.add("show");
        const modalBody = simpananModal.querySelector('.modal-body');
        
        // Reconstruct the form content dynamically
        modalBody.innerHTML = `
            <form id="simpananForm" onsubmit="handleSubmitSimpanan(event)">
                <input type="hidden" id="simpananId" name="simpananId">
                
                <div class="form-group">
                    <label for="jenisInput">Jenis Simpanan</label>
                    <select class="form-select" id="jenisInput" name="jenis" required>
                        <option value="wajib">Wajib</option>
                        <option value="sukarela">Sukarela</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jumlahInput">Jumlah Simpanan</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control" id="jumlahInput" name="jumlah" 
                                required min="1000" step="1000" placeholder="Minimal Rp 1.000">
                    </div>
                    <div class="form-text">Minimal Rp 1.000</div>
                </div>

                <div class="form-group">
                    <label for="ketInput">Keterangan</label>
                    <textarea class="form-control" id="ketInput" name="keterangan" 
                                rows="3" placeholder="Contoh: Pembayaran iuran bulan Juni" required></textarea>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-primary-form" id="submitBtn">
                        <i class="fas fa-paper-plane"></i>
                        <span>Simpan</span>
                    </button>
                </div>
            </form>
        `;

        // RE-GET DOM elements after innerHTML has been set, important for dynamic content
        const re_jenisInput = document.getElementById("jenisInput");
        const re_jumlahInput = document.getElementById("jumlahInput");
        const re_ketInput = document.getElementById("ketInput");
        const re_simpananIdInput = document.getElementById("simpananId");
        const re_submitBtn = document.getElementById('submitBtn');
        
        // Re-attach event listener for the new submit button instance
        if (re_submitBtn) { 
            re_submitBtn.onclick = handleSubmitSimpanan;
        }

        if (data) {
            modalTitle.textContent = "Edit Simpanan";
            re_simpananIdInput.value = data.id;
            re_jenisInput.value = data.jenis;
            re_jumlahInput.value = data.jumlah;
            re_ketInput.value = data.keterangan || "";
        } else {
            modalTitle.textContent = "Tambah Simpanan Baru";
            re_simpananIdInput.value = "";
            re_jenisInput.value = "wajib"; // Default for new
            re_jumlahInput.value = "";
            re_ketInput.value = "";
        }
    };

    window.closeModal = () => {
        simpananModal.classList.remove("show");
        // Only reset the form if it exists and is visible (not in view mode)
        const form = document.getElementById('simpananForm');
        if (form) { 
             form.reset();
             document.getElementById('simpananId').value = '';
        }
    };

    // Edit Simpanan (for Admin role or Menunggu status)
    window.editSimpanan = async (id) => {
        const snap = await getDoc(doc(db, "simpanan", id));
        if (!snap.exists()) {
            alert("Data simpanan tidak ditemukan.");
            return;
        }
        const data = snap.data();
        // Memungkinkan edit hanya jika admin atau jika status Menunggu
        if (currentRole !== "admin" && data.status !== "Menunggu") {
            alert("Hanya simpanan dengan status 'Menunggu' yang bisa diedit oleh mahasiswa.");
            return;
        }
        openModal({ id, ...data });
    };

    // View Simpanan Details
    window.viewSimpanan = async (id) => {
        try {
            const docRef = doc(db, "simpanan", id);
            const docSnap = await getDoc(docRef);
            
            if (docSnap.exists()) {
                const simpanan = docSnap.data();
                
                const form = document.getElementById('simpananForm');
                const modalBody = simpananModal.querySelector('.modal-body');
                const modalFooter = simpananModal.querySelector('.modal-footer');
                
                if (form) form.style.display = 'none'; // Hide the form
                
                modalTitle.textContent = 'Detail Simpanan';
                modalBody.innerHTML = `
                    <div class="simpanan-details">
                        <div class="form-group">
                            <label>Jenis Simpanan</label>
                            <div class="form-control-static">${getTypeBadge(simpanan.jenis)}</div>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Simpanan</label>
                            <div class="form-control-static">${formatCurrency(simpanan.jumlah || 0)}</div>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <div class="form-control-static">${simpanan.keterangan || '-'}</div>
                        </div>
                        <div class="form-group">
                            <label>Pengaju</label>
                            <div class="form-control-static">${simpanan.userEmail || '-'}</div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pengajuan</label>
                            <div class="form-control-static">${formatDate(simpanan.createdAt || simpanan.tanggal)}</div>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <div class="form-control-static">${getStatusBadge(simpanan.status || 'Menunggu')}</div>
                        </div>
                    </div>
                `;

                modalFooter.innerHTML = `
                    <button type="button" class="btn-secondary" onclick="closeModal()">Tutup</button>
                `;
                
                simpananModal.classList.add('show');
            } else {
                throw new Error('Data simpanan tidak ditemukan.');
            }
        } catch (error) {
            console.error("Error viewing simpanan:", error);
            alert("Terjadi kesalahan saat memuat detail simpanan.");
        }
    };

    // Delete Simpanan
    window.deleteSimpanan = async (id) => {
        if (confirm("Apakah Anda yakin ingin menghapus simpanan ini?")) {
            try {
                await deleteDoc(doc(db, "simpanan", id));
                alert("Simpanan berhasil dihapus.");
            } catch (error) {
                console.error("Error deleting simpanan:", error);
                alert("Terjadi kesalahan saat menghapus simpanan.");
            }
        }
    };

    // Toggle Status (Admin Only)
    window.toggleStatus = async (id, currentStatus) => {
        if (currentRole !== "admin") {
            alert("Anda tidak memiliki izin untuk mengubah status.");
            return;
        }

        let nextStatusValueForDB; 
        let alertMessageStatus;   

        // Cycle through statuses: Menunggu -> Disetujui -> Ditolak -> Menunggu
        if (currentStatus === "Menunggu") {
            nextStatusValueForDB = "Disetujui";
            alertMessageStatus = "Disetujui";
        } else if (currentStatus === "Disetujui") {
            nextStatusValueForDB = "Ditolak";
            alertMessageStatus = "Ditolak";
        } else { // If currentStatus is 'Ditolak' or anything unexpected, go back to 'Menunggu'
            nextStatusValueForDB = "Menunggu";
            alertMessageStatus = "Menunggu";
        }

        try {
            await updateDoc(doc(db, "simpanan", id), { status: nextStatusValueForDB, updatedAt: serverTimestamp() });
            alert(`Status simpanan berhasil diubah menjadi: ${alertMessageStatus}`);
        } catch (error) {
            console.error("Error toggling status:", error);
            alert("Terjadi kesalahan saat mengubah status simpanan.");
        }
    };

    // Initialize listeners for search and filters
    const setupSearchAndFilterListeners = () => {
        searchInput.addEventListener('input', renderTable);
        
        const statusFilterElement = document.getElementById("statusFilter");
        if (statusFilterElement) {
            statusFilterElement.addEventListener('change', renderTable);
        }
        typeFilter.addEventListener('change', renderTable);
        sortFilter.addEventListener('change', renderTable);
    };

    // Initial load on authentication state change
    onAuthStateChanged(auth, async (user) => {
        if (user) {
            currentUid = user.uid;
            // Fetch user role from 'users' collection to determine permissions
            const usrSnap = await getDoc(doc(db, "users", currentUid));
            if (usrSnap.exists()) {
                currentRole = usrSnap.data().role || "mahasiswa";
            }
            loadSimpanan(); // Call loadSimpanan to fetch and display data
            setupSearchAndFilterListeners();
        } else {
            window.location.href = "/login"; // Redirect if not authenticated
        }
    });

    // Event listener for modal transition end to reset form
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('simpananModal');
        modal.addEventListener('transitionend', (e) => {
            if (!modal.classList.contains('show') && e.propertyName === 'opacity') {
                const form = document.getElementById('simpananForm');
                if (form) { 
                    form.reset();
                    document.getElementById('simpananId').value = '';
                }
            }
        });
    });
</script>
@endpush