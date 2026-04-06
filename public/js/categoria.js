function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

const categorySheetId = 'categorySheet';

function abrirSheet(id) {
    const sheet = document.getElementById(id);
    if (!sheet) {
        return;
    }
    sheet.hidden = false;
    document.body.style.overflow = 'hidden';
}

function fecharSheet(id) {
    const sheet = document.getElementById(id);
    if (!sheet) {
        return;
    }
    sheet.hidden = true;
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/mykeeper-lucas_vianna/config/check_session.php');
    const data = await response.json();

    if (!data.logado) {
        window.location.href = '/mykeeper-lucas_vianna/src/Views/usuario_login.php';
        return;
    }

    await buscar();

    if (new URLSearchParams(window.location.search).get('sheet') === 'new') {
        abrirSheetCategoria();
    }
});

async function buscar() {
    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/categoria_get.php');
    const resposta = await retorno.json();
    if (resposta.status == 'ok') {
        preencherTabela(resposta.data);
    } else {
        document.getElementById('item').innerHTML = '<div class="table-empty">Nenhuma categoria encontrada.</div>';
    }
}

function preencherTabela(tabela) {
    let html = `
        <table class="tabela data-table">
            <tr>
                <th>ID</th>
                <th>Ícone</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>#</th>
            </tr>
        `;

    for (let i = 0; i < tabela.length; i++) {
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
                    <button class="btn-editar"><a href="categoria_alterar.php?id=${tabela[i].id}">Editar</a></button>
                    <button class="btn-excluir"><a href="#" onclick="excluir(${tabela[i].id})">Excluir</a></button>
                </td>
            </tr>`;
    }

    html += `</table>`;
    document.getElementById('item').innerHTML = html;
}

async function excluir(id) {
    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/categoria_excluir.php?id=' + id);
    const resposta = await retorno.json();
    if (resposta.status == 'ok') {
        alert('SUCESSO! ' + resposta.mensagem);
    } else {
        alert('ERRO! ' + resposta.mensagem);
    }
    window.location.reload();
}

function abrirSheetCategoria() {
    document.getElementById('sheet_nome_categoria').value = '';
    document.getElementById('sheet_descricao_categoria').value = '';
    document.getElementById('sheet_icone_categoria').value = '';
    document.getElementById('sheet_preview_categoria').src = '';
    document.getElementById('sheet_preview_categoria').style.display = 'none';
    abrirSheet(categorySheetId);
}

document.getElementById('sheet_icone_categoria').addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (event) => {
            const preview = document.getElementById('sheet_preview_categoria');
            preview.src = event.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('categoria_nova').addEventListener('click', () => {
    abrirSheetCategoria();
});

document.getElementById('sheet_addcategoria').addEventListener('click', async () => {
    const nome_categoria = document.getElementById('sheet_nome_categoria').value.trim();
    const descricao_categoria = document.getElementById('sheet_descricao_categoria').value.trim();
    const icone_categoria = document.getElementById('sheet_icone_categoria').files[0];

    if (!nome_categoria) {
        alert('Preencha o nome da categoria.');
        return;
    }

    const fd = new FormData();
    fd.append('nome_categoria', nome_categoria);
    fd.append('descricao_categoria', descricao_categoria);
    if (icone_categoria) {
        fd.append('icone_categoria', icone_categoria);
    }

    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/categoria_novo_back.php', {
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        alert('SUCESSO! ' + resposta.mensagem);
        fecharSheet(categorySheetId);
        window.location.href = '/mykeeper-lucas_vianna/src/Views/categoria.php';
        return;
    }

    alert('ERRO! ' + resposta.mensagem);
});
