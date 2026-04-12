function confirmar(mensagem) {
    return new Promise((resolve) => {
        const modal = document.getElementById('confirmacao');
        document.getElementById('confirmacao-mensagem').textContent = mensagem; 
        modal.style.display = 'flex';

        document.getElementById('confirmacao-btn').onclick = () => {
            modal.style.display = 'none';
            resolve(true);
        };

        document.getElementById('confirmacao-cancelar').onclick = () => { 
            modal.style.display = 'none';
            resolve(false);
        };
    });
}