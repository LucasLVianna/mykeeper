<?php
session_start();
include_once(__DIR__ . '/../../config/headers.php');
include_once(__DIR__ . '/../../config/conexao.php');

$stmt = $conexao->prepare("SELECT * FROM usuario WHERE email = ?");
$stmt->bind_param("s", $_POST['email']);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if ($usuario && password_verify($_POST['senha'], $usuario['senha'])) {
    $retorno = [
        'status' => 'ok',
        'mensagem' => 'Login realizado com sucesso',
        'redirect' => '/mykeeper/src/Views/home.php'
    ];

    $_SESSION['usuario'] = [
        'id' => $usuario['id'],
        'nome' => $usuario['nome']
    ];

    $_SESSION['logado'] = true;
}else{
    $retorno = [
        'status' => 'nok',
        'mensagem' => 'Login não realizado'
    ];
};

$stmt->close();
$conexao->close();

header('Content-type:application/json;charset:utf-8');
echo json_encode($retorno);

?>