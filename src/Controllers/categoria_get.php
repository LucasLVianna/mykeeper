<?php
include_once(__DIR__ . '/../../config/headers.php');
include_once(__DIR__ . '/../../config/conexao.php');

$retorno = [
    'status'   => '',
    'mensagem' => '',
    'data'     => []
];

if (isset($_GET['id'])) {
    $stmt = $conexao->prepare("SELECT * FROM categoria WHERE id = ?");
    $stmt->bind_param('i', $_GET['id']);
} else {
    $stmt = $conexao->prepare("SELECT * FROM categoria");
}

$stmt->execute();
$resultado = $stmt->get_result();
$tabela = [];

if ($resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $tabela[] = $linha;
    }
    $retorno = [
        'status'   => 'ok',
        'mensagem' => 'Sucesso, consulta efetuada',
        'data'     => $tabela
    ];
} else {
    $retorno = [
        'status'   => 'nok',
        'mensagem' => 'Não há categorias cadastradas',
        'data'     => []
    ];
}

$stmt->close();
$conexao->close();

header("Content-type: application/json; charset=utf-8");
echo json_encode($retorno);