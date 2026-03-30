<?php
// 1. Verifica se a requisição é um POST (ou seja, se o formulário foi enviado)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once('../php/conexao.php');
    
    $retorno = [
        'status'   => '',
        'mensagem' => '',
        'data'     => []
    ];

    // Pegando os dados de forma segura (se não existir, fica vazio em vez de dar Warning)
    $nome  = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Verifica se os campos não estão vazios antes de tentar salvar
    if (!empty($nome) && !empty($email) && !empty($senha)) {
        
        // 2. Ordem das colunas e do bind_param corrigidas
        $stmt = $conexao->prepare("INSERT INTO usuario(email, nome, senha) VALUES(?, ?, ?)");
        $stmt->bind_param("sss", $email, $nome, $senha);
        
        try {
            $stmt->execute();
            
            if($stmt->affected_rows > 0){
                $retorno = [
                    'status' => 'ok',
                    'mensagem' => 'Registro inserido com sucesso',
                    'data' => []
                ];
            } else {
                $retorno = [
                    'status' => 'nok',
                    'mensagem' => 'Falha ao inserir o registro',
                    'data' => []
                ];
            }
        } catch (mysqli_sql_exception $e) {
            // Caso o email já exista ou dê outro erro de SQL, ele cai aqui
            $retorno = [
                'status' => 'erro',
                'mensagem' => 'Erro no banco de dados: ' . $e->getMessage(),
                'data' => []
            ];
        }

        $stmt->close();
        $conexao->close();
    } else {
        $retorno = [
            'status' => 'nok',
            'mensagem' => 'Todos os campos são obrigatórios',
            'data' => []
        ];
    }

    // 3. Define o cabeçalho JSON, imprime a resposta e PARA a execução do script.
    
    header("Content-type: application/json; charset=utf-8");
    echo json_encode($retorno);
    exit; // Isso impede que o HTML abaixo seja renderizado na resposta da API
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar usuário</title>
</head>
<body>
    <h1>Criar usuário</h1>
    <form action="usuario_novo.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>
        
        <input type="submit" id="enviar" value="Criar usuário">
    </form>
</body>
</html>