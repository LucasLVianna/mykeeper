<?php
    include_once('../../config/auth.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários</title>
</head>
<body>
    <h1>Usuários</h1>
    <button id="novo">Novo usuário</button>
    <button id="logoff">Logoff</button>
    
    <div id="lista"></div>
    
    <script src="../../public/js/valida_sessao.js"></script>
    <script src="../../public/js/usuario_get.js"></script>
</body>
</html>