function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

document.addEventListener('DOMContentLoaded', ()=>{
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    buscar(id);
});

// buscando o id e preenchendo formulário com informações registradas

async function buscar(id){
    const retorno = await fetch('/mykeeper-main/src/Controllers/produto_get.php?id='+id);
    const resposta = await retorno.json();
    if(resposta.status == 'ok'){
        alert('SUCESSO! '+resposta.mensagem);
        var item = resposta.data[0];

        document.getElementById('nome_produto').value       = e(item.nome_produto);
        document.getElementById('categoria_produto').value  = e(item.categoria_produto);
        document.getElementById('und_medida_produto').value = e(item.und_medida_produto);
        document.getElementById('id').value                 = id;

    }else{
        alert("ERRO: "+resposta.mensagem)
        window.location.href = 'produto.php';
    }
}

// alterando informações no sql

document.getElementById('alterarproduto').addEventListener('click', ()=>{
    alterar();
})

async function alterar(){
    let nome_produto       = document.getElementById('nome_produto').value;
    let categoria_produto  = document.getElementById('categoria_produto').value;
    let und_medida_produto = document.getElementById('und_medida_produto').value;
    let id                 = document.getElementById('id').value;
    const fd = new FormData();

    fd.append('nome_produto', nome_produto);
    fd.append('categoria_produto', categoria_produto);
    fd.append('und_medida_produto', und_medida_produto);

    const retorno = await fetch('/mykeeper-main/src/Controllers/produto_alterar_back.php?id='+id, {
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();

    if(resposta.status == 'ok'){
        alert('SUCESSO! ' + resposta.mensagem);
        window.location.href = "/mykeeper-main/src/Views/produto.php";
    }else{
        alert('ERRO! ' + resposta.mensagem);
        window.location.href = "/mykeeper-main/src/Views/produto.php";
    }
}