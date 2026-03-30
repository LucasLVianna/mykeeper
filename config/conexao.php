<?php
// lendo o .env manualmente (PHP puro, sem Laravel)
<<<<<<< HEAD
$env = parse_ini_file(__DIR__ . '/../.env');
=======
$envPath = __DIR__ . '/../.env';
if (!file_exists($envPath)) {
    header("Content-type: application/json; charset=utf-8");
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'Arquivo .env não encontrado.',
        'data' => []
    ]);
    exit();
}

$env = @parse_ini_file($envPath, false, INI_SCANNER_TYPED);
if ($env === false) {
    header("Content-type: application/json; charset=utf-8");
    echo json_encode([
        'status' => 'nok',
        'mensagem' => 'Falha ao ler o arquivo de configuração .env.',
        'data' => []
    ]);
    exit();
}
>>>>>>> local-snapshot

$conexao = new mysqli(
    $env['DB_HOST'],
    $env['DB_USERNAME'],
    $env['DB_PASSWORD'],
    $env['DB_NAME']
);

if($conexao->connect_error){
    header("Content-type: application/json; charset=utf-8");
    echo json_encode([
        'status' => 'nok',
        'mensagem' => $conexao->connect_error,
        'data' => []
    ]);
    exit();
}
