<?php
$servidor = "localhost";
$usuario  = "root";
$senha    = "Mp0709@#";
$nome_banco = "Mykeeper";

$conexao = new mysqli($servidor, $usuario, $senha, $nome_banco);

if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}
?>