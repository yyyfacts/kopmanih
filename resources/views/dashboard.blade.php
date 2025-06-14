<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Koperasi Mahasiswa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --primary: #1a5f7a;
      --primary-dark: #0f4c64;
      --primary-light: #e8f4f8;
      --secondary: #64748b;
      --success: #10b981;
      --danger: #ef4444;
      --warning: #f59e0b;
      --background: #f8fafc;
      --surface: #ffffff;
      --text: #0f172a;
      --text-secondary: #475569;
      --border: #e2e8f0;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--background);
      color: var(--text);
      line-height: 1.5;
      min-height: 100vh;
      display: flex;
    }

    .sidebar {
      width: 280px;
      background: var(--surface);
      border-right: 1px solid var(--border);
      height: 100vh;
      position: fixed;
      padding: 2rem 0;
      display: flex;
      flex-direction: column;
    }

    .sidebar-header {
      padding: 0 2rem 2rem;
      border-bottom: 1px solid var(--border);
    }

    .logo-container {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .logo-container img {
      height: 40px;
      width: auto;
    }

    .brand-name {
      font-size: 1.25rem;
      font-weight: 600;
      color: var(--primary);
    }

    .nav-menu {
      padding: 2rem 1rem;
      flex: 1;
    }

    .nav-item {
      display: flex;
      align-items: center;
      padding: 0.75rem 1rem;
      color: var(--text-secondary);
      text-decoration: none;
      border-radius: 0.5rem;
      margin-bottom: 0.5rem;
      transition: all 0.2s;
    }

    .nav-item i {
      width: 1.5rem;
      margin-right: 0.75rem;
    }

    .nav-item:hover {
      background: var(--primary-light);
      color: var(--primary);
    }

    .nav-item.active {
      background: var(--primary-light);
      color: var(--primary);
      font-weight: 500;
    }

    .main-content {
      flex: 1;
      margin-left: 280px;
      padding: 2rem;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }

    .page-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--text);
    }

    .user-menu {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .logout-btn {
      padding: 0.5rem 1rem;
      background: var(--surface);
      border: 1px solid var(--border);
      color: var(--text);
      border-radius: 0.5rem;
      cursor: pointer;
      font-size: 0.875rem;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.2s;
    }

    .logout-btn:hover {
      background: var(--primary-light);
      color: var(--primary);
      border-color: var(--primary);
    }

    .dashboard-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .stat-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 0.75rem;
      padding: 1.5rem;
    }

    .stat-header {
      display: flex;
      justify-content: space-between;
      align-items: start;
      margin-bottom: 1rem;
    }

    .stat-title {
      color: var(--text-secondary);
      font-size: 0.875rem;
      font-weight: 500;
    }

    .stat-icon {
      width: 2.5rem;
      height: 2.5rem;
      background: var(--primary-light);
      color: var(--primary);
      border-radius: 0.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .stat-value {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--text);
      margin-bottom: 0.25rem;
    }

    .stat-description {
      font-size: 0.875rem;
      color: var(--text-secondary);
    }

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
    }

    .card-title {
      font-size: 1rem;
      font-weight: 600;
      color: var(--text);
    }

    .transaction-list {
      padding: 1rem 1.5rem;
    }

    .transaction-item {
      display: flex;
      align-items: center;
      padding: 1rem 0;
      border-bottom: 1px solid var(--border);
    }

    .transaction-item:last-child {
      border-bottom: none;
    }

    .transaction-icon {
      width: 2.5rem;
      height: 2.5rem;
      background: var(--primary-light);
      color: var(--primary);
      border-radius: 0.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 1rem;
    }

    .transaction-info {
      flex: 1;
    }

    .transaction-title {
      font-weight: 500;
      color: var(--text);
      margin-bottom: 0.25rem;
    }

    .transaction-date {
      font-size: 0.875rem;
      color: var(--text-secondary);
    }

    .transaction-amount {
      font-weight: 600;
      color: var(--primary);
    }

    @media (max-width: 1024px) {
      .sidebar {
        width: 5rem;
      }

      .sidebar-header {
        padding: 0 1rem 2rem;
      }

      .brand-name {
        display: none;
      }

      .nav-item span {
        display: none;
      }

      .main-content {
        margin-left: 5rem;
      }

      .dashboard-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 768px) {
      .dashboard-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="logo-container">
          <img src="{{ asset('images/logokopma.png') }}" alt="Logo Koperasi">
          <span class="brand-name">KOPMA</span>
        </div>
      </div>

      <nav class="nav-menu">
        <a href="/dashboard" class="nav-item active">
          <i class="fas fa-home"></i>
          <span>Dashboard</span>
        </a>
        <a href="/pinjaman" class="nav-item">
          <i class="fas fa-hand-holding-usd"></i>
          <span>Pinjaman</span>
        </a>
        <a href="/simpanan" class="nav-item">
          <i class="fas fa-piggy-bank"></i>
          <span>Simpanan</span>
        </a>
        <a href="/profil" class="nav-item">
          <i class="fas fa-user"></i>
          <span>Profil</span>
        </a>
        <a href="/feedback" class="nav-item">
          <i class="fas fa-comments"></i>
          <span>Feedback</span>
        </a>
        <a href="/about" class="nav-item">
          <i class="fas fa-info-circle"></i>
          <span>Tentang</span>
        </a>
      </nav>
    </aside>

    <main class="main-content">
      <div class="top-bar">
        <h1 class="page-title">Dashboard</h1>
        <div class="user-menu">
          <span id="user-email" class="user-email">Memuat...</span>
          <button class="logout-btn" onclick="logout()">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
          </button>
        </div>
      </div>

      <div class="dashboard-grid">
        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-title">Total Simpanan</div>
            <div class="stat-icon">
              <i class="fas fa-wallet"></i>
            </div>
          </div>
          <div class="stat-value" id="total-simpanan">Rp 0</div>
          <div class="stat-description">Total simpanan Anda saat ini</div>
        </div>

        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-title">Pinjaman Aktif</div>
            <div class="stat-icon">
              <i class="fas fa-credit-card"></i>
            </div>
          </div>
          <div class="stat-value" id="pinjaman-aktif">0</div>
          <div class="stat-description">Jumlah pinjaman yang sedang berjalan</div>
        </div>

        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-title">Status Keanggotaan</div>
            <div class="stat-icon">
              <i class="fas fa-user-check"></i>
            </div>
          </div>
          <div class="stat-value" id="user-role">-</div>
          <div class="stat-description">Status keanggotaan Anda</div>
        </div>
      </div>

      <div class="content-card">
        <div class="card-header">
          <h2 class="card-title">Transaksi Terbaru</h2>
          <div class="card-actions">
            <button class="logout-btn">
              <i class="fas fa-sync-alt"></i>
              <span>Refresh</span>
            </button>
          </div>
        </div>
        <div class="transaction-list" id="transaction-list">
          <!-- Transactions will be inserted here -->
        </div>
      </div>
    </main>

    <script type="module">
      import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
      import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";
      import { getFirestore, doc, getDoc, collection, query, orderBy, limit, getDocs } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

      const firebaseConfig = {
        apiKey: "AIzaSyAuq0JEjnEOagJnONPemkMP0bbgqepiFp8",
        authDomain: "koperasimahasiswaapp.firebaseapp.com",
        projectId: "koperasimahasiswaapp",
        storageBucket: "koperasimahasiswaapp.appspot.com",
        messagingSenderId: "812843080953",
        appId: "1:812843080953:web:9a931f89186182660bd628"
      };

      const app = initializeApp(firebaseConfig);
      const auth = getAuth(app);
      const db = getFirestore(app);

      // Format currency
      const formatCurrency = (amount) => {
        return new Intl.NumberFormat('id-ID', {
          style: 'currency',
          currency: 'IDR',
          minimumFractionDigits: 0,
          maximumFractionDigits: 0
        }).format(amount);
      };

      // Format date
      const formatDate = (date) => {
        return new Intl.DateTimeFormat('id-ID', {
          day: 'numeric',
          month: 'long',
          year: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        }).format(date);
      };

      onAuthStateChanged(auth, async (user) => {
        if (user) {
          document.getElementById('user-email').textContent = user.email;

          // Get user data and role
          const userDoc = await getDoc(doc(db, "users", user.uid));
          const userData = userDoc.exists() ? userDoc.data() : {};
          const role = userData.role || "mahasiswa";
          document.getElementById('user-role').textContent = role.charAt(0).toUpperCase() + role.slice(1);

          // Get total simpanan
          const simpananQuery = query(
            collection(db, "simpanan"),
            where("userId", "==", user.uid)
          );
          const simpananSnapshot = await getDocs(simpananQuery);
          const totalSimpanan = simpananSnapshot.docs.reduce((sum, doc) => {
            return sum + (doc.data().jumlah || 0);
          }, 0);
          document.getElementById('total-simpanan').textContent = formatCurrency(totalSimpanan);

          // Get active pinjaman
          const pinjamanQuery = query(
            collection(db, "pinjaman"),
            where("userId", "==", user.uid),
            where("status", "==", "active")
          );
          const pinjamanSnapshot = await getDocs(pinjamanQuery);
          document.getElementById('pinjaman-aktif').textContent = pinjamanSnapshot.docs.length;

          // Load recent transactions
          const transaksiRef = collection(db, "transaksi");
          const q = query(transaksiRef, orderBy("tanggal", "desc"), limit(5));
          const snapshot = await getDocs(q);

          const transactionList = document.getElementById('transaction-list');
          transactionList.innerHTML = "";

          if (snapshot.empty) {
            transactionList.innerHTML = `
              <div class="transaction-item">
                <div class="transaction-icon">
                  <i class="fas fa-info-circle"></i>
                </div>
                <div class="transaction-info">
                  <div class="transaction-title">Belum ada transaksi</div>
                  <div class="transaction-date">Tidak ada data transaksi untuk ditampilkan</div>
                </div>
              </div>
            `;
          } else {
            snapshot.forEach(doc => {
              const data = doc.data();
              const date = new Date(data.tanggal.seconds * 1000);
              
              const transactionHTML = `
                <div class="transaction-item">
                  <div class="transaction-icon">
                    <i class="fas ${data.type === 'simpanan' ? 'fa-piggy-bank' : 'fa-hand-holding-usd'}"></i>
                  </div>
                  <div class="transaction-info">
                    <div class="transaction-title">${data.nama}</div>
                    <div class="transaction-date">${formatDate(date)}</div>
                  </div>
                  <div class="transaction-amount">
                    ${formatCurrency(data.jumlah)}
                  </div>
                </div>
              `;
              transactionList.insertAdjacentHTML('beforeend', transactionHTML);
            });
          }
        } else {
          window.location.href = "/login";
        }
      });

      window.logout = function() {
        signOut(auth).then(() => {
          localStorage.clear();
          window.location.href = "/login";
        }).catch((error) => {
          console.error("Logout gagal:", error);
        });
      };
    </script>

</body>
</html>
