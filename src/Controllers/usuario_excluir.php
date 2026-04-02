<?php
    include_once('../../config/auth.php');
    include_once('../../config/conexao.php');

    $retorno = [
        'status'    => '',
        'mensagem'  => '',
        'data'      => []
    ];

    if(isset($_GET['id'])){
        $stmt = $conexao->prepare("UPDATE usuario SET ativo = 0 WHERE id = ?");
        $stmt->bind_param("ii", $_GET['id']);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $retorno = [
                'status'    => 'ok',
                'mensagem'  => 'Registro excluído.',
                'data'      => []
            ];
        }else{
            $retorno = [
                'status'    => 'nok',
                'mensagem'  => 'Registro não excluído.',
                'data'      => []
            ];
        }
        $stmt->close();
    }else{
        $retorno = [
            'status'    => 'nok',
            'mensagem'  => 'É necessário informar um ID para exclusão.',
            'data'      => []
        ];
    }

    $conexao->close();
    header("Content-type: application/json; charset=utf-8");
    echo json_encode($retorno);
    exit;
?>