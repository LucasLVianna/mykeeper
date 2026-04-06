document.addEventListener('DOMContentLoaded', async () => {
    // 1. Primeiro verifica se está logado
    const response = await fetch('/mykeeper-lucas_vianna/config/check_session.php');
    const data = await response.json();
    
    if (!data.logado) {
        window.location.href = '/mykeeper-lucas_vianna/src/Views/usuario_login.php';
        return; // Para a execução aqui.
    }
});


document.getElementById('criarTicket').addEventListener('click', () => {
    novo();
});

async function novo() {
    const titulo = document.getElementById('titulo').value;
    const descricao = document.getElementById('descricao').value;

    const fd = new FormData();
    fd.append('titulo', titulo);
    fd.append('descricao', descricao);

    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/ticket_novo_back.php', {
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        alert('SUCESSO! ' + resposta.mensagem);
        window.location.href = '/mykeeper-lucas_vianna/src/Views/ticket_usuario.php';
    } else {
        alert('ERRO! ' + resposta.mensagem);
    }
}
