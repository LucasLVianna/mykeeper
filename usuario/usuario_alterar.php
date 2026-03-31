<?php
    include_once('../php/auth.php');
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
        <input type="submit" value="Alterar">
    </form>
    <script src="../js/valida_sessao.js"></script>
    <script src="usuario_alterar.js"></script>
</body>
</html>