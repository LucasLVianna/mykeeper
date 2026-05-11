const urlParams = new URLSearchParams(window.location.search);
const id_lista = urlParams.get('id');

function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/mykeeper/config/check_session.php');
    const data = await response.json();
    
    if (!data.logado) {
        window.location.href = '/mykeeper/src/Views/usuario_login.php';
        return;
    }

    if (!id_lista) {
        document.getElementById('mensagem').textContent = 'ID da lista não informado';
        return;
    }

    await carregarInfoLista();
    await carregarProdutos();
});

async function carregarInfoLista() {
    const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_get.php?id=${id_lista}`);
    const resposta = await retorno.json();

    if (resposta.status == 'ok' && resposta.data.length > 0) {
        const lista = resposta.data[0];
        document.getElementById('titulo_lista').textContent = e(lista.titulo);
        
        let infoHtml = `
            <div style="background-color: #f5f5f5; padding: 10px; border-radius: 5px; margin: 10px 0;">
                <p><strong>Título:</strong> ${e(lista.titulo)}</p>
                <p><strong>Status:</strong> <span class="status-${lista.status_compra === 'aberta' ? 'ativa' : lista.status_compra}">${lista.status_compra}</span></p>
            </div>
        `;
        document.getElementById('info_lista').innerHTML = infoHtml;
    }
}

async function carregarProdutos() {
    const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_produto_get.php?id_lista=${id_lista}`);
    const resposta = await retorno.json();

    if (resposta.status == 'ok' && resposta.data.length > 0) {
        preencherTabelaProdutos(resposta.data);
    } else {
        document.getElementById('lista_produtos').innerHTML = '<p>Nenhum produto adicionado a esta lista.</p>';
    }
}

function preencherTabelaProdutos(produtos) {
    let html = `
        <table class="tabela">
            <tr>
                <th>ID Produto</th>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>#</th>
            </tr>
    `;

    for (let i = 0; i < produtos.length; i++) {
        const nome = produtos[i].nome_produto || 'Produto sem nome';
        
        html += `
            <tr>
                <td>${produtos[i].id_produto || '-'}</td>
                <td>${e(nome)}</td>
                <td>${produtos[i].quantidade}</td>
                <td>
                    <button onclick="removerProduto(${produtos[i].id_lista_compra}, ${produtos[i].id_produto})" title="Remover" style="background: none; border: none; cursor: pointer; padding: 0;">
                        <img src="/mykeeper/public/assets/deletar.png" alt="remover">
                    </button>
                </td>
            </tr>
        `;
    }

    html += `</table>`;
    document.getElementById('lista_produtos').innerHTML = html;
}

async function adicionarAoEstoque(id_produto) {
    const confirma = confirm('Adicionar este produto ao estoque?');
    if (confirma) {
        const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_produto_adicionar_estoque.php?id_produto=${id_produto}`);
        const resposta = await retorno.json();
        
        if (resposta.status == 'ok') {
            document.getElementById('mensagem').textContent = 'Produto adicionado ao estoque com sucesso!';
            setTimeout(() => carregarProdutos(), 1500);
        } else {
            document.getElementById('mensagem').textContent = 'Erro ao adicionar ao estoque: ' + resposta.mensagem;
        }
    }
}

async function removerProduto(id_lista, id_produto) {
    const confirma = confirm('Remover este produto da lista?');
    if (confirma) {
        const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_produto_excluir.php?id_lista=${id_lista}&id_produto=${id_produto}`);
        const resposta = await retorno.json();
        
        if (resposta.status == 'ok') {
            document.getElementById('mensagem').textContent = 'Produto removido com sucesso!';
            setTimeout(() => carregarProdutos(), 1500);
        } else {
            document.getElementById('mensagem').textContent = 'Erro ao remover produto: ' + resposta.mensagem;
        }
    }
}

document.getElementById('adicionar_produto').addEventListener('click', () => {
    document.getElementById('formulario_produto').style.display = document.getElementById('formulario_produto').style.display === 'none' ? 'block' : 'none';
});

document.getElementById('cancelar_produto').addEventListener('click', () => {
    document.getElementById('formulario_produto').style.display = 'none';
    document.getElementById('nome_produto').value = '';
    document.getElementById('quantidade_produto').value = '1';
});

document.getElementById('confirmar_produto').addEventListener('click', () => {
    adicionarProduto();
});

async function adicionarProduto() {
    const nome_produto = document.getElementById('nome_produto').value;
    const quantidade_produto = parseInt(document.getElementById('quantidade_produto').value);

    if (!nome_produto) {
        document.getElementById('error-nome').textContent = 'Nome do produto é obrigatório';
        return;
    }

    if (isNaN(quantidade_produto) || quantidade_produto <= 0) {
        document.getElementById('error-nome').textContent = 'Quantidade deve ser maior que 0';
        return;
    }

    const fd = new FormData();
    fd.append('nome_produto', nome_produto);
    fd.append('quantidade_produto', quantidade_produto);

    const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_produto_novo_back.php?id_lista=${id_lista}`, {
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        document.getElementById('error').textContent = 'Produto adicionado com sucesso!';
        document.getElementById('nome_produto').value = '';
        document.getElementById('quantidade_produto').value = '1';
        document.getElementById('formulario_produto').style.display = 'none';
        setTimeout(() => carregarProdutos(), 1000);
    } else {
        document.getElementById('error').textContent = 'ERRO! ' + resposta.mensagem;
    }
}

document.getElementById('editar_lista').addEventListener('click', () => {
    window.location.href = `/mykeeper/src/Views/lista_compras_alterar.php?id=${id_lista}`;
});

document.getElementById('deletar_lista').addEventListener('click', () => {
    const confirma = confirm('Deseja realmente deletar esta lista de compras?');
    if (confirma) {
        fetch(`/mykeeper/src/Controllers/lista_compras_excluir.php?id=${id_lista}`)
            .then(response => response.json())
            .then(resposta => {
                if (resposta.status == 'ok') {
                    window.location.href = '/mykeeper/src/Views/lista_compras.php';
                } else {
                    alert('Erro ao deletar: ' + resposta.mensagem);
                }
            });
    }
});
