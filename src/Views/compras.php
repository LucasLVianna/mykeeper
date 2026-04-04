<?php
$pageTitle = 'Lista de Compras';
$pageSlug = 'shopping';
include __DIR__ . '/../Includes/header.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Lista de Compras</h1>
            <p class="page-subtitle"><span id="shoppingCountLabel">0 itens na lista</span></p>
        </div>
        <button type="button" id="openShoppingForm" class="button button-primary">
            <span class="button-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14"></path>
                    <path d="M5 12h14"></path>
                </svg>
            </span>
            <span>Adicionar</span>
        </button>
    </div>
    <div id="shoppingList" class="stack-list"></div>
</section>
<?php include __DIR__ . '/../Includes/shopping_sheet.php'; ?>
<?php include __DIR__ . '/../Includes/footer.php'; ?>
