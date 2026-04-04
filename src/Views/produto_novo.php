<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Produto</title>
</head>

<body>
    <section>
        <form>
            <div>
                <label for="nome_produto">Nome</label>
                <input type="text" name="nome_produto" id="nome_produto">
            </div>

            <div>
                <label for="categoria_produto">Categoria</label>
                <select name="categoria_produto" id="categoria_produto">
                    <option value="">Selecione uma categoria</option>
                </select>
            </div>
            
            <div>
                <label for="und_medida_produto">Unidade de medida</label>
                <input type="text" name="und_medida_produto" id="und_medida_produto">
            </div>

            <div>
                <label for="icone_produto">Ícone do produto</label>
                <input type="file" name="icone_produto" id="icone_produto" accept="image/png, image/jpeg, image/jpg">
            </div>

            <div>
                <img src="" id="preview" style="display:none; width:100px; height:100px;">
            </div>

            <button type="button" id="addproduto">Adicionar</button>
        </form>
    </section>

    <script src="/mykeeper/public/js/produto_novo.js"></script>
</body>

</html>
=======
<?php
$pageTitle = 'Adicionar Produto';
$pageSlug = 'inventory-form';
include __DIR__ . '/../Includes/header.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Adicionar Produto</h1>
            <p class="page-subtitle">Preencha os dados do novo produto.</p>
        </div>
    </div>

    <div class="standalone-sheet-wrap">
        <section class="surface-card standalone-sheet">
            <div class="surface-content">
                <form id="standaloneProductForm" class="stack-form" data-mode="add">
                    <div class="field-group">
                        <label class="field-label" for="nome_produto">Nome do produto</label>
                        <input class="field-control" type="text" name="nome_produto" id="nome_produto" placeholder="Ex: Leite Integral">
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
                        <button class="button button-primary" type="submit" id="addproduto">Adicionar Produto</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</section>
<?php include __DIR__ . '/../Includes/footer.php'; ?>
>>>>>>> local-snapshot
