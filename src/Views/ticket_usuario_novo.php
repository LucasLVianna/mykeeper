<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');

$pageTitle = 'Novo ticket';
$pageSlug = 'tickets';
include __DIR__ . '/../Includes/app_layout_start.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Abrir ticket</h1>
            <p class="page-subtitle">Descreva o atendimento que você precisa.</p>
        </div>
    </div>

    <div class="standalone-sheet-wrap">
        <section class="surface-card standalone-sheet">
            <div class="surface-content">
                <form class="stack-form">
                    <div class="field-group">
                        <label class="field-label" for="titulo">Título</label>
                        <input class="field-control" type="text" name="titulo" id="titulo" placeholder="Ex: Erro ao cadastrar produto">
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="descricao">Descrição</label>
                        <textarea class="field-control" name="descricao" id="descricao" placeholder="Descreva o que você precisa"></textarea>
                    </div>

                    <div class="inline-actions">
                        <a href="/mykeeper-lucas_vianna/src/Views/ticket_usuario.php" class="button button-secondary">Cancelar</a>
                        <button type="button" id="criarTicket" class="button button-primary">Criar ticket</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</section>
<script src="/mykeeper-lucas_vianna/public/js/ticket_usuario_novo.js"></script>
<?php include __DIR__ . '/../Includes/app_layout_end.php'; ?>
