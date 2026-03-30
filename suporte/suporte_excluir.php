<?php
    // só executa se for GET e tiver id
    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])){
        include_once('../php/conexao.php'); // conexão

        $retorno = [
            'status'   => '',
            'mensagem' => '',
            'data'     => []
        ];

        // prepara o DELETE
        $stmt = $conexao->prepare("DELETE FROM suporte WHERE id = ?");
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();

        // Verifica se deletou
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

        // retorna JSON
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($retorno);
        exit;
    }
?>