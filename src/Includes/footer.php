                </div>
            </main>
        </div>
    </div>
    <div id="mobileSidebarOverlay" class="mobile-sidebar-overlay" hidden></div>
    <nav class="bottom-nav" aria-label="Navegacao inferior">
        <div class="bottom-nav-inner">
            <a href="/mykeeper-main/src/Views/home.php" class="bottom-nav-link" data-nav="dashboard">
                <span class="bottom-nav-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 13h8V3H3z"></path>
                        <path d="M3 21h8v-6H3z"></path>
                        <path d="M13 21h8V11h-8z"></path>
                        <path d="M13 3v6h8V3z"></path>
                    </svg>
                </span>
                <span>Inicio</span>
            </a>
            <a href="/mykeeper-main/src/Views/produto.php" class="bottom-nav-link" data-nav="inventory">
                <span class="bottom-nav-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M8 3h8a2 2 0 0 1 2 2v16H6V5a2 2 0 0 1 2-2z"></path>
                        <path d="M10 8h4"></path>
                        <path d="M10 12h4"></path>
                    </svg>
                </span>
                <span>Inventario</span>
            </a>
            <a href="/mykeeper-main/src/Views/avencer.php" class="bottom-nav-link" data-nav="expiring">
                <span class="bottom-nav-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="8"></circle>
                        <path d="M12 8v4l2 2"></path>
                    </svg>
                </span>
                <span>A Vencer</span>
            </a>
            <a href="/mykeeper-main/src/Views/compras.php" class="bottom-nav-link" data-nav="shopping">
                <span class="bottom-nav-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 6h15l-1.5 9H8.5L6 6z"></path>
                        <path d="M6 6L4 3H2"></path>
                        <circle cx="9" cy="20" r="1"></circle>
                        <circle cx="18" cy="20" r="1"></circle>
                    </svg>
                </span>
                <span>Compras</span>
            </a>
            <a href="/mykeeper-main/src/Views/historico.php" class="bottom-nav-link" data-nav="history">
                <span class="bottom-nav-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3v6h6"></path>
                        <path d="M12 7a5 5 0 1 1-5 5"></path>
                        <path d="M21 21v-6h-6"></path>
                    </svg>
                </span>
                <span>Historico</span>
            </a>
        </div>
    </nav>
    <div class="dialog-root" id="confirmDialog" hidden>
        <div class="dialog-backdrop" data-close-dialog="true"></div>
        <div class="dialog-card" role="dialog" aria-modal="true" aria-labelledby="confirmDialogTitle">
            <div class="dialog-content">
                <h2 class="dialog-title" id="confirmDialogTitle">Confirmar acao</h2>
                <p class="dialog-description" id="confirmDialogDescription">Tem certeza que deseja continuar?</p>
                <div class="dialog-actions">
                    <button class="button button-secondary" type="button" data-close-dialog="true">Cancelar</button>
                    <button class="button button-primary" type="button" id="confirmDialogAction">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    <div id="toastRegion" class="toast-region" aria-live="polite" aria-atomic="true"></div>
    <script src="/mykeeper-main/assets/js/ui.js"></script>
    <script src="/mykeeper-main/assets/js/app.js"></script>
    <script src="/mykeeper-main/assets/js/forms.js"></script>
</body>
</html>
