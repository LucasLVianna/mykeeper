<?php
    include_once(__DIR__ . '/../../config/valida_sessao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Edicao</title>
    <link rel="stylesheet" href="/mykeeper/public/css/perfil_alterar.css?v=20260411-profile-fix">
</head>
<body data-user-id="<?php echo isset($_SESSION['usuario']['id']) ? (int)$_SESSION['usuario']['id'] : ''; ?>">
    <?php include(__DIR__ . '/sidebar.php'); ?>
    <section class="main-content">
        <div class="form-page-header">
            <h2>Alterar Perfil</h2>
            <a href="/mykeeper/src/Views/perfil_usuario.php" class="page-close-button page-close-inline" title="Fechar">&times;</a>
        </div>
        <form>
            <div>
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome">
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>

            <div>
                <label for="cep">CEP</label>
                <input type="text" name="cep" id="cep" placeholder="00000-000" maxlength="9" inputmode="numeric">
            </div>

            <button type="button" id="alterarperfil">Salvar</button>
        </form>
    </section>

    <script src="/mykeeper/public/js/perfil_alterar.js?v=20260411-profile-fix"></script>
</body>
</html>