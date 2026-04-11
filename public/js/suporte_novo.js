document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/mykeeper/config/check_session.php');
    const data = await response.json();
    
    if (!data.logado) {
        window.location.href = '/mykeeper/src/Views/usuario_login.php';
        return;
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
        toast('Suporte cadastrado com sucesso!', 'ok');
        setTimeout(() => {
            window.location.href = '/mykeeper/src/Views/suporte.php';
        }, 800);
    } else {
        toast('Erro ao cadastrar!', 'erro');
    }
}

function toast(mensagem, tipo = 'ok') {
    const div = document.getElementById('toast');
    div.textContent = mensagem;
    div.style.backgroundColor = tipo === 'ok' ? '#00c97a' : '#ff4757';
    div.style.display = 'block';
    div.style.opacity = '1';
    setTimeout(() => {
        div.style.opacity = '0';
        setTimeout(() => div.style.display = 'none', 300);
    }, 1500);
}