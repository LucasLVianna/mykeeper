document.addEventListener("DOMContentLoaded", () => { 
    valida_sessao(); 
    buscar(); // carrega lista
});

// envio do formulário (cadastrar ou alterar)
document.getElementById("formSuporte").addEventListener("submit", async (e) => {
    e.preventDefault();

    const id = document.getElementById("suporteId").value;

    const fd = new FormData();
    fd.append("nome",  document.getElementById("nome").value.trim());
    fd.append("email", document.getElementById("email").value.trim());
    fd.append("senha", document.getElementById("senha").value);

    // Se tiver id = altera, senão = cadastra
    const url = id ? `suporte_alterar.php?id=${id}` : "suporte_novo.php";

    const res = await (await fetch(url, { method: "POST", body: fd })).json();

    // Mostra mensagem
    document.getElementById("mensagem").textContent = res.mensagem;
    document.getElementById("mensagem").style.color = res.status === "ok" ? "green" : "red";

    if(res.status === "ok"){ 
        limpar(); 
        buscar(); // atualiza lista
    }
});

// Botão cancelar
document.getElementById("botaoCancelar").addEventListener("click", limpar);

// Limpa formulário
function limpar(){
    document.getElementById("formSuporte").reset();
    document.getElementById("suporteId").value = "";
    document.getElementById("botaoEnviar").textContent = "Cadastrar";
    document.getElementById("mensagem").textContent = "";
}

// Busca dados no servidor
async function buscar(){
    const res = await (await fetch("suporte_get.php")).json();
    if(res.status == "ok") preencherTabela(res.data);
}

// Excluir registro
async function excluir(id){
    if(!confirm("Deseja realmente excluir?")) return;

    const res = await (await fetch("suporte_excluir.php?id=" + id)).json();
    alert(res.mensagem);

    if(res.status == "ok") buscar(); // atualiza lista
}

// Preenche formulário para edição
function editar(id, nome, email){
    document.getElementById("suporteId").value = id;
    document.getElementById("nome").value      = nome;
    document.getElementById("email").value     = email;
    document.getElementById("botaoEnviar").textContent = "Salvar alterações";
}

// Monta tabela na tela
function preencherTabela(tabela){
    var html = `<table border="1" cellpadding="6" cellspacing="0"><tr><th>ID</th><th>Nome</th><th>Email</th><th>#</th></tr>`;

    for(var i = 0; i < tabela.length; i++){
        html += `<tr>
            <td>${tabela[i].id}</td>
            <td>${tabela[i].nome}</td>
            <td>${tabela[i].email}</td>
            <td>
                <a href='#' onclick='editar(${tabela[i].id}, "${tabela[i].nome}", "${tabela[i].email}")'>Alterar</a>
                <a href='#' onclick='excluir(${tabela[i].id})'>Excluir</a>
            </td>
        </tr>`;
    }

    html += '</table>';

    document.getElementById("lista").innerHTML = html;
}