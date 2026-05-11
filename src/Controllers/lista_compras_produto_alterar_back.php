<?php
header("Content-type: application/json; charset=utf-8");
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

if (isset($_GET['id'])) {
    $quantidade = intval($_POST['quantidade'] ?? 1);

    $stmt = $conexao->prepare("UPDATE item_lista_compra SET quantidade = ? WHERE id_lista_compra = ? AND id_produto = ?");
    $stmt->bind_param('iii', $quantidade, $_GET['id'], $_GET['id_produto']);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $retorno = [
                'status'   => 'ok',
                'mensagem' => 'Produto alterado com sucesso',
                'data'     => []
            ];
        } else {
            $retorno = [
                'status'   => 'nok',
                'mensagem' => 'Nenhuma alteração realizada',
                'data'     => []
            ];
        }
    } else {
        $retorno = [
            'status'   => 'nok',
            'mensagem' => 'Erro ao alterar produto',
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

echo json_encode($retorno);
?>
