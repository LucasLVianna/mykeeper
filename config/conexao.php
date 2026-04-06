<?php
mysqli_report(MYSQLI_REPORT_OFF);

$envPath = __DIR__ . '/../.env';

function responderErroConexao($mensagem)
{
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'nok',
        'mensagem' => $mensagem,
        'data' => []
    ]);
    exit();
}

if (!file_exists($envPath)) {
    responderErroConexao('Arquivo .env nao encontrado. Configure as credenciais do banco.');
}

$env = parse_ini_file($envPath);

if ($env === false) {
    responderErroConexao('Nao foi possivel ler o arquivo .env.');
}

$dbHost = $env['DB_HOST'] ?? '127.0.0.1';
$dbPort = isset($env['DB_PORT']) && $env['DB_PORT'] !== '' ? (int) $env['DB_PORT'] : 3306;
$dbName = $env['DB_NAME'] ?? '';
$dbUser = $env['DB_USERNAME'] ?? '';
$dbPass = $env['DB_PASSWORD'] ?? '';

if ($dbName === '' || $dbUser === '') {
    responderErroConexao('Credenciais do banco incompletas no arquivo .env.');
}

$conexao = @new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

if ($conexao->connect_error) {
    responderErroConexao('Falha ao conectar no banco: ' . $conexao->connect_error);
}
