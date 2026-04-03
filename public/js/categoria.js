function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

document.addEventListener('DOMContentLoaded', () => {
    buscar();
});

async function buscar() {
    const retorno = await fetch('/mykeeper/src/Controllers/categoria_get.php');
    const resposta = await retorno.json();
    if (resposta.status == 'ok') {
        preencherTabela(resposta.data);
    } else {
        document.getElementById('item').innerHTML = '<p>Nenhuma categoria encontrada.</p>';
    }
}

function preencherTabela(tabela) {
    var html = `
        <table class="tabela">
            <tr>
                <th>ID</th>
                <th>Ícone</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>#</th>
            </tr>
        `;

    for (var i = 0; i < tabela.length; i++) {
        const icone = tabela[i].icone
            ? `<img src="${e(tabela[i].icone)}" style="width:40px; height:40px;">`
            : 'Sem ícone';

        html += `
            <tr>
                <td>${tabela[i].id}</td>
                <td>${icone}</td>
                <td>${e(tabela[i].nome)}</td>
                <td>${e(tabela[i].descricao)}</td>
                <td class="botoes">
                    <button class="btn-editar">
                        <a href="categoria_alterar.php?id=${tabela[i].id}">Editar</a>
                    </button>
                    <button class="btn-excluir">
                        <a href="#" onclick="excluir(${tabela[i].id})">Excluir</a>
                    </button>
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
        alert('SUCESSO! ' + resposta.mensagem);
    } else {
        alert('ERRO! ' + resposta.mensagem);
    }
    window.location.reload();
}

document.getElementById('categoria_nova').addEventListener('click', () => {
    window.location.href = '/mykeeper/src/Views/categoria_novo.php';
});