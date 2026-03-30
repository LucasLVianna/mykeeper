<?php
    include_once('../php/conexao.php'); // conexão

    $retorno = [
        'status'   => '',
        'mensagem' => '',
        'data'     => []
    ];

    // Se tiver id, busca um registro específico
    if(isset($_GET['id'])){
        $stmt = $conexao->prepare("SELECT id, nome, email FROM suporte WHERE id = ?");
        $stmt->bind_param("i", $_GET['id']);
    }else{
        // Senão, busca todos
        $stmt = $conexao->prepare("SELECT id, nome, email FROM suporte");
    }

    $stmt->execute();
    $resultado = $stmt->get_result();
    $tabela = [];

    // Monta array com os resultados
    if($resultado->num_rows > 0){
        while($linha = $resultado->fetch_assoc()){
            $tabela[] = $linha;
        }

        $retorno = [
            'status'   => 'ok',
            'mensagem' => 'Sucesso, consulta efetuada.',
            'data'     => $tabela
        ];
    }else{
        $retorno = [
            'status'   => 'nok',
            'mensagem' => 'Não há registros.',
            'data'     => []
        ];
    }

    $stmt->close();
    $conexao->close();

    // Retorna JSON
    header("Content-type: application/json; charset=utf-8");
    echo json_encode($retorno);
    exit;
?>