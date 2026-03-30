// Envio do formulário
document.querySelector('form').addEventListener('submit', async (e) => {
    e.preventDefault(); // evita reload

    const nome  = document.getElementById('nome').value.trim();
    const email = document.getElementById('email').value.trim();
    const senha = document.getElementById('senha').value;

    // Monta dados para envio
    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('email', email);
    formData.append('senha', senha);

    // Envia para o PHP
    const response = await fetch('suporte_novo.php', { method: 'POST', body: formData });
    const result   = await response.json();

    // Mostra mensagem
    const mensagem = document.getElementById('mensagem');
    mensagem.textContent = result.mensagem;
    mensagem.style.color = result.status === 'ok' ? 'green' : 'red';

    // Limpa form se deu certo
    if(result.status === 'ok') document.querySelector('form').reset();
});