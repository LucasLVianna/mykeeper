<?php
    include_once('../../config/auth.php');
    include_once('../../config/conexao.php');

    $retorno = [
        'status'    => '',
        'mensagem'  => '',
        'data'      => []
    ];

    if(isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome  = $_POST['nome']  ?? '';
        $email = $_POST['email'] ?? ''; //segurança para evitar undefined index
        $senha = $_POST['senha'] ?? '';
        $cep = $_POST['cep'] ?? '';

        $stmt = $conexao->prepare("UPDATE usuario SET email = ?, nome = ?, senha = ?, cep = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $email, $nome, $senha, $cep, $_GET['id']);
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