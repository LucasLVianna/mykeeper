<?php
// É uma boa prática colocar o session_start() logo na primeira linha
session_start();    

// 1. Só executa a lógica do banco se a requisição for um POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once('../php/conexao.php');
    
    $retorno = [
        'status'    => '',
        'mensagem'  => '',
        'data'      => []
    ];

    // Pega os dados com segurança
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Verifica se os campos não estão vazios
    if (!empty($email) && !empty($senha)) {
        
        $stmt = $conexao->prepare("SELECT * FROM usuario WHERE email = ? AND senha = ?");
        $stmt->bind_param("ss", $email, $senha);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $tabela = [];
        if($resultado->num_rows > 0){
            while($linha = $resultado->fetch_assoc()){
                $tabela[] = $linha;
            }

            $_SESSION['usuario'] = $tabela;

            $retorno = [
                'status'    => 'ok',
                'mensagem'  => 'Sucesso, consulta efetuada.',
                'data'      => $tabela
            ];
        } else {
            $retorno = [
                'status'    => 'nok',
                'mensagem'  => 'E-mail ou senha incorretos.', // Mensagem mais clara para o usuário
                'data'      => []
            ];
        }
        
        $stmt->close();
        $conexao->close();
    } else {
        $retorno = [
            'status'    => 'nok',
            'mensagem'  => 'Preencha todos os campos.',
            'data'      => []
        ];
    }

    // 2. Entrega o JSON e PARA o script, impedindo que o HTML seja lido pelo Fetch/AJAX
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
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form id="formLogin">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>
        
        <input type="submit" value="Login">
    </form>
    
    <script src="usuario_login.js"></script>
</body>
</html>