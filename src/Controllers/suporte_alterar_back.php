<?php
include_once(__DIR__ . '/../../config/headers.php');
include_once(__DIR__ . '/../../config/conexao.php');

$retorno = [
    'status' => '',
    'mensagem' => '',
    'data' => []
];

if(isset($_GET['id'])){

    $nome      = trim($_POST['nome'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $cep       = trim($_POST['cep'] ?? '');

    if ($nome === '' || $email === '' || $cep === '') {
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Preencha nome, e-mail e CEP',
            'data' => []
        ]);
        exit;
    }

    $check = $conexao->prepare("
        SELECT email FROM suporte WHERE email = ? AND id <> ?
        UNION
        SELECT email FROM usuario WHERE email = ?
    ");
    $check->bind_param("sis", $email, $_GET['id'], $email);
    $check->execute();

    if ($check->get_result()->num_rows > 0) {
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Este email já está cadastrado',
            'data' => []
        ]);
        exit;
    }

    $check->close();

    $stmt = $conexao->prepare("UPDATE suporte SET nome=?, email=?, cep=? WHERE id=?");
    $stmt->bind_param("sssi", $nome, $email, $cep, $_GET['id']);

    $stmt->execute();

    if($stmt->affected_rows > 0){
        $retorno = [
            'status' => 'ok',
            'mensagem' => 'Suporte alterado com sucesso',
            'data' => []
        ];
    }else{
        $retorno = [
            'status' => 'nok',
            'mensagem' => 'Nenhuma alteração realizada',
            'data' => []
        ];
    }

    $stmt->close();

}else{
    $retorno = [
        'status' => 'nok',
        'mensagem' => 'ID não informado',
        'data' => []
    ];
}

$conexao->close();

header("Content-type: application/json; charset=utf-8");
echo json_encode($retorno);
