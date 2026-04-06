<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');

$pageTitle = 'Editar perfil';
$pageSlug = 'profile';
include __DIR__ . '/../Includes/app_layout_start.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Alterar perfil</h1>
            <p class="page-subtitle">Atualize seus dados de acesso e contato.</p>
        </div>
    </div>

    <div class="standalone-sheet-wrap">
        <section class="surface-card standalone-sheet">
            <div class="surface-content">
                <form class="stack-form">
                    <div class="field-group">
                        <label class="field-label" for="nome">Nome</label>
                        <input class="field-control" type="text" name="nome" id="nome">
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="email">E-mail</label>
                        <input class="field-control" type="email" name="email" id="email">
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="cep">CEP</label>
                        <input class="field-control" type="text" name="cep" id="cep">
                    </div>

                    <div class="inline-actions">
                        <a href="/mykeeper-lucas_vianna/src/Views/perfil_usuario.php" class="button button-secondary">Cancelar</a>
                        <button type="button" id="alterarperfil" class="button button-primary">Salvar perfil</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</section>
<script src="/mykeeper-lucas_vianna/public/js/perfil_alterar.js"></script>
<?php include __DIR__ . '/../Includes/app_layout_end.php'; ?>
