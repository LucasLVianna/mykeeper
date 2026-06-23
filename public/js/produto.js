function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

function debounce(fn, delay) {
    let timer;
    return function(...args) {
        clearTimeout(timer);
        timer = setTimeout(() => fn(...args), delay);
    };
}

document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/mykeeper/config/check_session.php');
    const data = await response.json();

    if (!data.logado) {
        if (data.expirado) {
            window.location.href = '/mykeeper/usuario_login?motivo=expirado';
        } else {
            window.location.href = '/mykeeper/usuario_login';
        }
        return;
    }

    await carregarCategorias();
    buscar();

    const debouncedBuscar = debounce(buscar, 300);
    document.getElementById('filtro-nome').addEventListener('input', debouncedBuscar);
    document.getElementById('filtro-categoria').addEventListener('change', buscar);
})

async function carregarCategorias() {
    const retorno = await fetch('/mykeeper/src/Controllers/categoria_get.php');
    const resposta = await retorno.json();
    if (resposta.status == 'ok') {
        const select = document.getElementById('filtro-categoria');
        resposta.data.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat.id;
            option.textContent = cat.nome;
            select.appendChild(option);
        });
    }
}

async function buscar() {
    const nome = document.getElementById('filtro-nome').value.trim();
    const idCategoria = document.getElementById('filtro-categoria').value;

    const params = new URLSearchParams();
    if (nome) params.set('nome', nome);
    if (idCategoria) params.set('id_categoria', idCategoria);

    const qs = params.toString();
    const url = '/mykeeper/src/Controllers/produto_get.php' + (qs ? '?' + qs : '');

    const retorno = await fetch(url);
    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        document.getElementById('mensagem').textContent = '';
        preencherTabela(resposta.data);
    } else {
        document.getElementById('item').innerHTML = '';
        document.getElementById('mensagem').textContent = 'Nenhum produto encontrado.';
    }
}

function preencherTabela(tabela) {
    var html = `
    <table class="tabela">
        <tr>
            <th> ID </th>
            <th>Ícone</th>
            <th> Nome </th>
            <th> Categoria </th>
            <th> Unidade Medida </th>
            <th> # </th>
        </tr>
    `;

    for (var i = 0; i < tabela.length; i++) {
        const icone = tabela[i].imagem
            ? `<img src="${e(tabela[i].imagem)}" style="width:40px; height:40px;">`
            : 'Sem ícone';

        html += `<tr>
                <td> ${tabela[i].id} </td>
                <td> ${icone} </td>
                <td> ${e(tabela[i].nome)} </td>
                <td> ${e(tabela[i].categoria)} </td>
                <td> ${e(tabela[i].und_medida)} </td>
                <td class="botoes">
                <button class="btn-editar"><a href="/mykeeper/produto_alterar?id=${tabela[i].id}">Editar</a></button>
                <button class="btn-excluir"><a href="#" onclick="excluir(${tabela[i].id})">Excluir</a></button>
                </td>
                </tr>`;
    }

    html += `</table>`;
    document.getElementById('item').innerHTML = html;
}

async function excluir(id) {
    notificacaoExcluir('Tem certeza que deseja excluir este produto?', 'confirm', async function() {
        const retorno = await fetch('/mykeeper/src/Controllers/produto_excluir.php?id=' + id);
        const resposta = await retorno.json();
        if (resposta.status == 'ok') {
            notificacaoExcluir(resposta.mensagem, 'success');
            setTimeout(function() { window.location.reload(); }, 1500);
        } else {
            notificacaoExcluir(resposta.mensagem, 'error');
        }
    });
}

document.getElementById('produto_novo').addEventListener('click', () => {
    window.location.href = '/mykeeper/produto_novo'
})
