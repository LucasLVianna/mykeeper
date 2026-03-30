<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte</title>
</head>
<body>
    <h1>Suporte</h1>

    <form id="formSuporte">
        <input type="hidden" id="suporteId">
        <label>Nome:</label><br>
        <input type="text" id="nome" required><br><br>
        <label>Email:</label><br>
        <input type="email" id="email" required><br><br>
        <label>Senha:</label><br>
        <input type="password" id="senha" required><br><br>
        <button type="submit" id="botaoEnviar">Cadastrar</button>
        <button type="button" id="botaoCancelar">Cancelar</button>
    </form>
    <p id="mensagem"></p>

    <h2>Lista</h2>
    <div id="lista"></div>

    <script src="../js/valida_sessao.js"></script>
    <script src="suporte_get.js"></script>
</body>
</html>