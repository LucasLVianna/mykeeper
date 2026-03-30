<<<<<<< HEAD
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Produto</title>
</head>
<body>
    <section>
        <form>
            <div>
                <label for="nome_produto">Nome</label>
                <input type="text" name="nome_produto" id="nome_produto">
                <input type="hidden" name="id" id="id">
            </div>

            <div>
                <label for="categoria_produto">Categoria</label>
                <input type="text" name="categoria_produto" id="categoria_produto">
            </div>
            <div>
                <label for="und_medida_produto">Unidade de medida</label>
                <input type="text" name="und_medida_produto" id="und_medida_produto">
            </div>

            <button type="button" id="alterarproduto">Salvar</button>
        </form>
    </section>

    <script src="/mykeeper/public/js/produto_alterar.js"></script>
</body>
</html>
=======
<?php
$pageTitle = 'Editar Produto';
$pageSlug = 'inventory-form';
include __DIR__ . '/../Includes/header.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Editar Produto</h1>
            <p class="page-subtitle">Altere as informacoes do produto.</p>
        </div>
    </div>

    <div class="standalone-sheet-wrap">
        <section class="surface-card standalone-sheet">
            <div class="surface-content">
                <form id="standaloneProductForm" class="stack-form" data-mode="edit">
                    <input type="hidden" name="id" id="id">
                    <div class="field-group">
                        <label class="field-label" for="nome_produto">Nome do produto</label>
                        <input class="field-control" type="text" name="nome_produto" id="nome_produto" placeholder="Ex: Queijo Mussarela">
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="data_validade_produto">Data de vencimento</label>
                        <input class="field-control" type="date" name="data_validade_produto" id="data_validade_produto">
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="quantidade_produto">Quantidade</label>
                        <input class="field-control" type="number" name="quantidade_produto" id="quantidade_produto" min="1" value="1">
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="categoria_produto">Categoria</label>
                        <select class="field-control" name="categoria_produto" id="categoria_produto">
                            <option value="laticinios">Laticinios</option>
                            <option value="carnes">Carnes</option>
                            <option value="frutas">Frutas</option>
                            <option value="verduras">Verduras</option>
                            <option value="bebidas">Bebidas</option>
                            <option value="congelados">Congelados</option>
                            <option value="condimentos">Condimentos</option>
                            <option value="outros">Outros</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="und_medida_produto">Unidade de medida</label>
                        <input class="field-control" type="text" name="und_medida_produto" id="und_medida_produto" placeholder="Ex: Unidade">
                    </div>
                    <div class="inline-actions">
                        <a class="button button-secondary" href="/mykeeper-main/src/Views/produto.php">Cancelar</a>
                        <button class="button button-primary" type="submit" id="alterarproduto">Salvar Alteracoes</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</section>
<?php include __DIR__ . '/../Includes/footer.php'; ?>
>>>>>>> local-snapshot
