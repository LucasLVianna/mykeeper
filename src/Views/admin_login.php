<?php
session_start();
include_once(__DIR__ . '/../../config/verifica_login_realizado.php');

$pageTitle = 'Admin';
$authEyebrow = 'Administração';
$authHeadline = 'Área administrativa';
$authCopy = 'Acesse o painel de suporte.';
$authTheme = 'admin';
include __DIR__ . '/../Includes/auth_layout_start.php';
?>
<span class="auth-mark" aria-hidden="true">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 3l7 4v5c0 5-3.5 8-7 9-3.5-1-7-4-7-9V7l7-4z"></path>
        <path d="M9.5 12.5 11 14l3.5-3.5"></path>
    </svg>
</span>
<h1>Entrada admin</h1>
<p>Entre com a senha de acesso.</p>

<form class="stack-form">
    <div class="field-group">
        <label class="field-label" for="senha">Senha</label>
        <input class="field-control" type="password" id="senha" placeholder="Senha administrativa">
    </div>

    <button type="button" id="entrar" class="button button-primary">Entrar</button>
</form>
<script src="/mykeeper-lucas_vianna/public/js/admin_login.js"></script>
<?php include __DIR__ . '/../Includes/auth_layout_end.php'; ?>
