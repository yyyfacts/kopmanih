@extends('layouts.app')

@section('title', 'Feedback')

@section('content')
<div class="animate-fade-in">
    <div class="feedback-container">
        <!-- Feedback Card -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Berikan Feedback Anda</h2>
            </div>
            <div class="card-body">
                <div class="feedback-intro">
                    <div class="feedback-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <p class="feedback-text">
                        Kami sangat menghargai masukan Anda untuk meningkatkan layanan kami. 
                        Feedback Anda akan membantu kami memberikan pelayanan yang lebih baik.
                    </p>
                </div>

                <form id="feedbackForm" class="mt-6">
                    <div class="form-group">
                        <label for="feedbackInput" class="form-label">Pesan Feedback</label>
                        <textarea 
                            id="feedbackInput" 
                            class="form-control" 
                            rows="5" 
                            placeholder="Tuliskan saran, kritik, atau masukan Anda di sini..."
                            required></textarea>
                    </div>

                    <div class="form-group mt-6">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>
                            Kirim Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Previous Feedbacks -->
        <div class="card mt-6" id="previousFeedbacks">
            <div class="card-header">
                <h2 class="card-title">Riwayat Feedback</h2>
            </div>
            <div class="feedback-list" id="feedbackList">
                <div class="text-center py-8 text-secondary">
                    <div class="spinner">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                    <p class="mt-4">Memuat data feedback...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Alert -->
<div class="alert alert-success" id="successMsg" style="display: none;">
    <i class="fas fa-check-circle me-2"></i>
    Terima kasih! Feedback Anda berhasil dikirim.
</div>
@endsection

@push('styles')
<style>
    .feedback-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .feedback-intro {
        text-align: center;
        max-width: 600px;
        margin: 0 auto 2rem;
    }

    .feedback-icon {
        width: 80px;
        height: 80px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 1.5rem;
    }

    .feedback-text {
        color: var(--secondary);
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .feedback-list {
        min-height: 200px;
    }

    .feedback-item {
        padding: 1.5rem;
        border-bottom: 1px solid #E5E7EB;
    }

    .feedback-item:last-child {
        border-bottom: none;
    }

    .feedback-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }

    .feedback-date {
        color: var(--secondary);
        font-size: 0.875rem;
    }

    .feedback-status {
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
    }

    .status-pending {
        background: #FEF3C7;
        color: #D97706;
    }

    .status-replied {
        background: #DEF7EC;
        color: #03543F;
    }

    .feedback-message {
        margin: 1rem 0;
        line-height: 1.6;
    }

    .feedback-reply {
        background: #F3F4F6;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-top: 1rem;
    }

    .feedback-reply strong {
        color: var(--primary);
        display: block;
        margin-bottom: 0.5rem;
    }

    .alert {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        padding: 1rem 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        z-index: 50;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .spinner {
        margin: 0 auto;
        width: 70px;
        text-align: center;
    }
    
    .spinner > div {
        width: 18px;
        height: 18px;
        background-color: #ddd;
        border-radius: 100%;
        display: inline-block;
        animation: sk-bouncedelay 1.4s infinite ease-in-out both;
    }
    
    .spinner .bounce1 {
        animation-delay: -0.32s;
    }
    
    .spinner .bounce2 {
        animation-delay: -0.16s;
    }
    
    @keyframes sk-bouncedelay {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1.0); }
    }
</style>
@endpush

@push('scripts')
<script type="module">
    // Firebase imports
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
    import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";
    import {
        getFirestore, collection, addDoc, query, where,
        orderBy, onSnapshot, serverTimestamp
    } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

    const firebaseConfig = {
        apiKey: "AIzaSyAuq0JEjnEOagJnONPemkMP0bbgqepiFp8",
        authDomain: "koperasimahasiswaapp.firebaseapp.com",
        projectId: "koperasimahasiswaapp",
        storageBucket: "koperasimahasiswaapp.firebasestorage.app",
        messagingSenderId: "812843080953",
        appId: "1:812843080953:web:9a931f89186182660bd628",
        measurementId: "G-ES6G76W66D"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const db = getFirestore(app);

    // DOM Elements
    const form = document.getElementById("feedbackForm");
    const input = document.getElementById("feedbackInput");
    const successEl = document.getElementById("successMsg");
    const feedbackList = document.getElementById("feedbackList");

    let currentUser = null;

    // Auth state observer
    onAuthStateChanged(auth, user => {
        if (!user) {
            window.location.href = "/login";
            return;
        }
        currentUser = user;
        loadFeedbacks(user.uid);
    });

    // Load user's feedbacks
    function loadFeedbacks(userId) {
        const q = query(
            collection(db, "feedback"),
            where("userId", "==", userId),
            orderBy("createdAt", "desc")
        );

        onSnapshot(q, snapshot => {
            if (snapshot.empty) {
                feedbackList.innerHTML = `
                    <div class="text-center py-8 text-secondary">
                        <i class="fas fa-inbox fa-3x mb-4"></i>
                        <p>Belum ada feedback yang dikirim</p>
                    </div>
                `;
                return;
            }

            let html = '';
            snapshot.forEach(doc => {
                const data = doc.data();
                const date = data.createdAt?.toDate() || new Date();
                const formattedDate = date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                html += `
                    <div class="feedback-item">
                        <div class="feedback-meta">
                            <span class="feedback-date">
                                <i class="fas fa-calendar-alt me-2"></i>
                                ${formattedDate}
                            </span>
                            <span class="feedback-status ${data.status === 'pending' ? 'status-pending' : 'status-replied'}">
                                ${data.status === 'pending' ? 'Menunggu Balasan' : 'Sudah Dibalas'}
                            </span>
                        </div>
                        <div class="feedback-message">
                            ${data.message}
                        </div>
                        ${data.reply ? `
                            <div class="feedback-reply">
                                <strong>
                                    <i class="fas fa-reply me-2"></i>
                                    Balasan Admin:
                                </strong>
                                ${data.reply}
                            </div>
                        ` : ''}
                    </div>
                `;
            });

            feedbackList.innerHTML = html;
        });
    }

    // Submit feedback
    form.onsubmit = async (e) => {
        e.preventDefault();
        const text = input.value.trim();
        if (!text) return;

        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <div class="spinner-border spinner-border-sm me-2"></div>
            Mengirim...
        `;

        try {
            await addDoc(collection(db, "feedback"), {
                userId: currentUser.uid,
                userEmail: currentUser.email,
                message: text,
                status: "pending",
                reply: "",
                createdAt: serverTimestamp()
            });

            input.value = "";
            showSuccess();

        } catch (error) {
            alert('Gagal mengirim feedback: ' + error.message);
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    };

    // Show success message
    function showSuccess() {
        successEl.style.display = 'flex';
        setTimeout(() => {
            successEl.style.opacity = '0';
            setTimeout(() => {
                successEl.style.display = 'none';
                successEl.style.opacity = '1';
            }, 300);
        }, 3000);
    }
</script>
@endpush
