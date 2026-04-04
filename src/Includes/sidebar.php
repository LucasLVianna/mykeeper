<?php
$navigationItems = [
    [
        'slug' => 'dashboard',
        'label' => 'Inicio',
        'href' => '/mykeeper-main/src/Views/home.php',
        'icon' => '<path d="M3 13h8V3H3z"></path><path d="M3 21h8v-6H3z"></path><path d="M13 21h8V11h-8z"></path><path d="M13 3v6h8V3z"></path>',
    ],
    [
        'slug' => 'inventory',
        'label' => 'Inventario',
        'href' => '/mykeeper-main/src/Views/produto.php',
        'icon' => '<path d="M8 3h8a2 2 0 0 1 2 2v16H6V5a2 2 0 0 1 2-2z"></path><path d="M10 8h4"></path><path d="M10 12h4"></path>',
    ],
    [
        'slug' => 'expiring',
        'label' => 'A Vencer',
        'href' => '/mykeeper-main/src/Views/avencer.php',
        'icon' => '<circle cx="12" cy="12" r="8"></circle><path d="M12 8v4l2 2"></path>',
    ],
    [
        'slug' => 'shopping',
        'label' => 'Compras',
        'href' => '/mykeeper-main/src/Views/compras.php',
        'icon' => '<path d="M6 6h15l-1.5 9H8.5L6 6z"></path><path d="M6 6L4 3H2"></path><circle cx="9" cy="20" r="1"></circle><circle cx="18" cy="20" r="1"></circle>',
    ],
    [
        'slug' => 'history',
        'label' => 'Historico',
        'href' => '/mykeeper-main/src/Views/historico.php',
        'icon' => '<path d="M3 3v6h6"></path><path d="M12 7a5 5 0 1 1-5 5"></path><path d="M21 21v-6h-6"></path>',
    ],
];
?>
<aside class="sidebar" id="sidebarMenu" aria-label="Navegacao principal">
    <div class="sidebar-head">
        <span class="brand-badge" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8 3h8a2 2 0 0 1 2 2v16H6V5a2 2 0 0 1 2-2z"></path>
                <path d="M10 8h4"></path>
                <path d="M10 12h4"></path>
            </svg>
        </span>
        <span class="brand-title">Fridge Manager</span>
    </div>
    <nav class="sidebar-nav">
        <?php foreach ($navigationItems as $item): ?>
            <a
                href="<?= htmlspecialchars($item['href'], ENT_QUOTES) ?>"
                class="sidebar-link<?= $currentSlug === $item['slug'] ? ' is-active' : '' ?>"
                data-nav="<?= htmlspecialchars($item['slug'], ENT_QUOTES) ?>"
            >
                <span class="nav-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <?= $item['icon'] ?>
                    </svg>
                </span>
                <span><?= htmlspecialchars($item['label'], ENT_QUOTES) ?></span>
            </a>
        <?php endforeach; ?>
    </nav>
</aside>
