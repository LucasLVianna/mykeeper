document.addEventListener('DOMContentLoaded', async () => {
    // 1. Primeiro verifica se está logado
    const response = await fetch('/mykeeper/config/check_session.php');
    const data = await response.json();
    
    if (!data.logado) {
        window.location.href = '/mykeeper/src/Views/usuario_login.php';
        return; // para a execução aqui
    }
});

document.getElementById('icone_categoria').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.getElementById('preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('addcategoria').addEventListener('click', () => {
    novo();
});

async function novo() {
    const nome_categoria      = document.getElementById('nome_categoria').value;
    const descricao_categoria = document.getElementById('descricao_categoria').value;
    const icone_categoria     = document.getElementById('icone_categoria').files[0];

    const fd = new FormData();
    fd.append('nome_categoria', nome_categoria);
    fd.append('descricao_categoria', descricao_categoria);
    if (icone_categoria) {
        fd.append('icone_categoria', icone_categoria);
    }

    const retorno = await fetch('/mykeeper/src/Controllers/categoria_novo_back.php', {
        method: 'POST',
        body: fd
    });

    const resposta = await retorno.json();

    if (resposta.status == 'ok') {
        toast('Categoria cadastrada com sucesso!', 'ok');
        setTimeout(() => {
            window.location.href = '/mykeeper/src/Views/categoria.php';
        }, 800);
    } else {
        toast('Erro ao cadastrar!', 'erro');
    }
}

function toast(mensagem, tipo = 'ok') {
    const div = document.getElementById('toast');
    div.textContent = mensagem;
    div.style.backgroundColor = tipo === 'ok' ? '#00c97a' : '#ff4757';
    div.style.display = 'block';
    div.style.opacity = '1';
    setTimeout(() => {
        div.style.opacity = '0';
        setTimeout(() => div.style.display = 'none', 500);
    }, 3000);
}