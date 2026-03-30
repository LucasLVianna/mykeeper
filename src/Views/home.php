<?php
$pageTitle = 'Minha Geladeira';
$pageSlug = 'dashboard';
include __DIR__ . '/../Includes/header.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Minha Geladeira</h1>
            <p class="page-subtitle">Resumo geral dos seus produtos</p>
        </div>
        <button type="button" id="produto_novo" class="button button-primary" data-open-product-sheet="add">
            <span class="button-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14"></path>
                    <path d="M5 12h14"></path>
                </svg>
            </span>
            <span>Adicionar</span>
        </button>
    </div>

    <div class="summary-grid">
        <a href="/mykeeper-main/src/Views/produto.php" class="surface-card summary-card">
            <span class="icon-badge is-primary" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8 3h8a2 2 0 0 1 2 2v16H6V5a2 2 0 0 1 2-2z"></path>
                    <path d="M10 8h4"></path>
                    <path d="M10 12h4"></path>
                </svg>
            </span>
            <div>
                <p class="summary-value" id="summaryTotal">0</p>
                <p class="summary-label">Total de itens</p>
            </div>
        </a>

        <a href="/mykeeper-main/src/Views/avencer.php" class="surface-card summary-card">
            <span class="icon-badge is-warning" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="7"></circle>
                    <path d="M12 8v4l2 2"></path>
                </svg>
            </span>
            <div>
                <p class="summary-value" id="summaryExpiring">0</p>
                <p class="summary-label">A vencer (7 dias)</p>
            </div>
        </a>

        <a href="/mykeeper-main/src/Views/produto.php" class="surface-card summary-card">
            <span class="icon-badge is-danger" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="7"></circle>
                    <path d="M9 9l6 6"></path>
                    <path d="M15 9l-6 6"></path>
                </svg>
            </span>
            <div>
                <p class="summary-value" id="summaryExpired">0</p>
                <p class="summary-label">Vencidos</p>
            </div>
        </a>

        <a href="/mykeeper-main/src/Views/compras.php" class="surface-card summary-card">
            <span class="icon-badge is-muted" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 6h15l-1.5 9H8.5L6 6z"></path>
                    <path d="M6 6L4 3H2"></path>
                    <circle cx="9" cy="20" r="1"></circle>
                    <circle cx="18" cy="20" r="1"></circle>
                </svg>
            </span>
            <div>
                <p class="summary-value" id="summaryShopping">0</p>
                <p class="summary-label">Lista de compras</p>
            </div>
        </a>
    </div>

    <section class="surface-card">
        <div class="surface-header">
            <div>
                <h2 class="surface-title">Proximos a vencer</h2>
            </div>
            <a href="/mykeeper-main/src/Views/avencer.php" class="button button-ghost">Ver todos</a>
        </div>
        <div class="surface-content">
            <div id="upcomingExpiringList" class="stack-list">
                <div class="empty-state">
                    <div class="empty-state-icon is-success" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 8v4l2 2"></path>
                            <circle cx="12" cy="12" r="8"></circle>
                        </svg>
                    </div>
                    <p class="empty-title">Nenhum produto proximo do vencimento</p>
                    <p class="empty-copy">Tudo certo por aqui.</p>
                </div>
            </div>
        </div>
    </section>
</section>
<?php include __DIR__ . '/../Includes/product_sheet.php'; ?>
<?php include __DIR__ . '/../Includes/footer.php'; ?>
