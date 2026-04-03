<?php
    session_start();
    $_SESSION = array();
    session_destroy();
    header("Location: /mykeeper/src/Views/usuario_login.php");
    exit;