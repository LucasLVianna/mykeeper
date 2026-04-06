<?php
    session_start();
    include_once(__DIR__ . '/../../config/headers.php');
    include_once(__DIR__ . '/../../config/conexao.php');

    if (empty($_SESSION['usuario']['id'])) {
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Usuário não autenticado'
        ]);
        exit;
    }

    $id    = $_SESSION['usuario']['id'];
    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $cep   = $_POST['cep'];

    $stmt = $conexao->prepare("UPDATE usuario SET nome = ?, email = ?, cep = ? WHERE id = ?");
    $stmt->bind_param('sssi', $nome, $email, $cep, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['usuario']['nome'] = $nome; 
        $retorno = [
            'status' => 'ok',
            'mensagem' => 'Perfil atualizado com sucesso'
        ];
    } else {
        $retorno = [
            'status' => 'nok',
            'mensagem' => 'Falha ao atualizar perfil'
        ];
    }

    $stmt->close();
    $conexao->close();
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($retorno);
