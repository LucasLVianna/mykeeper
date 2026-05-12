const urlParams = new URLSearchParams(window.location.search);
const id_lista = urlParams.get('id');
const modoVisualizacao = urlParams.get('modo') === 'ver';

function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

function mostrarMensagem(texto, tipo = 'info') {
    const el = document.getElementById('mensagem');
    el.textContent = texto;
    el.className = `mensagem-feedback mensagem-${tipo}`;
}

async function respostaJsonSegura(response) {
    const texto = await response.text();
    try {
        return JSON.parse(texto);
    } catch (erro) {
        return {
            status: 'nok',
            mensagem: 'Resposta invalida do servidor',
            data: []
        };
    }
}

document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/mykeeper/config/check_session.php');
    const data = await response.json();
    
    if (!data.logado) {
        window.location.href = '/mykeeper/src/Views/usuario_login.php';
        return;
    }

    if (!id_lista) {
        mostrarMensagem('ID da lista nao informado', 'erro');
        return;
    }

    await carregarInfoLista();
    await carregarProdutos();

    if (modoVisualizacao) {
        document.body.classList.add('modo-visualizacao');
        document.getElementById('titulo_lista').textContent = 'Produtos da Lista';
    }
});

async function carregarInfoLista() {
    const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_get.php?id=${id_lista}`);
    const resposta = await respostaJsonSegura(retorno);

    if (resposta.status == 'ok' && resposta.data.length > 0) {
        const lista = resposta.data[0];
        document.getElementById('titulo_lista').textContent = e(lista.titulo);
        
        let infoHtml = `
            <div style="background-color: #f5f5f5; padding: 10px; border-radius: 5px; margin: 10px 0;">
                <p><strong>Título:</strong> ${e(lista.titulo)}</p>
                <p><strong>Estoque:</strong> ${e(lista.nome_estoque || 'Nao vinculado')}</p>
                <p><strong>Status:</strong> <span class="status-${lista.status_compra === 'aberta' ? 'ativa' : lista.status_compra}">${lista.status_compra}</span></p>
            </div>
        `;
        document.getElementById('info_lista').innerHTML = infoHtml;
    }
}

async function carregarProdutos() {
    const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_produto_get.php?id_lista=${id_lista}&t=${Date.now()}`, {
        cache: 'no-store'
    });
    const resposta = await respostaJsonSegura(retorno);

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
                <th>Comprado</th>
                <th>Quantidade</th>
                ${modoVisualizacao ? '' : '<th class="coluna-acoes">#</th>'}
            </tr>
    `;

    for (let i = 0; i < produtos.length; i++) {
        const nome = produtos[i].nome_produto || 'Produto sem nome';
        const comprado = Number(produtos[i].comprado || 0) === 1;
        const rowClass = comprado ? ' class="comprado"' : '';
        
        html += `
            <tr${rowClass}>
                <td>${produtos[i].id_produto || '-'}</td>
                <td>${e(nome)}</td>
                <td>
                    ${modoVisualizacao
                        ? `<span class="status-compra ${comprado ? 'status-sim' : 'status-nao'}">${comprado ? 'Sim' : 'Nao'}</span>`
                        : `<label class="check-comprado">
                            <input type="checkbox" id="comprado-${produtos[i].id_produto}" ${comprado ? 'checked' : ''} onchange="salvarProduto(${produtos[i].id_lista_compra}, ${produtos[i].id_produto})">
                            <span>Comprado</span>
                        </label>`
                    }
                </td>
                <td>
                    ${modoVisualizacao
                        ? e(String(produtos[i].quantidade))
                        : `<input class="input-quantidade-lista" type="number" id="quantidade-${produtos[i].id_produto}" value="${e(String(produtos[i].quantidade))}" min="1">`
                    }
                </td>
                ${modoVisualizacao ? '' : `
                    <td class="acoes-lista">
                        <button class="botao-acao botao-salvar" onclick="salvarProduto(${produtos[i].id_lista_compra}, ${produtos[i].id_produto})" title="Salvar">Salvar</button>
                        <button class="botao-acao botao-remover" onclick="removerProduto(${produtos[i].id_lista_compra}, ${produtos[i].id_produto})" title="Remover">Remover</button>
                    </td>
                `}
            </tr>
        `;
    }

    html += `</table>`;
    document.getElementById('lista_produtos').innerHTML = html;
}

async function salvarProduto(id_lista, id_produto) {
    const quantidade = parseInt(document.getElementById(`quantidade-${id_produto}`).value);
    const comprado = document.getElementById(`comprado-${id_produto}`).checked ? 1 : 0;

    if (isNaN(quantidade) || quantidade <= 0) {
        mostrarMensagem('Quantidade deve ser maior que 0', 'erro');
        return;
    }

    const fd = new FormData();
    fd.append('quantidade', quantidade);
    fd.append('comprado', comprado);

    const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_produto_alterar_back.php?id=${id_lista}&id_produto=${id_produto}`, {
        method: 'POST',
        body: fd
    });
    const resposta = await respostaJsonSegura(retorno);

    if (resposta.status == 'ok') {
        mostrarMensagem('Produto atualizado com sucesso!', 'sucesso');
        await carregarProdutos();
    } else {
        mostrarMensagem('Erro ao atualizar produto: ' + resposta.mensagem, 'erro');
    }
}

async function adicionarAoEstoque(id_produto) {
    const confirma = confirm('Adicionar este produto ao estoque?');
    if (confirma) {
        const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_produto_adicionar_estoque.php?id_produto=${id_produto}`);
        const resposta = await respostaJsonSegura(retorno);
        
        if (resposta.status == 'ok') {
            mostrarMensagem('Produto adicionado ao estoque com sucesso!', 'sucesso');
            await carregarProdutos();
        } else {
            mostrarMensagem('Erro ao adicionar ao estoque: ' + resposta.mensagem, 'erro');
        }
    }
}

async function removerProduto(id_lista, id_produto) {
    const confirma = confirm('Remover este produto da lista?');
    if (confirma) {
        const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_produto_excluir.php?id_lista=${id_lista}&id_produto=${id_produto}`);
        const resposta = await respostaJsonSegura(retorno);
        
        if (resposta.status == 'ok') {
            mostrarMensagem('Produto removido com sucesso!', 'sucesso');
            await carregarProdutos();
        } else {
            mostrarMensagem('Erro ao remover produto: ' + resposta.mensagem, 'erro');
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

    const resposta = await respostaJsonSegura(retorno);

    if (resposta.status == 'ok') {
        mostrarMensagem('Produto adicionado com sucesso!', 'sucesso');
        document.getElementById('nome_produto').value = '';
        document.getElementById('quantidade_produto').value = '1';
        document.getElementById('formulario_produto').style.display = 'none';
        await carregarProdutos();
    } else {
        mostrarMensagem('Erro ao adicionar produto: ' + resposta.mensagem, 'erro');
    }
}

document.getElementById('editar_lista').addEventListener('click', () => {
    window.location.href = `/mykeeper/src/Views/lista_compras_alterar.php?id=${id_lista}`;
});

document.getElementById('deletar_lista').addEventListener('click', () => {
    const confirma = confirm('Deseja realmente deletar esta lista de compras?');
    if (confirma) {
        fetch(`/mykeeper/src/Controllers/lista_compras_excluir.php?id=${id_lista}`)
            .then(response => respostaJsonSegura(response))
            .then(resposta => {
                if (resposta.status == 'ok') {
                    window.location.href = '/mykeeper/src/Views/lista_compras.php';
                } else {
                    mostrarMensagem('Erro ao deletar: ' + resposta.mensagem, 'erro');
                }
            });
    }
});
