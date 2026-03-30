<?php
$servidor = "127.0.0.1";
$usuario = "root";
$senha = "Dwu9qv85@d4rk1";
$nome_banco = "mykeeper";

$conexao = new mysqli($servidor, $usuario, $senha, $nome_banco);

if($conexao->connect_error){
    header("Content-type: application/json; charset=utf-8");
    echo json_encode([
        'status' => 'nok',
        'mensagem' => $conexao->connect_error,
        'data' => []
    ]);
    exit();
}