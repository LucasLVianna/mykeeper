const sidebarRoutes = {
    inicioButtonLink: '/mykeeper-lucas_vianna/src/Views/home.php',
    produtosButtonLink: '/mykeeper-lucas_vianna/src/Views/produto.php',
    categoriasButtonLink: '/mykeeper-lucas_vianna/src/Views/categoria.php',
    ticketButtonLink: '/mykeeper-lucas_vianna/src/Views/ticket_usuario.php',
    perfilButtonLink: '/mykeeper-lucas_vianna/src/Views/perfil_usuario.php',
    adminHomeButtonLink: '/mykeeper-lucas_vianna/src/Views/admin_home.php',
    logoffButtonLink: '/mykeeper-lucas_vianna/src/Controllers/logoff.php',
};

Object.entries(sidebarRoutes).forEach(([id, href]) => {
    const element = document.getElementById(id);

    if (!element) {
        return;
    }

    element.addEventListener('click', () => {
        window.location.href = href;
    });
});

