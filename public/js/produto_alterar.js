function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

document.addEventListener('DOMContentLoaded', async () => {
    // 1. Primeiro verifica se está logado
    const response = await fetch('/mykeeper/config/check_session.php');
    const data = await response.json();
    
    if (!data.logado) {
        window.location.href = '/mykeeper/src/Views/usuario_login.php';
        return; // para a execução aqui
    }

    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');
    carregarCategorias(id);
});

document.getElementById('icone_produto').addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            const preview = document.getElementById('preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});

async function carregarCategorias(id) {
    const retorno = await fetch('/mykeeper/src/Controllers/categoria_get.php');
    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        const select = document.getElementById('categoria_produto');
        resposta.data.forEach(categoria => {
            const option = document.createElement('option');
            option.value = categoria.id;
            option.textContent = categoria.nome;
            select.appendChild(option);
        });
    }

    // Só busca o produto depois que as categorias já estão no select
    buscar(id);
}

async function buscar(id) {
    const retorno = await fetch('/mykeeper/src/Controllers/produto_get.php?id='+id);
=======
    const retorno = await fetch('/mykeeper-main/src/Controllers/produto_get.php?id='+id);
>>>>>>> local-snapshot
    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        const item = resposta.data[0];
        document.getElementById('nome_produto').value      = e(item.nome);
        document.getElementById('und_medida_produto').value = e(item.und_medida);
        document.getElementById('id').value                = id;

        // Seleciona a categoria atual do produto no select
        document.getElementById('categoria_produto').value = item.id_categoria;

        if(item.imagem){
            const preview = document.getElementById('preview');
            preview.src = item.imagem; 
            preview.style.display = 'block';
        }

    } else {
        alert('ERRO: ' + resposta.mensagem);
        window.location.href = 'produto.php';
    }
}

document.getElementById('alterarproduto').addEventListener('click', () => {
    alterar();
});

async function alterar() {
    const nome_produto       = document.getElementById('nome_produto').value;
    const id_categoria       = document.getElementById('categoria_produto').value;
    const und_medida_produto = document.getElementById('und_medida_produto').value;
    const id                 = document.getElementById('id').value;
    const icone_produto      = document.getElementById('icone_produto').files[0];

    const fd = new FormData();
    fd.append('nome_produto', nome_produto);
    fd.append('id_categoria', id_categoria);
    fd.append('und_medida_produto', und_medida_produto);
    if (icone_produto) {
        fd.append('icone_produto', icone_produto);
    }

<<<<<<< HEAD
    const retorno = await fetch('/mykeeper/src/Controllers/produto_alterar_back.php?id='+id, {
=======
    const retorno = await fetch('/mykeeper-main/src/Controllers/produto_alterar_back.php?id='+id, {
>>>>>>> local-snapshot
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        alert('SUCESSO! ' + resposta.mensagem);
        window.location.href = '/mykeeper/src/Views/produto.php';
    } else {
        alert('ERRO! ' + resposta.mensagem);
        window.location.href = '/mykeeper/src/Views/produto.php';
    }
}