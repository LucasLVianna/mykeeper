<?php
    include_once(__DIR__ . '/../../config/valida_sessao.php');
?>
    <!DOCTYPE html>
    <html lang="en">    

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
    </head>

    <body>
        <header>
            <button id="colorMode">White/dark mode</button>
        </header>
        <aside class="sideNavBar">
            <div>
                <h2>MyKeeper</h2>
            </div>
            <div>
                <nav>
                    <button id="inicioButtonLink">Início</button>
                <button id="inventarioButtonLink">Inventario</button>
                <button id="produtosButtonLink">Produtos registrados</button>
                <button id="categoriasButtonLink">Categorias</button>
                <button id="avencerButtonLink">A Vencer</button>
                <button id="comprasButtonLink">Compras</button>
                <button id="receitasButtonLink">Receitas</button>
                <button id="historicoButtonLink">Historico</button>
                <button id="logoffButtonLink">Sair</button>
                </nav>
            </div>
        </aside>
    </body>

    <script src="/mykeeper/public/js/home.js"></script>
    <script src="/mykeeper/public/js/sidebar.js"></script>
    </html>