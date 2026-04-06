<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Acesso';
}

header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

$rootPath = '/mykeeper-lucas_vianna';
$authEyebrow = isset($authEyebrow) ? $authEyebrow : 'MyKeeper';
$authHeadline = isset($authHeadline) ? $authHeadline : 'Organize seu estoque com clareza';
$authCopy = isset($authCopy) ? $authCopy : 'Acesse sua conta e continue seu controle de estoque.';
$authTheme = isset($authTheme) ? $authTheme : 'default';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES) ?> - MyKeeper</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= htmlspecialchars($rootPath, ENT_QUOTES) ?>/public/css/app_theme.css">
</head>
<body class="auth-page">
    <div class="auth-shell auth-shell-<?= htmlspecialchars($authTheme, ENT_QUOTES) ?>">
        <section class="auth-hero">
            <div class="auth-hero-card">
                <span class="auth-hero-kicker"><?= htmlspecialchars($authEyebrow, ENT_QUOTES) ?></span>
                <h1><?= htmlspecialchars($authHeadline, ENT_QUOTES) ?></h1>
                <p><?= htmlspecialchars($authCopy, ENT_QUOTES) ?></p>
            </div>
        </section>
        <main class="auth-panel">
            <div class="auth-card">
