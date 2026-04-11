<?php
    include_once(__DIR__ . '/../../config/valida_sessao.php');
    include_once(__DIR__ . '/../../config/valida_admin.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Suporte</title>
    <link rel="stylesheet" href="/mykeeper/public/css/suporte_novo.css">
</head>

<body>
    <section>
        <form>
            <div>
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome">
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>

            <div>
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" minlength="8">
            </div>
            
            <p id="erro" style="color:salmon;"></p>
            <button type="button" id="addsuporte">Adicionar</button>
        </form>
    </section>

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

    <script src="/mykeeper/public/js/suporte_novo.js"></script>
</body>

</html>