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

if (isset($_GET['id_lista'])) {
    $id_lista = $_GET['id_lista'];
    $nome_produto = $_POST['nome_produto'] ?? '';
    $quantidade_produto = intval($_POST['quantidade_produto'] ?? 1);

    if (empty($nome_produto)) {
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Nome do produto é obrigatório'
        ]);
        $conexao->close();
        exit;
    }

    // Tenta encontrar o produto existente
    $stmt_busca = $conexao->prepare("SELECT id FROM produto WHERE nome = ? AND id_usuario = ? LIMIT 1");
    $stmt_busca->bind_param('si', $nome_produto, $_SESSION['usuario']['id']);
    $stmt_busca->execute();
    $resultado_busca = $stmt_busca->get_result();
    
    $id_produto = null;
    if ($resultado_busca->num_rows > 0) {
        $row = $resultado_busca->fetch_assoc();
        $id_produto = $row['id'];
    }
    $stmt_busca->close();

    $stmt = $conexao->prepare("INSERT INTO item_lista_compra (id_lista_compra, id_produto, quantidade) VALUES (?, ?, ?)");
    $stmt->bind_param('iii', $id_lista, $id_produto, $quantidade_produto);

    if ($stmt->execute()) {
        $retorno = [
            'status'   => 'ok',
            'mensagem' => 'Produto adicionado à lista com sucesso',
            'data'     => []
        ];
    } else {
        $retorno = [
            'status'   => 'nok',
            'mensagem' => 'Erro ao adicionar produto à lista',
            'data'     => []
        ];
    }

    $stmt->close();
} else {
    $retorno = [
        'status'   => 'nok',
        'mensagem' => 'ID da lista não informado',
        'data'     => []
    ];
}

$conexao->close();

echo json_encode($retorno);
?>
