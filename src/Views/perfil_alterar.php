<?php
    include_once(__DIR__ . '/../../config/valida_sessao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Perfil</title>
    <link rel="stylesheet" href="/mykeeper/public/css/perfil_alterar.css">
</head>
<body>
    <section>
    <a href="/mykeeper/src/Views/perfil_usuario.php">
        <img src="/mykeeper/public/assets/perto.png" alt="x.png" style="position:fixed; top:12px; left:12px; width:32px; height:32px; object-fit:contain;">
    </a>
        <form>
            <div>
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome">
                <p id="error-nome"></p>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
                <p id="error-email"></p>
            </div>

            <div>
                <label for="cep">CEP</label>
                <input type="text" name="cep" id="cep" placeholder="00000-000" maxlength="9" inputmode="numeric">
                <p id="error-cep"></p>
            </div>
            <div>
                <p id="error"></p>
            </div>
            <button type="button" id="alterarperfil">Salvar</button>
        </form>
    </section>

    <script src="/mykeeper/public/js/perfil_alterar.js?v=20260406-cep"></script>
</body>
</html>