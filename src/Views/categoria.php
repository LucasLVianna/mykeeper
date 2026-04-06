<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');

$pageTitle = 'Categorias';
$pageSlug = 'categories';
include __DIR__ . '/../Includes/app_layout_start.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Categorias</h1>
            <p class="page-subtitle">Organize seus produtos por tipo.</p>
        </div>
        <button type="button" id="categoria_nova" class="button button-primary">Adicionar categoria</button>
    </div>

    <div class="surface-card table-shell">
        <div class="table-scroll">
            <div id="item" class="table-empty">Carregando categorias...</div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../Includes/category_sheet.php'; ?>
<script src="/mykeeper-lucas_vianna/public/js/categoria.js"></script>
<?php include __DIR__ . '/../Includes/app_layout_end.php'; ?>
