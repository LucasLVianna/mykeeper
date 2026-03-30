<?php
include_once('conexao.php');

$retorno = [
    'status'   => '',
    'mensagem' => '',
    'data'     => []
];

// 🔒 Validação dos dados
if (!isset($_POST['nome'], $_POST['email'], $_POST['senha'])) {
    $retorno = [
        'status'   => 'erro',
        'mensagem' => 'Dados incompletos.',
        'data'     => []
    ];

    header("Content-type: application/json; charset=utf-8");
    echo json_encode($retorno);
    exit;
}

// Pegando os dados
$nome  = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

// Preparando query
$stmt = $conexao->prepare("INSERT INTO suporte (nome, email, senha) VALUES (?, ?, ?)");

if (!$stmt) {
    $retorno = [
        'status'   => 'erro',
        'mensagem' => 'Erro na preparação da query.',
        'data'     => []
    ];
} else {

    $stmt->bind_param("sss", $nome, $email, $senha);

    if ($stmt->execute()) {
        $retorno = [
            'status'   => 'ok',
            'mensagem' => 'Registro inserido com sucesso.',
            'data'     => []
        ];
    } else {
        $retorno = [
            'status'   => 'nok',
            'mensagem' => 'Falha ao inserir o registro.',
            'data'     => []
        ];
    }

    $stmt->close();
}

$conexao->close();

header("Content-type: application/json; charset=utf-8");
echo json_encode($retorno);
?>