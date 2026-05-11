document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/mykeeper/config/check_session.php');
    const data = await response.json();
    
    if (!data.logado) {
        window.location.href = '/mykeeper/src/Views/usuario_login.php';
        return;
    }
});

document.getElementById('addlista').addEventListener('click', () => {
    nova();
});

async function nova() {
    const nome_lista = document.getElementById('nome_lista').value;

    if (!nome_lista) {
        document.getElementById('error-nome').textContent = 'Nome precisa receber valores';
        return;
    }

    const fd = new FormData();
    fd.append('nome_lista', nome_lista);

    const retorno = await fetch('/mykeeper/src/Controllers/lista_compras_novo_back.php', {
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
