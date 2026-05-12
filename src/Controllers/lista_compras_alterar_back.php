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

function garantirColunaEstoqueLista($conexao) {
    $resultado = $conexao->query("SHOW COLUMNS FROM lista_compras LIKE 'id_estoque'");
    if ($resultado && $resultado->num_rows === 0) {
        $conexao->query("ALTER TABLE lista_compras ADD COLUMN id_estoque INT NULL");
    }
}

garantirColunaEstoqueLista($conexao);

if (isset($_GET['id'])) {
    $titulo_lista = $_POST['nome_lista'] ?? '';
    $status_lista = $_POST['status_lista'] ?? 'aberta';
    $id_estoque = intval($_POST['id_estoque'] ?? 0);

    if (empty($titulo_lista)) {
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Nome da lista é obrigatório'
        ]);
        $conexao->close();
        exit;
    }

    if ($id_estoque <= 0) {
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Estoque vinculado e obrigatorio'
        ]);
        $conexao->close();
        exit;
    }

    $checkEstoque = $conexao->prepare("SELECT id FROM estoque WHERE id = ? AND id_usuario = ?");
    $checkEstoque->bind_param('ii', $id_estoque, $id_usuario);
    $checkEstoque->execute();
    $checkEstoque->store_result();

    if ($checkEstoque->num_rows === 0) {
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Estoque nao encontrado'
        ]);
        $checkEstoque->close();
        $conexao->close();
        exit;
    }
    $checkEstoque->close();

    $stmt = $conexao->prepare("UPDATE lista_compras SET titulo=?, status_compra=?, id_estoque=? WHERE id=? AND id_usuario=?");
    $stmt->bind_param('ssiii', $titulo_lista, $status_lista, $id_estoque, $_GET['id'], $id_usuario);

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
