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
    const retorno = await fetch('/mykeeper/src/Controllers/categoria_get.php');
    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        preencherTabela(resposta.data);
    } else {
        document.getElementById('item').innerHTML = '';
        mostrarMensagem('Nao ha categorias cadastradas.', 'info');
    }
}

function preencherTabela(tabela) {
    var html = `
        <table class="tabela">
            <tr>
                <th>ID</th>
                <th>Icone</th>
                <th>Nome</th>
                <th>Descricao</th>
                <th>#</th>
            </tr>
        `;

    for (var i = 0; i < tabela.length; i++) {
        const icone = tabela[i].icone
            ? `<img src="${e(tabela[i].icone)}" style="width:40px; height:40px;">`
            : 'Sem icone';

        html += `
            <tr>
                <td>${tabela[i].id}</td>
                <td>${icone}</td>
                <td>${e(tabela[i].nome)}</td>
                <td>${e(tabela[i].descricao)}</td>
                <td class="botoes">
                    <button class="btn-editar"><a href="categoria_alterar.php?id=${tabela[i].id}">Editar</a></button>
                    <button class="btn-excluir"><a href="#" onclick="excluir(${tabela[i].id})">Excluir</a></button>
                </td>
            </tr>`;
    }

    html += `</table>`;
    document.getElementById('item').innerHTML = html;
}

async function excluir(id) {
    const retorno = await fetch('/mykeeper/src/Controllers/categoria_excluir.php?id=' + id);
    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        mostrarMensagem('Categoria excluida com sucesso!', 'sucesso');
        await buscar();
    } else {
        mostrarMensagem('Erro ao excluir categoria: ' + resposta.mensagem, 'erro');
    }
}

document.getElementById('categoria_nova').addEventListener('click', () => {
    window.location.href = '/mykeeper/src/Views/categoria_novo.php';
});
