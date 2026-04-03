<?php
    include_once('../../config/auth.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Usuário</title>
</head>
<body>
    <h1>Alterar usuários</h1>
    <form id="formAlterar">
        <input type="hidden" id="id" name="id">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>
        <label for="cep">CEP:</label>
        <input type="text" id="cep" name="cep" required><br><br>
        <input type="submit" value="Alterar">
    </form>
    <script src="../../public/js/valida_sessao.js"></script>
    <script src="../../public/js/usuario_alterar.js"></script>
</body>
</html>