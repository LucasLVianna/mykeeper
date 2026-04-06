<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');

$pageTitle = 'Perfil';
$pageSlug = 'profile';
include __DIR__ . '/../Includes/app_layout_start.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Perfil</h1>
            <p class="page-subtitle">Confira e atualize seus dados.</p>
        </div>
    </div>

    <div class="surface-card">
        <div class="profile-card">
            <div class="profile-row">
                <span class="profile-label">Nome</span>
                <span id="nome" class="profile-value">Carregando...</span>
            </div>
            <div class="profile-row">
                <span class="profile-label">E-mail</span>
                <span id="email" class="profile-value">Carregando...</span>
            </div>
            <div class="profile-row">
                <span class="profile-label">CEP</span>
                <span id="cep" class="profile-value">Carregando...</span>
            </div>
            <div class="profile-actions">
                <a href="#" id="linkEditar" class="button button-primary">Editar perfil</a>
                <button class="button button-danger" id="desativarConta" type="button">Desativar conta</button>
            </div>
        </div>
    </div>
</section>
<script src="/mykeeper-lucas_vianna/public/js/perfil_usuario.js"></script>
<?php include __DIR__ . '/../Includes/app_layout_end.php'; ?>
