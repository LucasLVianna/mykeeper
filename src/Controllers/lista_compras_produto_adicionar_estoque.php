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

$retorno = []
    'status'   => '',
    'mensagem' => '',
    'data'     => []
];

$id_usuario = $_SESSION['usuario']['id'];

if (isset($_GET['id_lista']) && isset($_GET['id_produto'])) {
    // Busca os dados do item na lista de compras
    $stmt = $conexao->prepare("SELECT ilc.*, p.nome as nome_produto FROM item_lista_compra ilc LEFT JOIN produto p ON ilc.id_produto = p.id WHERE ilc.id_lista_compra = ? AND ilc.id_produto = ?");
    $stmt->bind_param('ii', $_GET['id_lista'], $_GET['id_produto']);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $item = $resultado->fetch_assoc();
        $id_estoque = 1; // Estoque padrão - ajuste se necessário
        
        // Se tem id_produto, adiciona ao estoque existente
        if ($item['id_produto']) {
            // Cria um novo item no estoque
            $stmt2 = $conexao->prepare("INSERT INTO item_estoque (id_estoque, id_produto, quantidade) VALUES (?, ?, ?)");
            $stmt2->bind_param('iii', $id_estoque, $item['id_produto'], $item['quantidade']);
            $stmt2->execute();
            $stmt2->close();
        }

        // Remove o produto da lista de compras
        $stmt3 = $conexao->prepare("DELETE FROM item_lista_compra WHERE id_lista_compra = ? AND id_produto = ?");
        $stmt3->bind_param('ii', $_GET['id_lista'], $_GET['id_produto']);
        $stmt3->execute();
        $stmt3->close();

        $retorno = [
            'status'   => 'ok',
            'mensagem' => 'Produto adicionado ao estoque com sucesso',
            'data'     => []
        ];
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
        'mensagem' => 'ID do produto não informado',
        'data'     => []
    ];
}

$conexao->close();

header("Content-type: application/json; charset=utf-8");
echo json_encode($retorno);
?>
