<?php
    session_start();
    if (empty($_SESSION['admin']) || $_SESSION['admin'] !== true) {
        header("Location: /mykeeper-lucas_vianna/src/Views/admin_login.php");
        exit;
    }
