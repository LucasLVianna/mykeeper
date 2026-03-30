async function enviarFormulario(event) {
    event.preventDefault();

    const id    = document.getElementById('suporteId').value.trim();
    const nome  = document.getElementById('nome').value.trim();
    const email = document.getElementById('email').value.trim();
    const senha = document.getElementById('senha').value;

    if (!nome || !email || !senha) {
        exibirMensagem('Preencha todos os campos.', 'erro');
        return;
    }

    const result = id
        ? await alterarSuporte(id, nome, email, senha)
        : await novoSuporte(nome, email, senha);

    if (result.status === 'ok') {
        exibirMensagem(result.mensagem || 'Operação realizada com sucesso.');
        limparFormulario();
        carregarSuportes();
    } else {
        exibirMensagem(result.mensagem || 'Erro na operação.', 'erro');
    }
}

tabela.addEventListener('click', (event) => {
    const target = event.target;
    if (target.tagName !== 'BUTTON') return;

    const action = target.dataset.action;
    const id     = target.dataset.id;

    if (action === 'editar') {
        document.getElementById('suporteId').value = id;
        document.getElementById('nome').value      = target.dataset.nome;
        document.getElementById('email').value     = target.dataset.email;
        botaoEnviar.textContent = 'Salvar alterações';
        exibirMensagem('Modo edição ativado, altere os dados e envie.');
    }

    if (action === 'excluir') {
        excluirSuporte(id);
    }
});

form.addEventListener('submit', enviarFormulario);
document.getElementById('botaoCancelar').addEventListener('click', limparFormulario);
document.getElementById('btnRecarregar').addEventListener('click', carregarSuportes);

carregarSuportes();