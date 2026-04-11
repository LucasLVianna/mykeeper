<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Categoria</title>
    <link rel="stylesheet" href="/mykeeper/public/css/categoria_novo.css">
</head>
<body class="form-page">
    <?php include(__DIR__ . '/sidebar.php'); ?>
    <section class="main-content">
    <div class="form-page-header">
        <h2>Nova Categoria</h2>
        <a href="/mykeeper/src/Views/categoria.php" class="page-close-button page-close-inline" title="Fechar">&times;</a>
    </div>

    <form>
        <div>
            <label for="nome_categoria">Nome</label>
            <input type="text" name="nome_categoria" id="nome_categoria">
        </div>

        <div>
            <label for="descricao_categoria">Descrição</label>
            <input type="text" name="descricao_categoria" id="descricao_categoria">
        </div>

        <div>
            <label for="icone_categoria">Ícone da categoria</label>
            <input type="file" name="icone_categoria" id="icone_categoria" accept="image/png, image/jpeg, image/jpg">
        </div>

        <div>
            <img src="" id="preview" style="display:none; width:100px; height:100px;">
        </div>

        <button type="button" id="addcategoria">Adicionar</button>
    </form>
    <div id="toast" style="
        display:none;
        position:fixed;
        bottom:30px;
        right:30px;
        padding:15px 25px;
        border-radius:10px;
        color:white;
        font-size:1rem;
        z-index:9999;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        transition: opacity 0.5s;
    "></div>

    </section>
    <script src="/mykeeper/public/js/categoria_novo.js"></script>
</body>
</html>