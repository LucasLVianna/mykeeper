<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');
include_once(__DIR__ . '/sidebar.php'); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos da Lista</title>
    <link rel="stylesheet" href="/mykeeper/public/css/lista_compras_gerenciar_produtos.css">
</head>
<body>
<section>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 id="titulo_lista">Gerenciar Produtos</h2>
        </div>
        <a href="/mykeeper/src/Views/lista_compras.php">
            <img src="/mykeeper/public/assets/perto.png" alt="x.png" style="width:32px; height:32px; object-fit:contain;">
        </a>
    </div>
    
    <div id="info_lista"></div>

    <div style="display: flex; gap: 10px; margin: 15px 0;">
        <button type="button" id="adicionar_produto" class="addvs">Adicionar Produto</button>
        <button type="button" id="editar_lista" class="addvs">Editar Lista</button>
        <button type="button" id="deletar_lista" class="addvs" style="background-color: #ff6b6b;">Deletar Lista</button>
    </div>

    <div id="formulario_produto" style="display: none; border: 1px solid #ddd; padding: 15px; margin: 15px 0; border-radius: 5px;">
        <h3>Adicionar Produto</h3>
        <form>
            <div>
                <label for="nome_produto">Nome do Produto</label>
                <input type="text" name="nome_produto" id="nome_produto">
                <p id="error-nome"></p>
            </div>

            <div>
                <label for="quantidade_produto">Quantidade</label>
                <input type="number" name="quantidade_produto" id="quantidade_produto" value="1">
            </div>

            <div>
                <p id="error"></p>
            </div>

            <button type="button" id="confirmar_produto">Adicionar</button>
            <button type="button" id="cancelar_produto" style="background-color: #999;">Cancelar</button>
        </form>
    </div>

    <div id="lista_produtos"></div>
    <div><h4 id="mensagem"></h4></div>
</section>
<script src="/mykeeper/public/js/lista_compras_gerenciar_produtos.js"></script>
<script src="/mykeeper/public/js/sidebar.js"></script>
</body>
</html>
