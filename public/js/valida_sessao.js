async function valida_sessao(){
    const retorno = await fetch("../../config/valida_sessao.php");
    const resposta = await retorno.json();
    if(resposta.status == "nok"){
        window.location.href = '../../src/Views/usuario_login.php';
    }
}