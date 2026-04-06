function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/mykeeper-lucas_vianna/config/check_session.php');
    const data = await response.json();
    if (!data.logado) {
        window.location.href = '/mykeeper-lucas_vianna/src/Views/usuario_login.php';
        return;
    }
    buscar(data.id);
});

async function buscar(id) {
    const retorno = await fetch(`/mykeeper-lucas_vianna/src/Controllers/usuario_get.php?id=${id}`);
    const resposta = await retorno.json();
    if (resposta.status == 'ok') {
        preencherInformacoes(resposta.data);
    }
}

function preencherInformacoes(usuario) {
    document.getElementById('nome').value = usuario.nome;
    document.getElementById('email').value = usuario.email;
    document.getElementById('cep').value = usuario.cep;
}

document.getElementById('alterarperfil').addEventListener('click', async () => {
    const fd = new FormData();
    fd.append('nome', document.getElementById('nome').value);
    fd.append('email', document.getElementById('email').value);
    fd.append('cep', document.getElementById('cep').value);

    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/usuario_alterar_post.php', {
        method: 'POST',
        body: fd
    });
    const resposta = await retorno.json();
    if (resposta.status == 'ok') {
        alert(resposta.mensagem);
        window.location.href = '/mykeeper-lucas_vianna/src/Views/perfil_usuario.php';
    } else {
        alert('Erro: ' + resposta.mensagem);
    }
});
