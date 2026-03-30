const endpointListar  = 'php/suporte_get.php';
const endpointNovo    = 'php/suporte_novo.php';
const endpointAlterar = 'php/suporte_alterar.php';
const endpointExcluir = 'php/suporte_excluir.php';

const tabela      = document.getElementById('tabelaSuporte');
const mensagem    = document.getElementById('mensagem');
const form        = document.getElementById('formSuporte');
const botaoEnviar = document.getElementById('botaoEnviar');

function exibirMensagem(texto, tipo = 'info') {
    mensagem.textContent = texto;
    mensagem.style.color = tipo === 'erro' ? 'red' : 'green';
}

function limparFormulario() {
    form.reset();
    document.getElementById('suporteId').value = '';
    botaoEnviar.textContent = 'Cadastrar';
}