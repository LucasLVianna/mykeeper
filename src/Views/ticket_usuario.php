<?php
    include_once(__DIR__ . '/../../config/valida_sessao.php');  
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets de Suporte</title>
    <link rel="stylesheet" href="/mykeeper/public/css/ticket_usuario.css">
</head>
<body>
    <?php include_once(__DIR__ . '/sidebar.php'); ?>
    <section class="main-content">
        <div>
            <h2>Tickets de Suporte</h2>
        </div>
        <div id="item"></div>
        <p id="mensagem"></p>
        <div>
            <button type="button" id="ticket_novo" class="addvs">Adicionar Ticket</button>
        </div>
    </section>
    <?php include_once(__DIR__ . '/confirmacao.php'); ?>
    <script src="/mykeeper/public/js/confirmacao.js"></script>
    <script src="/mykeeper/public/js/ticket.js"></script>
</body>
</html>