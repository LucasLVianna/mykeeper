<?php
    include_once('../../php/conexao.php');

    $retorno = [
        'status' => '', //ok ou nok
        'mensagem' => '', //mensagem que envio para o front
        'data' => []
    ];

    // preparando para alteração no banco de dados
    if(isset($_GET['id'])){
        // infos para serem alteradas

        $nome_produto       = $_POST['nome_produto'];
        $categoria_produto  = $_POST['categoria_produto'];
        $und_medida_produto = $_POST['und_medida_produto'];


        $stmt = $conexao->prepare("UPDATE produto SET nome_produto=?, categoria_produto=?, und_medida_produto=? WHERE id = ?");
        $stmt->bind_param("sssi", $nome_produto, $categoria_produto, $und_medida_produto, $_GET['id']);
        $stmt->execute();

        if($stmt->affected_rows >0){
            $retorno = [
                'status' => 'ok', //ok ou nok
                'mensagem' => 'Produto alterado com sucesso',
                'data' => []
            ];
        }else{
            $retorno = [
                'status' => 'nok', //ok ou nok
                'mensagem' => 'Nenhuma alteração realizada',
                'data' => []
            ];
        }

        $stmt->close();
    }else{
        $retorno = [
            'status' => 'nok',
            'mensagem' => 'É necessário informar um id para alterar registro',
            'data' => []
        ];
    }
    $conexao->close();

    header("Content-type:application/json;charset:utf-8");
    echo json_encode($retorno);