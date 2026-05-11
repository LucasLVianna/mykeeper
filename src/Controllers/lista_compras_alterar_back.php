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
    $titulo_lista = $_POST['nome_lista'] ?? '';
    $status_lista = $_POST['status_lista'] ?? 'aberta';

    if (empty($titulo_lista)) {
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Nome da lista é obrigatório'
        ]);
        $conexao->close();
        exit;
    }

    $stmt = $conexao->prepare("UPDATE lista_compras SET titulo=?, status_compra=? WHERE id=? AND id_usuario=?");
    $stmt->bind_param('ssii', $titulo_lista, $status_lista, $_GET['id'], $id_usuario);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $retorno = [
                'status'   => 'ok',
                'mensagem' => 'Lista de compras alterada com sucesso',
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
            'mensagem' => 'Erro ao alterar lista de compras',
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
