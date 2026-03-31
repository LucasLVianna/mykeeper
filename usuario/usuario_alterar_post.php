<?php
    include_once('../php/auth.php');
    include_once('../php/conexao.php');

    $retorno = [
        'status'    => '',
        'mensagem'  => '',
        'data'      => []
    ];

    if(isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome  = $_POST['nome']  ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $stmt = $conexao->prepare("UPDATE usuario SET email = ?, nome = ?, senha = ? WHERE id = ?");
        $stmt->bind_param("sssi", $email, $nome, $senha, $_GET['id']);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $retorno = [
                'status'    => 'ok',
                'mensagem'  => 'Registro alterado com sucesso.',
                'data'      => []
            ];
        }else{
            $retorno = [
                'status'    => 'nok',
                'mensagem'  => 'Erro ao alterar o registro.',
                'data'      => []
            ];
        }
        $stmt->close();
    }
       
    $conexao->close();
    header("Content-type:application/json;charset:utf-8");
    echo json_encode($retorno);
    exit;
?>