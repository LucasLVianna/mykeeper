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

function respostaOuTracos(valor) {
    if (valor === null || valor === undefined || String(valor).trim() === '' || String(valor).toLowerCase() === 'null') {
        return '---';
    }
    return e(valor);
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

    const urlParams = new URLSearchParams(window.location.search);
    const id_estoque = urlParams.get('id_estoque');

    if (!id_estoque) {
        window.location.href = '/mykeeper/estoque';
        return;
    }

    await carregarCategorias();
    buscar(id_estoque);

    document.getElementById('adicionarItem').addEventListener('click', () => {
        window.location.href = `/mykeeper/item_estoque_adicionar?id_estoque=${id_estoque}`;
    });

    const debouncedBuscar = debounce(() => buscar(id_estoque), 300);
    document.getElementById('filtro-nome').addEventListener('input', debouncedBuscar);
    document.getElementById('filtro-categoria').addEventListener('change', () => buscar(id_estoque));
});

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

async function buscar(id_estoque) {
    const nome = document.getElementById('filtro-nome').value.trim();
    const idCategoria = document.getElementById('filtro-categoria').value;

    const params = new URLSearchParams({ id_estoque });
    if (nome) params.set('nome', nome);
    if (idCategoria) params.set('id_categoria', idCategoria);

    const retorno = await fetch('/mykeeper/src/Controllers/item_estoque_get.php?' + params.toString());
    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        document.getElementById('mensagem').textContent = '';
        preencherTabela(resposta.data, id_estoque);
    } else {
        document.getElementById('item').innerHTML = '';
        document.getElementById('mensagem').textContent = 'Nenhum item encontrado.';
    }
}

function preencherTabela(tabela, id_estoque) {
    var html = "";
    for (var i = 0; i < tabela.length; i++) {
        const imagem = tabela[i].imagem
            ? `<img src="${e(tabela[i].imagem)}" style="width:40px; height:40px;">`
            : 'Sem imagem';

        const validade = tabela[i].data_validade
            ? new Date(tabela[i].data_validade).toLocaleDateString('pt-BR')
            : 'Sem validade';

        html += `<div class="card">
                    <div class="card-icone">
                        ${imagem}
                    </div>
                    <div class="card-nome">
                        ${e(tabela[i].nome)}
                    </div>
                    <div class="card-data">
                        Categoria: ${respostaOuTracos(tabela[i].categoria)}
                    </div>
                    <div class="card-data">
                        Quantidade: ${respostaOuTracos(tabela[i].quantidade)} ${e(tabela[i].und_medida)}
                    </div>
                    <div class="card-data">
                        Marca: ${respostaOuTracos(tabela[i].marca)}
                    </div>
                    <div class="card-data">
                        Validade: ${validade}
                    </div>
                    <div class="card-botoes">
                        <button class="btn-editar"><a href="/mykeeper/item_estoque_alterar?id=${tabela[i].id}&id_estoque=${id_estoque}">Editar</a></button>
                        <button class="btn-excluir"><a href="#" onclick="excluir(${tabela[i].id}, ${id_estoque})">Excluir</a></button>
                    </div>
                </div>`;
    }
    document.getElementById('item').innerHTML = html;
}

async function excluir(id) {
    notificacaoExcluir('Tem certeza que deseja excluir este item?', 'confirm', async function() {
        const retorno = await fetch('/mykeeper/src/Controllers/item_estoque_excluir.php?id=' + id);
        const resposta = await retorno.json();
        if (resposta.status == 'ok') {
            notificacaoExcluir(resposta.mensagem, 'success');
            setTimeout(function() { window.location.reload(); }, 1500);
        } else {
            notificacaoExcluir(resposta.mensagem, 'error');
        }
    });
}
