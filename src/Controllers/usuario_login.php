<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once(__DIR__ . '/../../config/headers.php');
include_once(__DIR__ . '/../../config/conexao.php');

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($email === '' || $senha === '') {
    header('Content-type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'Informe e-mail e senha para continuar.'
    ]);
    exit;
}

$stmt = $conexao->prepare('SELECT * FROM usuario WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if ($usuario && password_verify($senha, $usuario['senha'])) {
    if (!$usuario['conta_ativa']) {
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Conta desativada. Entre em contato com o suporte.'
        ]);
        exit;
    }

    $_SESSION['usuario'] = [
        'id'   => $usuario['id'],
        'nome' => $usuario['nome']
    ];
    $_SESSION['logado'] = true;

    $retorno = [
        'status'   => 'ok',
        'mensagem' => 'Login realizado com sucesso.',
        'redirect' => '/mykeeper-lucas_vianna/src/Views/home.php'
    ];
} else {
    $retorno = [
        'status'   => 'nok',
        'mensagem' => 'E-mail ou senha incorretos.'
    ];
}

$stmt->close();
$conexao->close();

header('Content-type: application/json; charset=utf-8');
echo json_encode($retorno);
