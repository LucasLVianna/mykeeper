<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
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
                    <button id="logoffButtonLink">Sair</button>
                </nav>
            </div>
        </aside>
        
    <section>
        <div>
            <h2>Perfil</h2>
        </div>
        
        <div>
            <p><strong>Nome:</strong> <span id="nome"></span></p>
            <p><strong>Email:</strong> <span id="email"></span></p>
            <p><strong>CEP:</strong> <span id="cep"></span></p>
        </div>

        <div>
            <button class = "btn-editar"><a href="" id="linkEditar">Editar</a></button>
            <button class="btn-desativar" id="desativarConta">Desativar Conta</button>
        </div>

    </section>

    <script src="/mykeeper/public/js/perfil_usuario.js"></script>
    <script src="/mykeeper/public/js/sidebar.js"></script>
</body>
</html>