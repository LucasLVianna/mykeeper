<?php
include_once(__DIR__ . '/../../config/headers.php');
include_once(__DIR__ . '/../../config/conexao.php');

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
$cep = trim($_POST['cep'] ?? '');

if ($nome === '' || $email === '' || $senha === '' || $cep === '') {
    header('Content-type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'Preencha todos os campos obrigatórios.'
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Content-type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'Digite um e-mail válido.'
    ]);
    exit;
}

if (strlen($cep) !== 9) {
    header('Content-type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'Digite um CEP válido no formato 00000-000.'
    ]);
    exit;
}

if (strlen($senha) < 8) {
    header('Content-type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'A senha precisa ter pelo menos 8 caracteres.'
    ]);
    exit;
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$stmt = $conexao->prepare("INSERT INTO usuario (nome, email, senha, cep) VALUES (?,?,?,?)");
$stmt->bind_param("ssss", $nome, $email, $senhaHash, $cep);

try {
    $stmt->execute();
    $retorno = [
        'status'   => 'ok',
        'mensagem' => 'Cadastro realizado com sucesso.'
    ];
} catch (mysqli_sql_exception $e) {
    $retorno = [
        'status'   => 'nok',
        'mensagem' => $e->getCode() == 1062
            ? 'Este e-mail já está cadastrado.'
            : 'Falha ao cadastrar usuário.'
    ];
}

$stmt->close();
$conexao->close();

header('Content-type: application/json; charset=utf-8');
echo json_encode($retorno);
