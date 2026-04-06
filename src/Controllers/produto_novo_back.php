<?php
include_once(__DIR__ . '/../../config/headers.php');
include_once(__DIR__ . '/../../config/conexao.php');
include_once(__DIR__ . '/../Includes/product_units.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$retorno = [
    'status'   => '',
    'mensagem' => '',
    'data'     => []
];

if (empty($_SESSION['usuario']['id'])) {
    $retorno = [
        'status'   => 'nok',
        'mensagem' => 'Sessão expirada. Faça login novamente.',
        'data'     => []
    ];

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($retorno);
    exit;
}

$id_usuario = (int) $_SESSION['usuario']['id'];

$nome_produto = trim($_POST['nome_produto'] ?? '');
$id_categoria = isset($_POST['id_categoria']) && $_POST['id_categoria'] !== '' ? (int) $_POST['id_categoria'] : 0;
$und_medida_produto = trim($_POST['und_medida_produto'] ?? '');
$icone_produto = null;
$unidadesPermitidas = productUnitValues();

if ($nome_produto === '' || $und_medida_produto === '') {
    header('Content-type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'Preencha nome e unidade de medida antes de salvar.',
        'data' => []
    ]);
    exit;
}

if ($id_categoria <= 0) {
    header('Content-type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'Selecione uma categoria válida antes de cadastrar o produto.',
        'data' => []
    ]);
    exit;
}

if (!in_array($und_medida_produto, $unidadesPermitidas, true)) {
    header('Content-type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'Selecione uma unidade de medida valida para alimentos.',
        'data' => []
    ]);
    exit;
}

$validarCategoria = $conexao->prepare('SELECT id FROM categoria WHERE id = ? AND id_usuario = ?');
$validarCategoria->bind_param('ii', $id_categoria, $id_usuario);
$validarCategoria->execute();
$categoriaResult = $validarCategoria->get_result();

if ($categoriaResult->num_rows === 0) {
    $validarCategoria->close();
    $conexao->close();

    header('Content-type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'A categoria selecionada não foi encontrada para este usuário.',
        'data' => []
    ]);
    exit;
}

$validarCategoria->close();

if (isset($_FILES['icone_produto']) && $_FILES['icone_produto']['error'] === 0) {
    $extensoesPermitidas = ['jpg', 'jpeg', 'png'];
    $extensao = strtolower(pathinfo($_FILES['icone_produto']['name'], PATHINFO_EXTENSION));

    if (!in_array($extensao, $extensoesPermitidas, true)) {
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Formato de imagem inválido.',
            'data' => []
        ]);
        exit;
    }

    if ($_FILES['icone_produto']['size'] > 2 * 1024 * 1024) {
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'A imagem deve ter no máximo 2 MB.',
            'data' => []
        ]);
        exit;
    }

    $nomeArquivo = uniqid('produto_') . '.' . $extensao;
    $pastaFisica = dirname(__DIR__, 2) . '/public/uploads/produtos/';
    $caminhoURL = '/mykeeper-lucas_vianna/public/uploads/produtos/' . $nomeArquivo;

    if (move_uploaded_file($_FILES['icone_produto']['tmp_name'], $pastaFisica . $nomeArquivo)) {
        $icone_produto = $caminhoURL;
    } else {
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Erro ao salvar o ícone.',
            'data' => []
        ]);
        exit;
    }
}

$stmt = $conexao->prepare('INSERT INTO produto(nome, id_categoria, und_medida, imagem, id_usuario) VALUES(?,?,?,?,?)');
$stmt->bind_param('sissi', $nome_produto, $id_categoria, $und_medida_produto, $icone_produto, $id_usuario);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $retorno = [
        'status' => 'ok',
        'mensagem' => 'Produto inserido com sucesso.',
        'data' => []
    ];
} else {
    $retorno = [
        'status' => 'nok',
        'mensagem' => 'Falha ao inserir o produto.',
        'data' => []
    ];
}

$stmt->close();
$conexao->close();

header('Content-type: application/json; charset=utf-8');
echo json_encode($retorno);
