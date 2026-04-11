<?php
    include_once(__DIR__ . '/../../config/valida_sessao.php');
    include_once(__DIR__ . '/../../config/valida_admin.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas de Suporte</title>
    <link rel="stylesheet" href="/mykeeper/public/css/suporte.css">
</head>
<body>
    <?php include_once(__DIR__ . '/sidebar.php'); ?>
    <section class="main-content">
        <div>
            <h2>Contas de Suporte</h2>
        </div>
        <div id="item"></div>
        <div>
            <button type="button" id="suporte_novo" class="addvs">Adicionar Suporte</button>
        </div>

    </section>
    <script src="/mykeeper/public/js/suporte.js"></script>
    <script src="/mykeeper/public/js/sidebar.js"></script>
</body>
</html>