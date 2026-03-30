<php


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Produto</title>
</head>

<body>
    <section>
        <form>
            <div>
                <label for="nome_produto">Nome</label>
                <input type="text" name="nome_produto" id="nome_produto">
            </div>

            <div>
                <label for="categoria_produto">Categoria</label>
                <input type="text" name="categoria_produto" id="categoria_produto">
            </div>
            <div>
                <label for="und_medida_produto">Unidade de medida</label>
                <input type="text" name="und_medida_produto" id="und_medida_produto">
            </div>

            <button type="button" id="addproduto">Adicionar</button>
        </form>
    </section>

    <script src="../js/produto_novo.js"></script>
</body>

</html>