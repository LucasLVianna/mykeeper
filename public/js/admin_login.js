document.addEventListener('DOMContentLoaded', async () => {
    try {
        // A tela admin exige usuario logado; se nao estiver, volta para login comum.
        const response = await fetch('/mykeeper/config/check_session.php');
        const data = await response.json();

        if (!data.logado) {
            window.location.href = '/mykeeper/src/Views/usuario_login.php';
        }
    } catch (error) {
        appNotify('ERRO! Falha ao validar sessao.');
    }
}); 

document.getElementById('entrar').addEventListener('click', async () => {
        const senha = document.getElementById('senha').value;
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
    });