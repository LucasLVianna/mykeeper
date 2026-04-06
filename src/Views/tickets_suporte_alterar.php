<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');
include_once(__DIR__ . '/../../config/valida_admin.php');

$pageTitle = 'Responder ticket';
$pageSlug = 'admin';
include __DIR__ . '/../Includes/app_layout_start.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Atualizar ticket</h1>
            <p class="page-subtitle">Visualize o chamado e registre a resposta.</p>
        </div>
    </div>

    <div class="surface-card">
        <div class="profile-card">
            <div class="profile-row">
                <span class="profile-label">Usuário</span>
                <span id="usuario" class="profile-value">Carregando...</span>
            </div>
            <div class="profile-row">
                <span class="profile-label">Título</span>
                <span id="titulo" class="profile-value">Carregando...</span>
                <input type="hidden" id="ticketId">
            </div>
            <div class="profile-row">
                <span class="profile-label">Descrição</span>
                <span id="descricao" class="profile-value">Carregando...</span>
            </div>
            <div class="profile-row">
                <span class="profile-label">Data de abertura</span>
                <span id="data_ticket" class="profile-value">Carregando...</span>
            </div>
        </div>
    </div>

    <div class="standalone-sheet-wrap">
        <section class="surface-card standalone-sheet">
            <div class="surface-content">
                <form class="stack-form">
                    <div class="field-group">
                        <label class="field-label" for="resposta_ticket">Resposta</label>
                        <textarea class="field-control" name="resposta_ticket" id="resposta_ticket" placeholder="Escreva a resposta do suporte"></textarea>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="status_ticket">Status</label>
                        <select class="field-control" name="status_ticket" id="status_ticket">
                            <option value="ticket_aberto">Aberto</option>
                            <option value="ticket_respondido">Respondido</option>
                            <option value="ticket_atualizado">Atualizado</option>
                            <option value="ticket_encerrado">Fechado</option>
                        </select>
                    </div>

                    <div class="inline-actions">
                        <a href="/mykeeper-lucas_vianna/src/Views/tickets_suporte.php" class="button button-secondary">Cancelar</a>
                        <button type="button" id="alterarTicket" class="button button-primary">Salvar resposta</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</section>
<script src="/mykeeper-lucas_vianna/public/js/tickets_suporte_alterar.js"></script>
<?php include __DIR__ . '/../Includes/app_layout_end.php'; ?>
