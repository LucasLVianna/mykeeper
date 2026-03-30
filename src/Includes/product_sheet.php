<div class="sheet-root" id="productSheet" hidden>
    <div class="sheet-backdrop" data-close-sheet="true"></div>
    <section class="sheet-panel" role="dialog" aria-modal="true" aria-labelledby="productSheetTitle">
        <div class="sheet-header">
            <div>
                <h2 class="sheet-title" id="productSheetTitle">Adicionar Produto</h2>
                <p class="sheet-description" id="productSheetDescription">Preencha os dados do novo produto.</p>
            </div>
            <button class="sheet-close" type="button" data-close-sheet="true" aria-label="Fechar formulario">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="sheet-body">
            <form id="productSheetForm" class="sheet-form">
                <input type="hidden" id="sheet_product_id" name="id">
                <div class="field-group">
                    <label class="field-label" for="sheet_nome_produto">Nome do produto</label>
                    <input class="field-control" type="text" id="sheet_nome_produto" name="nome_produto" placeholder="Ex: Leite Integral">
                    <p class="field-error" id="error_sheet_nome_produto" hidden></p>
                </div>
                <div class="field-group">
                    <label class="field-label" for="sheet_data_validade_produto">Data de vencimento</label>
                    <input class="field-control" type="date" id="sheet_data_validade_produto" name="data_validade_produto">
                    <p class="field-error" id="error_sheet_data_validade_produto" hidden></p>
                </div>
                <div class="field-group">
                    <label class="field-label" for="sheet_quantidade_produto">Quantidade</label>
                    <input class="field-control" type="number" id="sheet_quantidade_produto" name="quantidade_produto" min="1" value="1">
                    <p class="field-error" id="error_sheet_quantidade_produto" hidden></p>
                </div>
                <div class="field-group">
                    <label class="field-label" for="sheet_categoria_produto">Categoria</label>
                    <select class="field-control" id="sheet_categoria_produto" name="categoria_produto">
                        <option value="laticinios">Laticinios</option>
                        <option value="carnes">Carnes</option>
                        <option value="frutas">Frutas</option>
                        <option value="verduras">Verduras</option>
                        <option value="bebidas">Bebidas</option>
                        <option value="congelados">Congelados</option>
                        <option value="condimentos">Condimentos</option>
                        <option value="outros">Outros</option>
                    </select>
                </div>
                <div class="field-group">
                    <label class="field-label" for="sheet_und_medida_produto">Unidade de medida</label>
                    <input class="field-control" type="text" id="sheet_und_medida_produto" name="und_medida_produto" placeholder="Ex: Unidade">
                    <p class="field-error" id="error_sheet_und_medida_produto" hidden></p>
                </div>
                <button class="button button-primary" type="submit" id="productSheetSubmit">Adicionar Produto</button>
            </form>
        </div>
    </section>
</div>
