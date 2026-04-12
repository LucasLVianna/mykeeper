function confirmar(mensagem) {
    return new Promise((resolve) => {
        const modal = document.getElementById('modal-confirmar');
        document.getElementById('modal-mensagem').textContent = mensagem;
        modal.style.display = 'flex';

        document.getElementById('modal-confirmar-btn').onclick = () => {
            modal.style.display = 'none';
            resolve(true);
        };

        document.getElementById('modal-cancelar').onclick = () => {
            modal.style.display = 'none';
            resolve(false);
        };
    });
}