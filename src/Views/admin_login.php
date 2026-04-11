<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <link rel="stylesheet" href="/mykeeper/public/css/admin_login.css">
    <link rel="stylesheet" href="/mykeeper/public/css/app-notifications.css">
</head>

<body>
    
    <section>
        <div>
            <div>
                <h2>Página de entrada para Administradores</h2>
            </div>
            <div>
                <form>
                    <input type="password" id="senha" placeholder="Senha de acesso">
                    <button type="button" id="entrar">Entrar</button>
                </form>
            </div>
        </div>
    </section>

<script src="/mykeeper/public/js/app-notifications.js?v=20260411-login-notify"></script>
<script src="/mykeeper/public/js/admin_login.js?v=20260411-login-notify"></script>
</body>
</html>