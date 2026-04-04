<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Fridge Manager';
}

$currentSlug = isset($pageSlug) ? $pageSlug : 'dashboard';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/mykeeper-main/assets/css/style.css">
    <link rel="stylesheet" href="/mykeeper-main/assets/css/components.css">
    <link rel="stylesheet" href="/mykeeper-main/assets/css/responsive.css">
</head>
<body class="theme-light" data-page="<?= htmlspecialchars($currentSlug, ENT_QUOTES) ?>">
    <div class="app-shell">
        <?php include __DIR__ . '/sidebar.php'; ?>
        <div class="content-shell">
            <header class="mobile-header">
                <button id="mobileMenuButton" class="ghost-icon-button" type="button" aria-label="Abrir navegacao">
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
                    <span class="brand-title">Fridge Manager</span>
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
