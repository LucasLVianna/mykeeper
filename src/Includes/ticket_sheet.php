<div class="sheet-root" id="ticketSheet" hidden>
    <div class="sheet-backdrop" data-close-sheet="ticketSheet"></div>
    <section class="sheet-panel" role="dialog" aria-modal="true" aria-labelledby="ticketSheetTitle">
        <div class="sheet-header">
            <div>
                <h2 class="sheet-title" id="ticketSheetTitle">Abrir ticket</h2>
                <p class="sheet-description">Descreva o atendimento que você precisa.</p>
            </div>
            <button class="sheet-close" type="button" data-close-sheet="ticketSheet" aria-label="Fechar formulário">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="sheet-body">
            <form class="stack-form">
                <div class="field-group">
                    <label class="field-label" for="sheet_titulo_ticket">Título</label>
                    <input class="field-control" type="text" name="titulo" id="sheet_titulo_ticket" placeholder="Ex: Erro ao cadastrar produto">
                </div>

                <div class="field-group">
                    <label class="field-label" for="sheet_descricao_ticket">Descrição</label>
                    <textarea class="field-control" name="descricao" id="sheet_descricao_ticket" placeholder="Descreva o que você precisa"></textarea>
                </div>

                <div class="inline-actions">
                    <button type="button" class="button button-secondary" data-close-sheet="ticketSheet">Cancelar</button>
                    <button type="button" id="sheet_criarTicket" class="button button-primary">Criar ticket</button>
                </div>
            </form>
        </div>
    </section>
</div>
