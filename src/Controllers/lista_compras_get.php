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
    $stmt = $conexao->prepare("
        SELECT lc.*, e.nome_estoque
        FROM lista_compras lc
        LEFT JOIN estoque e ON e.id = lc.id_estoque
        WHERE lc.id = ? AND lc.id_usuario = ?
    ");
    $stmt->bind_param('ii', $_GET['id'], $id_usuario);
} else {
    $stmt = $conexao->prepare("
        SELECT lc.*, e.nome_estoque
        FROM lista_compras lc
        LEFT JOIN estoque e ON e.id = lc.id_estoque
        WHERE lc.id_usuario = ?
        ORDER BY lc.data_criacao DESC
    ");
    $stmt->bind_param('i', $id_usuario);
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
        'mensagem' => 'Não há listas de compras cadastradas',
        'data'     => []
    ];
}

$stmt->close();
$conexao->close();

header("Content-type: application/json; charset=utf-8");
echo json_encode($retorno);
?>
