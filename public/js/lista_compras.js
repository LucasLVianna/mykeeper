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
    buscar();
});

async function buscar() {
    const retorno = await fetch('/mykeeper/src/Controllers/lista_compras_get.php');
    const resposta = await retorno.json();
    if (resposta.status == 'ok') {
        preencherTabela(resposta.data);
    } else {
        document.getElementById('mensagem').textContent = 'Não há listas de compras cadastradas.';
    }
}

function preencherTabela(tabela) {
    var html = `
        <table class="tabela">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Status</th>
                <th>Data de Criação</th>
                <th>#</th>
            </tr>
        `;

    for (var i = 0; i < tabela.length; i++) {
        const statusClass = tabela[i].status_compra === 'aberta' ? 'status-ativa' : tabela[i].status_compra === 'concluida' ? 'status-concluida' : 'status-arquivada';
        const dataCriacao = new Date(tabela[i].data_criacao).toLocaleDateString('pt-BR');

        html += `
            <tr>
                <td>${tabela[i].id}</td>
                <td>${e(tabela[i].titulo)}</td>
                <td><span class="${statusClass}">${tabela[i].status_compra}</span></td>
                <td>${dataCriacao}</td>
                <td>
                    <a href="/mykeeper/src/Views/lista_compras_gerenciar_produtos.php?id=${tabela[i].id}">
                        <img src="/mykeeper/public/assets/abrir.png" alt="abrir" title="Gerenciar Produtos">
                    </a>
                    <a href="/mykeeper/src/Views/lista_compras_alterar.php?id=${tabela[i].id}">
                        <img src="/mykeeper/public/assets/editar.png" alt="editar" title="Editar">
                    </a>
                    <button onclick="deletar(${tabela[i].id})" title="Deletar" style="background: none; border: none; cursor: pointer; padding: 0;">
                        <img src="/mykeeper/public/assets/deletar.png" alt="deletar">
                    </button>
                </td>
            </tr>
        `;
    }

    html += `</table>`;

    document.getElementById('item').innerHTML = html;
}

async function deletar(id) {
    const confirma = confirm('Deseja realmente deletar esta lista de compras?');
    if (confirma) {
        const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_excluir.php?id=${id}`);
        const resposta = await retorno.json();
        
        if (resposta.status == 'ok') {
            document.getElementById('mensagem').textContent = 'Lista excluída com sucesso!';
            setTimeout(() => buscar(), 1500);
        } else {
            document.getElementById('mensagem').textContent = 'Erro ao excluir lista: ' + resposta.mensagem;
        }
    }
}

document.getElementById('lista_compras_nova').addEventListener('click', () => {
    window.location.href = '/mykeeper/src/Views/lista_compras_nova.php';
});
