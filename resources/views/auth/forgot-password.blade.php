<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Koperasi Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M54.627 0l.83.828-1.415 1.415L51.8 0h2.827zM5.373 0l-.83.828L5.96 2.243 8.2 0H5.374zM48.97 0l3.657 3.657-1.414 1.414L46.143 0h2.828zM11.03 0L7.372 3.657 8.787 5.07 13.857 0H11.03zm32.284 0L49.8 6.485 48.384 7.9l-7.9-7.9h2.83zM16.686 0L10.2 6.485 11.616 7.9l7.9-7.9h-2.83zM22.343 0L13.8 8.544 15.214 9.96l9.9-9.96h-2.77zM32 0l-9.9 9.9 1.415 1.415L34.357 0H32z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.1;
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

        .auth-container {
            width: 100%;
            max-width: 420px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .auth-header h2 {
            color: #111827;
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .auth-header p {
            color: #6B7280;
            font-size: 16px;
            line-height: 1.5;
        }

        .info-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .info-box i {
            color: #047857;
            font-size: 20px;
            margin-top: 2px;
        }

        .info-box p {
            color: #065f46;
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
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

        #error-message,
        #success-message {
            display: none;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            animation: fadeIn 0.3s ease;
        }

        #error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        #success-message {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        #error-message.visible,
        #success-message.visible {
            display: block;
        }

        .auth-button {
            width: 100%;
            background: #047857;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .auth-button:hover {
            background: #065f46;
        }

        .auth-button:active {
            transform: translateY(1px);
        }

        .auth-links {
            text-align: center;
            margin-top: 24px;
            color: #6B7280;
            font-size: 14px;
        }

        .auth-links a {
            color: #047857;
            text-decoration: none;
            font-weight: 500;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 1023px) {
            .split-screen .left {
                display: none;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
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
                    <h1>Lupa Password?</h1>
                    <p>Jangan khawatir! Kami akan membantu Anda mendapatkan kembali akses ke akun Anda dengan aman dan mudah. Ikuti langkah-langkah sederhana untuk mereset password Anda.</p>
                </div>
            </div>
            <div class="left-footer">
                © {{ date('Y') }} Koperasi Mahasiswa. All rights reserved.
            </div>
        </div>

        <div class="right">
            <div class="auth-container">
                <div class="auth-header">
                    <h2>Reset Password</h2>
                    <p>Masukkan email yang terdaftar untuk menerima instruksi reset password</p>
                </div>

                <div class="info-box">
                    <i class="fas fa-info-circle"></i>
                    <p>Kami akan mengirim email yang berisi tautan untuk mereset password Anda. Pastikan untuk memeriksa folder spam jika email tidak muncul di kotak masuk.</p>
                </div>

                <form id="reset-form" onsubmit="event.preventDefault(); resetPassword();">
                    <div id="error-message"></div>
                    <div id="success-message"></div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required>
                        </div>
                    </div>

                    <button type="submit" class="auth-button">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Link Reset Password
                    </button>

                    <div class="auth-links">
                        <a href="/login">
                            <i class="fas fa-arrow-left"></i>
                            Kembali ke halaman login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-auth-compat.js"></script>
    <script>
        // Firebase configuration
        const firebaseConfig = {
            apiKey: "{{ config('services.firebase.api_key') }}",
            authDomain: "{{ config('services.firebase.auth_domain') }}",
            projectId: "{{ config('services.firebase.project_id') }}",
            storageBucket: "{{ config('services.firebase.storage_bucket') }}",
            messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
            appId: "{{ config('services.firebase.app_id') }}"
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        async function resetPassword() {
            const email = document.getElementById('email').value;
            const errorMessage = document.getElementById('error-message');
            const successMessage = document.getElementById('success-message');
            const submitButton = document.querySelector('.auth-button');
            const originalButtonText = submitButton.innerHTML;

            try {
                submitButton.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Mengirim...';
                submitButton.disabled = true;
                errorMessage.classList.remove('visible');
                successMessage.classList.remove('visible');

                await firebase.auth().sendPasswordResetEmail(email);
                
                successMessage.textContent = 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau folder spam Anda.';
                successMessage.classList.add('visible');
                
                submitButton.innerHTML = '<i class="fas fa-check"></i> Email Terkirim';
                // Re-enable button after 3 seconds
                setTimeout(() => {
                    submitButton.innerHTML = originalButtonText;
                    submitButton.disabled = false;
                }, 3000);
            } catch (error) {
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false;

                let message = 'Terjadi kesalahan. Silakan coba lagi.';
                if (error.code === 'auth/user-not-found') {
                    message = 'Email tidak terdaftar dalam sistem.';
                } else if (error.code === 'auth/invalid-email') {
                    message = 'Format email tidak valid.';
                }

                errorMessage.textContent = message;
                errorMessage.classList.add('visible');
            }
        }
    </script>
</body>
</html>
