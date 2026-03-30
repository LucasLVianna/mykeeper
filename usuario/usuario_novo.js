document.addEventListener("DOMContentLoaded", () => {
    valida_sessao();
});

document.getElementById("enviar").addEventListener("click", () => {
    novo();
});

async function novo(){
    var nome    = document.getElementById("nome").value;
    var senha   = document.getElementById("senha").value;
    var email   = document.getElementById("email").value;

    const fd = new FormData();
    fd.append("nome", nome);
    fd.append("senha", senha);
    fd.append("email", email);

    const retorno = await fetch("usuario_novo.php",
        {
          method: 'POST',
          body: fd  
        });
    const resposta = await retorno.json();
    if(resposta.status == "ok"){
        alert("SUCESSO: " + resposta.mensagem);
        //window.location.href = "../home/";
    }else{
        alert("ERRO: " + resposta.mensagem);
    }
}