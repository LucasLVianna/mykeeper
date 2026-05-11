<?php
header("Content-type: application/json; charset=utf-8");
include_once(__DIR__ . '/../../config/headers.php');
include_once(__DIR__ . '/../../config/conexao.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['logado']) || !isset($_SESSION['usuario']['id'])) {
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'Sessão expirada ou usuário não autenticado',
        'data' => []
    ]);
    exit;
}

$retorno = [
    'status'   => '',
    'mensagem' => '',
    'data'     => []
];

$id_usuario = $_SESSION['usuario']['id'];
$titulo_lista = $_POST['nome_lista'] ?? '';

if (empty($titulo_lista)) {
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'Nome da lista é obrigatório'
    ]);
    exit;
}

$stmt = $conexao->prepare("INSERT INTO lista_compras (id_usuario, titulo, status_compra) VALUES (?, ?, 'aberta')");
$stmt->bind_param('is', $id_usuario, $titulo_lista);

if ($stmt->execute()) {
    $retorno = [
        'status'   => 'ok',
        'mensagem' => 'Lista de compras criada com sucesso',
        'data'     => ['id' => $stmt->insert_id]
    ];
} else {
    $retorno = [
        'status'   => 'nok',
        'mensagem' => 'Erro ao criar lista de compras',
        'data'     => []
    ];
}

$stmt->close();
$conexao->close();

echo json_encode($retorno);
?>
