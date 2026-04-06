<aside class="sidebar" id="sidebarMenu" aria-label="Navegação principal">
    <div class="sidebar-head">
        <span class="brand-badge" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8 3h8a2 2 0 0 1 2 2v16H6V5a2 2 0 0 1 2-2z"></path>
                <path d="M10 8h4"></path>
                <path d="M10 12h4"></path>
            </svg>
        </span>
        <div>
            <span class="brand-title">MyKeeper</span>
            <p class="brand-copy">Controle do estoque</p>
        </div>
    </div>
    <nav class="sidebar-nav">
        <?php foreach ($navigationItems as $item): ?>
            <button
                type="button"
                id="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>"
                class="sidebar-link<?= $currentPage === $item['slug'] ? ' is-active' : '' ?>"
                data-nav="<?= htmlspecialchars($item['slug'], ENT_QUOTES) ?>"
            >
                <span class="nav-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <?= $item['icon'] ?>
                    </svg>
                </span>
                <span><?= htmlspecialchars($item['label'], ENT_QUOTES) ?></span>
            </button>
        <?php endforeach; ?>
    </nav>
</aside>
