function e(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

let todosProdutos = []; // ✅ ADICIONADO

document.addEventListener('DOMContentLoaded', async ()=>{
    const response = await fetch('/mykeeper/config/check_session.php');
    const data = await response.json();
    
    if (!data.logado) {
        window.location.href = '/mykeeper/src/Views/usuario_login.php';
        return;
    }
    buscar();
})

async function buscar() {
    const retorno = await fetch('/mykeeper/src/Controllers/produto_get.php');
    const resposta = await retorno.json();
    if(resposta.status == 'ok'){
        todosProdutos = resposta.data;
        preencherTabela(resposta.data);
    } else {
        mostrarVazio('Não há produtos cadastrados');
    }
}

document.getElementById('busca').addEventListener('input', () => {
    const termo = document.getElementById('busca').value.toLowerCase();
    const filtrado = todosProdutos.filter(p => p.nome.toLowerCase().includes(termo));
    if(filtrado.length > 0){
        preencherTabela(filtrado);
    } else {
        mostrarVazio('Nenhum produto encontrado');
    }
});

function mostrarVazio(mensagem) {
    document.getElementById('item').style.display = 'none';
    const msg = document.getElementById('mensagem');
    msg.className = 'vazio';
    msg.textContent = mensagem;
}

function preencherTabela(tabela){
    var html = `
    <table class="tabela">
        <tr>
            <th> ID </th>
            <th>Ícone</th>
            <th> Nome </th>
            <th> Categoria </th>
            <th> Unidade Medida </th>
            <th> # </th>
        </tr>
    `;

    for(var i=0;i<tabela.length;i++){
        const icone = tabela[i].imagem
            ? `<img src="${e(tabela[i].imagem)}" style="width:40px; height:40px;">`
            : 'Sem ícone';

        html += `<tr>
                <td> ${tabela[i].id} </td>
                <td> ${icone} </td>
                <td> ${e(tabela[i].nome)} </td>
                <td> ${e(tabela[i].categoria)} </td>
                <td> ${e(tabela[i].und_medida)} </td>
                <td class="botoes"> 
                <button class = "btn-editar"><a href="produto_alterar.php?id=${tabela[i].id}">Editar</a></button>
                <button class = "btn-excluir"><a href="#" onclick="excluir(${tabela[i].id})">Excluir</a></button>
                </td>
                </tr>`;
    }

    html += `</table>`;
    document.getElementById('item').innerHTML = html;
}

async function excluir(id){
    const ok = await confirmar('Tem certeza que deseja excluir este produto?'); 
    if(!ok) return;

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