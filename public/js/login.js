const loginForm = document.getElementById('formLogin');
const createAccountButton = document.getElementById('createAccount');
const loginFeedback = document.getElementById('authFeedback');
const loginSubmit = document.getElementById('loginSubmit');
const loginEmailInput = document.getElementById('email');
const loginPasswordInput = document.getElementById('senha');
const loginEmailError = document.getElementById('emailError');
const loginPasswordError = document.getElementById('senhaError');

loginForm.addEventListener('submit', (event) => {
    event.preventDefault();
    login();
});

createAccountButton.addEventListener('click', () => {
    window.location.href = '/mykeeper-lucas_vianna/src/Views/usuario_cadastro.php';
});

function showFeedback(message, type = 'info') {
    loginFeedback.textContent = message;
    loginFeedback.className = `auth-feedback is-visible is-${type}`;
}

function clearFeedback() {
    loginFeedback.textContent = '';
    loginFeedback.className = 'auth-feedback';
}

function setFieldError(input, errorElement, message) {
    input.classList.add('is-invalid');
    errorElement.textContent = message;
    errorElement.classList.add('is-visible');
}

function clearFieldError(input, errorElement) {
    input.classList.remove('is-invalid');
    errorElement.textContent = '';
    errorElement.classList.remove('is-visible');
}

function validateLogin() {
    let isValid = true;
    const email = loginEmailInput.value.trim();
    const senha = loginPasswordInput.value;

    clearFieldError(loginEmailInput, loginEmailError);
    clearFieldError(loginPasswordInput, loginPasswordError);
    clearFeedback();

    if (!email) {
        setFieldError(loginEmailInput, loginEmailError, 'Informe seu e-mail.');
        isValid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        setFieldError(loginEmailInput, loginEmailError, 'Digite um e-mail v\u00E1lido.');
        isValid = false;
    }

    if (!senha) {
        setFieldError(loginPasswordInput, loginPasswordError, 'Informe sua senha.');
        isValid = false;
    }

    return isValid;
}

async function parseJsonResponse(response) {
    const text = await response.text();

    try {
        return JSON.parse(text);
    } catch (error) {
        throw new Error(text || 'Resposta inv\u00E1lida do servidor.');
    }
}

async function login() {
    if (!validateLogin()) {
        showFeedback('Revise os campos destacados para continuar.', 'error');
        return;
    }

    const fd = new FormData();
    fd.append('email', loginEmailInput.value.trim());
    fd.append('senha', loginPasswordInput.value);

    loginSubmit.disabled = true;
    loginSubmit.textContent = 'Entrando...';

    try {
        const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/usuario_login.php', {
            method: 'POST',
            body: fd,
            cache: 'no-store'
        });

        const resposta = await parseJsonResponse(retorno);

        if (resposta.status === 'ok') {
            showFeedback(resposta.mensagem || 'Login realizado com sucesso.', 'success');
            window.location.href = resposta.redirect;
            return;
        }

        showFeedback(resposta.mensagem || 'N\u00E3o foi poss\u00EDvel entrar agora.', 'error');
    } catch (error) {
        showFeedback('Erro ao processar o login. ' + error.message, 'error');
    } finally {
        loginSubmit.disabled = false;
        loginSubmit.textContent = 'Entrar';
    }
}

document.addEventListener('DOMContentLoaded', async () => {
    try {
        const response = await fetch('/mykeeper-lucas_vianna/config/check_session.php', {
            cache: 'no-store'
        });
        const data = await parseJsonResponse(response);

        if (data.logado) {
            window.location.href = data.redirect;
        }
    } catch (error) {
        console.error('Falha ao validar sess\u00E3o:', error.message);
    }
});
