const categoriaSelectNovo = document.getElementById('categoria_produto');
const addProdutoButton = document.getElementById('addproduto');

document.getElementById('icone_produto').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.getElementById('preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/mykeeper-lucas_vianna/config/check_session.php');
    const data = await response.json();

    if (!data.logado) {
        window.location.href = '/mykeeper-lucas_vianna/src/Views/usuario_login.php';
        return;
    }

    carregarCategorias();
});

function preencherSemCategorias(mensagem) {
    categoriaSelectNovo.innerHTML = '<option value="">' + mensagem + '</option>';
    categoriaSelectNovo.disabled = true;
    addProdutoButton.disabled = true;
}

async function carregarCategorias() {
    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/categoria_get.php');
    const resposta = await retorno.json();

    if (resposta.status === 'ok' && Array.isArray(resposta.data) && resposta.data.length > 0) {
        categoriaSelectNovo.disabled = false;
        addProdutoButton.disabled = false;
        resposta.data.forEach((categoria) => {
            const option = document.createElement('option');
            option.value = categoria.id;
            option.textContent = categoria.nome;
            categoriaSelectNovo.appendChild(option);
        });
        return;
    }

    preencherSemCategorias('Cadastre uma categoria primeiro');
    alert(resposta.mensagem || 'Não há categorias cadastradas para este usuário.');
}

document.getElementById('addproduto').addEventListener('click', () => {
    novo();
});

async function novo() {
    const nome_produto = document.getElementById('nome_produto').value.trim();
    const categoria_produto = document.getElementById('categoria_produto').value;
    const und_medida_produto = document.getElementById('und_medida_produto').value;
    const icone_produto = document.getElementById('icone_produto').files[0];

    if (!nome_produto) {
        alert('Por favor, preencha o nome do produto.');
        document.getElementById('nome_produto').focus();
        return;
    }

    if (!categoria_produto) {
        alert('Cadastre ou selecione uma categoria antes de salvar o produto.');
        document.getElementById('categoria_produto').focus();
        return;
    }

    if (!und_medida_produto) {
        alert('Por favor, selecione a unidade de medida.');
        document.getElementById('und_medida_produto').focus();
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
        window.location.href = '/mykeeper-lucas_vianna/src/Views/produto.php';
    } else {
        alert('ERRO! ' + resposta.mensagem);
    }
}
