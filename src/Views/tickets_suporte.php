<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');
include_once(__DIR__ . '/../../config/valida_admin.php');

$pageTitle = 'Tickets do suporte';
$pageSlug = 'admin';
$ticketsSupportScriptVersion = (string) filemtime(dirname(__DIR__, 2) . '/public/js/tickets_suporte.js');
include __DIR__ . '/../Includes/app_layout_start.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Tickets recebidos</h1>
            <p class="page-subtitle">Acompanhe os chamados enviados pelos usuários.</p>
        </div>
    </div>

    <div class="surface-card table-shell">
        <div class="table-scroll">
            <div id="item" class="table-empty">Carregando tickets...</div>
        </div>
    </div>
</section>
<script src="/mykeeper-lucas_vianna/public/js/tickets_suporte.js?v=<?= htmlspecialchars($ticketsSupportScriptVersion, ENT_QUOTES, 'UTF-8') ?>"></script>
<?php include __DIR__ . '/../Includes/app_layout_end.php'; ?>
