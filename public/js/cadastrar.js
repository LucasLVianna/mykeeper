document.getElementById('formCadastro').addEventListener('submit',(e)=>{
    e.preventDefault();
    cadastrar();
})

document.getElementById('entrar').addEventListener('click',()=>{
    window.location.href = '/mykeeper/src/Views/usuario_login.php';
})

async function cadastrar() {
    let nome  = document.getElementById('nome').value;
    let email = document.getElementById('email').value;
    let senha = document.getElementById('senha').value;
    let cep   = document.getElementById('cep').value;

    if(cep.length != 9){
        alert('ERRO! CEP inválido');
        return;
    }else{
        if(senha.length<8){
            alert('ERRO! Senha muito curta');
            return;
        }else{
            const fd = new FormData();
            fd.append('nome', nome);
            fd.append('email',email);
            fd.append('senha',senha);
            fd.append('cep',cep);

            const retorno = await fetch('/mykeeper/src/Controllers/usuario_cadastrar.php',{
                method: 'POST',
                body: fd
            })

            const resposta = await retorno.json();
            if(resposta.status == 'ok'){
                alert("SUCESSO! Cadastro realizado com êxito");
                window.location.href = '/mykeeper/src/Views/usuario_login.php';
            }else{
                alert('ERRO!' + resposta.mensagem);
            }
        }
    }
    
}