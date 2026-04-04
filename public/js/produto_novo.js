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
    // 1. Primeiro verifica se está logado
    const response = await fetch('/mykeeper/config/check_session.php');
    const data = await response.json();
    
    if (!data.logado) {
        window.location.href = '/mykeeper/src/Views/usuario_login.php';
        return; // para a execução aqui
    }
    
    carregarCategorias();
});

async function carregarCategorias() {
    const retorno = await fetch('/mykeeper/src/Controllers/categoria_get.php');
    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        const select = document.getElementById('categoria_produto');
        resposta.data.forEach(categoria => {
            const option = document.createElement('option');
            option.value = categoria.id;        // envia o id para o banco
            option.textContent = categoria.nome; // exibe o nome para o usuário
            select.appendChild(option);
        });
    } else {
        alert('Erro ao carregar categorias');
    }
}

document.getElementById('addproduto').addEventListener('click', () => {
    novo();
});

async function novo() {
    const nome_produto       = document.getElementById('nome_produto').value;
    const categoria_produto  = document.getElementById('categoria_produto').value;
    const und_medida_produto = document.getElementById('und_medida_produto').value;
    const icone_produto      = document.getElementById('icone_produto').files[0];

    const fd = new FormData();
    fd.append('nome_produto', nome_produto);
    fd.append('id_categoria', categoria_produto); // envia o id da categoria
    fd.append('und_medida_produto', und_medida_produto);
    if (icone_produto) {
        fd.append('icone_produto', icone_produto);
    }

<<<<<<< HEAD
    const retorno = await fetch('/mykeeper/src/Controllers/produto_novo_back.php', {
=======
    const retorno = await fetch('/mykeeper-main/src/Controllers/produto_novo_back.php', {
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
    }
}