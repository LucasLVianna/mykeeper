<?php
    include_once(__DIR__ . '/../../config/valida_sessao.php');  
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo ticket</title>
    <link rel="stylesheet" href="/mykeeper/public/css/ticket_usuario_novo.css">
</head>

<body class="form-page">
    <?php include(__DIR__ . '/sidebar.php'); ?>
    <section class="main-content">
            <div class="form-page-header">
                <h2>Criar ticket</h2>
                <a href="/mykeeper/src/Views/ticket_usuario.php" class="page-close-button page-close-inline" title="Fechar">&times;</a>
            </div>
            <div>
                <p>Preencha os dados abaixo para criar um novo ticket</p>
            </div>

            <form>
                <div>
                    <div>
                        <label for="titulo">Título</label>
                    </div>
                    <div>
                        <input type="text" name="titulo" id="titulo" placeholder="Título do ticket">
                    </div>
                </div>
                <div>
                    <div>
                        <label for="descricao">Descrição</label>
                    </div>
                    <div>
                        <input type="text" name="descricao" id="descricao" placeholder="Descrição do ticket">
                    </div>
                </div>

                <button type="button" id="criarTicket">Criar ticket</button>
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
</body>
<script src="/mykeeper/public/js/ticket_usuario_novo.js"></script>
</html>