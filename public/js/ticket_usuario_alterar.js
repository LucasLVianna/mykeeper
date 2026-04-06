function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

document.addEventListener('DOMContentLoaded', async ()=>{
    // 1. Primeiro verifica se está logado
    const response = await fetch('/mykeeper-lucas_vianna/config/check_session.php');
    const data = await response.json();
    
    if (!data.logado) {
        window.location.href = '/mykeeper-lucas_vianna/src/Views/usuario_login.php';
        return; // Para a execução aqui.
    }

    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    document.getElementById('ticketId').value = id;

    buscar(id);
});


async function buscar(id){
    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/ticket_get_id.php?id='+id);
    const resposta = await retorno.json();

    if(resposta.status == 'ok'){
        const item = resposta.data;

        document.getElementById('titulo').value    = e(item.titulo);
        document.getElementById('descricao').value = e(item.descricao);

    }else{
        alert("ERRO: "+resposta.mensagem)
        window.location.href = 'ticket_usuario.php';
    }
}

document.getElementById('alterarTicket').addEventListener('click', ()=>{
    alterar();
});

async function alterar(){
    let titulo = document.getElementById('titulo').value;
    let descricao = document.getElementById('descricao').value;
    let id = document.getElementById('ticketId').value;

    const fd = new FormData();

    fd.append('titulo', titulo);
    fd.append('descricao', descricao);

    const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/ticket_usuario_alterar_back.php?id='+id, {
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();

    if(resposta.status == 'ok'){
        alert('SUCESSO! ' + resposta.mensagem);
        window.location.href = "/mykeeper-lucas_vianna/src/Views/ticket_usuario.php";
    }else{
        alert('ERRO! ' + resposta.mensagem);
    }
}

