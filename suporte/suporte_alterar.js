// quando a página carrega
document.addEventListener("DOMContentLoaded", async () => {
    const id = new URLSearchParams(window.location.search).get('id');

    if(!id) window.location.href = 'index.php'; // sem id, volta

    const retorno  = await fetch(`suporte_get.php?id=${id}`);
    const resposta = await retorno.json();

    if(resposta.status === 'ok'){
        document.getElementById('nome').value  = resposta.data[0].nome;
        document.getElementById('email').value = resposta.data[0].email;
    }
});


// nnvio do formulário
document.getElementById('formSuporte').addEventListener('submit', async (e) => {
    e.preventDefault(); // evita reload

    const id    = new URLSearchParams(window.location.search).get('id');
    const nome  = document.getElementById('nome').value.trim();
    const email = document.getElementById('email').value.trim();
    const senha = document.getElementById('senha').value;

    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('email', email);
    formData.append('senha', senha);

    const response = await fetch(`suporte_alterar.php?id=${id}`, {
        method: 'POST',
        body: formData
    });

    const result = await response.json();

    const mensagem = document.getElementById('mensagem');
    mensagem.textContent = result.mensagem;
    mensagem.style.color = result.status === 'ok' ? 'green' : 'red';

    if(result.status === 'ok'){
        setTimeout(() => window.location.href = 'index.php', 1000); // redireciona
    }
});