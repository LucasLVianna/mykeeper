var reconhecimento = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
reconhecimento.lang = 'pt-BR';
reconhecimento.continuous = true;
reconhecimento.interimResults = true;

// variável que controla se o microfone está ativo ou não
var ouvindo = false;

// container dos toasts no canto superior direito
var toastContainer = document.createElement('div');
toastContainer.id = 'voz-toast-container';
toastContainer.style.cssText = 'position:fixed; top:24px; right:24px; display:flex; flex-direction:column; gap:10px; z-index:9999;';
document.body.appendChild(toastContainer);

// animação de entrada dos toasts
var estiloAnimacao = document.createElement('style');
estiloAnimacao.textContent = '@keyframes toastVozIn { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }';
document.head.appendChild(estiloAnimacao);

// exibe toast e some após 2 segundos
function mostrarToast(msg, tipo) {
    var toast = document.createElement('div');
    var cor = tipo === 'success' ? '#1D9E75' : '#E24B4A';
    var icone = tipo === 'success' ? '' : '';

    toast.style.cssText =
        'background:#1a1d23;' +
        'border-left:4px solid ' + cor + ';' +
        'color:#fff;' +
        'padding:14px 20px;' +
        'border-radius:8px;' +
        'font-size:14px;' +
        'font-weight:600;' +
        'animation:toastVozIn 0.2s ease;' +
        'transition:opacity 0.3s;' +
        'min-width:220px;';

    toast.textContent = icone + msg;
    toastContainer.appendChild(toast);

    setTimeout(function() {
        toast.style.opacity = '0';
        setTimeout(function() {
            toast.remove();
        }, 300);
    }, 2000);
}

// alterna entre ouvindo e parado ao clicar no botão
document.getElementById('btnVoz').addEventListener('click', function() {
    if (ouvindo) {
        reconhecimento.stop();
        ouvindo = false;
        document.getElementById('btnVoz').textContent = '🎙️';
    } else {
        reconhecimento.start();
        ouvindo = true;
        document.getElementById('btnVoz').textContent = '✕';
    }
});

// evento disparado quando o navegador reconhece fala
reconhecimento.onresult = function(evento) {
    var ultimo = evento.results.length - 1;

    // só processa resultados finais
    if (!evento.results[ultimo].isFinal) return;

    // pega o texto, converte para minúsculas e remove espaços
    var texto = evento.results[ultimo][0].transcript.toLowerCase().trim();

    // se não tiver texto, interrompe
    if (!texto) return;

    var nome = texto.charAt(0).toUpperCase() + texto.slice(1);

    var fd = new FormData();
    fd.append('nome_produto', nome);
    fd.append('id_categoria', '');
    fd.append('und_medida_produto', '');

    fetch('/mykeeper/src/Controllers/produto_novo_back.php', {
        method: 'POST',
        body: fd
    })
    .then(function(retorno) {
        return retorno.json();
    })

    // processa a resposta do servidor
    .then(function(resposta) {
        if (resposta.status == 'ok') {
            mostrarToast(nome + ' adicionado!', 'success');
        } else {
            mostrarToast('Erro ao adicionar ' + nome, 'error');
        }
    });
};

// caso der erro no reconhecimento, para o microfone e volta o ícone
reconhecimento.onerror = function() {
    ouvindo = false;
    document.getElementById('btnVoz').innerHTML = `
    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0b0e11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/>
        <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
        <line x1="12" y1="19" x2="12" y2="23"/>
        <line x1="8" y1="23" x2="16" y2="23"/>
    </svg>`;
    //CASO QUEIRA USAR O EMOJI, APAGA O DE CIMA E USA O DE BAIXO
    //document.getElementById('btnVoz').textContent = '🎙️';
};

// quando termina de ouvir, reinicia se ainda estiver no modo ouvindo
reconhecimento.onend = function() {
    if (ouvindo) {
        reconhecimento.start();
    }
};