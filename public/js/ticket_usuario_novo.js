document.addEventListener('DOMContentLoaded', async () => {
    // 1. Primeiro verifica se está logado
    const response = await fetch('/mykeeper/config/check_session.php');
    const data = await response.json();
    
    if (!data.logado) {
        window.location.href = '/mykeeper/src/Views/usuario_login.php';
        return; // para a execução aqui
    }
});


document.getElementById('criarTicket').addEventListener('click', () => {
    novo();
});

async function novo() {
    const titulo = document.getElementById('titulo').value;
    const descricao = document.getElementById('descricao').value;

    if (!titulo.trim()) {   
        alert('Por favor, preencha o título do ticket.');
        document.getElementById('titulo').focus();
        return;
    }

    if (!descricao.trim()) {
        alert('Por favor, preencha a descrição do ticket.');
        document.getElementById('descricao').focus();
        return; 
    }

    const fd = new FormData();
    fd.append('titulo', titulo);
    fd.append('descricao', descricao);

    const retorno = await fetch('/mykeeper/src/Controllers/ticket_novo_back.php', {
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        toast('Ticket criado com sucesso!', 'ok');
        setTimeout(() => {
            window.location.href = '/mykeeper/src/Views/ticket_usuario.php';
        }, 800);
    } else {
        toast('Erro ao criar ticket!', 'erro');
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
        setTimeout(() => div.style.display = 'none', 500);
    }, 3000);
}