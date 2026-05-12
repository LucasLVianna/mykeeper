<?php
ini_set('display_errors', 0);
header("Content-type: application/json; charset=utf-8");
include_once(__DIR__ . '/../../config/headers.php');
include_once(__DIR__ . '/../../config/conexao.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function respostaJson($status, $mensagem, $data = []) {
    echo json_encode([
        'status' => $status,
        'mensagem' => $mensagem,
        'data' => $data
    ]);
    exit;
}

if (empty($_SESSION['logado']) || !isset($_SESSION['usuario']['id'])) {
    respostaJson('nok', 'Sessao expirada ou usuario nao autenticado');
}

function garantirColunaComprado($conexao) {
    $resultado = $conexao->query("SHOW COLUMNS FROM item_lista_compra LIKE 'comprado'");
    if ($resultado && $resultado->num_rows === 0) {
        $conexao->query("ALTER TABLE item_lista_compra ADD COLUMN comprado TINYINT(1) NOT NULL DEFAULT 0");
    }
}

function obterEstoqueVinculado($conexao, $id_lista, $id_usuario) {
    $stmt = $conexao->prepare("
        SELECT lc.id_estoque
        FROM lista_compras lc
        INNER JOIN estoque e ON e.id = lc.id_estoque
        WHERE lc.id = ?
        AND lc.id_usuario = ?
        AND e.id_usuario = ?
        LIMIT 1
    ");
    if (!$stmt) {
        throw new Exception('Erro ao buscar estoque vinculado');
    }

    $stmt->bind_param('iii', $id_lista, $id_usuario, $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $lista = $resultado->fetch_assoc();
        $stmt->close();
        return (int) $lista['id_estoque'];
    }
    $stmt->close();

    throw new Exception('Vincule esta lista a um estoque antes de marcar produtos como comprados');
}

function adicionarProdutoAoEstoqueAutomatico($conexao, $id_usuario, $id_lista, $id_produto, $quantidade) {
    if ($id_produto <= 0 || $quantidade <= 0) {
        return;
    }

    $idEstoque = obterEstoqueVinculado($conexao, $id_lista, $id_usuario);

    $stmtBusca = $conexao->prepare("
        SELECT ie.id
        FROM item_estoque ie
        WHERE ie.id_estoque = ?
        AND ie.id_produto = ?
        ORDER BY ie.id ASC
        LIMIT 1
    ");
    if (!$stmtBusca) {
        throw new Exception('Erro ao buscar item no estoque');
    }

    $stmtBusca->bind_param('ii', $idEstoque, $id_produto);
    $stmtBusca->execute();
    $resultadoBusca = $stmtBusca->get_result();

    if ($resultadoBusca->num_rows > 0) {
        $item = $resultadoBusca->fetch_assoc();
        $stmtBusca->close();

        $stmtAtualizar = $conexao->prepare("UPDATE item_estoque SET quantidade = COALESCE(quantidade, 0) + ? WHERE id = ?");
        if (!$stmtAtualizar) {
            throw new Exception('Erro ao atualizar quantidade do estoque');
        }

        $stmtAtualizar->bind_param('ii', $quantidade, $item['id']);
        $stmtAtualizar->execute();
        $stmtAtualizar->close();
        return;
    }
    $stmtBusca->close();

    $stmtInserir = $conexao->prepare("INSERT INTO item_estoque (id_estoque, id_produto, quantidade) VALUES (?, ?, ?)");
    if (!$stmtInserir) {
        throw new Exception('Erro ao inserir item no estoque');
    }

    $stmtInserir->bind_param('iii', $idEstoque, $id_produto, $quantidade);
    $stmtInserir->execute();
    $stmtInserir->close();
}

try {
    if (!isset($_GET['id']) || !isset($_GET['id_produto'])) {
        respostaJson('nok', 'ID nao informado');
    }

    garantirColunaComprado($conexao);

    $id_usuario = (int) $_SESSION['usuario']['id'];
    $id_lista = intval($_GET['id']);
    $id_produto = intval($_GET['id_produto']);
    $quantidade = intval($_POST['quantidade'] ?? 1);
    $comprado = intval($_POST['comprado'] ?? 0);

    $compradoAnterior = 0;
    $stmtAnterior = $conexao->prepare("
        SELECT ilc.comprado
        FROM item_lista_compra ilc
        INNER JOIN lista_compras lc ON lc.id = ilc.id_lista_compra
        WHERE ilc.id_lista_compra = ?
        AND ilc.id_produto = ?
        AND lc.id_usuario = ?
    ");
    if (!$stmtAnterior) {
        throw new Exception('Erro ao consultar produto da lista');
    }

    $stmtAnterior->bind_param('iii', $id_lista, $id_produto, $id_usuario);
    $stmtAnterior->execute();
    $resultadoAnterior = $stmtAnterior->get_result();

    if ($resultadoAnterior->num_rows > 0) {
        $itemAnterior = $resultadoAnterior->fetch_assoc();
        $compradoAnterior = intval($itemAnterior['comprado'] ?? 0);
    }
    $stmtAnterior->close();

    $stmt = $conexao->prepare("UPDATE item_lista_compra SET quantidade = ?, comprado = ? WHERE id_lista_compra = ? AND id_produto = ?");
    if (!$stmt) {
        throw new Exception('Erro ao preparar alteracao do produto');
    }

    $stmt->bind_param('iiii', $quantidade, $comprado, $id_lista, $id_produto);
    $stmt->execute();
    $stmt->close();

    if ($comprado === 1 && $compradoAnterior !== 1) {
        adicionarProdutoAoEstoqueAutomatico($conexao, $id_usuario, $id_lista, $id_produto, $quantidade);
    }

    $conexao->close();
    respostaJson('ok', 'Produto alterado com sucesso');
} catch (Throwable $erro) {
    if (isset($conexao) && $conexao instanceof mysqli) {
        $conexao->close();
    }

    respostaJson('nok', 'Erro ao alterar produto: ' . $erro->getMessage());
}
