<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once(__DIR__ . '/../../config/headers.php');
include_once(__DIR__ . '/../../config/conexao.php');

$retorno = [
    'status' => '',
    'mensagem' => '',
    'data' => []
];

if(isset($_GET['id'])){

    $nome = $_POST['nome_produto'];
    $id_categoria = (int) $_POST['id_categoria'];
    $und_medida = $_POST['und_medida_produto'];

    $imagem = null;

    if(isset($_FILES['icone_produto']) && $_FILES['icone_produto']['error'] == 0){

        $ext = pathinfo($_FILES['icone_produto']['name'], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid('produto_') . '.' . $ext;

        $pastaFisica = dirname(__DIR__, 2) . '/public/uploads/produtos/';
        $caminhoURL = '/mykeeper/public/uploads/produtos/' . $nome_arquivo;

        if(move_uploaded_file($_FILES['icone_produto']['tmp_name'], $pastaFisica . $nome_arquivo)){
            $imagem = $caminhoURL;
        } else {
            echo json_encode([
                'status' => 'nok',
                'mensagem' => 'Erro ao mover imagem'
            ]);
            exit;
        }
    }

    if($imagem){
        $stmt = $conexao->prepare("
            UPDATE produto 
            SET nome=?, id_categoria=?, und_medida=?, imagem=?
            WHERE id=?
        ");
        $stmt->bind_param("sissi", $nome, $id_categoria, $und_medida, $imagem, $_GET['id']);
    } else {
        $stmt = $conexao->prepare("
            UPDATE produto 
            SET nome=?, id_categoria=?, und_medida=?
            WHERE id=?
        ");
        $stmt->bind_param("sisi", $nome, $id_categoria, $und_medida, $_GET['id']);
    }

    if(!$stmt->execute()){
        echo json_encode([
            'status' => 'nok',
            'mensagem' => $stmt->error
        ]);
        exit;
    }

    $retorno = [
        'status' => 'ok',
        'mensagem' => 'Produto alterado com sucesso',
        'data' => []
    ];

    $stmt->close();

}else{
    $retorno = [
        'status' => 'nok',
        'mensagem' => 'ID não informado',
        'data' => []
    ];
}

$conexao->close();

header("Content-type: application/json; charset=utf-8");
echo json_encode($retorno);