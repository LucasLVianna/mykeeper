function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

function formatTicketResponse(value) {
    if (value === null || value === undefined || String(value).trim() === '' || String(value).toLowerCase() === 'null') {
        return '----';
    }

    return value;
}

function isEmptyTicketResponse(value) {
    return value === null || value === undefined || String(value).trim() === '' || String(value).toLowerCase() === 'null';
}

const ticketSheetId = 'ticketSheet';

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

    await buscar(data.id);

    if (new URLSearchParams(window.location.search).get('sheet') === 'new') {
        abrirSheetTicket();
    }
});

async function buscar(id) {
    const retorno = await fetch(`/mykeeper-lucas_vianna/src/Controllers/ticket_get.php?id=${id}`);
    const resposta = await retorno.json();
    if (resposta.status == 'ok') {
        preencherTabela(resposta.data);
    } else {
        document.getElementById('item').innerHTML = '<div class="table-empty">Nenhum ticket encontrado.</div>';
    }
}

function preencherTabela(tabela) {
    let html = `
    <table class="tabela data-table">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>Data de abertura</th>
            <th>Resposta</th>
            <th>Status</th>
            <th>#</th>
        </tr>
    `;

    for (let i = 0; i < tabela.length; i++) {
        html += `<tr>
                <td>${tabela[i].id}</td>
                <td>${e(tabela[i].titulo)}</td>
                <td>${e(tabela[i].descricao)}</td>
                <td>${e(tabela[i].data_ticket)}</td>
                <td class="ticket-response-cell${isEmptyTicketResponse(tabela[i].resposta_ticket) ? ' is-empty' : ''}">${e(formatTicketResponse(tabela[i].resposta_ticket))}</td>
                <td>${e(tabela[i].status_ticket)}</td>
                <td class="botoes"> 
                <button class="btn-editar"><a href="ticket_usuario_alterar.php?id=${tabela[i].id}">Editar</a></button>
                <button class="btn-excluir"><a href="#" onclick="excluir(${tabela[i].id})">Excluir</a></button>
                </td>
                </tr>`;
    }

    html += `</table>`;
    document.getElementById('item').innerHTML = html;
}

async function excluir(id) {
    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/ticket_excluir.php?id=' + id);
    const resposta = await retorno.json();
    if (resposta.status == 'ok') {
        alert('SUCESSO! ' + resposta.mensagem);
    } else {
        alert('ERRO! ' + resposta.mensagem);
    }

    window.location.reload();
}

function abrirSheetTicket() {
    document.getElementById('sheet_titulo_ticket').value = '';
    document.getElementById('sheet_descricao_ticket').value = '';
    abrirSheet(ticketSheetId);
}

document.getElementById('ticket_novo').addEventListener('click', () => {
    abrirSheetTicket();
});

document.getElementById('sheet_criarTicket').addEventListener('click', async () => {
    const titulo = document.getElementById('sheet_titulo_ticket').value.trim();
    const descricao = document.getElementById('sheet_descricao_ticket').value.trim();

    if (!titulo || !descricao) {
        alert('Preencha o título e a descrição do ticket.');
        return;
    }

    const fd = new FormData();
    fd.append('titulo', titulo);
    fd.append('descricao', descricao);

    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/ticket_novo_back.php', {
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        alert('SUCESSO! ' + resposta.mensagem);
        fecharSheet(ticketSheetId);
        window.location.href = '/mykeeper-lucas_vianna/src/Views/ticket_usuario.php';
        return;
    }

    alert('ERRO! ' + resposta.mensagem);
});
