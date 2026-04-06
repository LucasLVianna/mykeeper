function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

const productSheetId = 'productSheet';
const productSheet = document.getElementById(productSheetId);
const productCategoriaSelect = document.getElementById('sheet_categoria_produto');

function abrirSheet(id) {
    const sheet = document.getElementById(id);
    if (!sheet) {
        return;
    }
    sheet.hidden = false;
    document.body.style.overflow = 'hidden';
}

function fecharSheet(id) {
    const sheet = document.getElementById(id);
    if (!sheet) {
        return;
    }
    sheet.hidden = true;
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/mykeeper-lucas_vianna/config/check_session.php');
    const data = await response.json();

    if (!data.logado) {
        window.location.href = '/mykeeper-lucas_vianna/src/Views/usuario_login.php';
        return;
    }

    await buscar();

    if (new URLSearchParams(window.location.search).get('sheet') === 'new') {
        abrirSheetProduto();
    }
});

async function buscar() {
    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/produto_get.php');
    const resposta = await retorno.json();
    if (resposta.status == 'ok') {
        preencherTabela(resposta.data);
    } else {
        document.getElementById('item').innerHTML = '<div class="table-empty">Nenhum produto encontrado.</div>';
    }
}

function preencherTabela(tabela) {
    let html = `
    <table class="tabela data-table">
        <tr>
            <th>ID</th>
            <th>Ícone</th>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Unidade de medida</th>
            <th>#</th>
        </tr>
    `;

    for (let i = 0; i < tabela.length; i++) {
        const icone = tabela[i].imagem
            ? `<img src="${e(tabela[i].imagem)}" style="width:40px; height:40px;">`
            : 'Sem ícone';

        html += `<tr>
                <td>${tabela[i].id}</td>
                <td>${icone}</td>
                <td>${e(tabela[i].nome)}</td>
                <td>${e(tabela[i].categoria)}</td>
                <td>${e(tabela[i].und_medida)}</td>
                <td class="botoes"> 
                <button class="btn-editar"><a href="produto_alterar.php?id=${tabela[i].id}">Editar</a></button>
                <button class="btn-excluir"><a href="#" onclick="excluir(${tabela[i].id})">Excluir</a></button>
                </td>
                </tr>`;
    }

    html += `</table>`;
    document.getElementById('item').innerHTML = html;
}

async function excluir(id) {
    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/produto_excluir.php?id=' + id);
    const resposta = await retorno.json();
    if (resposta.status == 'ok') {
        alert('SUCESSO! ' + resposta.mensagem);
    } else {
        alert('ERRO! ' + resposta.mensagem);
    }

    window.location.reload();
}

function limparSheetProduto() {
    document.getElementById('sheet_nome_produto').value = '';
    document.getElementById('sheet_und_medida_produto').value = '';
    document.getElementById('sheet_icone_produto').value = '';
    document.getElementById('sheet_preview_produto').src = '';
    document.getElementById('sheet_preview_produto').style.display = 'none';
    productCategoriaSelect.innerHTML = '<option value="">Selecione uma categoria</option>';
}

async function carregarCategoriasSheet() {
    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/categoria_get.php');
    const resposta = await retorno.json();

    productCategoriaSelect.innerHTML = '<option value="">Selecione uma categoria</option>';

    if (resposta.status === 'ok' && Array.isArray(resposta.data) && resposta.data.length > 0) {
        resposta.data.forEach((categoria) => {
            const option = document.createElement('option');
            option.value = categoria.id;
            option.textContent = categoria.nome;
            productCategoriaSelect.appendChild(option);
        });
        return true;
    }

    alert(resposta.mensagem || 'Cadastre uma categoria antes de adicionar um produto.');
    return false;
}

async function abrirSheetProduto() {
    limparSheetProduto();
    const temCategorias = await carregarCategoriasSheet();
    if (!temCategorias) {
        return;
    }

    abrirSheet(productSheetId);
}

document.getElementById('sheet_icone_produto').addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (event) => {
            const preview = document.getElementById('sheet_preview_produto');
            preview.src = event.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('produto_novo').addEventListener('click', () => {
    abrirSheetProduto();
});

document.getElementById('sheet_addproduto').addEventListener('click', async () => {
    const nome_produto = document.getElementById('sheet_nome_produto').value.trim();
    const categoria_produto = document.getElementById('sheet_categoria_produto').value;
    const und_medida_produto = document.getElementById('sheet_und_medida_produto').value;
    const icone_produto = document.getElementById('sheet_icone_produto').files[0];

    if (!nome_produto || !categoria_produto || !und_medida_produto) {
        alert('Preencha nome, categoria e selecione a unidade de medida.');
        return;
    }

    const fd = new FormData();
    fd.append('nome_produto', nome_produto);
    fd.append('id_categoria', categoria_produto);
    fd.append('und_medida_produto', und_medida_produto);
    if (icone_produto) {
        fd.append('icone_produto', icone_produto);
    }

    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/produto_novo_back.php', {
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        alert('SUCESSO! ' + resposta.mensagem);
        fecharSheet(productSheetId);
        window.location.href = '/mykeeper-lucas_vianna/src/Views/produto.php';
        return;
    }

    alert('ERRO! ' + resposta.mensagem);
});
