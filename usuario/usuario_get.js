document.addEventListener("DOMContentLoaded", async () => {
    await valida_sessao();
    listar();

    document.getElementById("novo").addEventListener("click", () => {
        window.location.href = "usuario_novo.php";
    });

    document.getElementById("logoff").addEventListener("click", () => {
        window.location.href = "../php/logoff.php";
    });
});

async function excluir(id){
    if(!confirm('Tem certeza que deseja excluir este usuário?')) return;

    const retorno = await fetch("../usuario/usuario_excluir.php?id=" + id);
    const resposta = await retorno.json();
    if(resposta.status == "ok"){
        alert("SUCESSO: " + resposta.mensagem);
        listar();
    }else{
        alert("ERRO: " + resposta.mensagem);
    }
}

async function listar(){
    const retorno = await fetch("../usuario/usuario_get.php");
    const resposta = await retorno.json();
    if(resposta.status == "ok"){
        var html = "<table border='1'><tr><th>ID</th><th>Nome</th><th>Email</th><th>Ações</th></tr>";
        resposta.data.forEach(usuario => {
            html += `<tr>
                <td>${usuario.id}</td>
                <td>${usuario.nome}</td>
                <td>${usuario.email}</td>
                <td>
                    <a href="usuario_alterar.php?id=${usuario.id}">Editar</a>
                    <button onclick="excluir(${usuario.id})">Excluir</button>
                </td>
            </tr>`;
        });
        html += "</table>";
        document.getElementById("lista").innerHTML = html;
    }else{
        alert("ERRO: " + resposta.mensagem);
    }
}