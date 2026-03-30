<?php
$pageTitle = 'Produtos a Vencer';
$pageSlug = 'expiring';
include __DIR__ . '/../Includes/header.php';
?>
<section class="page-view">
    <div>
        <h1 class="page-title">Produtos a Vencer</h1>
        <p class="page-subtitle">Produtos que vencem nos proximos 7 dias</p>
    </div>
    <div id="expiringList" class="stack-list"></div>
</section>
<?php include __DIR__ . '/../Includes/footer.php'; ?>
