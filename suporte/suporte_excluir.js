document.getElementById('btnExcluir').addEventListener('click', async () => {
    const id = document.getElementById('suporteId').value;

    if(!id){
        document.getElementById('mensagem').textContent = 'Informe um ID.';
        return;
    }

    if(!confirm('Deseja realmente excluir este suporte?')) return;

    const response = await fetch(`suporte_excluir.php?id=${id}`);
    const result   = await response.json();

    const mensagem = document.getElementById('mensagem');
    mensagem.textContent = result.mensagem;
    mensagem.style.color = result.status === 'ok' ? 'green' : 'red';
});