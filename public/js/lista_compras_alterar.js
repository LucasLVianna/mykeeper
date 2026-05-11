const urlParams = new URLSearchParams(window.location.search);
const id_lista = urlParams.get('id');

document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/mykeeper/config/check_session.php');
    const data = await response.json();
    
    if (!data.logado) {
        window.location.href = '/mykeeper/src/Views/usuario_login.php';
        return;
    }

    if (!id_lista) {
        document.getElementById('error').textContent = 'ID da lista não informado';
        return;
    }

    await carregarDados();
});

async function carregarDados() {
    const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_get.php?id=${id_lista}`);
    const resposta = await retorno.json();

    if (resposta.status == 'ok' && resposta.data.length > 0) {
        const lista = resposta.data[0];
        document.getElementById('nome_lista').value = lista.titulo;
        document.getElementById('status_lista').value = lista.status_compra;
    }
}

document.getElementById('alterar_lista').addEventListener('click', () => {
    alterar();
});

async function alterar() {
    const nome_lista = document.getElementById('nome_lista').value;
    const status_lista = document.getElementById('status_lista').value;

    if (!nome_lista) {
        document.getElementById('error-nome').textContent = 'Nome precisa receber valores';
        return;
    }

    const fd = new FormData();
    fd.append('nome_lista', nome_lista);
    fd.append('status_lista', status_lista);

    const retorno = await fetch(`/mykeeper/src/Controllers/lista_compras_alterar_back.php?id=${id_lista}`, {
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        document.getElementById('error').textContent = 'SUCESSO! ' + resposta.mensagem + '. Redirecionando...';
        setTimeout(() => {
            window.location.href = "/mykeeper/src/Views/lista_compras.php";
        }, 1000);
    } else {
        document.getElementById('error').textContent = 'ERRO! ' + resposta.mensagem;
    }
}
