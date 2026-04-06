document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/mykeeper-lucas_vianna/config/check_session.php');
    const data = await response.json();

    if (!data.logado) {
        window.location.href = '/mykeeper-lucas_vianna/src/Views/usuario_login.php';
        return;
    }
});

document.getElementById('entrar').addEventListener('click', async () => {
    const fd = new FormData();
    fd.append('senha', document.getElementById('senha').value);

    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/admin_auth.php', {
        method: 'POST',
        body: fd
    });
    const resposta = await retorno.json();

    if (resposta.status === 'ok') {
        window.location.href = '/mykeeper-lucas_vianna/src/Views/admin_home.php';
    } else {
        alert('Erro: ' + resposta.mensagem);
    }
});
