<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');

$pageTitle = 'Tickets';
$pageSlug = 'tickets';
$ticketScriptVersion = (string) filemtime(dirname(__DIR__, 2) . '/public/js/ticket.js');
include __DIR__ . '/../Includes/app_layout_start.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Tickets de suporte</h1>
            <p class="page-subtitle">Abra e acompanhe seus chamados.</p>
        </div>
        <button type="button" id="ticket_novo" class="button button-primary">Novo ticket</button>
    </div>

    <div class="surface-card table-shell">
        <div class="table-scroll">
            <div id="item" class="table-empty">Carregando tickets...</div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../Includes/ticket_sheet.php'; ?>
<script src="/mykeeper-lucas_vianna/public/js/ticket.js?v=<?= htmlspecialchars($ticketScriptVersion, ENT_QUOTES, 'UTF-8') ?>"></script>
<?php include __DIR__ . '/../Includes/app_layout_end.php'; ?>
