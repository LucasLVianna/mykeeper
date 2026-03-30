<<<<<<< HEAD
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
</head>
<body>
    <aside class="sideNavBar">
            <div>
                <h2>MyKeeper</h2>
            </div>
            <div>
                <nav>
                    <button id="inicioButtonLink">Início</button>
                    <button id="inventarioButtonLink">Inventario</button>
                    <button id="produtosButtonLink">Produtos registrados</button>
                    <button id="avencerButtonLink">A Vencer</button>
                    <button id="comprasButtonLink">Compras</button>
                    <button id="receitasButtonLink">Receitas</button>
                    <button id="historicoButtonLink">Historico</button>
                </nav>
            </div>
        </aside>
        
    <section>
        <div>
            <h2>Produtos Registrados</h2>
        </div>
        <div id="item"></div>
        <div>
            <button type="button" id="produto_novo" class="addvs">Adicionar Produto</button>
        </div>
    </section>
    <script src="/mykeeper/public/js/produto.js"></script>
</body>
</html>
=======
<?php
$pageTitle = 'Inventario';
$pageSlug = 'inventory';
include __DIR__ . '/../Includes/header.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Inventario</h1>
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

    <div class="toolbar-stack">
        <div class="search-shell">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="11" cy="11" r="7"></circle>
                <path d="m20 20-3.5-3.5"></path>
            </svg>
            <input id="inventorySearch" class="field-control" type="search" placeholder="Buscar produtos...">
        </div>

        <div class="filter-bar" role="group" aria-label="Filtrar produtos">
            <button type="button" class="filter-chip is-active" data-filter="all">
                <span>Todos</span>
                <span class="filter-count" id="filterAllCount">0</span>
            </button>
            <button type="button" class="filter-chip" data-filter="expiring">
                <span>A vencer</span>
                <span class="filter-count" id="filterExpiringCount">0</span>
            </button>
            <button type="button" class="filter-chip" data-filter="expired">
                <span>Vencidos</span>
                <span class="filter-count" id="filterExpiredCount">0</span>
            </button>
        </div>
    </div>

    <div id="inventoryGrid" class="inventory-grid columns-3"></div>
</section>
<?php include __DIR__ . '/../Includes/product_sheet.php'; ?>
<?php include __DIR__ . '/../Includes/footer.php'; ?>
>>>>>>> local-snapshot
