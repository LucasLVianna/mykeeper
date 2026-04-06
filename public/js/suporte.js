function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

const supportSheetId = 'supportSheet';

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
        abrirSheetSuporte();
    }
});

async function buscar() {
    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/suporte_get.php');
    const resposta = await retorno.json();
    if (resposta.status == 'ok') {
        preencherTabela(resposta.data);
    } else {
        document.getElementById('item').innerHTML = '<div class="table-empty">Nenhuma conta de suporte encontrada.</div>';
    }
}

function preencherTabela(tabela) {
    let html = `
    <table class="tabela data-table">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>#</th>
        </tr>
    `;

    for (let i = 0; i < tabela.length; i++) {
        html += `<tr>
                <td>${tabela[i].id}</td>
                <td>${e(tabela[i].nome)}</td>
                <td>${e(tabela[i].email)}</td>
                <td class="botoes"> 
                <button class="btn-editar"><a href="suporte_alterar.php?id=${tabela[i].id}">Editar</a></button>
                <button class="btn-excluir"><a href="#" onclick="excluir(${tabela[i].id})">Excluir</a></button>
                </td>
                </tr>`;
    }

    html += `</table>`;
    document.getElementById('item').innerHTML = html;
}

async function excluir(id) {
    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/suporte_excluir.php?id=' + id);
    const resposta = await retorno.json();
    if (resposta.status == 'ok') {
        alert('SUCESSO! ' + resposta.mensagem);
    } else {
        alert('ERRO! ' + resposta.mensagem);
    }

    window.location.reload();
}

function abrirSheetSuporte() {
    document.getElementById('sheet_nome_suporte').value = '';
    document.getElementById('sheet_email_suporte').value = '';
    document.getElementById('sheet_senha_suporte').value = '';
    abrirSheet(supportSheetId);
}

document.getElementById('suporte_novo').addEventListener('click', () => {
    abrirSheetSuporte();
});

document.getElementById('sheet_addsuporte').addEventListener('click', async () => {
    const nome = document.getElementById('sheet_nome_suporte').value.trim();
    const email = document.getElementById('sheet_email_suporte').value.trim();
    const senha = document.getElementById('sheet_senha_suporte').value;

    if (!nome || !email || !senha) {
        alert('Preencha nome, e-mail e senha.');
        return;
    }

    const fd = new FormData();
    fd.append('nome', nome);
    fd.append('email', email);
    fd.append('senha', senha);

    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/suporte_novo_back.php', {
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        alert('SUCESSO! ' + resposta.mensagem);
        fecharSheet(supportSheetId);
        window.location.href = '/mykeeper-lucas_vianna/src/Views/suporte.php';
        return;
    }

    alert('ERRO! ' + resposta.mensagem);
});
