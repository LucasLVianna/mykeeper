document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const toggleArrow = document.getElementById('toggleSidebar');

    // A classe `collapsed` e `sidebar-collapsed` na inicialização 
    // já foi tratada diretamente e de forma imediata dentro do arquivo sidebar.php
    // para evitar animações tremidas ao trocar de página

    // Toggle da sidebar
    toggleArrow.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        document.body.classList.toggle('sidebar-collapsed');
        
        const collapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', collapsed);

        // Disparar evento de redimensionamento para atualizar layouts responsivos
        window.dispatchEvent(new Event('resize'));
    });
});


