<?php
    include_once('../../config/auth.php');
    include_once('../../config/conexao.php');

    $retorno = [
        'status'    => '',
        'mensagem'  => '',
        'data'      => []
    ];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nome  = $_POST['nome']  ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $cep = $_POST['cep'] ?? '';

        $stmt = $conexao->prepare("INSERT INTO usuario (nome, email, senha, cep) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $senha, $cep);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $retorno = [
                'status'    => 'ok',
                'mensagem'  => 'Usuário cadastrado com sucesso.',
                'data'      => []
            ];
        }else{
            $retorno = [
                'status'    => 'nok',
                'mensagem'  => 'Erro ao cadastrar usuário.',
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