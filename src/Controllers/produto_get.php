<?php
<<<<<<< HEAD
=======
    ob_start();
    error_reporting(0);
    ini_set('display_errors', '0');

>>>>>>> local-snapshot
    include_once(__DIR__ . '/../../config/headers.php');
    include_once(__DIR__ . '/../../config/conexao.php');

    $retorno = [
        'status' => '',
        'mensagem' => '',
        'data' => []
    ];

    if(isset($_GET['id'])){
        $stmt = $conexao->prepare("
            SELECT p.*, c.nome AS categoria 
            FROM produto p
            LEFT JOIN categoria c ON p.id_categoria = c.id
            WHERE p.id = ?
        ");
        $stmt->bind_param('i', $_GET['id']);
=======
        if ($stmt) {
            $stmt->bind_param('i', $_GET['id']);
        }
>>>>>>> local-snapshot
    } else {
        $stmt = $conexao->prepare("
            SELECT p.*, c.nome AS categoria 
            FROM produto p
            LEFT JOIN categoria c ON p.id_categoria = c.id
        ");
    }

<<<<<<< HEAD
=======
    if (!$stmt) {
        header("Content-type: application/json; charset=utf-8");
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Erro ao preparar consulta: ' . $conexao->error,
            'data' => []
        ]);
        $conexao->close();
        exit();
    }

>>>>>>> local-snapshot
    $stmt->execute();
    $resultado = $stmt->get_result();
    $tabela = [];

    if($resultado->num_rows > 0){
        while($linha = $resultado->fetch_assoc()){
            $tabela[] = $linha;
        }
        $retorno = [
            'status' => 'ok',
            'mensagem' => 'Sucesso, consulta efetuada',
            'data' => $tabela
        ];
    } else {
        $retorno = [
            'status' => 'nok',
            'mensagem' => 'Não há registros',
            'data' => []
        ];
    }

    $stmt->close();
    $conexao->close();

    header("Content-type: application/json; charset=utf-8");
<<<<<<< HEAD
    echo json_encode($retorno);
=======
    ob_clean();
    echo json_encode($retorno);
    exit();
>>>>>>> local-snapshot
?>