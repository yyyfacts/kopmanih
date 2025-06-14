<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Koperasi Mahasiswa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            background-color: #f3f4f6;
        }

        .split-screen {
            display: flex;
            width: 100%;
        }

        .left {
            flex: 1;
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }

        .left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M54.627 0l.83.828-1.415 1.415L51.8 0h2.827zM5.373 0l-.83.828L5.96 2.243 8.2 0H5.374zM48.97 0l3.657 3.657-1.414 1.414L46.143 0h2.828zM11.03 0L7.372 3.657 8.787 5.07 13.857 0H11.03zm32.284 0L49.8 6.485 48.384 7.9l-7.9-7.9h2.83zM16.686 0L10.2 6.485 11.616 7.9l7.9-7.9h-2.83zM22.343 0L13.8 8.544 15.214 9.96l9.9-9.96h-2.77zM32 0l-9.9 9.9 1.415 1.415L34.357 0H32zm-3.657 0l-8.486 8.485 1.415 1.415L30.7 0h-2.357zm-12.728 0l-6.364 6.364 1.414 1.414L23.8 0H15.615zM38 0l-1.414 1.414L40.97 5.8 42.384 4.385 38 0zm-6.656 0L28.97 2.374l1.414 1.415L34.8 0h-3.457zm-12.728 0l-2.374 2.374 1.414 1.415L21.8 0H18.615zM44 0l-1.414 1.414 3.414 3.414L47.414 3.4 44 0zm-6.656 0L34.97 2.374l1.414 1.415L40.8 0h-3.457zm-12.728 0l-2.374 2.374 1.414 1.415L27.8 0H24.615zM50 0l-1.414 1.414 1.414 1.414L51.414 1.4 50 0zm-6.656 0L40.97 2.374l1.414 1.415L46.8 0h-3.457zM32 0l-2.374 2.374 1.414 1.415L33.8 0H32zm12.728 0l-2.374 2.374 1.414 1.415L45.8 0H44.728zm-25.456 0l-2.374 2.374 1.414 1.415L21.8 0H19.272zm-6.656 0l-2.374 2.374 1.414 1.415L15.143 0h-2.457zM38 0l-2.374 2.374 1.414 1.415L39.8 0H38zm-6.656 0L28.97 2.374l1.414 1.415L33.8 0h-2.457zM25.272 0l-2.374 2.374 1.414 1.415L27.8 0h-2.528zm-6.656 0l-2.374 2.374 1.414 1.415L21.143 0h-2.457zM44 0l-2.374 2.374 1.414 1.415L45.8 0H44zm-6.656 0L34.97 2.374l1.414 1.415L39.8 0h-2.457zM31.272 0l-2.374 2.374 1.414 1.415L33.8 0h-2.528zm-6.656 0l-2.374 2.374 1.414 1.415L27.143 0h-2.457zM50 0l-2.374 2.374 1.414 1.415L51.8 0H50zm-6.656 0L40.97 2.374l1.414 1.415L45.8 0h-2.457zM37.272 0l-2.374 2.374 1.414 1.415L39.8 0h-2.528zm-6.656 0l-2.374 2.374 1.414 1.415L33.143 0h-2.457zM43.272 0l-2.374 2.374 1.414 1.415L45.8 0h-2.528zm-6.656 0l-2.374 2.374 1.414 1.415L39.143 0h-2.457z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        }

        .left-content {
            position: relative;
            z-index: 1;
        }

        .left-header {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 80px;
        }

        .logo-container {
            background: rgba(255, 255, 255, 0.12);
            padding: 16px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .logo-container:hover {
            background: rgba(255, 255, 255, 0.18);
            transform: translateY(-3px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }

        .left-header img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .left-header h2 {
            color: white;
            font-size: 32px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
            letter-spacing: -0.5px;
        }

        .brand-tagline {
            color: rgba(255, 255, 255, 0.95);
            font-size: 16px;
            font-weight: 500;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .hero-content {
            max-width: 480px;
        }

        .hero-content h1 {
            color: white;
            font-size: 40px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 24px;
        }

        .hero-content p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            line-height: 1.6;
        }

        .left-footer {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
        }

        .right {
            flex: 1;
            padding: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h2 {
            color: #111827;
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .login-header p {
            color: #6B7280;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            color: #374151;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            font-size: 18px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 12px 12px 48px;
            border: 2px solid #E5E7EB;
            border-radius: 8px;
            font-size: 15px;
            color: #1F2937;
            transition: all 0.2s;
            background: white;
        }

        .form-group input:focus {
            border-color: #047857;
            outline: none;
            box-shadow: 0 0 0 3px rgba(4, 120, 87, 0.1);
        }

        .form-group input::placeholder {
            color: #9CA3AF;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #047857;
        }

        .remember-me label {
            color: #4B5563;
            font-size: 14px;
        }

        .forgot-password {
            color: #047857;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: #065f46;
        }

        .auth-button {
            width: 100%;
            padding: 12px;
            background: #047857;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .auth-button:hover {
            background: #065f46;
        }

        .register-prompt {
            text-align: center;
            color: #4B5563;
            font-size: 14px;
        }

        .register-prompt a {
            color: #047857;
            font-weight: 600;
            text-decoration: none;
            margin-left: 4px;
        }

        .register-prompt a:hover {
            color: #065f46;
        }

        #error {
            display: none;
            background: #FEF2F2;
            border: 1px solid #FEE2E2;
            color: #DC2626;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 24px;
        }

        #error.visible {
            display: block;
        }

        @media (max-width: 1024px) {
            .split-screen {
                flex-direction: column;
            }

            .left {
                min-height: auto;
                padding: 32px;
            }

            .left-header {
                margin-bottom: 40px;
            }

            .hero-content {
                margin-bottom: 40px;
            }

            .hero-content h1 {
                font-size: 32px;
            }

            .right {
                padding: 32px;
            }

            .login-container {
                max-width: 400px;
            }
        }

        @media (max-width: 640px) {
            .left, .right {
                padding: 24px;
            }

            .hero-content h1 {
                font-size: 28px;
            }

            .login-header h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="split-screen">
        <div class="left">
            <div class="left-content">
                <div class="left-header">
                    <div class="logo-container">
                        <img src="{{ asset('images/logokopma.png') }}" alt="Logo Koperasi Mahasiswa">
                    </div>
                    <div class="brand-text">
                        <h2>Koperasi Mahasiswa</h2>
                        <span class="brand-tagline">Membangun Ekonomi Kampus</span>
                    </div>
                </div>
                <div class="hero-content">
                    <h1>Selamat datang di Portal Koperasi Mahasiswa</h1>
                    <p>Platform digital yang memudahkan anggota koperasi dalam mengelola simpanan, mengajukan pinjaman, dan mengakses berbagai layanan koperasi secara efisien.</p>
                </div>
            </div>
            <div class="left-footer">
                © {{ date('Y') }} Koperasi Mahasiswa. All rights reserved.
            </div>
        </div>

        <div class="right">
            <div class="login-container">
                <div class="login-header">
                    <h2>Masuk ke Akun Anda</h2>
                    <p>Silakan masukkan kredensial Anda untuk melanjutkan</p>
                </div>

                <form id="firebase-login-form">
                    <div id="error"></div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" required placeholder="nama@email.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" required placeholder="••••••••">
                        </div>
                    </div>

                    <div class="form-footer">
                        <div class="remember-me">
                            <input type="checkbox" id="rememberMe">
                            <label for="rememberMe">Ingat Saya</label>
                        </div>
                        <a href="{{ url('/forgot-password') }}" class="forgot-password">Lupa Password?</a>
                    </div>

                    <button type="submit" id="submit-btn" class="auth-button">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Masuk</span>
                    </button>

                    <div class="register-prompt">
                        Belum punya akun?<a href="{{ url('/register') }}">Daftar sekarang</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Firebase Script -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
        import { getAuth, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";
        import { getFirestore, doc, getDoc } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

        /* --- CONFIG --- */
        const firebaseConfig = {
          apiKey: "AIzaSyAuq0JEjnEOagJnONPemkMP0bbgqepiFp8",
          authDomain: "koperasimahasiswaapp.firebaseapp.com",
          projectId: "koperasimahasiswaapp",
          storageBucket: "koperasimahasiswaapp.appspot.com",
          messagingSenderId: "812843080953",
          appId: "1:812843080953:web:9a931f89186182660bd628",
          measurementId: "G-ES6G76W66D"
        };

        const app  = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db   = getFirestore(app);

        /* --- ELEMENTS --- */
        const form    = document.getElementById("firebase-login-form");
        const emailEl = document.getElementById("email");
        const passEl  = document.getElementById("password");
        const remember= document.getElementById("rememberMe");
        const errBox  = document.getElementById("error");
        const btn     = document.getElementById("submit-btn");

        /* --- Restore Remember Me --- */
        window.onload = () =>{
          if(localStorage.getItem("rememberMe")==="true"){
            emailEl.value    = localStorage.getItem("email")    || "";
            passEl.value     = localStorage.getItem("password") || "";
            remember.checked = true;
          }
        };

        /* --- Login handler --- */
        form.addEventListener("submit", async e => {
        e.preventDefault();
        errBox.textContent = "";
        btn.disabled = true;
        btn.textContent = "Loading...";

        try {
            const cred = await signInWithEmailAndPassword(auth, emailEl.value, passEl.value);

            if (remember.checked) {
            localStorage.setItem("email", emailEl.value);
            localStorage.setItem("password", passEl.value);
            localStorage.setItem("rememberMe", "true");
            } else {
            localStorage.removeItem("email");
            localStorage.removeItem("password");
            localStorage.setItem("rememberMe", "false");
            }

            const snap = await getDoc(doc(db, "users", cred.user.uid));
            const role = snap.exists() ? (snap.data().role || "mahasiswa") : "mahasiswa";

            console.log("Role:", role);

            window.location.href = role === "admin"
            ? "{{ url('/admin') }}"
            : "{{ url('/dashboard') }}";
        } catch (err) {
            errBox.textContent = err.message;
        } finally {
            btn.disabled = false;
            btn.textContent = "SIGN IN";
        }
        });

      </script>
</body>
</html>
