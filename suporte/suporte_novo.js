document.querySelector('form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const nome  = document.getElementById('nome').value.trim();
    const email = document.getElementById('email').value.trim();
    const senha = document.getElementById('senha').value;

    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('email', email);
    formData.append('senha', senha);

    const response = await fetch('suporte_novo.php', { method: 'POST', body: formData });
    const result   = await response.json();

    const mensagem = document.getElementById('mensagem');
    mensagem.textContent = result.mensagem;
    mensagem.style.color = result.status === 'ok' ? 'green' : 'red';

    if(result.status === 'ok') document.querySelector('form').reset();
});