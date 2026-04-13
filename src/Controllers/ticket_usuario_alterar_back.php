<?php
session_start();
include_once(__DIR__ . '/../../config/headers.php');
include_once(__DIR__ . '/../../config/conexao.php');

$retorno = [
    'status' => '',
    'mensagem' => '',
    'data' => []
];

if(isset($_GET['id'])){

    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $id_usuario = $_SESSION['usuario']['id'];

    // Verifica se o ticket já foi respondido
<<<<<<< HEAD
    $check = $conexao->prepare("SELECT status FROM ticket_suporte WHERE id = ? AND id_usuario = ?");
=======
    $check = $conexao->prepare("SELECT status_ticket FROM ticket_suporte WHERE id = ? AND id_usuario = ?");
>>>>>>> 6a5be11cba6956360c30c89793d9acf33a5b2f66
    $check->bind_param("ii", $_GET['id'], $id_usuario);
    $check->execute();
    $resultado = $check->get_result();
    $ticket = $resultado->fetch_assoc();

<<<<<<< HEAD
    if($ticket['status'] !== 'ticket_aberto'){
=======
    if($ticket['status_ticket'] !== 'ticket_aberto'){
>>>>>>> 6a5be11cba6956360c30c89793d9acf33a5b2f66
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Tickets respondidos não podem ser alterados.'
        ]);
        exit;
    }

    $check->close();

    // Se passou da verificação, faz o UPDATE
    $stmt = $conexao->prepare("UPDATE ticket_suporte SET titulo=?, descricao=? WHERE id=? AND id_usuario=?");
    $stmt->bind_param("ssii", $titulo, $descricao, $_GET['id'], $id_usuario);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        $retorno = [
            'status' => 'ok',
            'mensagem' => 'Ticket alterado com sucesso',
            'data' => []
        ];
    }else{
        $retorno = [
            'status' => 'nok',
            'mensagem' => 'Nenhuma alteração realizada',
            'data' => []
        ];
    }

    $stmt->close();
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($retorno);