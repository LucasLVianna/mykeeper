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

    buscar();
});

async function buscar() {
    const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_get.php?t=${Date.now()}`, {
        cache: 'no-store'
    });
    const resposta = await respostaJsonSegura(retorno);

    if (resposta.status == 'ok') {
        preencherTabela(resposta.data);
    } else {
        document.getElementById('item').innerHTML = '';
        mostrarMensagem('Nao ha listas de compras cadastradas.', 'info');
    }
}

function preencherTabela(tabela) {
    var html = `
        <table class="tabela">
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Estoque</th>
                <th>Status</th>
                <th>Data de Criacao</th>
                <th class="coluna-acoes">#</th>
            </tr>
        `;

    for (var i = 0; i < tabela.length; i++) {
        const statusClass = tabela[i].status_compra === 'aberta' ? 'status-ativa' : tabela[i].status_compra === 'concluida' ? 'status-concluida' : 'status-arquivada';
        const dataCriacao = new Date(tabela[i].data_criacao).toLocaleDateString('pt-BR');

        html += `
            <tr class="linha-lista" id="linha-lista-${tabela[i].id}">
                <td>${tabela[i].id}</td>
                <td>${e(tabela[i].titulo)}</td>
                <td>${e(tabela[i].nome_estoque || 'Nao vinculado')}</td>
                <td><span class="${statusClass}">${tabela[i].status_compra}</span></td>
                <td>${dataCriacao}</td>
                <td class="acoes-lista">
                    <button class="botao-ver-receita" onclick="toggleProdutosLista(${tabela[i].id})" title="Ver produtos">&gt;</button>
                    <a class="botao-acao botao-gerenciar" href="/mykeeper/src/Views/lista_compras_gerenciar_produtos.php?id=${tabela[i].id}">Gerenciar</a>
                    <a class="botao-acao botao-editar" href="/mykeeper/src/Views/lista_compras_alterar.php?id=${tabela[i].id}">Editar</a>
                    <button class="botao-acao botao-remover" onclick="deletar(${tabela[i].id})" title="Deletar">Remover</button>
                </td>
            </tr>
            <tr class="linha-produtos-lista" id="produtos-lista-${tabela[i].id}" style="display:none;">
                <td colspan="6">
                    <div class="produtos-inline"></div>
                </td>
            </tr>
        `;
    }

    html += `</table>`;
    document.getElementById('item').innerHTML = html;
}

async function toggleProdutosLista(idLista) {
    const linha = document.getElementById(`produtos-lista-${idLista}`);
    const painel = linha.querySelector('.produtos-inline');
    const botao = document.querySelector(`#linha-lista-${idLista} .botao-ver-receita`);
    const abrindo = linha.style.display === 'none';

    document.querySelectorAll('.linha-produtos-lista').forEach(item => {
        if (item !== linha) item.style.display = 'none';
    });
    document.querySelectorAll('.botao-ver-receita').forEach(item => item.classList.remove('aberto'));

    if (!abrindo) {
        linha.style.display = 'none';
        return;
    }

    linha.style.display = 'table-row';
    botao.classList.add('aberto');
    painel.innerHTML = '<p class="lista-vazia-inline">Carregando produtos...</p>';

    const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_produto_get.php?id_lista=${idLista}&t=${Date.now()}`, {
        cache: 'no-store'
    });
    const resposta = await respostaJsonSegura(retorno);

    if (resposta.status != 'ok' || resposta.data.length === 0) {
        painel.innerHTML = '<p class="lista-vazia-inline">Nenhum produto adicionado nesta lista.</p>';
        return;
    }

    let html = '<div class="produtos-inline-grid">';
    for (let i = 0; i < resposta.data.length; i++) {
        const produto = resposta.data[i];
        const comprado = Number(produto.comprado || 0) === 1;
        html += `
            <div class="produto-inline ${comprado ? 'comprado' : ''}">
                <label class="check-inline">
                    <input type="checkbox" ${comprado ? 'checked' : ''} onchange="marcarProdutoCompradoInline(${idLista}, ${produto.id_produto}, ${produto.quantidade}, this)">
                    <span class="produto-inline-nome">${e(produto.nome_produto || 'Produto sem nome')}</span>
                </label>
                <span class="produto-inline-meta">Qtd: ${e(String(produto.quantidade))}</span>
                <span class="produto-inline-status ${comprado ? 'status-sim' : 'status-nao'}">${comprado ? 'Comprado' : 'Pendente'}</span>
            </div>
        `;
    }
    html += '</div>';
    painel.innerHTML = html;
}

async function marcarProdutoCompradoInline(idLista, idProduto, quantidade, checkbox) {
    const fd = new FormData();
    fd.append('quantidade', quantidade);
    fd.append('comprado', checkbox.checked ? 1 : 0);

    const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_produto_alterar_back.php?id=${idLista}&id_produto=${idProduto}`, {
        method: 'POST',
        body: fd
    });
    const resposta = await respostaJsonSegura(retorno);

    if (resposta.status == 'ok') {
        const card = checkbox.closest('.produto-inline');
        const status = card.querySelector('.produto-inline-status');

        card.classList.toggle('comprado', checkbox.checked);
        status.textContent = checkbox.checked ? 'Comprado' : 'Pendente';
        status.className = `produto-inline-status ${checkbox.checked ? 'status-sim' : 'status-nao'}`;
        mostrarMensagem('Produto atualizado com sucesso!', 'sucesso');
    } else {
        mostrarMensagem('Erro ao atualizar produto: ' + resposta.mensagem, 'erro');
        checkbox.checked = !checkbox.checked;
    }
}

async function deletar(id) {
    const confirma = confirm('Deseja realmente deletar esta lista de compras?');
    if (!confirma) return;

    const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_excluir.php?id=${id}`);
    const resposta = await respostaJsonSegura(retorno);

    if (resposta.status == 'ok') {
        mostrarMensagem('Lista excluida com sucesso!', 'sucesso');
        await buscar();
    } else {
        mostrarMensagem('Erro ao excluir lista: ' + resposta.mensagem, 'erro');
    }
}

document.getElementById('lista_compras_nova').addEventListener('click', () => {
    window.location.href = '/mykeeper/src/Views/lista_compras_nova.php';
});
