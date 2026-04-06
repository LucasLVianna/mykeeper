<?php
session_start();

if (empty($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: /mykeeper-lucas_vianna/src/Views/usuario_login.php");
    exit;
}

