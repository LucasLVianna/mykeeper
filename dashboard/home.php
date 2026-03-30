<?php
    include_once('../php/conexao.php');
    include('../php/valida_sessao.php');
    

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
                    <button id="inventarioButtonLink"></button>
                    <button id="avencerButtonLink">A Vencer</button>
                    <button id="comprasButtonLink">Compras</button>
                    <button id="receitasButtonLink">Receitas</button>
                    <button id="historicoButtonLink">Historico</button>
                    <button id="logoff">Log Off</button>
                </nav>
            </div>
        </aside>
    </body>
        <script src="../js/valida_sessao.js">
        </script>
        <script>
            document.getElementById("inicioButtonLink").addEventListener("click", () => {
                window.location.href = '../dashboard/home.php';
            });
            document.getElementById("inventarioButtonLink").addEventListener("click", () => {
                window.location.href = '../inventario/inventario.php';
            });
            document.getElementById("avencerButtonLink").addEventListener("click", () => {
                window.location.href = '../avencer/avencer.php';
            });
            document.getElementById("comprasButtonLink").addEventListener("click", () => {
                window.location.href = '../compras/compras.php';
            });
            document.getElementById("receitasButtonLink").addEventListener("click", () => {
                window.location.href = '../receitas/receitas.php';
            });
            document.getElementById("historicoButtonLink").addEventListener("click", () => {
                window.location.href = '../historico/historico.php';
            });
            document.getElementById("logoff").addEventListener("click", () => {
                window.location.href = '../php/logoff.php';
            });
        </script>
    </html>