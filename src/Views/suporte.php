<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');
include_once(__DIR__ . '/../../config/valida_admin.php');

$pageTitle = 'Suporte';
$pageSlug = 'admin';
include __DIR__ . '/../Includes/app_layout_start.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Contas de suporte</h1>
            <p class="page-subtitle">Gerencie os acessos da equipe de atendimento.</p>
        </div>
        <button type="button" id="suporte_novo" class="button button-primary">Adicionar suporte</button>
    </div>

    <div class="surface-card table-shell">
        <div class="table-scroll">
            <div id="item" class="table-empty">Carregando contas de suporte...</div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../Includes/support_sheet.php'; ?>
<script src="/mykeeper-lucas_vianna/public/js/suporte.js"></script>
<?php include __DIR__ . '/../Includes/app_layout_end.php'; ?>
