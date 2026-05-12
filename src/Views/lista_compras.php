<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');
include_once(__DIR__ . '/sidebar.php'); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listas de Compras</title>
    <link rel="stylesheet" href="/mykeeper/public/css/lista_compras.css?v=9">
</head>
<body>
<section>
    <div>
        <h2>Listas de Compras</h2>
    </div>
    <div id="item"></div>
    <div><h4 id="mensagem"></h4></div>
    <div style="display: flex; justify-content: flex-end;">
        <button type="button" id="lista_compras_nova" class="addvs">Adicionar Lista</button>
    </div>
</section>
<script src="/mykeeper/public/js/lista_compras.js?v=9"></script>
<script src="/mykeeper/public/js/sidebar.js"></script>
</body>
</html>
