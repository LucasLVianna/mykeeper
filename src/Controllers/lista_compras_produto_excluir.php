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

if (isset($_GET['id_lista']) && isset($_GET['id_produto'])) {
    // Verifica se o produto existe na lista
    $stmt = $conexao->prepare("SELECT id_produto FROM item_lista_compra WHERE id_lista_compra = ? AND id_produto = ?");
    $stmt->bind_param('ii', $_GET['id_lista'], $_GET['id_produto']);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $stmt2 = $conexao->prepare("DELETE FROM item_lista_compra WHERE id_lista_compra = ? AND id_produto = ?");
        $stmt2->bind_param('ii', $_GET['id_lista'], $_GET['id_produto']);

        if ($stmt2->execute()) {
            $retorno = [
                'status'   => 'ok',
                'mensagem' => 'Produto removido da lista com sucesso',
                'data'     => []
            ];
        } else {
            $retorno = [
                'status'   => 'nok',
                'mensagem' => 'Erro ao remover produto',
                'data'     => []
            ];
        }
        $stmt2->close();
    } else {
        $retorno = [
            'status'   => 'nok',
            'mensagem' => 'Produto não encontrado',
            'data'     => []
        ];
    }

    $stmt->close();
} else {
    $retorno = [
        'status'   => 'nok',
        'mensagem' => 'ID não informado',
        'data'     => []
    ];
}

$conexao->close();

header("Content-type: application/json; charset=utf-8");
echo json_encode($retorno);
?>
