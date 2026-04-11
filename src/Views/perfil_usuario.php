<?php
    include_once(__DIR__ . '/../../config/valida_sessao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="/mykeeper/public/css/perfil_usuario.css">
</head>
<body class="profile-page">
    <?php include(__DIR__ . '/sidebar.php'); ?>
      
    <section class="main-content">
        <div class="profile-header">
            <h2>Perfil</h2>
        </div>
        
        <div class="profile-card">
            <p><strong>Nome:</strong> <span id="nome"></span></p>
            <p><strong>Email:</strong> <span id="email"></span></p>
            <p><strong>CEP:</strong> <span id="cep"></span></p>
        </div>

        <div class="profile-actions">
            <a class="btn-editar" href="" id="linkEditar">Editar</a>
            <button class="btn-desativar" id="desativarConta">Desativar Conta</button>
        </div>

    </section>

    <script src="/mykeeper/public/js/perfil_usuario.js?v=20260411-profile-fix"></script>
</body>
</html>