function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

function formatCep(value) {
    let digits = String(value || '').replace(/\D/g, '').slice(0, 8);

    if (digits.length > 5) {
        digits = `${digits.slice(0, 5)}-${digits.slice(5)}`;
    }

    return digits;
}

function cepDigitsLength(value) {
    return String(value || '').replace(/\D/g, '').length;
}

const cepInput = document.getElementById('cep');
const nomeInput = document.getElementById('nome');
const emailInput = document.getElementById('email');

cepInput.addEventListener('input', () => {
    cepInput.value = formatCep(cepInput.value);
});

document.addEventListener('DOMContentLoaded', async () => {
    try {
        const urlParams = new URLSearchParams(window.location.search);
        const profileId = urlParams.get('id') || document.body.dataset.userId;

        if (!profileId) {
            appNotify('ERRO! Nao foi possivel identificar o perfil para edicao.');
            window.location.href = '/mykeeper/src/Views/perfil_usuario.php';
            return;
        }

        await buscar(profileId);
    } catch (error) {
        appNotify('ERRO! Nao foi possivel carregar os dados do perfil.');
    }
});

async function buscar(id) {
    const retorno = await fetch(`/mykeeper/src/Controllers/usuario_get.php?id=${id}`);
    const resposta = await retorno.json();

    if (resposta.status == 'ok' && resposta.data) {
        preencherInformacoes(resposta.data);
        return;
    }

    appNotify('ERRO! Nao foi possivel localizar os dados do perfil.');
    window.location.href = '/mykeeper/src/Views/perfil_usuario.php';
}

function preencherInformacoes(usuario) {
    nomeInput.value = usuario.nome || '';
    emailInput.value = usuario.email || '';
    cepInput.value = formatCep(usuario.cep);
}

document.getElementById('alterarperfil').addEventListener('click', async () => {
    const cep = formatCep(cepInput.value);
    const nome = nomeInput.value.trim();
    const email = emailInput.value.trim();

    if (!nome) {
        appNotify('Por favor, preencha o nome.');
        nomeInput.focus();
        return;
    }

    if (!email) {
        appNotify('Por favor, preencha o email.');
        emailInput.focus();
        return;
    }

    if (cepDigitsLength(cep) !== 8) {
        appNotify('Digite um CEP valido no formato 00000-000.');
        cepInput.focus();
        return;
    }

    const fd = new FormData();
    fd.append('nome', nome);
    fd.append('email', email);
    fd.append('cep', cep);

    try {
        const retorno = await fetch('/mykeeper/src/Controllers/usuario_alterar_post.php', {
            method: 'POST',
            body: fd
        });
        const resposta = await retorno.json();

        if (resposta.status == 'ok') {
            appNotify('SUCESSO! ' + resposta.mensagem);
            window.location.href = '/mykeeper/src/Views/perfil_usuario.php';
        } else {
            appNotify('ERRO! ' + resposta.mensagem);
        }
    } catch (error) {
        appNotify('ERRO! Nao foi possivel salvar as alteracoes do perfil.');
    }
});