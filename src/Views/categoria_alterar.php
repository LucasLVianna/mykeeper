<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');

$pageTitle = 'Alterar categoria';
$pageSlug = 'categories';
include __DIR__ . '/../Includes/app_layout_start.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Editar categoria</h1>
            <p class="page-subtitle">Atualize os dados da categoria selecionada.</p>
        </div>
    </div>

    <div class="standalone-sheet-wrap">
        <section class="surface-card standalone-sheet">
            <div class="surface-content">
                <form class="stack-form">
                    <div class="field-group">
                        <label class="field-label" for="nome_categoria">Nome da categoria</label>
                        <input class="field-control" type="text" name="nome_categoria" id="nome_categoria">
                        <input type="hidden" id="id">
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="descricao_categoria">Descrição</label>
                        <input class="field-control" type="text" name="descricao_categoria" id="descricao_categoria">
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="icone_categoria">Ícone da categoria</label>
                        <input class="field-control" type="file" name="icone_categoria" id="icone_categoria" accept="image/png, image/jpeg, image/jpg">
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="preview">Preview</label>
                        <img src="" id="preview" style="display:none;">
                    </div>

                    <div class="inline-actions">
                        <a href="/mykeeper-lucas_vianna/src/Views/categoria.php" class="button button-secondary">Cancelar</a>
                        <button type="button" id="alterarcategoria" class="button button-primary">Salvar alterações</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</section>
<script src="/mykeeper-lucas_vianna/public/js/categoria_alterar.js"></script>
<?php include __DIR__ . '/../Includes/app_layout_end.php'; ?>
