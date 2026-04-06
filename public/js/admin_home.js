addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/mykeeper-lucas_vianna/config/check_session.php');
    const data = await response.json();
    if (!data.logado) {
        window.location.href = '/mykeeper-lucas_vianna/src/Views/usuario_login.php';
        return;
    }
});

document.getElementById('cadastroSuporteButtonLink').addEventListener('click', () => {
    window.location.href = '/mykeeper-lucas_vianna/src/Views/suporte.php';
});

document.getElementById('ticketsSuporte').addEventListener('click', () => {
    window.location.href = '/mykeeper-lucas_vianna/src/Views/tickets_suporte.php';
});
