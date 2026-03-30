<?php
    // Só executa se for POST
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        include_once('../php/conexao.php'); // conexão

        $retorno = [
            'status'   => '',
            'mensagem' => '',
            'data'     => []
        ];

        // Verifica se os dados vieram
        if(!isset($_POST['nome'], $_POST['email'], $_POST['senha'])){
            $retorno = [
                'status'   => 'erro',
                'mensagem' => 'Dados incompletos.',
                'data'     => []
            ];

            header("Content-type: application/json; charset=utf-8");
            echo json_encode($retorno);
            exit;
        }

        $nome  = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Prepara o INSERT
        $stmt = $conexao->prepare("INSERT INTO suporte (nome, email, senha) VALUES (?, ?, ?)");

        if(!$stmt){
            // Erro ao preparar
            $retorno = [
                'status'   => 'erro',
                'mensagem' => 'Erro na preparação da query.',
                'data'     => []
            ];
        }else{
            $stmt->bind_param("sss", $nome, $email, $senha);

            // Executa inserção
            if($stmt->execute()){
                $retorno = [
                    'status'   => 'ok',
                    'mensagem' => 'Registro inserido com sucesso.',
                    'data'     => []
                ];
            }else{
                $retorno = [
                    'status'   => 'nok',
                    'mensagem' => 'Falha ao inserir o registro.',
                    'data'     => []
                ];
            }

            $stmt->close();
        }

        $conexao->close();

        // Retorna JSON
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($retorno);
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Suporte - MyKeeper</title>
</head>
<body>
    <h1>Novo Suporte</h1>
    <form id="formSuporte">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" required><br><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" required><br><br>
        <button type="submit">Cadastrar</button>
        <button type="button" onclick="window.location.href='index.php'">Cancelar</button>
    </form>
    <p id="mensagem"></p>
    <script src="../js/valida_sessao.js"></script>
    <script src="suporte_novo.js"></script>
    <script>valida_sessao();</script>
</body>
</html>