                </div>
            </main>
        </div>
    </div>
    <div id="mobileSidebarOverlay" class="mobile-sidebar-overlay" hidden></div>
    <nav class="bottom-nav" aria-label="Navegação inferior">
        <div class="bottom-nav-inner">
            <?php foreach ($bottomNavigationItems as $item): ?>
                <a
                    href="<?= htmlspecialchars($item['href'], ENT_QUOTES) ?>"
                    class="bottom-nav-link<?= $currentPage === $item['slug'] ? ' is-active' : '' ?>"
                    data-nav="<?= htmlspecialchars($item['slug'], ENT_QUOTES) ?>"
                >
                    <span class="bottom-nav-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <?= $item['icon'] ?>
                        </svg>
                    </span>
                    <span><?= htmlspecialchars($item['label'], ENT_QUOTES) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>
    <script src="<?= htmlspecialchars($rootPath, ENT_QUOTES) ?>/public/js/app_shell.js"></script>
    <script src="<?= htmlspecialchars($rootPath, ENT_QUOTES) ?>/public/js/sidebar.js"></script>
</body>
</html>
