@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* General Styling - Menggabungkan dari kedua tema, prioritas tema Poppins */
        :root {
            --primary-color: #065f46; /* Hijau utama */
            --primary-dark: #065f46; /* Sedikit lebih gelap dari primary */
            --primary-light: #d1fae5; /* Sangat terang dari primary, untuk background aktif */
            --secondary-color: #f9fafb; /* Kuning Cerah (dipertahankan untuk aksen kontras) */
            
            --text-color: #1f2937; /* Teks gelap */
            --light-bg: #f9fafb; /* Background utama konten yang lebih terang */
            --white: #fff;
            --border-color: #e5e7eb; /* Warna border yang lebih netral */
            --text-secondary-color: #6b7280; /* Warna teks sekunder */
            --surface-color: #ffffff; /* Untuk background card/sidebar */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Perhatian: Style 'body' ini mungkin akan ditimpa oleh layout.app Anda */
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--light-bg);
            min-height: 100vh;
            display: flex; /* Untuk layout sidebar-main-content */
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        a {
            text-decoration: none;
            color: var(--primary-color);
        }

        ul {
            list-style: none;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
            border: 2px solid var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            border: 2px solid var(--secondary-color);
        }

        .btn-secondary:hover {
            background-color: var(--primary-color);
            color: var(--white);
            border-color: var(--primary-color);
        }

        .logout-btn {
            padding: 0.5rem 1rem;
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            color: var(--text-color);
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
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Sidebar Styling */
        .sidebar {
            width: 280px;
            background: var(--surface-color);
            border-right: 1px solid var(--border-color);
            height: 100vh;
            position: fixed;
            padding: 2rem 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
        }

        .sidebar-header {
            padding: 0 2rem 2rem;
            border-bottom: 1px solid var(--border-color);
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
            color: var(--primary-color);
        }

        .nav-menu {
            padding: 2rem 1rem;
            flex: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--text-secondary-color);
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
            color: var(--primary-color);
        }

        .nav-item.active {
            background: var(--primary-light);
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Main Content Area */
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
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-email {
            color: var(--text-color);
            font-weight: 500;
        }

        /* Hero Slider Section */
        .hero-slider-section {
            position: relative;
            width: 100%;
            height: 400px;
            overflow: hidden;
            border-radius: 0.75rem;
            margin-top: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            background-color: var(--surface-color);
        }

        .slider-container {
            display: flex;
            height: 100%;
            transition: transform 0.8s ease-in-out;
        }

        .slider-item {
            min-width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex-shrink: 0;
            padding: 40px;
            background-size: cover;
            background-position: center;
            color: var(--white);
            position: relative;
        }

        .slider-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Dark overlay */
            z-index: 1;
        }

        .slider-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
        }

        .slider-content h2 {
            font-size: 2.8rem;
            margin-bottom: 15px;
            font-weight: 700;
            color: var(--white);
        }

        .slider-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: var(--white);
            opacity: 0.9;
        }

        .slider-content .btn {
            padding: 12px 30px;
            font-size: 1.1rem;
        }

        /* Slide specific backgrounds - Menggunakan path relatif untuk Laravel */
        .slide-1 {
            background-image: url('{{ asset('images/tangan.jpg') }}');
        }
        .slide-2 {
            background-image: url('{{ asset('images/babi.jpg') }}');
        }
        .slide-3 {
            background-image: url('{{ asset('images/join.jpg') }}');
        }

        /* Pagination Dots */
        .slider-dots {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 3;
        }

        .dot {
            width: 12px;
            height: 12px;
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .dot.active {
            background-color: var(--secondary-color); /* Aksen kuning cerah untuk dot aktif */
            transform: scale(1.2);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
            text-align: center;
            padding: 60px 20px;
            border-radius: 0.75rem;
            margin-top: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .cta-section h2 {
            font-size: 2.2rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .cta-section p {
            font-size: 1rem;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-primary-outline {
            background-color: transparent;
            color: var(--white);
            border: 2px solid var(--white);
        }

        .btn-primary-outline:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            border: 2px solid var(--secondary-color);
        }

        /* Footer */
        .main-footer {
            background-color: var(--primary-dark);
            color: var(--white);
            padding: 40px 0 20px;
            font-size: 0.85rem;
            margin-top: 2rem;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 -5px 15px rgba(0,0,0,0.1);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 30px;
        }

        .footer-col h3 {
            font-size: 1.1rem;
            color: var(--secondary-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .footer-col ul li {
            margin-bottom: 8px;
        }

        .footer-col ul li a {
            color: var(--white);
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .footer-col ul li a:hover {
            opacity: 1;
            color: var(--secondary-color);
        }

        .footer-col p {
            margin-bottom: 8px;
            line-height: 1.6;
            opacity: 0.8;
        }

        .footer-col p i {
            margin-right: 8px;
            color: var(--secondary-color);
        }

        .logo-col img {
            height: 45px;
            margin-bottom: 8px;
        }

        .logo-col p:first-of-type {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .social-icons a {
            color: var(--white);
            font-size: 1.4rem;
            margin-right: 12px;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: var(--secondary-color);
        }


        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                width: 5rem;
                padding: 1.5rem 0;
            }

            .sidebar-header {
                padding: 0 1rem 1.5rem;
            }

            .brand-name {
                display: none;
            }

            .nav-item span {
                display: none;
            }

            .main-content {
                margin-left: 5rem;
                padding: 1.5rem;
            }

            .hero-slider-section {
                height: 300px;
            }

            .slider-content h2 {
                font-size: 2.2rem;
            }

            .slider-content p {
                font-size: 1rem;
            }
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
                padding: 1rem 0;
            }

            .sidebar-header {
                padding: 0 1rem 1rem;
                border-bottom: none;
                text-align: center;
            }

            .brand-name {
                display: inline-block;
            }

            .nav-menu {
                padding: 1rem;
            }

            .nav-menu ul {
                 display: flex;
                 flex-wrap: wrap;
                 justify-content: center;
                 gap: 10px;
            }

            .nav-item {
                justify-content: center;
                flex: 1 1 auto;
                max-width: 150px;
            }

            .nav-item span {
                display: block;
                font-size: 0.8rem;
                margin-top: 5px;
            }

            .nav-item i {
                margin-right: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 1.5rem;
            }

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 1.5rem;
            }

            .page-title {
                margin-bottom: 1rem;
            }

            .hero-slider-section {
                height: 250px;
                padding: 20px;
            }

            .slider-content h2 {
                font-size: 1.8rem;
            }
            .slider-content p {
                font-size: 0.9rem;
            }

            .cta-section h2 {
                font-size: 1.8rem;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .social-icons {
                margin-top: 15px;
            }
        }

        @media (max-width: 480px) {
            .hero-slider-section {
                height: 200px;
            }
            .slider-content h2 {
                font-size: 1.5rem;
            }
            .slider-content p {
                font-size: 0.8rem;
            }
            .slider-content .btn {
                padding: 8px 20px;
                font-size: 0.9rem;
            }
        }
    </style>
@endpush

@section('content')
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="logo-container">
          <img src="{{ asset('images/logokopma.png') }}" alt="Logo Koperasi">
          <span class="brand-name">KOPMA</span>
        </div>
      </div>

      <nav class="nav-menu">
        <a href="{{ url('/dashboard') }}" class="nav-item active">
          <i class="fas fa-home"></i>
          <span>Dashboard</span>
        </a>
        <a href="{{ url('/pinjaman') }}" class="nav-item">
          <i class="fas fa-hand-holding-usd"></i>
          <span>Pinjaman</span>
        </a>
        <a href="{{ url('/simpanan') }}" class="nav-item">
          <i class="fas fa-piggy-bank"></i>
          <span>Simpanan</span>
        </a>
        <a href="{{ url('/profil') }}" class="nav-item">
          <i class="fas fa-user"></i>
          <span>Profil</span>
        </a>
        <a href="{{ url('/feedback') }}" class="nav-item">
          <i class="fas fa-comments"></i>
          <span>Feedback</span>
        </a>
        <a href="{{ url('/about') }}" class="nav-item">
          <i class="fas fa-info-circle"></i>
          <span>Tentang</span>
        </a>
      </nav>
    </aside>

        <section class="hero-slider-section">
            <div class="slider-container" id="sliderContainer">
                <div class="slider-item slide-1">
                    <div class="slider-content">
                        <h2>Ajukan Pinjaman Mahasiswa Cepat</h2>
                        <p>Dapatkan dukungan finansial untuk studimu dengan proses yang mudah dan cepat dari KOPMA.</p>
                        </div>
                </div>
                <div class="slider-item slide-2">
                    <div class="slider-content">
                        <h2>Mulai Simpanan Masa Depanmu</h2>
                        <p>Investasikan dan kembangkan dana Anda dengan berbagai pilihan simpanan yang aman dan menguntungkan.</p>
                        </div>
                </div>
                <div class="slider-item slide-3">
                    <div class="slider-content">
                        <h2>Jadilah Bagian dari Komunitas KOPMA</h2>
                        <p>Bergabunglah dengan ribuan mahasiswa lainnya dan dapatkan manfaat eksklusif sebagai anggota.</p>
                        </div>
                </div>
            </div>
            <div class="slider-dots" id="sliderDots">
                </div>
        </section>

        <footer class="main-footer">
            <div class="container footer-grid">
                <div class="footer-col logo-col">
                    <img src="{{ asset('images/logokopma.png') }}" alt="Logo KOPMA">
                    <p>KOPMA Universitas Telkom Purwokerto</p>
                    <p>&copy; 2025 KOPMA Hak Cipta Dilindungi.</p>
                </div>
                <div class="footer-col">
                    <h3>Informasi Kontak</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Jalan jalan ke bangladesh</p>
                    <p><i class="fas fa-envelope"></i> info@kopma-universitas.ac.id</p>
                    <p><i class="fas fa-phone"></i> (021) 12345678</p>
                </div>
                <div class="footer-col">
                    <h3>Ikuti Kami</h3>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </footer>
    </main>
@endsection

@push('scripts')
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";
        import { getFirestore, doc, getDoc, collection, query, orderBy, limit, getDocs, where } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

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

        // Firebase Auth State Listener
        onAuthStateChanged(auth, async (user) => {
            if (user) {
                document.getElementById('user-email').textContent = user.email;
                const userDoc = await getDoc(doc(db, "users", user.uid));
                const userData = userDoc.exists() ? userDoc.data() : {};
                const role = userData.role || "mahasiswa";

                const simpananQuery = query(collection(db, "simpanan"), where("userId", "==", user.uid));
                const simpananSnapshot = await getDocs(simpananQuery);
                let totalSimpanan = 0;
                simpananSnapshot.docs.forEach(doc => {
                    const data = doc.data();
                    if (data.status === 'Disetujui') {
                        totalSimpanan += (parseFloat(data.jumlah) || 0);
                    }
                });

                const pinjamanQuery = query(collection(db, "pinjaman"), where("userId", "==", user.uid));
                const pinjamanSnapshot = await getDocs(pinjamanQuery);
                let aktifCount = 0;
                pinjamanSnapshot.docs.forEach(doc => {
                    const status = doc.data().status;
                    if (status === 'Diterima') {
                        aktifCount++;
                    }
                });

            } else {
                window.location.href = "{{ url('/login') }}"; // Menggunakan url() untuk login
            }
        });

        window.logout = function() {
            signOut(auth).then(() => {
                localStorage.clear();
                window.location.href = "{{ url('/login') }}"; // Menggunakan url() untuk login
            }).catch((error) => {
                console.error("Logout gagal:", error);
            });
        };

        // Slider Functionality
        const sliderContainer = document.getElementById('sliderContainer');
        const sliderItems = document.querySelectorAll('.slider-item');
        const sliderDotsContainer = document.getElementById('sliderDots');
        let currentIndex = 0;
        const slideInterval = 5000; // 5 seconds

        function createDots() {
            sliderItems.forEach((_, index) => {
                const dot = document.createElement('div');
                dot.classList.add('dot');
                if (index === 0) {
                    dot.classList.add('active');
                }
                dot.addEventListener('click', () => goToSlide(index));
                sliderDotsContainer.appendChild(dot);
            });
        }

        function updateDots() {
            const dots = document.querySelectorAll('.dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentIndex);
            });
        }

        function goToSlide(index) {
            currentIndex = index;
            const offset = -currentIndex * 100;
            sliderContainer.style.transform = `translateX(${offset}%)`;
            updateDots();
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % sliderItems.length;
            goToSlide(currentIndex);
        }

        // Initialize slider
        createDots();
        setInterval(nextSlide, slideInterval);
    </script>
@endpush