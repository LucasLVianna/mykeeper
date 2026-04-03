// Captura o evento de 'submit' do formulário inteiro
document.getElementById("formLogin").addEventListener("submit", (event) => {
    // ESSA É A MÁGICA: Impede o formulário de recarregar a página!
    event.preventDefault(); 
    login();
});

async function login(){
    var email = document.getElementById("email").value;
    var senha = document.getElementById("senha").value;
    
    const fd = new FormData();
    fd.append("email", email);
    fd.append("senha", senha);
    
    try {
        const retorno = await fetch("../../src/Views/usuario_login.php", {
            method: "POST",
            body: fd
        });
        
        const resposta = await retorno.json();
        
        if(resposta.status == "ok"){
            // Login deu certo, redireciona
            window.location.href = "../../src/Views/home.php";
        }else{
            // Login deu errado (senha incorreta, etc)
            alert(resposta.mensagem || "Credenciais inválidas."); 
        }
    } catch (erro) {
        console.error("Erro na requisição:", erro);
        alert("Ocorreu um erro ao tentar fazer login.");
    }
}