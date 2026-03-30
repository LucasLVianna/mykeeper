<?php
    // só executa se for requisição POST
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        include_once('../php/conexao.php'); // conexão com banco

        $retorno = [
            'status'   => '',
            'mensagem' => '',
            'data'     => []
        ];

        // verifica se veio o id pela URL
        if(isset($_GET['id'])){
            $nome  = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            // Prepara o UPDATE
            $stmt = $conexao->prepare("UPDATE suporte SET nome = ?, email = ?, senha = ? WHERE id = ?");
            $stmt->bind_param("sssi", $nome, $email, $senha, $_GET['id']);
            $stmt->execute();

            // verifica se alterou algo
            if($stmt->affected_rows > 0){
                $retorno = [
                    'status'   => 'ok',
                    'mensagem' => 'Registro alterado com sucesso.',
                    'data'     => []
                ];
            }else{
                $retorno = [
                    'status'   => 'nok',
                    'mensagem' => 'Não posso alterar um registro.' . json_encode($_GET),
                    'data'     => []
                ];
            }

            $stmt->close();
        }else{
            // caso não tenha id
            $retorno = [
                'status'   => 'nok',
                'mensagem' => 'Não posso alterar um registro sem um ID informado.',
                'data'     => []
            ];
        }

        $conexao->close();

        // retorna JSON pro js
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
    <title>Alterar Suporte - MyKeeper</title>
</head>
<body>
    <h1>Alterar Suporte</h1>
    <form id="formSuporte">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" required><br><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" required><br><br>
        <button type="submit">Salvar</button>
        <button type="button" onclick="window.location.href='index.php'">Cancelar</button>
    </form>
    <p id="mensagem"></p>
    <script src="../js/valida_sessao.js"></script>
    <script src="suporte_alterar.js"></script>
    <script>valida_sessao();</script>
</body>
</html>