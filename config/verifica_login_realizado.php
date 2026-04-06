<?php

if(!empty($_SESSION['logado']) && $_SESSION['logado'] == true) {
    header("Location: /mykeeper-lucas_vianna/src/Views/home.php");
    exit;
};

