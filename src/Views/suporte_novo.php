<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');
include_once(__DIR__ . '/../../config/valida_admin.php');

$pageTitle = 'Novo suporte';
$pageSlug = 'admin';
include __DIR__ . '/../Includes/app_layout_start.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Cadastrar suporte</h1>
            <p class="page-subtitle">Preencha os dados do novo acesso.</p>
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
                        <label class="field-label" for="senha">Senha</label>
                        <input class="field-control" type="password" name="senha" id="senha" minlength="8">
                    </div>

                    <div class="inline-actions">
                        <a href="/mykeeper-lucas_vianna/src/Views/suporte.php" class="button button-secondary">Cancelar</a>
                        <button type="button" id="addsuporte" class="button button-primary">Cadastrar suporte</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</section>
<script src="/mykeeper-lucas_vianna/public/js/suporte_novo.js"></script>
<?php include __DIR__ . '/../Includes/app_layout_end.php'; ?>
