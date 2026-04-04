(function () {
    const STORAGE_THEME_KEY = 'mykeeper-theme';

    function applyTheme(theme) {
        const isDark = theme === 'dark';
        document.body.classList.toggle('theme-dark', isDark);

        document.querySelectorAll('.theme-toggle-button').forEach((button) => {
            const sun = button.querySelector('.theme-icon-sun');
            const moon = button.querySelector('.theme-icon-moon');

            if (sun) {
                sun.hidden = isDark;
            }

            if (moon) {
                moon.hidden = !isDark;
            }

            button.setAttribute('aria-label', isDark ? 'Ativar tema claro' : 'Ativar tema escuro');
        });
    }

    function initTheme() {
        const savedTheme = localStorage.getItem(STORAGE_THEME_KEY);
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const initialTheme = savedTheme || (prefersDark ? 'dark' : 'light');
        applyTheme(initialTheme);

        document.querySelectorAll('.theme-toggle-button').forEach((button) => {
            button.addEventListener('click', () => {
                const nextTheme = document.body.classList.contains('theme-dark') ? 'light' : 'dark';
                localStorage.setItem(STORAGE_THEME_KEY, nextTheme);
                applyTheme(nextTheme);
            });
        });
    }

    function initSidebar() {
        const button = document.getElementById('mobileMenuButton');
        const sidebar = document.getElementById('sidebarMenu');
        const overlay = document.getElementById('mobileSidebarOverlay');

        if (!button || !sidebar || !overlay) {
            return;
        }

        const closeSidebar = () => {
            sidebar.classList.remove('is-open');
            overlay.classList.remove('is-visible');
            overlay.hidden = true;
        };

        const openSidebar = () => {
            sidebar.classList.add('is-open');
            overlay.hidden = false;
            requestAnimationFrame(() => {
                overlay.classList.add('is-visible');
            });
        };

        button.addEventListener('click', () => {
            if (sidebar.classList.contains('is-open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

        overlay.addEventListener('click', closeSidebar);

        document.querySelectorAll('.sidebar a, .bottom-nav a').forEach((link) => {
            link.addEventListener('click', closeSidebar);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeSidebar();
            }
        });
    }

    function setActiveNavigation() {
        const currentPage = document.body.dataset.page || '';

        document.querySelectorAll('[data-nav]').forEach((item) => {
            item.classList.toggle('is-active', item.dataset.nav === currentPage);
        });
    }

    function showToast(message, type) {
        const region = document.getElementById('toastRegion');
        if (!region) {
            return;
        }

        const toast = document.createElement('div');
        toast.className = 'toast' + (type ? ' is-' + type : '');
        toast.innerHTML = '<span class="toast-message"></span>';
        toast.querySelector('.toast-message').textContent = message;
        region.appendChild(toast);

        window.setTimeout(() => {
            toast.remove();
        }, 3200);
    }

    document.addEventListener('DOMContentLoaded', () => {
        initTheme();
        initSidebar();
        setActiveNavigation();
    });

    window.MyKeeperUI = {
        showToast: showToast,
    };
})();
