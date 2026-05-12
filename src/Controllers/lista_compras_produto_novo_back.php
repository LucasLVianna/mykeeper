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

function buscarOuCriarProduto($conexao, $nome_produto, $id_usuario) {
    $stmtBusca = $conexao->prepare("SELECT id FROM produto WHERE nome = ? AND id_usuario = ? LIMIT 1");
    if (!$stmtBusca) {
        throw new Exception('Erro ao buscar produto');
    }

    $stmtBusca->bind_param('si', $nome_produto, $id_usuario);
    $stmtBusca->execute();
    $resultadoBusca = $stmtBusca->get_result();

    if ($resultadoBusca->num_rows > 0) {
        $row = $resultadoBusca->fetch_assoc();
        $stmtBusca->close();
        return (int) $row['id'];
    }
    $stmtBusca->close();

    $idCategoria = null;
    $unidade = 'un';
    $imagem = '';

    $stmtCriar = $conexao->prepare("INSERT INTO produto (nome, id_categoria, und_medida, imagem, id_usuario) VALUES (?, ?, ?, ?, ?)");
    if (!$stmtCriar) {
        throw new Exception('Erro ao criar produto');
    }

    $stmtCriar->bind_param('sissi', $nome_produto, $idCategoria, $unidade, $imagem, $id_usuario);
    $stmtCriar->execute();
    $idProduto = $stmtCriar->insert_id;
    $stmtCriar->close();

    if (!$idProduto) {
        throw new Exception('Nao foi possivel criar produto');
    }

    return (int) $idProduto;
}

try {
    if (!isset($_GET['id_lista'])) {
        respostaJson('nok', 'ID da lista nao informado');
    }

    $id_usuario = (int) $_SESSION['usuario']['id'];
    $id_lista = intval($_GET['id_lista']);
    $nome_produto = trim($_POST['nome_produto'] ?? '');
    $quantidade_produto = intval($_POST['quantidade_produto'] ?? 1);

    if ($nome_produto === '') {
        respostaJson('nok', 'Nome do produto e obrigatorio');
    }

    if ($quantidade_produto <= 0) {
        respostaJson('nok', 'Quantidade deve ser maior que 0');
    }

    $id_produto = buscarOuCriarProduto($conexao, $nome_produto, $id_usuario);

    $stmtExistente = $conexao->prepare("SELECT quantidade FROM item_lista_compra WHERE id_lista_compra = ? AND id_produto = ? LIMIT 1");
    if (!$stmtExistente) {
        throw new Exception('Erro ao verificar item da lista');
    }

    $stmtExistente->bind_param('ii', $id_lista, $id_produto);
    $stmtExistente->execute();
    $resultadoExistente = $stmtExistente->get_result();

    if ($resultadoExistente->num_rows > 0) {
        $stmtExistente->close();
        $stmtAtualizar = $conexao->prepare("UPDATE item_lista_compra SET quantidade = quantidade + ? WHERE id_lista_compra = ? AND id_produto = ?");
        if (!$stmtAtualizar) {
            throw new Exception('Erro ao atualizar produto na lista');
        }

        $stmtAtualizar->bind_param('iii', $quantidade_produto, $id_lista, $id_produto);
        $stmtAtualizar->execute();
        $stmtAtualizar->close();
    } else {
        $stmtExistente->close();
        $stmtInserir = $conexao->prepare("INSERT INTO item_lista_compra (id_lista_compra, id_produto, quantidade) VALUES (?, ?, ?)");
        if (!$stmtInserir) {
            throw new Exception('Erro ao adicionar produto na lista');
        }

        $stmtInserir->bind_param('iii', $id_lista, $id_produto, $quantidade_produto);
        $stmtInserir->execute();
        $stmtInserir->close();
    }

    $conexao->close();
    respostaJson('ok', 'Produto adicionado a lista com sucesso');
} catch (Throwable $erro) {
    if (isset($conexao) && $conexao instanceof mysqli) {
        $conexao->close();
    }

    respostaJson('nok', 'Erro ao adicionar produto: ' . $erro->getMessage());
}
