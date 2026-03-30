<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])){
        include_once('../php/conexao.php');

        $retorno = [
            'status'   => '',
            'mensagem' => '',
            'data'     => []
        ];

        $stmt = $conexao->prepare("DELETE FROM suporte WHERE id = ?");
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $retorno = [
                'status'   => 'ok',
                'mensagem' => 'Registro excluído.',
                'data'     => []
            ];
        }else{
            $retorno = [
                'status'   => 'nok',
                'mensagem' => 'Registro não excluído.',
                'data'     => []
            ];
        }

        $stmt->close();
        $conexao->close();

        header("Content-type: application/json; charset=utf-8");
        echo json_encode($retorno);
        exit;
    }
?>