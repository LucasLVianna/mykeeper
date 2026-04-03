<?php
    include_once(__DIR__ . '/../../config/valida_sessao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Perfil</title>
</head>
<body>
    <section>
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
                <input type="text" name="cep" id="cep">
            </div>

            <button type="button" id="alterarperfil">Salvar</button>
        </form>
    </section>

    <script src="/mykeeper/public/js/perfil_alterar.js"></script>
</body>
</html>