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

document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/mykeeper-lucas_vianna/config/check_session.php');
    const data = await response.json();

    if (!data.logado) {
        window.location.href = '/mykeeper-lucas_vianna/src/Views/usuario_login.php';
        return;
    }
    buscar();
});

async function buscar() {
    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/tickets_suporte_get.php');
    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        if (resposta.data.length === 0) {
            document.getElementById('item').innerHTML = '<p>Nenhum ticket registrado no momento.</p>';
            return;
        }
        preencherTabela(resposta.data);
    } else {
        document.getElementById('item').innerHTML = '<p>Erro ao carregar os tickets.</p>';
    }
}

function preencherTabela(tabela) {
    let html = `
    <table class="tabela data-table">
        <tr>
            <th>ID</th>
            <th>T\u00EDtulo</th>
            <th>Descri\u00E7\u00E3o</th>
            <th>Data de Abertura</th>
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
                <button class="btn-editar"><a href="tickets_suporte_alterar.php?id=${tabela[i].id}">Editar</a></button>
                </td>
                </tr>`;
    }

    html += `</table>`;
    document.getElementById('item').innerHTML = html;
}
