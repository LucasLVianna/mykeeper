<?php
    include_once(__DIR__ . '/../../config/headers.php');
    include_once(__DIR__ . '/../../config/conexao.php');

    $nome      = $_POST['nome'];
    $email     = $_POST['email'];
    $senha     = $_POST['senha'];
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $cep       = $_POST['cep'];

    $stmt = $conexao->prepare("INSERT INTO usuario (nome, email, senha, cep) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $nome, $email, $senhaHash, $cep);

    try {
        $stmt->execute();
        $retorno = [
            'status'   => 'ok',
            'mensagem' => 'Registro inserido com sucesso'
        ];
    } catch (mysqli_sql_exception $e) {
        $retorno = [
            'status'   => 'nok',
            'mensagem' => $e->getCode() == 1062
                ? 'Este email já está cadastrado'
                : 'Falha ao inserir: ' . $e->getMessage()
        ];
    }

    $stmt->close();
    $conexao->close();
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($retorno);
