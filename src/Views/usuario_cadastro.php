<?php
$pageTitle = 'Cadastro';
$authEyebrow = 'Novo cadastro';
$authHeadline = 'Crie sua conta';
$authCopy = 'Cadastre-se para come&ccedil;ar a usar o MyKeeper.';
$authTheme = 'signup';
include __DIR__ . '/../Includes/auth_layout_start.php';
?>
<span class="auth-mark" aria-hidden="true">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 5v14"></path>
        <path d="M5 12h14"></path>
    </svg>
</span>
<h1>Criar conta</h1>
<p>Preencha seus dados para come&ccedil;ar.</p>

<div class="auth-form-shell">
    <div id="cadastroFeedback" class="auth-feedback" role="status" aria-live="polite"></div>

    <form id="formCadastro" class="stack-form" novalidate>
        <div class="field-group">
            <label class="field-label" for="nome">Nome completo</label>
            <input class="field-control" type="text" name="nome" id="nome" placeholder="Seu nome">
            <span id="nomeError" class="field-error-text"></span>
        </div>

        <div class="field-group">
            <label class="field-label" for="email">E-mail</label>
            <input class="field-control" type="text" name="email" id="email" placeholder="seu@email.com" autocomplete="email">
            <span id="cadastroEmailError" class="field-error-text"></span>
        </div>

        <div class="field-group">
            <label class="field-label" for="cep">CEP</label>
            <input class="field-control" type="text" name="cep" id="cep" placeholder="00000-000" maxlength="9" inputmode="numeric">
            <span id="cepError" class="field-error-text"></span>
        </div>

        <div class="field-group">
            <label class="field-label" for="senha">Senha</label>
        <input class="field-control" type="password" name="senha" id="senha" placeholder="M&iacute;nimo de 8 caracteres" minlength="8" autocomplete="new-password">
            <span class="field-hint">Use pelo menos 8 caracteres.</span>
            <span id="cadastroSenhaError" class="field-error-text"></span>
        </div>

        <button type="submit" id="cadastroSubmit" class="button button-primary auth-submit">Criar conta</button>
    </form>
</div>

<div class="auth-divider">
    <span>J&aacute; possui conta?</span>
    <button type="button" id="entrar" class="button button-secondary">Entrar</button>
</div>
<script src="/mykeeper-lucas_vianna/public/js/cadastrar.js?v=20260406b"></script>
<?php include __DIR__ . '/../Includes/auth_layout_end.php'; ?>
