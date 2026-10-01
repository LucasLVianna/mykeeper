<?php
include_once(__DIR__ . '/../../config/headers.php');
include_once(__DIR__ . '/../../config/conexao.php');
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

$retorno = [
    'status' => '',
    'mensagem' => '',
    'data' => []
];

$id_usuario = $_SESSION['usuario']['id'];

if(isset($_GET['id'])){

    // 1. Verifica se o produto está sendo usado como ingrediente
    // FAZ: consulta apenas a tabela item_ingrediente (vínculo com receitas).
    // NÃO FAZ: não consulta item_estoque, portanto não detecta produto vinculado a um estoque.
    // NÃO FAZ: também não consulta item_lista_compra.
    $stmt = $conexao->prepare("SELECT COUNT(*) AS total FROM item_ingrediente WHERE id_produto = ?");
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $linha = $resultado->fetch_assoc();
    $stmt->close();

    // FAZ: se total > 0, retorna 'nok' com aviso e encerra com exit().
    // NÃO FAZ: para produto só em estoque, total = 0 e este bloqueio NÃO é acionado.
    if($linha['total'] > 0){
        $retorno = [
            'status' => 'nok',
            'mensagem' => 'Não é possível excluir este produto pois ele está sendo usado como ingrediente em uma ou mais receitas.',
            'data' => []
        ];
        $conexao->close();
        header("Content-type:application/json;charset:utf-8");
        echo json_encode($retorno);
        exit();
    }

    // 2. Busca a imagem antes de deletar
    // ATENÇÃO: este trecho roda ANTES do DELETE. Se o DELETE falhar, a imagem já foi apagada (unlink).
    $stmt = $conexao->prepare("SELECT imagem FROM produto WHERE id = ? AND id_usuario = ?");
    $stmt->bind_param('ii', $_GET['id'], $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $imagem = null;
    if($resultado->num_rows > 0){
        $linha = $resultado->fetch_assoc();
        $imagem = $linha['imagem'];
    }
    $stmt->close();

    if($imagem){
        $caminhoFisico = dirname(__DIR__, 2) . str_replace('/mykeeper', '', $imagem);
        if(file_exists($caminhoFisico)){
            unlink($caminhoFisico);
        }
    }

    //para o comando de voz
    // ATENÇÃO: o INSERT em produto_historico também roda ANTES do DELETE.
    // Se o DELETE falhar, fica um registro de histórico de um produto que continua existindo.
    $hist = $conexao->prepare("INSERT INTO produto_historico (id_usuario, nome, id_categoria, und_medida) SELECT id_usuario, nome, id_categoria, und_medida FROM produto WHERE id = ? AND id_usuario = ?");
    $hist->bind_param('ii', $_GET['id'], $id_usuario);
    $hist->execute();
    $hist->close();

    // 3. Deleta o produto
    // NÃO FAZ: não verifica vínculo com estoque; quem barra é a FK ON DELETE RESTRICT do banco (item_estoque.id_produto).
    // Se a FK bloquear: no PHP 8.1+ o mysqli lança exceção (erro 500, sem JSON de aviso);
    // em versões anteriores, affected_rows fica -1 e cai no else com a mensagem enganosa
    // "Produto não encontrado ou sem permissão".
    $stmt = $conexao->prepare("DELETE FROM produto WHERE id = ? AND id_usuario = ?");
    $stmt->bind_param('ii', $_GET['id'], $id_usuario);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        $retorno = [
            'status' => 'ok',
            'mensagem' => 'Produto excluído com sucesso.',
            'data' => []
        ];
    } else {
        $retorno = [
            'status' => 'nok',
            'mensagem' => 'Produto não encontrado ou sem permissão para exclusão.',
            'data' => []
        ];
    }
    $stmt->close();

} else {
    $retorno = [
        'status' => 'nok',
        'mensagem' => 'É necessário informar um ID para exclusão.',
        'data' => []
    ];
}

$conexao->close();
header("Content-type:application/json;charset:utf-8");
echo json_encode($retorno);