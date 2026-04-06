<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');
include_once(__DIR__ . '/../../config/valida_admin.php');

$pageTitle = 'Editar suporte';
$pageSlug = 'admin';
include __DIR__ . '/../Includes/app_layout_start.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Atualizar conta de suporte</h1>
            <p class="page-subtitle">Edite os dados do acesso selecionado.</p>
        </div>
    </div>

    <div class="standalone-sheet-wrap">
        <section class="surface-card standalone-sheet">
            <div class="surface-content">
                <form class="stack-form">
                    <div class="field-group">
                        <label class="field-label" for="nome">Nome</label>
                        <input class="field-control" type="text" name="nome" id="nome">
                        <input type="hidden" id="id">
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="email">E-mail</label>
                        <input class="field-control" type="email" name="email" id="email">
                    </div>

                    <div class="inline-actions">
                        <a href="/mykeeper-lucas_vianna/src/Views/suporte.php" class="button button-secondary">Cancelar</a>
                        <button type="button" id="alterarsuporte" class="button button-primary">Salvar alterações</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</section>
<script src="/mykeeper-lucas_vianna/public/js/suporte_alterar.js"></script>
<?php include __DIR__ . '/../Includes/app_layout_end.php'; ?>
