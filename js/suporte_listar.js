async function carregarSuportes() {
    tabela.innerHTML = '';
    exibirMensagem('Carregando...');

    const res  = await fetch(endpointListar);
    const data = await res.json();

    if (data.status !== 'ok') {
        exibirMensagem(data.mensagem || 'Erro ao obter lista.', 'erro');
        return;
    }

    if (data.data.length === 0) {
        tabela.innerHTML = '<tr><td colspan="4">Nenhum suporte encontrado.</td></tr>';
        exibirMensagem('Nenhum registro encontrado.');
        return;
    }

    for (const item of data.data) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.id}</td>
            <td>${item.nome}</td>
            <td>${item.email}</td>
            <td>
                <button data-action="editar" data-id="${item.id}" data-nome="${item.nome}" data-email="${item.email}">Editar</button>
                <button data-action="excluir" data-id="${item.id}">Excluir</button>
            </td>
        `;
        tabela.appendChild(tr);
    }

    exibirMensagem('Lista carregada com sucesso.');
}