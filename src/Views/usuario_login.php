<?php
session_start();
include_once(__DIR__ . '/../../config/verifica_login_realizado.php');

$pageTitle = 'Login';
$authEyebrow = 'Acesso';
$authHeadline = 'Entre na sua conta';
$authCopy = 'Acesse seu MyKeeper e continue o controle do seu estoque.';
$authTheme = 'default';
include __DIR__ . '/../Includes/auth_layout_start.php';
?>
<span class="auth-mark" aria-hidden="true">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M8 3h8a2 2 0 0 1 2 2v16H6V5a2 2 0 0 1 2-2z"></path>
        <path d="M10 8h4"></path>
        <path d="M10 12h4"></path>
    </svg>
</span>
<h1>Bem-vindo</h1>
<p>Entre com seu e-mail e senha para continuar.</p>

<div class="auth-form-shell">
    <div id="authFeedback" class="auth-feedback" role="status" aria-live="polite"></div>

    <form id="formLogin" class="stack-form" novalidate>
        <div class="field-group">
            <label class="field-label" for="email">E-mail</label>
            <input class="field-control" type="text" name="email" id="email" placeholder="seu@email.com" autocomplete="email">
            <span id="emailError" class="field-error-text"></span>
        </div>

        <div class="field-group">
            <label class="field-label" for="senha">Senha</label>
            <input class="field-control" type="password" name="senha" id="senha" placeholder="Sua senha" minlength="8" autocomplete="current-password">
            <span class="field-hint">Esqueceu a senha? Entre em contato com o suporte.</span>
            <span id="senhaError" class="field-error-text"></span>
        </div>

        <button type="submit" id="loginSubmit" class="button button-primary auth-submit">Entrar</button>
    </form>
</div>

<div class="auth-divider">
    <span>Ainda n&atilde;o tem conta?</span>
    <button type="button" id="createAccount" class="button button-secondary">Criar conta</button>
</div>
<script src="/mykeeper-lucas_vianna/public/js/login.js?v=20260406c"></script>
<?php include __DIR__ . '/../Includes/auth_layout_end.php'; ?>
