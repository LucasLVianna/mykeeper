<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="/mykeeper/public/css/sidebar.css">
<link rel="stylesheet" href="/mykeeper/public/css/theme.css?v=20260411-theme">
<link rel="stylesheet" href="/mykeeper/public/css/app-notifications.css?v=20260411-notify-fix">

<script>
    (function () {
        var theme = localStorage.getItem('mykeeper-theme');
        document.documentElement.setAttribute('data-theme', theme === 'light' ? 'light' : 'dark');
    })();
</script>

<!-- Script executado imediatamente para impedir o piscar/tremer da animação -->
<script>
    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        document.body.classList.add('sidebar-collapsed');
        // Desativa temporariamente as transições para não animar a entrada
        document.write('<style id="sidebar-preload">.sideNavBar, .main-content, .toggle-arrow { transition: none !important; }</style>');
        
        // Remove a trava de animação logo após o carregamento da página
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                var preloadStyle = document.getElementById("sidebar-preload");
                if (preloadStyle) preloadStyle.remove();
            }, 50);
        });
    }
</script>

<aside class="sideNavBar" id="sidebar">
    <!-- Adiciona a classe collapsed se necessário IMEDIATAMENTE após criar o elemento -->
    <script>
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            document.getElementById('sidebar').classList.add('collapsed');
        }
    </script>
    <div class="sidebar-header">
        <div class="logo-container">
            <div class="logo-badge" title="MyKeeper">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="12" height="18" x="6" y="3" rx="2" />
                    <line x1="6" x2="18" y1="9" y2="9" />
                    <line x1="10" x2="10" y1="12" y2="15" />
                    <line x1="10" x2="10" y1="5" y2="7" />
                </svg>
            </div>
            <h2>MyKeeper</h2>
        </div>
    </div>
    <div class="nav-container">
        <nav>
            <button type="button" id="inicioButtonLink" data-label="Início" title="Início">
                <i class="fas fa-home"></i>
                <span>Início</span>
            </button>
            <button type="button" id="produtosButtonLink" data-label="Produtos" title="Produtos registrados">
                <i class="fas fa-box"></i>
                <span>Produtos registrados</span>
            </button>
            <button type="button" id="categoriasButtonLink" data-label="Categorias" title="Categorias">
                <i class="fas fa-tags"></i>
                <span>Categorias</span>
            </button>
            <button type="button" id="perfilButtonLink" data-label="Perfil" title="Perfil">
                <i class="fas fa-user"></i>
                <span>Perfil</span>
            </button>
            <button type="button" id="adminHomeButtonLink" data-label="Admin" title="Admin">
                <i class="fas fa-cog"></i>
                <span>Admin</span>
            </button>
            <button type="button" id="ticketButtonLink" data-label="Tickets" title="Tickets">
                <i class="fas fa-ticket-alt"></i>
                <span>Tickets</span>
            </button>

            <button type="button" id="themeToggleButton" data-label="Tema" title="Ativar modo claro">
                <i class="fas fa-sun"></i>
                <span>Modo claro</span>
            </button>
        </nav>

        <button type="button" id="logoffButtonLink" data-label="Sair" title="Sair">
            <i class="fas fa-door-open"></i>
            <span>Sair</span>
        </button>
    </div>
</aside>

<div class="toggle-arrow" id="toggleSidebar" title="Compactar/Expandir">
    <i class="fas fa-chevron-left"></i>
</div>

<script src="/mykeeper/public/js/sidebar-toggle.js"></script>
<script src="/mykeeper/public/js/sidebar.js"></script>
<script src="/mykeeper/public/js/theme.js?v=20260411-theme"></script>
<script src="/mykeeper/public/js/app-notifications.js?v=20260411-notify-fix"></script>