function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/mykeeper/config/check_session.php');
    const data = await response.json();

    if (!data.logado) {
        window.location.href = '/mykeeper/src/Views/usuario_login.php';
        return;
    }

    buscar(data.id); 
});

async function buscar(id) {
    const retorno = await fetch(`/mykeeper/src/Controllers/usuario_get.php?id=${id}`);
    const resposta = await retorno.json();
    if (resposta.status == 'ok') {
        preencherInformacoes(resposta.data);
        return;
    }

    appNotify('ERRO! Nao foi possivel carregar os dados do perfil.');
}

function preencherInformacoes(usuario) {
    document.getElementById('nome').textContent = e(usuario.nome);
    document.getElementById('email').textContent = e(usuario.email);
    document.getElementById('cep').textContent = e(usuario.cep);
    document.getElementById('linkEditar').href = `/mykeeper/src/Views/perfil_alterar.php?id=${usuario.id}`;
}

document.getElementById('desativarConta').addEventListener('click', async () => {
    const confirmed = await appConfirm('Tem certeza que deseja desativar sua conta? Esta acao nao pode ser desfeita.', {
        title: 'Desativar conta',
        confirmText: 'Desativar',
        cancelText: 'Voltar',
    });

    if (!confirmed) {
        return;
    }

    const response = await fetch('/mykeeper/src/Controllers/usuario_desativar.php', {
        method: 'POST'
    });
    const data = await response.json();
    if (data.status === 'ok') {
        appNotify('SUCESSO! ' + data.mensagem);
        window.location.href = '/mykeeper/src/Views/usuario_login.php';
    } else {
        appNotify('ERRO! ' + data.mensagem);
    }
});