<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');

define('SENHA_ADMIN', 'senhaforte');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'nok', 'mensagem' => 'Metodo invalido']);
    exit;
}

$senhaInformada = isset($_POST['senha']) ? trim((string) $_POST['senha']) : '';

if ($senhaInformada !== '' && hash_equals(SENHA_ADMIN, $senhaInformada)) {
    $_SESSION['admin'] = true;
    echo json_encode(['status' => 'ok']);
} else {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Senha incorreta']);
}