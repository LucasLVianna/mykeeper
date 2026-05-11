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

if (isset($_GET['id'])) {
    // Verifica se a lista pertence ao usuário
    $stmt = $conexao->prepare("SELECT id FROM lista_compras WHERE id = ? AND id_usuario = ?");
    $stmt->bind_param('ii', $_GET['id'], $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Deleta os produtos relacionados
        $stmt2 = $conexao->prepare("DELETE FROM item_lista_compra WHERE id_lista_compra = ?");
        $stmt2->bind_param('i', $_GET['id']);
        $stmt2->execute();
        $stmt2->close();

        // Deleta a lista
        $stmt3 = $conexao->prepare("DELETE FROM lista_compras WHERE id = ?");
        $stmt3->bind_param('i', $_GET['id']);

        if ($stmt3->execute()) {
            $retorno = [
                'status'   => 'ok',
                'mensagem' => 'Lista de compras excluída com sucesso',
                'data'     => []
            ];
        } else {
            $retorno = [
                'status'   => 'nok',
                'mensagem' => 'Erro ao excluir lista de compras',
                'data'     => []
            ];
        }
        $stmt3->close();
    } else {
        $retorno = [
            'status'   => 'nok',
            'mensagem' => 'Lista não encontrada',
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
