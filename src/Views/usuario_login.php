<?php
    session_start();
    include_once('../../config/verifica_login_realizado.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/mykeeper/public/css/usuario_login.css">
    <link rel="stylesheet" href="/mykeeper/public/css/theme.css?v=20260411-theme">
    <link rel="stylesheet" href="/mykeeper/public/css/app-notifications.css">

    <script>
        (function () {
            var theme = localStorage.getItem('mykeeper-theme');
            document.documentElement.setAttribute('data-theme', theme === 'light' ? 'light' : 'dark');
        })();
    </script>
</head>

<body class="login-page">
    <section>
        <div>
            <div>
                <h2>Bem-vindo ao MyKeeper</h2>
            </div>
            <div>
                <p>Entre com sua conta para acessar seu estoque alimenticio</p>
            </div>

            <form id="formLogin">

                <div>
                    <div>
                        <label for="email">E-mail</label>
                    </div>
                    <div>
                        <input type="text" name="email" id="email" placeholder="seu@email.com">
                    </div>
                </div>


                <div>
                    <div>
                        <label for="senha">Senha</label> <br>
                    </div>
                    <div>
                        <input type="password" name="senha" id="senha" placeholder="••••••" minLength="8">
                    </div>
                    <div>
                        <p>Esqueceu a senha? <a href="#">Redefinir</a></p>
                    </div>
                </div>

                <p id="erro" style="color:salmon"></p>
                <button type="submit">Entrar</button>
            </form>

            <div class="divider">
                <span>AINDA NÃO TEM CONTA?</span>
                <button type="button" id="createAccount">Criar uma conta</button>
            </div>

        </div>
        
    </section>

<script src="/mykeeper/public/js/app-notifications.js?v=20260411-login-notify"></script>
<script src="/mykeeper/public/js/theme.js?v=20260411-theme"></script>
<script src="/mykeeper/public/js/login.js?v=20260411-login-notify"></script>
</body>
</html>