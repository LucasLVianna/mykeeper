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
$id_estoque = intval($_POST['id_estoque'] ?? 0);

function garantirColunaEstoqueLista($conexao) {
    $resultado = $conexao->query("SHOW COLUMNS FROM lista_compras LIKE 'id_estoque'");
    if ($resultado && $resultado->num_rows === 0) {
        $conexao->query("ALTER TABLE lista_compras ADD COLUMN id_estoque INT NULL");
    }
}

garantirColunaEstoqueLista($conexao);

if (empty($titulo_lista)) {
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'Nome da lista é obrigatório'
    ]);
    exit;
}

if ($id_estoque <= 0) {
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'Estoque vinculado e obrigatorio'
    ]);
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
    exit;
}
$checkEstoque->close();

$stmt = $conexao->prepare("INSERT INTO lista_compras (id_usuario, titulo, status_compra, id_estoque) VALUES (?, ?, 'aberta', ?)");
$stmt->bind_param('isi', $id_usuario, $titulo_lista, $id_estoque);

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
