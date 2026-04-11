(function () {
    var KEY = 'mykeeper-theme';

    function getStoredTheme() {
        var stored = localStorage.getItem(KEY);
        return stored === 'light' ? 'light' : 'dark';
    }

    function applyTheme(theme) {
        var normalized = theme === 'light' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', normalized);
        localStorage.setItem(KEY, normalized);
        updateToggleButton(normalized);
    }

    function updateToggleButton(theme) {
        var button = document.getElementById('themeToggleButton');
        if (!button) {
            return;
        }

        var icon = button.querySelector('i');
        var label = button.querySelector('span');

        if (theme === 'light') {
            if (icon) {
                icon.className = 'fas fa-moon';
            }
            if (label) {
                label.textContent = 'Modo escuro';
            }
            button.title = 'Ativar modo escuro';
        } else {
            if (icon) {
                icon.className = 'fas fa-sun';
            }
            if (label) {
                label.textContent = 'Modo claro';
            }
            button.title = 'Ativar modo claro';
        }
    }

    function initToggle() {
        var button = document.getElementById('themeToggleButton');
        if (!button) {
            return;
        }

        button.addEventListener('click', function () {
            var current = document.documentElement.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
            applyTheme(current === 'light' ? 'dark' : 'light');
        });
    }

    window.appTheme = {
        apply: applyTheme,
        current: function () {
            return document.documentElement.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
        }
    };

    applyTheme(getStoredTheme());

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initToggle, { once: true });
    } else {
        initToggle();
    }
})();