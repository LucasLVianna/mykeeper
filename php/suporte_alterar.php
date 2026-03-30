<?php
    include_once('conexao.php');

    $retorno = [
        'status'   => '',
        'mensagem' => '',
        'data'     => []
    ];

    if(isset($_GET['id'])){
        $nome  = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $stmt = $conexao->prepare("UPDATE suporte SET nome = ?, email = ?, senha = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nome, $email, $senha, $_GET['id']);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $retorno = [
                'status'   => 'ok',
                'mensagem' => 'Registro alterado com sucesso.',
                'data'     => []
            ];
        }else{
            $retorno = [
                'status'   => 'nok',
                'mensagem' => 'Não posso alterar um registro.'.json_encode($_GET),
                'data'     => []
            ];
        }
        $stmt->close();
    }else{
        $retorno = [
            'status'   => 'nok',
            'mensagem' => 'Não posso alterar um registro sem um ID informado.',
            'data'     => []
        ];
    }

    $conexao->close();

    header("Content-type: application/json; charset=utf-8");
    echo json_encode($retorno);