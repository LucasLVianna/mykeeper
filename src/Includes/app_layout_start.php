<?php
if (!isset($pageTitle)) {
    $pageTitle = 'MyKeeper';
}

header('Content-Type: text/html; charset=utf-8');

$currentPage = isset($pageSlug) ? $pageSlug : '';
$rootPath = '/mykeeper-lucas_vianna';
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

$bottomNavigationItems = array_values(array_filter(
    $navigationItems,
    static function ($item) {
        return in_array($item['slug'], ['dashboard', 'inventory', 'categories', 'tickets', 'profile'], true);
    }
));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES) ?> - MyKeeper</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= htmlspecialchars($rootPath, ENT_QUOTES) ?>/public/css/app_theme.css">
</head>
<body class="app-body theme-light" data-page="<?= htmlspecialchars($currentPage, ENT_QUOTES) ?>">
    <div class="app-shell">
        <?php include __DIR__ . '/app_sidebar.php'; ?>
        <div class="content-shell">
            <header class="mobile-header">
                <button id="mobileMenuButton" class="ghost-icon-button" type="button" aria-label="Abrir navegação">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 7h16"></path>
                        <path d="M4 12h16"></path>
                        <path d="M4 17h16"></path>
                    </svg>
                </button>
                <div class="header-brand">
                    <span class="brand-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 3h8a2 2 0 0 1 2 2v16H6V5a2 2 0 0 1 2-2z"></path>
                            <path d="M10 8h4"></path>
                            <path d="M10 12h4"></path>
                        </svg>
                    </span>
                    <div>
                        <p class="toolbar-kicker">MyKeeper</p>
                        <p class="toolbar-title"><?= htmlspecialchars($pageTitle, ENT_QUOTES) ?></p>
                    </div>
                </div>
                <button class="ghost-icon-button theme-toggle-button" type="button" aria-label="Alternar tema">
                    <svg class="theme-icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M12 2v2"></path>
                        <path d="M12 20v2"></path>
                        <path d="M4.93 4.93l1.41 1.41"></path>
                        <path d="M17.66 17.66l1.41 1.41"></path>
                        <path d="M2 12h2"></path>
                        <path d="M20 12h2"></path>
                        <path d="M4.93 19.07l1.41-1.41"></path>
                        <path d="M17.66 6.34l1.41-1.41"></path>
                    </svg>
                    <svg class="theme-icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" hidden>
                        <path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79z"></path>
                    </svg>
                </button>
            </header>
            <div class="desktop-toolbar">
                <div>
                    <p class="toolbar-kicker">Painel</p>
                    <p class="toolbar-title"><?= htmlspecialchars($pageTitle, ENT_QUOTES) ?></p>
                </div>
                <button class="ghost-icon-button theme-toggle-button" type="button" aria-label="Alternar tema">
                    <svg class="theme-icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M12 2v2"></path>
                        <path d="M12 20v2"></path>
                        <path d="M4.93 4.93l1.41 1.41"></path>
                        <path d="M17.66 17.66l1.41 1.41"></path>
                        <path d="M2 12h2"></path>
                        <path d="M20 12h2"></path>
                        <path d="M4.93 19.07l1.41-1.41"></path>
                        <path d="M17.66 6.34l1.41-1.41"></path>
                    </svg>
                    <svg class="theme-icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" hidden>
                        <path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79z"></path>
                    </svg>
                </button>
            </div>
            <main class="main-content">
                <div class="page-container">

