<?php
    include_once(__DIR__ . '/../../config/valida_sessao.php');  
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar ticket</title>
    <link rel="stylesheet" href="/mykeeper/public/css/ticket_usuario_alterar.css">
    <link rel="stylesheet" href="/mykeeper/public/css/theme.css?v=20260411-theme">
    <link rel="stylesheet" href="/mykeeper/public/css/app-notifications.css">

    <script>
        (function () {
            var theme = localStorage.getItem('mykeeper-theme');
            document.documentElement.setAttribute('data-theme', theme === 'light' ? 'light' : 'dark');
        })();
    </script>
</head>
<body class="form-page">
    <a href="/mykeeper/src/Views/ticket_usuario.php" class="page-close-button" title="Fechar">&times;</a>
    <section>
        <div>
            <h2>Alterar ticket</h2>
        </div>
        <div>
            <p>Preencha os dados abaixo para alterar o ticket</p>
        </div>
        <form>
            <div>
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" placeholder="Título do ticket">
                <input type="hidden" id="ticketId">
            </div>
            <div>
                <label for="descricao">Descrição</label>
                <input type="text" name="descricao" id="descricao" placeholder="Descrição do ticket">
            </div>
            <button type="button" id="alterarTicket">Alterar ticket</button>
        </form>
    </section>
    <script src="/mykeeper/public/js/app-notifications.js"></script>
    <script src="/mykeeper/public/js/theme.js?v=20260411-theme"></script>
    <script src="/mykeeper/public/js/ticket_usuario_alterar.js"></script>
</body>
</html>