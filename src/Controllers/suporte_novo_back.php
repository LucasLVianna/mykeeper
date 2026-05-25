<?php
    include_once(__DIR__ . '/../../config/headers.php');
    include_once(__DIR__ . '/../../config/conexao.php');
    
    $nome      = trim($_POST['nome'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $senha     = $_POST['senha'] ?? '';
    $cep       = trim($_POST['cep'] ?? '');

    if ($nome === '' || $email === '' || $senha === '' || $cep === '') {
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Preencha nome, e-mail, senha e CEP'
        ]);
        exit;
    }

    $check = $conexao->prepare("
        SELECT email FROM suporte WHERE email = ?
        UNION
        SELECT email FROM usuario WHERE email = ?
    ");
    $check->bind_param("ss", $email, $email);
    $check->execute();

    if ($check->get_result()->num_rows > 0) {
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Este email já está cadastrado'
        ]);
        exit;
    }

    $check->close();
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conexao->prepare("INSERT INTO suporte (nome, email, senha, cep) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $nome, $email, $senhaHash, $cep);

    if ($stmt->execute()) {
        $retorno = [
            'status' => 'ok',
            'mensagem' => 'Registro inserido com sucesso'
        ];
    } else {
        $retorno = [
            'status' => 'nok',
            'mensagem' => 'Falha ao inserir: ' . $stmt->error
        ];
    }

    $stmt->close();
    $conexao->close();

    header('Content-type:application/json;charset:utf-8');
    echo json_encode($retorno);
?>
