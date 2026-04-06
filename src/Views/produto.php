<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');

$pageTitle = 'Produtos';
$pageSlug = 'inventory';
include __DIR__ . '/../Includes/app_layout_start.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Produtos</h1>
            <p class="page-subtitle">Consulte, edite e organize seus itens.</p>
        </div>
        <button type="button" id="produto_novo" class="button button-primary">Adicionar produto</button>
    </div>

    <div class="surface-card table-shell">
        <div class="table-scroll">
            <div id="item" class="table-empty">Carregando produtos...</div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../Includes/product_sheet.php'; ?>
<script src="/mykeeper-lucas_vianna/public/js/produto.js"></script>
<?php include __DIR__ . '/../Includes/app_layout_end.php'; ?>
