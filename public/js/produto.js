function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

document.addEventListener('DOMContentLoaded', ()=>{
    buscar();
})

async function buscar() {
    const retorno = await fetch('/mykeeper/src/Controllers/produto_get.php');
    const resposta = await retorno.json();
    if(resposta.status == 'ok'){
        preencherTabela(resposta.data);
    }
    
}

function preencherTabela(tabela){
    var html = `
    <table class="tabela">
        <tr>
            <th> ID </th>
            <th> Nome </th>
            <th> Categoria </th>
            <th> Unidade Medida </th>
            <th> # </th>
        </tr>
    `;

    for(var i=0;i<tabela.length;i++){
    html += `<tr>
            <td> ${tabela[i].id} </td>
            <td> ${e(tabela[i].nome_produto)} </td>
            <td> ${e(tabela[i].categoria_produto)} </td>
            <td> ${e(tabela[i].und_medida_produto)} </td>
            <td class="botoes"> 
            <button class = "btn-editar"><a href="produto_alterar.php?id=${tabela[i].id}">Editar</a></button>
            <button class = "btn-excluir"><a href="#" onclick="excluir(${tabela[i].id})">Excluir</a></button>
            </td>
        </tr>`;
    }

    html += `</table>`;
    document.getElementById('item').innerHTML = html
}

async function excluir(id){
    const retorno = await fetch('/mykeeper/src/Controllers/produto_excluir.php?id='+id);
    const resposta = await retorno.json();
    if(resposta.status == 'ok'){
        alert('SUCESSO! '+ resposta.mensagem);
    }else{
        alert('ERRO! ' + resposta.mensagem)
    }

    window.location.reload();
}

document.getElementById('produto_novo').addEventListener('click', ()=>{
    window.location.href = '/mykeeper/src/Views/produto_novo.php'
})

document.getElementById('inicioButtonLink').addEventListener('click', () => {
    window.location.href = '/mykeeper/src/Views/home.php';
});

document.getElementById('produtosButtonLink').addEventListener('click', () => {
    window.location.href = '/mykeeper/src/Views/produto.php';
});

