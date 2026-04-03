document.addEventListener("DOMContentLoaded", async () => {
    await valida_sessao();
    const url = new URLSearchParams(window.location.search);
    const id = url.get("id");
    buscar(id);
});

async function buscar(id){
    const retorno = await fetch("../../src/Controllers/usuario_get.php?id=" + id);
    const resposta = await retorno.json();
    if(resposta.status == "ok"){
        var registro = resposta.data[0];
        document.getElementById("nome").value = registro.nome;
        document.getElementById("email").value = registro.email;
        document.getElementById("senha").value = registro.senha;
        document.getElementById("cep").value = registro.cep;
        document.getElementById("id").value = registro.id;
    }else{
        alert("ERRO: " + resposta.mensagem);
        window.location.href = "../../src/Views/home.php";
    }
}

document.getElementById("formAlterar").addEventListener("submit", (e) => {
    e.preventDefault();
    alterar();
});

async function alterar(){
    var nome  = document.getElementById("nome").value;
    var senha = document.getElementById("senha").value;
    var email = document.getElementById("email").value;
    var cep = document.getElementById("cep").value;
    var id    = document.getElementById("id").value;

    const fd = new FormData();
    fd.append("nome", nome);
    fd.append("senha", senha);
    fd.append("email", email);
    fd.append("cep", cep);

    const retorno = await fetch("../../src/Controllers/usuario_alterar_post.php?id=" + id, {
        method: 'POST',
        body: fd  
    });
    const resposta = await retorno.json();
    if(resposta.status == "ok"){
        alert("SUCESSO: " + resposta.mensagem);
        window.location.href = '../../src/Views/home.php';
    }else{
        alert("ERRO: " + resposta.mensagem);
    }
}