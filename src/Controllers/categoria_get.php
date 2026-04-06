<?php
include_once(__DIR__ . '/../../config/headers.php');
include_once(__DIR__ . '/../../config/conexao.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$retorno = [
    'status'   => '',
    'mensagem' => '',
    'data'     => []
];

if (empty($_SESSION['usuario']['id'])) {
    $retorno = [
        'status'   => 'nok',
        'mensagem' => 'Sessão expirada. Faça login novamente.',
        'data'     => []
    ];

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($retorno);
    exit;
}

$id_usuario = (int) $_SESSION['usuario']['id'];

if (isset($_GET['id'])) {
    $categoriaId = (int) $_GET['id'];
    $stmt = $conexao->prepare('SELECT * FROM categoria WHERE id = ? AND id_usuario = ?');
    $stmt->bind_param('ii', $categoriaId, $id_usuario);
} else {
    $stmt = $conexao->prepare('SELECT * FROM categoria WHERE id_usuario = ? ORDER BY id ASC');
    $stmt->bind_param('i', $id_usuario);
}

$stmt->execute();
$resultado = $stmt->get_result();
$tabela = [];

while ($linha = $resultado->fetch_assoc()) {
    $tabela[] = $linha;
}

if (count($tabela) > 0) {
    $retorno = [
        'status'   => 'ok',
        'mensagem' => 'Sucesso, consulta efetuada.',
        'data'     => $tabela
    ];
} else {
    $retorno = [
        'status'   => 'nok',
        'mensagem' => 'Não há categorias cadastradas para este usuário.',
        'data'     => []
    ];
}

$stmt->close();
$conexao->close();

header('Content-type: application/json; charset=utf-8');
echo json_encode($retorno);
