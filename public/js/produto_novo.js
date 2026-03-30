document.getElementById('addproduto').addEventListener('click', ()=>{
    novo();
})

async function novo(){
    let nome_produto            = document.getElementById('nome_produto').value;
    let categoria_produto       = document.getElementById('categoria_produto').value;
    let und_medida_produto      = document.getElementById('und_medida_produto').value;
    

    const fd = new FormData();

    fd.append('nome_produto', nome_produto);
    fd.append('categoria_produto', categoria_produto);
    fd.append('und_medida_produto', und_medida_produto);

    const retorno = await fetch('/mykeeper-main/src/Controllers/produto_novo_back.php', {
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();

    if(resposta.status == 'ok'){
        alert('SUCESSO! ' + resposta.mensagem);
        window.location.href = "/mykeeper-main/src/Views/produto.php";
    }else{
        alert('ERRO! ' + resposta.mensagem);
    }
}  