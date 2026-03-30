async function excluirSuporte(id) {
    if (!confirm('Deseja realmente excluir este suporte?')) return;

    const response = await fetch(`${endpointExcluir}?id=${encodeURIComponent(id)}`);
    const result   = await response.json();

    if (result.status === 'ok') {
        exibirMensagem(result.mensagem || 'Registro excluído.');
        carregarSuportes();
    } else {
        exibirMensagem(result.mensagem || 'Erro ao excluir.', 'erro');
    }
}