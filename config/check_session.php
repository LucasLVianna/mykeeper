<?php
session_start();

header('Content-Type: application/json');

if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
    echo json_encode([
        'logado' => true,
        'id'      => $_SESSION['usuario']['id'],
        'nome'    => $_SESSION['usuario']['nome'],
        'redirect' => '/mykeeper-lucas_vianna/src/Views/home.php'
    ]);
}else{
    echo json_encode([
        'logado' => false
    ]);
}

