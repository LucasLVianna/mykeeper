document.addEventListener("DOMContentLoaded", async () => {
    await valida_sessao();
});

document.getElementById("formNovo").addEventListener("submit", (e) => {
    e.preventDefault();
    salvar();
});

async function salvar(){
    var nome  = document.getElementById("nome").value;
    var email = document.getElementById("email").value;
    var senha = document.getElementById("senha").value;
    var cep   = document.getElementById("cep").value;

    const fd = new FormData();
    fd.append("nome", nome);
    fd.append("email", email);
    fd.append("senha", senha);
    fd.append("cep", cep);

    const retorno = await fetch("../../src/Controllers/usuario_novo_post.php", {
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