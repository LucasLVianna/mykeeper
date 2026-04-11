document.addEventListener('DOMContentLoaded', async () => {
    // 1. Primeiro verifica se está logado
    const response = await fetch('/mykeeper/config/check_session.php');
    const data = await response.json();
    
    if (!data.logado) {
        window.location.href = '/mykeeper/src/Views/usuario_login.php';
        return; // para a execução aqui
    }
});


document.getElementById('addsuporte').addEventListener('click', () => {
    novo();
});

async function novo() {
    const nome = document.getElementById('nome').value;
    const email = document.getElementById('email').value;
    const senha = document.getElementById('senha').value;

    const retorno_email = await fetch('/mykeeper/src/Controllers/suporte_get.php');
    const resposta_email = await retorno_email.json();
    if(resposta_email.status == 'ok' && resposta_email.data.find(s => s.email === email)){
        document.getElementById('erro').textContent = 'Este e-mail já está em uso!';
        return;
    }
    document.getElementById('erro').textContent = '';

    const fd = new FormData();
    fd.append('nome', nome);
    fd.append('email', email);
    fd.append('senha', senha);

    const retorno = await fetch('/mykeeper/src/Controllers/suporte_novo_back.php', {
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        alert('SUCESSO! ' + resposta.mensagem);
        window.location.href = '/mykeeper/src/Views/suporte.php';
    } else {
        alert('ERRO! ' + resposta.mensagem);
    }
}