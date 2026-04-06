<?php include_once __DIR__ . '/product_units.php'; ?>
<div class="sheet-root" id="productSheet" hidden>
    <div class="sheet-backdrop" data-close-sheet="productSheet"></div>
    <section class="sheet-panel" role="dialog" aria-modal="true" aria-labelledby="productSheetTitle">
        <div class="sheet-header">
            <div>
                <h2 class="sheet-title" id="productSheetTitle">Adicionar produto</h2>
                <p class="sheet-description">Preencha os dados do novo produto.</p>
            </div>
            <button class="sheet-close" type="button" data-close-sheet="productSheet" aria-label="Fechar formulário">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="sheet-body">
            <form class="stack-form">
                <div class="field-group">
                    <label class="field-label" for="sheet_nome_produto">Nome do produto</label>
                    <input class="field-control" type="text" name="nome_produto" id="sheet_nome_produto" placeholder="Ex: Leite integral">
                </div>

                <div class="field-group">
                    <label class="field-label" for="sheet_categoria_produto">Categoria</label>
                    <select class="field-control" name="categoria_produto" id="sheet_categoria_produto">
                        <option value="">Selecione uma categoria</option>
                    </select>
                </div>

                <div class="field-group">
                    <label class="field-label" for="sheet_und_medida_produto">Unidade de medida</label>
                    <select class="field-control" name="und_medida_produto" id="sheet_und_medida_produto">
                        <?= renderProductUnitOptions() ?>
                    </select>
                </div>

                <div class="field-group">
                    <label class="field-label" for="sheet_icone_produto">Imagem do produto</label>
                    <input class="field-control" type="file" name="icone_produto" id="sheet_icone_produto" accept="image/png, image/jpeg, image/jpg">
                </div>

                <div class="field-group">
                    <label class="field-label" for="sheet_preview_produto">Preview</label>
                    <img src="" id="sheet_preview_produto" style="display:none;">
                </div>

                <div class="inline-actions">
                    <button type="button" class="button button-secondary" data-close-sheet="productSheet">Cancelar</button>
                    <button type="button" id="sheet_addproduto" class="button button-primary">Adicionar produto</button>
                </div>
            </form>
        </div>
    </section>
</div>
