<?php
session_start();

header('Content-Type: application/json');

if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
    echo json_encode([
        'logado' => true,
        'redirect' => '/mykeeper/src/Views/home.php'
    ]);
}else{
    echo json_encode([
        'logado' => false
    ]);
}
