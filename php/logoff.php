<?php
    session_start();
    session_unset();
    session_destroy();
    $retorno = [
        'status'    => 'ok', // ok - nok
        'mensagem'  => '', // mensagem que envio para o front
        'data'      => []
    ];
    header("Location: ../usuario/usuario_login.php");
    exit;