<div class="sheet-root" id="supportSheet" hidden>
    <div class="sheet-backdrop" data-close-sheet="supportSheet"></div>
    <section class="sheet-panel" role="dialog" aria-modal="true" aria-labelledby="supportSheetTitle">
        <div class="sheet-header">
            <div>
                <h2 class="sheet-title" id="supportSheetTitle">Cadastrar suporte</h2>
                <p class="sheet-description">Preencha os dados do novo acesso.</p>
            </div>
            <button class="sheet-close" type="button" data-close-sheet="supportSheet" aria-label="Fechar formulário">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="sheet-body">
            <form class="stack-form">
                <div class="field-group">
                    <label class="field-label" for="sheet_nome_suporte">Nome</label>
                    <input class="field-control" type="text" name="nome" id="sheet_nome_suporte">
                </div>

                <div class="field-group">
                    <label class="field-label" for="sheet_email_suporte">E-mail</label>
                    <input class="field-control" type="email" name="email" id="sheet_email_suporte">
                </div>

                <div class="field-group">
                    <label class="field-label" for="sheet_senha_suporte">Senha</label>
                    <input class="field-control" type="password" name="senha" id="sheet_senha_suporte" minlength="8">
                </div>

                <div class="inline-actions">
                    <button type="button" class="button button-secondary" data-close-sheet="supportSheet">Cancelar</button>
                    <button type="button" id="sheet_addsuporte" class="button button-primary">Cadastrar suporte</button>
                </div>
            </form>
        </div>
    </section>
</div>
