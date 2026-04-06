<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');
include_once(__DIR__ . '/../../config/valida_admin.php');

$pageTitle = 'Admin';
$pageSlug = 'admin';
include __DIR__ . '/../Includes/app_layout_start.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Painel administrativo</h1>
            <p class="page-subtitle">Gerencie o suporte e acompanhe os chamados.</p>
        </div>
    </div>

    <div class="quick-actions">
        <article class="action-card">
            <h2 class="surface-title">Contas de suporte</h2>
            <p>Cadastre, edite e remova acessos de atendimento.</p>
            <button id="cadastroSuporteButtonLink" type="button" class="button button-primary">Gerenciar suporte</button>
        </article>

        <article class="action-card">
            <h2 class="surface-title">Tickets recebidos</h2>
            <p>Visualize e responda aos chamados enviados.</p>
            <button id="ticketsSuporte" type="button" class="button button-secondary">Ver tickets</button>
        </article>
    </div>
</section>
<script src="/mykeeper-lucas_vianna/public/js/admin_home.js"></script>
<?php include __DIR__ . '/../Includes/app_layout_end.php'; ?>
