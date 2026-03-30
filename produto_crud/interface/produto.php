<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
</head>
<body>
    <aside class="sideNavBar">
            <div>
                <h2>MyKeeper</h2>
            </div>
            <div>
                <nav>
                    <button id="inicioButtonLink">Início</button>
                    <button id="inventarioButtonLink">Inventario</button>
                    <button id="produtosButtonLink">Produtos registrados</button>
                    <button id="avencerButtonLink">A Vencer</button>
                    <button id="comprasButtonLink">Compras</button>
                    <button id="receitasButtonLink">Receitas</button>
                    <button id="historicoButtonLink">Historico</button>
                </nav>
            </div>
        </aside>
        
    <section>
        <div>
            <h2>Produtos Registrados</h2>
        </div>
        <div id="item"></div>
        <div>
            <button type="button" id="produto_novo" class="addvs">Adicionar Produto</button>
        </div>
    </section>
    <script src="../js/produto.js"></script>
</body>
</html>