<?php
    include_once(__DIR__ . '/../../config/valida_sessao.php');  
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets de Suporte</title>
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
                    <button id="categoriasButtonLink">Categorias</button>
                    <button id="avencerButtonLink">A Vencer</button>
                    <button id="comprasButtonLink">Compras</button>
                    <button id="receitasButtonLink">Receitas</button>
                    <button id="historicoButtonLink">Historico</button>
                    <button id="perfilButtonLink">Perfil</button>
                    <button id="adminHomeButtonLink">Admin</button>
                    <button id="ticketButtonLink">Tickets</button>
                    <button id="logoffButtonLink">Sair</button>
                </nav>
            </div>
        </aside>
        
    <section>
        <div>
            <h2>Tickets de Suporte</h2>
        </div>
        <div id="item"></div>
        <div>
            <button type="button" id="ticket_novo" class="addvs">Adicionar Ticket</button>
        </div>
    </section>
    <script src="/mykeeper/public/js/ticket.js"></script>
    <script src="/mykeeper/public/js/sidebar.js"></script>
</body>
</html>