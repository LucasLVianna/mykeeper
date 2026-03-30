<?php
    include_once('../../php/conexao.php');

    //Configurando o padrão de retonro em todas as situações
    $retorno = [
        'status' => '', //ok ou nok
        'mensagem' => '', //mensagem que envio para o front
        'data' => []
    ];

    // recuperando informações do banco de dados

    if(isset($_GET['id'])){
        $stmt = $conexao->prepare("DELETE FROM produto WHERE id = ?");
        $stmt->bind_param('i', $_GET['id']);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $retorno = [
                'status' => 'ok', //ok ou nok
                'mensagem' => 'Item excluido', //mensagem que envio para o front
                'data' => []
            ];
        }else{
            $retorno = [
                'status' => 'nok', //ok ou nok
                'mensagem' => 'Item não excluido', //mensagem que envio para o front
                'data' => []
            ];
        }

        $stmt->close();
    }else{
        $retorno = [
            'status' => 'nok', //ok ou nok
            'mensagem' => 'É necessário informar um ID para exclusão', //mensagem que envio para o front
            'data' => []
        ];
    };

    $conexao->close();

    header("Content-type:application/json;charset:utf-8");
    echo json_encode($retorno);