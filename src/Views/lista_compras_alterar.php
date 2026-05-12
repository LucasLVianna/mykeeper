<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Lista de Compras</title>
    <link rel="stylesheet" href="/mykeeper/public/css/lista_compras_alterar.css">
</head>
<body>
    <section>
    <a href="/mykeeper/src/Views/lista_compras.php">
        <img src="/mykeeper/public/assets/perto.png" alt="x.png" style="position:fixed; top:12px; left:12px; width:32px; height:32px; object-fit:contain;">
    </a>

    <form>
        <div>
            <label for="nome_lista">Nome da Lista</label>
            <input type="text" name="nome_lista" id="nome_lista">
            <p id="error-nome"></p>
        </div>

        <div>
            <label for="status_lista">Status</label>
            <select name="status_lista" id="status_lista">
                <option value="aberta">Aberta</option>
                <option value="concluida">Concluída</option>
                <option value="arquivada">Arquivada</option>
            </select>
        </div>

        <div>
            <label for="id_estoque">Estoque vinculado</label>
            <select name="id_estoque" id="id_estoque">
                <option value="">Selecione um estoque</option>
            </select>
            <p id="error-estoque"></p>
        </div>

        <div>
            <p id="error"></p>
        </div>

        <button type="button" id="alterar_lista">Alterar</button>
    </form>

    </section>
    <script src="/mykeeper/public/js/lista_compras_alterar.js?v=3"></script>
</body>
</html>
