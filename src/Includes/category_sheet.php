<div class="sheet-root" id="categorySheet" hidden>
    <div class="sheet-backdrop" data-close-sheet="categorySheet"></div>
    <section class="sheet-panel" role="dialog" aria-modal="true" aria-labelledby="categorySheetTitle">
        <div class="sheet-header">
            <div>
                <h2 class="sheet-title" id="categorySheetTitle">Adicionar categoria</h2>
                <p class="sheet-description">Preencha os dados da nova categoria.</p>
            </div>
            <button class="sheet-close" type="button" data-close-sheet="categorySheet" aria-label="Fechar formulário">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="sheet-body">
            <form class="stack-form">
                <div class="field-group">
                    <label class="field-label" for="sheet_nome_categoria">Nome da categoria</label>
                    <input class="field-control" type="text" name="nome_categoria" id="sheet_nome_categoria" placeholder="Ex: Laticínios">
                </div>

                <div class="field-group">
                    <label class="field-label" for="sheet_descricao_categoria">Descrição</label>
                    <input class="field-control" type="text" name="descricao_categoria" id="sheet_descricao_categoria" placeholder="Ex: Produtos refrigerados">
                </div>

                <div class="field-group">
                    <label class="field-label" for="sheet_icone_categoria">Ícone da categoria</label>
                    <input class="field-control" type="file" name="icone_categoria" id="sheet_icone_categoria" accept="image/png, image/jpeg, image/jpg">
                </div>

                <div class="field-group">
                    <label class="field-label" for="sheet_preview_categoria">Preview</label>
                    <img src="" id="sheet_preview_categoria" style="display:none;">
                </div>

                <div class="inline-actions">
                    <button type="button" class="button button-secondary" data-close-sheet="categorySheet">Cancelar</button>
                    <button type="button" id="sheet_addcategoria" class="button button-primary">Adicionar categoria</button>
                </div>
            </form>
        </div>
    </section>
</div>
