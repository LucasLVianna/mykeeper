<?php
    include_once(__DIR__ . '/../../config/valida_sessao.php');
    include_once(__DIR__ . '/../../config/valida_admin.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Suporte</title>
    <link rel="stylesheet" href="/mykeeper/public/css/suporte_novo.css">
</head>

<body class="form-page">
    <?php include(__DIR__ . '/sidebar.php'); ?>
    <section class="main-content">
        <div class="form-page-header">
            <h2>Novo Usuario Suporte</h2>
            <a href="/mykeeper/src/Views/suporte.php" class="page-close-button page-close-inline" title="Fechar">&times;</a>
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
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" minlength="8">
            </div>
            
            <button type="button" id="addsuporte">Adicionar</button>
        </form>
    </section>

    <script src="/mykeeper/public/js/suporte_novo.js"></script>
</body>

</html>