// Handle Dark Mode
document.addEventListener('alpine:init', () => {
    Alpine.data('darkMode', () => ({
        isDark: localStorage.getItem('theme') === 'dark',
        
        init() {
            this.$watch('isDark', value => {
                localStorage.setItem('theme', value ? 'dark' : 'light');
                if (value) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            });

            // Check system preference on first load
            if (localStorage.getItem('theme') === null) {
                this.isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            }
        }
    }));
});

// Password Toggle Function
window.togglePassword = function(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
};

// Alert Auto-hide
document.addEventListener('DOMContentLoaded', () => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.add('opacity-0', 'transform', 'translate-y-2');
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});
