async function autenticarAdmin() {
    const senha = document.getElementById('senha').value.trim();
    if (!senha) {
        appNotify('Por favor, informe a senha de administrador.');
        return;
    }

    const fd = new FormData();
    fd.append('senha', senha);

    try {
        const retorno = await fetch('/mykeeper/src/Controllers/admin_auth.php', {
            method: 'POST',
            body: fd
        });
        const resposta = await retorno.json();

        if (resposta.status === 'ok') {
            appNotify('SUCESSO! Acesso administrativo liberado.');
            window.location.href = '/mykeeper/src/Views/admin_home.php';
        } else {
            appNotify('ERRO! ' + resposta.mensagem);
        }
    } catch (error) {
        appNotify('ERRO! Nao foi possivel validar o acesso admin.');
    }
}

document.getElementById('entrar').addEventListener('click', autenticarAdmin);

document.getElementById('adminLoginForm').addEventListener('submit', (event) => {
    event.preventDefault();
    autenticarAdmin();
});