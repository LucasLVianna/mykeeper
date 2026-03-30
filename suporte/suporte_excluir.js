// depois de clicar no botão excluir
document.getElementById('btnExcluir').addEventListener('click', async () => {
    const id = document.getElementById('suporteId').value;

    // se não tiver id
    if(!id){
        document.getElementById('mensagem').textContent = 'Informe um ID.';
        return;
    }

    // confirmação antes de excluir
    if(!confirm('Deseja realmente excluir este suporte?')) return;

    // envia requisição para excluir
    const response = await fetch(`suporte_excluir.php?id=${id}`);
    const result   = await response.json();

    // mostra mensagem
    const mensagem = document.getElementById('mensagem');
    mensagem.textContent = result.mensagem;
    mensagem.style.color = result.status === 'ok' ? 'green' : 'red';
});