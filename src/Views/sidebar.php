<?php
if (!isset($currentPage)) {
    $currentPage = '';
}

if (!isset($rootPath)) {
    $rootPath = '/mykeeper-lucas_vianna';
}

if (!isset($navigationItems)) {
    $navigationItems = [
        [
            'id' => 'inicioButtonLink',
            'slug' => 'dashboard',
            'label' => 'Início',
            'href' => $rootPath . '/src/Views/home.php',
            'icon' => '<path d="M3 13h8V3H3z"></path><path d="M3 21h8v-6H3z"></path><path d="M13 21h8V11h-8z"></path><path d="M13 3v6h8V3z"></path>',
        ],
        [
            'id' => 'produtosButtonLink',
            'slug' => 'inventory',
            'label' => 'Produtos',
            'href' => $rootPath . '/src/Views/produto.php',
            'icon' => '<path d="M8 3h8a2 2 0 0 1 2 2v16H6V5a2 2 0 0 1 2-2z"></path><path d="M10 8h4"></path><path d="M10 12h4"></path>',
        ],
        [
            'id' => 'categoriasButtonLink',
            'slug' => 'categories',
            'label' => 'Categorias',
            'href' => $rootPath . '/src/Views/categoria.php',
            'icon' => '<path d="M4 7h7"></path><path d="M4 12h16"></path><path d="M4 17h10"></path><circle cx="18" cy="7" r="2"></circle><circle cx="16" cy="17" r="2"></circle>',
        ],
        [
            'id' => 'ticketButtonLink',
            'slug' => 'tickets',
            'label' => 'Tickets',
            'href' => $rootPath . '/src/Views/ticket_usuario.php',
            'icon' => '<path d="M5 7.5A2.5 2.5 0 0 1 7.5 5h9A2.5 2.5 0 0 1 19 7.5v5A2.5 2.5 0 0 1 16.5 15H9l-4 4v-4.5A2.5 2.5 0 0 1 2.5 12V7.5A2.5 2.5 0 0 1 5 5z"></path>',
        ],
        [
            'id' => 'perfilButtonLink',
            'slug' => 'profile',
            'label' => 'Perfil',
            'href' => $rootPath . '/src/Views/perfil_usuario.php',
            'icon' => '<circle cx="12" cy="8" r="3"></circle><path d="M5 20a7 7 0 0 1 14 0"></path>',
        ],
        [
            'id' => 'adminHomeButtonLink',
            'slug' => 'admin',
            'label' => 'Admin',
            'href' => $rootPath . '/src/Views/admin_home.php',
            'icon' => '<path d="M12 3l7 4v5c0 5-3.5 8-7 9-3.5-1-7-4-7-9V7l7-4z"></path><path d="M9.5 12.5 11 14l3.5-3.5"></path>',
        ],
        [
            'id' => 'logoffButtonLink',
            'slug' => 'logout',
            'label' => 'Sair',
            'href' => $rootPath . '/src/Controllers/logoff.php',
            'icon' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="M16 17l5-5-5-5"></path><path d="M21 12H9"></path>',
        ],
    ];
}

include __DIR__ . '/../Includes/app_sidebar.php';

