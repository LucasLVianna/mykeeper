<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');
include_once(__DIR__ . '/../Includes/product_units.php');

$pageTitle = 'Novo produto';
$pageSlug = 'inventory';
include __DIR__ . '/../Includes/app_layout_start.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Adicionar produto</h1>
            <p class="page-subtitle">Preencha os dados do novo produto.</p>
        </div>
    </div>

    <div class="standalone-sheet-wrap">
        <section class="surface-card standalone-sheet">
            <div class="surface-content">
                <form class="stack-form">
                    <div class="field-group">
                        <label class="field-label" for="nome_produto">Nome do produto</label>
                        <input class="field-control" type="text" name="nome_produto" id="nome_produto" placeholder="Ex: Leite integral">
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="categoria_produto">Categoria</label>
                        <select class="field-control" name="categoria_produto" id="categoria_produto">
                            <option value="">Selecione uma categoria</option>
                        </select>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="und_medida_produto">Unidade de medida</label>
                        <select class="field-control" name="und_medida_produto" id="und_medida_produto">
                            <?= renderProductUnitOptions() ?>
                        </select>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="icone_produto">Imagem do produto</label>
                        <input class="field-control" type="file" name="icone_produto" id="icone_produto" accept="image/png, image/jpeg, image/jpg">
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="preview">Preview</label>
                        <img src="" id="preview" style="display:none;">
                    </div>

                    <div class="inline-actions">
                        <a href="/mykeeper-lucas_vianna/src/Views/produto.php" class="button button-secondary">Cancelar</a>
                        <button type="button" id="addproduto" class="button button-primary">Adicionar produto</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</section>
<script src="/mykeeper-lucas_vianna/public/js/produto_novo.js"></script>
<?php include __DIR__ . '/../Includes/app_layout_end.php'; ?>
