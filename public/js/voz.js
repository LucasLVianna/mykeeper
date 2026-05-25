const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
const rec = SpeechRecognition ? new SpeechRecognition() : null;

if (rec) {
    rec.lang = 'pt-BR';
    rec.continuous = true;
    rec.interimResults = true;
}

var ouvindo = false;

const mic = `
<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0b0e11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/>
    <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
    <line x1="12" y1="19" x2="12" y2="23"/>
    <line x1="8" y1="23" x2="16" y2="23"/>
</svg>
`;

var toastBox = document.createElement('div');
toastBox.style.cssText = `
    position:fixed;
    top:20px;
    right:20px;
    max-width:320px;
    z-index:9999;
`;
document.body.appendChild(toastBox);

function toast(msg, tipo = false){
    var div = document.createElement('div');
    var cor = '#00ffa3';
    var titulo = 'Sucesso';

    if(tipo === true || tipo === 'error') {
        cor = '#ff4d4d';
        titulo = 'Erro';
    }

    if(tipo === 'aviso') {
        cor = '#f5a623';
        titulo = 'Atenção';
    }

    div.style.cssText = `
        background:#171b22;
        color:#d9e2e7;
        border:1px solid #303640;
        border-left:4px solid ${cor};
        box-shadow:0 12px 32px rgba(0,0,0,0.38);
        padding:12px 14px;
        border-radius:8px;
        margin-bottom:10px;
        font-size:14px;
        line-height:1.4;
        transition:opacity 0.2s ease, transform 0.2s ease;
    `;
    var tituloEl = document.createElement('strong');
    tituloEl.style.cssText = 'display:block;color:#fff;margin-bottom:3px;';
    tituloEl.textContent = titulo;

    var textoEl = document.createElement('span');
    textoEl.textContent = msg;

    div.appendChild(tituloEl);
    div.appendChild(textoEl);
    toastBox.appendChild(div);
    setTimeout(function(){
        div.style.opacity = '0';
        div.style.transform = 'translateY(-6px)';
        setTimeout(function(){ div.remove(); }, 200);
    }, 2600);
}

const btnVoz = document.getElementById('btnVoz');

if (!btnVoz) {
    toast('Botão de voz não encontrado.', 'aviso');
} else if (!rec) {
    btnVoz.disabled = true;
    btnVoz.title = 'Comando de voz indisponível neste navegador';
    btnVoz.style.opacity = '0.5';
    toast('Comando de voz indisponível neste navegador.', 'aviso');
} else {
    btnVoz.addEventListener('click', ()=>{
        if(ouvindo){
            rec.stop();
            ouvindo = false;
            btnVoz.innerHTML = mic;
            return;
        }

        try {
            rec.start();
            ouvindo = true;
            btnVoz.innerHTML = '✕';
        } catch(e) {
            toast('Não foi possível iniciar o comando de voz.', true);
        }
    });

    rec.onresult = async (e) => {

        var i = e.results.length - 1;

        if(!e.results[i].isFinal) return;

        var texto = e.results[i][0].transcript.trim().toLowerCase();

        if(texto == '') return;

        var nome = texto.charAt(0).toUpperCase() + texto.slice(1);

        // verifica se já existe no produto
        const checkProduto = await fetch(
            '/mykeeper/src/Controllers/produto_verificar.php?nome=' +
            encodeURIComponent(nome)
        );

        const produtoExiste = await checkProduto.json();

        if(produtoExiste.status == 'ok'){
            toast(nome + ' já está cadastrado!', 'aviso');
            return;
        }

        // procura no histórico
        const checkHistorico = await fetch(
            '/mykeeper/src/Controllers/produto_historico_get.php?nome=' +
            encodeURIComponent(nome)
        );

        const historico = await checkHistorico.json();

        if(historico.status == 'ok'){

            var fd = new FormData();

            fd.append('nome_produto', nome);
            fd.append('id_categoria', historico.data?.id_categoria || '');
            fd.append('und_medida_produto', historico.data?.und_medida || '');

            try{

                const retorno = await fetch(
                    '/mykeeper/src/Controllers/produto_novo_back.php',
                    {
                        method: 'POST',
                        body: fd
                    }
                );

                const resposta = await retorno.json();

                if(resposta.status == 'ok'){
                    toast(nome + ' adicionado!', 'success');
                } else {
                    toast('Erro ao adicionar ' + nome, 'error');
                }

            } catch(err){
                toast('Erro ao adicionar ' + nome, 'error');
            }

            return;
        }

        // não encontrou em nenhum lugar
        document.getElementById('nome_produto').value = nome;

        toast('Complete as informações de ' + nome + '!', 'aviso');
    };



    rec.onerror = (evento)=>{
        ouvindo = false;
        btnVoz.innerHTML = mic;
        toast('Erro: ' + evento.error, true);
    };

    rec.onend = ()=>{
        if(ouvindo){
            try{
                rec.start();
            }
            catch(e){}
        }
    };
}
