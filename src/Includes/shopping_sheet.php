<div class="sheet-root" id="shoppingSheet" hidden>
    <div class="sheet-backdrop" data-close-shopping-sheet="true"></div>
    <section class="sheet-panel" role="dialog" aria-modal="true" aria-labelledby="shoppingSheetTitle">
        <div class="sheet-header">
            <div>
                <h2 class="sheet-title" id="shoppingSheetTitle">Adicionar a Lista</h2>
                <p class="sheet-description">Adicione um item manualmente a sua lista de compras.</p>
            </div>
            <button class="sheet-close" type="button" data-close-shopping-sheet="true" aria-label="Fechar formulario">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="sheet-body">
            <form id="shoppingSheetForm" class="sheet-form">
                <div class="field-group">
                    <label class="field-label" for="shopping_nome_item">Nome do item</label>
                    <input class="field-control" type="text" id="shopping_nome_item" name="nome_item" placeholder="Ex: Ovos">
                    <p class="field-error" id="error_shopping_nome_item" hidden></p>
                </div>
                <div class="field-group">
                    <label class="field-label" for="shopping_quantidade_item">Quantidade</label>
                    <input class="field-control" type="number" id="shopping_quantidade_item" name="quantidade_item" min="1" value="1">
                    <p class="field-error" id="error_shopping_quantidade_item" hidden></p>
                </div>
                <div class="field-group">
                    <label class="field-label" for="shopping_categoria_item">Categoria</label>
                    <select class="field-control" id="shopping_categoria_item" name="categoria_item">
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
                <button class="button button-primary" type="submit">Adicionar a Lista</button>
            </form>
        </div>
    </section>
</div>
