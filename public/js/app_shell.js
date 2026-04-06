(function () {
    const body = document.body;
    if (!body) {
        return;
    }

    const themeKey = 'mykeeper-theme';
    const menuButton = document.getElementById('mobileMenuButton');
    const sidebar = document.getElementById('sidebarMenu');
    const overlay = document.getElementById('mobileSidebarOverlay');
    const toggleButtons = document.querySelectorAll('.theme-toggle-button');

    function applyTheme(theme) {
        const isDark = theme === 'dark';
        body.classList.toggle('theme-dark', isDark);
        body.classList.toggle('theme-light', !isDark);

        toggleButtons.forEach((button) => {
            const sun = button.querySelector('.theme-icon-sun');
            const moon = button.querySelector('.theme-icon-moon');

            if (sun) {
                sun.hidden = isDark;
            }

            if (moon) {
                moon.hidden = !isDark;
            }
        });
    }

    function closeSidebar() {
        if (!sidebar || !overlay) {
            return;
        }

        sidebar.classList.remove('is-open');
        overlay.hidden = true;
        overlay.classList.remove('is-visible');
    }

    function openSidebar() {
        if (!sidebar || !overlay) {
            return;
        }

        sidebar.classList.add('is-open');
        overlay.hidden = false;
        requestAnimationFrame(() => {
            overlay.classList.add('is-visible');
        });
    }

    function closeSheet(sheetId) {
        const sheet = document.getElementById(sheetId);
        if (!sheet) {
            return;
        }

        sheet.hidden = true;
        body.style.overflow = '';
    }

    function openSheet(sheetId) {
        const sheet = document.getElementById(sheetId);
        if (!sheet) {
            return;
        }

        sheet.hidden = false;
        body.style.overflow = 'hidden';
    }

    window.myKeeperUI = {
        openSheet,
        closeSheet
    };

    applyTheme(localStorage.getItem(themeKey) || 'light');

    toggleButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const nextTheme = body.classList.contains('theme-dark') ? 'light' : 'dark';
            localStorage.setItem(themeKey, nextTheme);
            applyTheme(nextTheme);
        });
    });

    if (menuButton) {
        menuButton.addEventListener('click', () => {
            if (sidebar && sidebar.classList.contains('is-open')) {
                closeSidebar();
                return;
            }

            openSidebar();
        });
    }

    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    document.querySelectorAll('.sidebar-link, .bottom-nav-link').forEach((item) => {
        item.addEventListener('click', closeSidebar);
    });

    document.querySelectorAll('[data-close-sheet]').forEach((item) => {
        item.addEventListener('click', () => {
            closeSheet(item.getAttribute('data-close-sheet'));
        });
    });
})();
