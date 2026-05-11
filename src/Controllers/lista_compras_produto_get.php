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
    
    $stmt = $conexao->prepare("SELECT ilc.*, p.nome as nome_produto FROM item_lista_compra ilc LEFT JOIN produto p ON ilc.id_produto = p.id WHERE ilc.id_lista_compra = ?");
    $stmt->bind_param('i', $id_lista);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $tabela = [];

    if ($resultado->num_rows > 0) {
        while ($linha = $resultado->fetch_assoc()) {
            $tabela[] = $linha;
        }
        $retorno = [
            'status'   => 'ok',
            'mensagem' => 'Sucesso, produtos carregados',
            'data'     => $tabela
        ];
    } else {
        $retorno = [
            'status'   => 'ok',
            'mensagem' => 'Nenhum produto adicionado nesta lista',
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

header("Content-type: application/json; charset=utf-8");
echo json_encode($retorno);
?>
