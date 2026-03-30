<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    include_once(__DIR__ . '/../../config/headers.php');
    include_once(__DIR__ . '/../../config/conexao.php');
    

    $retorno = [
        'status' => '', //ok ou nok
        'mensagem' => '', //mensagem que envio para o front
        'data' => []
    ];

    // infos para serem adicionadas

    $nome_produto       = $_POST['nome_produto'];
    $categoria_produto  = $_POST['categoria_produto'];
    $und_medida_produto = $_POST['und_medida_produto'];

    // preparando inserção no banco de dados

    $stmt = $conexao->prepare("INSERT INTO produto(nome_produto, categoria_produto, und_medida_produto) VALUES(?,?,?)");
    // adicionando os valores no sql
    $stmt->bind_param("sss", $nome_produto, $categoria_produto, $und_medida_produto);
    // inserindo
    $stmt->execute();

    // verificando se a atualização ocorreu e retornando com base nas linhas afetadas

    if($stmt->affected_rows > 0){
        $retorno = [
            'status' => 'ok', //ok ou nok
            'mensagem' => 'Item inserido com sucesso', //mensagem que envio para o front
            'data' => []
        ];
    }else{
        $retorno = [
            'status' => 'nok', //ok ou nok
            'mensagem' => 'Falha ao inserir o item', //mensagem que envio para o front
            'data' => []
        ];
    }

    $stmt->close();
    $conexao->close();

    header("Content-type:application/json;charset:utf-8");
    echo json_encode($retorno);