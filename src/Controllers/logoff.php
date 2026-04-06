<?php
    session_start();
    $_SESSION = array();
    session_destroy();
    header("Location: /mykeeper-lucas_vianna/index.html");
    exit;
