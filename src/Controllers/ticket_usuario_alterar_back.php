<?php
session_start();
include_once(__DIR__ . '/../../config/headers.php');
include_once(__DIR__ . '/../../config/conexao.php');


header("Content-Type: application/json; charset=utf-8"); 

$retorno = ['status' => 'nok', 'mensagem' => 'Requisição inválida', 'data' => []];

if (!isset($_SESSION['usuario']['id'])) {
    $retorno['mensagem'] = 'Não autenticado.';
    echo json_encode($retorno);
    exit;
}

if (isset($_GET['id'])) {
    $titulo    = $_POST['titulo']    ?? null;
    $descricao = $_POST['descricao'] ?? null;
    $id_usuario = $_SESSION['usuario']['id'];

    if (!$titulo || !$descricao) {
        $retorno['mensagem'] = 'Título e descrição são obrigatórios.';
        echo json_encode($retorno);
        exit;
    }

    // Verifica se o ticket pertence ao usuário e está aberto
    $check = $conexao->prepare("SELECT status_ticket FROM ticket_suporte WHERE id = ? AND id_usuario = ?");
    $check->bind_param("ii", $_GET['id'], $id_usuario);
    $check->execute();
    $ticket = $check->get_result()->fetch_assoc();
    $check->close();

    if (!$ticket) {
        $retorno['mensagem'] = 'Ticket não encontrado.';
        echo json_encode($retorno);
        exit;
    }

    if ($ticket['status_ticket'] !== 'ticket_aberto') {
        $retorno['mensagem'] = 'Tickets respondidos não podem ser alterados.';
        echo json_encode($retorno);
        exit;
    }

    // UPDATE
    $stmt = $conexao->prepare("UPDATE ticket_suporte SET titulo=?, descricao=? WHERE id=? AND id_usuario=?");
    $stmt->bind_param("ssii", $titulo, $descricao, $_GET['id'], $id_usuario);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $retorno = ['status' => 'ok', 'mensagem' => 'Ticket alterado com sucesso.', 'data' => []];
    } else {
        $retorno['mensagem'] = 'Nenhuma alteração realizada (dados iguais aos anteriores).';
    }

    $stmt->close();
}

echo json_encode($retorno);