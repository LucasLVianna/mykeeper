document.getElementById('inicioButtonLink').addEventListener('click', () => {
    window.location.href = '/mykeeper/src/Views/home.php';
});

document.getElementById('produtosButtonLink').addEventListener('click', () => {
    window.location.href = '/mykeeper/src/Views/produto.php';
});   

document.getElementById('categoriasButtonLink').addEventListener('click', () => {
    window.location.href = '/mykeeper/src/Views/categoria.php';
});

document.getElementById('logoffButtonLink').addEventListener('click', () => {
    window.location.href = '/mykeeper/src/Controllers/logoff.php';
});

document.getElementById('comprasButtonLink').addEventListener('click', () => {
    window.location.href = '/mykeeper/src/Views/compra.php';
});

document.getElementById('receitasButtonLink').addEventListener('click', () => {
    window.location.href = '/mykeeper/src/Views/receita.php';
});

document.getElementById('historicoButtonLink').addEventListener('click', () => {
    window.location.href = '/mykeeper/src/Views/historico.php';
}); 

document.getElementById('perfilButtonLink').addEventListener('click', () => {
    window.location.href = '/mykeeper/src/Views/perfil_usuario.php';
});

document.getElementById('adminHomeButtonLink').addEventListener('click', () => {
    window.location.href = '/mykeeper/src/Views/admin_home.php';
});