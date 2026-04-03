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
</head>
<body>
    <aside class="sideNavBar">
            <div>
                <h2>SUPORTE HOME</h2>
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
                    <button id="adminHomeButtonLink">Admin</button>
                    <button id="perfilButtonLink">Perfil</button>
                    <button id="logoffButtonLink">Sair</button>
                </nav>
            </div>
        </aside>
        
    <section>
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