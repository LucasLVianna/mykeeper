const cadastroForm = document.getElementById('formCadastro');
const loginButton = document.getElementById('entrar');
const cadastroFeedback = document.getElementById('cadastroFeedback');
const cadastroSubmit = document.getElementById('cadastroSubmit');

const nomeInput = document.getElementById('nome');
const cadastroEmailInput = document.getElementById('email');
const cepInput = document.getElementById('cep');
const cadastroSenhaInput = document.getElementById('senha');

const nomeError = document.getElementById('nomeError');
const cadastroEmailError = document.getElementById('cadastroEmailError');
const cepError = document.getElementById('cepError');
const cadastroSenhaError = document.getElementById('cadastroSenhaError');

cadastroForm.addEventListener('submit', (event) => {
    event.preventDefault();
    cadastrar();
});

loginButton.addEventListener('click', () => {
    window.location.href = '/mykeeper-lucas_vianna/src/Views/usuario_login.php';
});

cepInput.addEventListener('input', () => {
    let value = cepInput.value.replace(/\D/g, '').slice(0, 8);
    if (value.length > 5) {
        value = `${value.slice(0, 5)}-${value.slice(5)}`;
    }
    cepInput.value = value;
});

function showCadastroFeedback(message, type = 'info') {
    cadastroFeedback.textContent = message;
    cadastroFeedback.className = `auth-feedback is-visible is-${type}`;
}

function clearCadastroFeedback() {
    cadastroFeedback.textContent = '';
    cadastroFeedback.className = 'auth-feedback';
}

function setCadastroFieldError(input, errorElement, message) {
    input.classList.add('is-invalid');
    errorElement.textContent = message;
    errorElement.classList.add('is-visible');
}

function clearCadastroFieldError(input, errorElement) {
    input.classList.remove('is-invalid');
    errorElement.textContent = '';
    errorElement.classList.remove('is-visible');
}

function validateCadastro() {
    let isValid = true;
    const nome = nomeInput.value.trim();
    const email = cadastroEmailInput.value.trim();
    const cep = cepInput.value.trim();
    const senha = cadastroSenhaInput.value;

    clearCadastroFeedback();
    clearCadastroFieldError(nomeInput, nomeError);
    clearCadastroFieldError(cadastroEmailInput, cadastroEmailError);
    clearCadastroFieldError(cepInput, cepError);
    clearCadastroFieldError(cadastroSenhaInput, cadastroSenhaError);

    if (!nome) {
        setCadastroFieldError(nomeInput, nomeError, 'Informe seu nome.');
        isValid = false;
    }

    if (!email) {
        setCadastroFieldError(cadastroEmailInput, cadastroEmailError, 'Informe seu e-mail.');
        isValid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        setCadastroFieldError(cadastroEmailInput, cadastroEmailError, 'Digite um e-mail v\u00E1lido.');
        isValid = false;
    }

    if (cep.length !== 9) {
        setCadastroFieldError(cepInput, cepError, 'Digite um CEP v\u00E1lido no formato 00000-000.');
        isValid = false;
    }

    if (senha.length < 8) {
        setCadastroFieldError(cadastroSenhaInput, cadastroSenhaError, 'A senha precisa ter pelo menos 8 caracteres.');
        isValid = false;
    }

    return isValid;
}

async function parseCadastroJson(response) {
    const text = await response.text();

    try {
        return JSON.parse(text);
    } catch (error) {
        throw new Error(text || 'Resposta inv\u00E1lida do servidor.');
    }
}

async function cadastrar() {
    if (!validateCadastro()) {
        showCadastroFeedback('Revise os campos destacados para continuar.', 'error');
        return;
    }

    const fd = new FormData();
    fd.append('nome', nomeInput.value.trim());
    fd.append('email', cadastroEmailInput.value.trim());
    fd.append('senha', cadastroSenhaInput.value);
    fd.append('cep', cepInput.value.trim());

    cadastroSubmit.disabled = true;
    cadastroSubmit.textContent = 'Criando conta...';

    try {
        const retorno = await fetch('/mykeeper-lucas_vianna/src/Controllers/usuario_cadastrar.php', {
            method: 'POST',
            body: fd
        });

        const resposta = await parseCadastroJson(retorno);

        if (resposta.status === 'ok') {
            showCadastroFeedback(resposta.mensagem || 'Cadastro realizado com sucesso.', 'success');
            setTimeout(() => {
                window.location.href = '/mykeeper-lucas_vianna/src/Views/usuario_login.php';
            }, 900);
            return;
        }

        showCadastroFeedback(resposta.mensagem || 'N\u00E3o foi poss\u00EDvel concluir o cadastro.', 'error');
    } catch (error) {
        showCadastroFeedback('Erro ao processar o cadastro. ' + error.message, 'error');
    } finally {
        cadastroSubmit.disabled = false;
        cadastroSubmit.textContent = 'Criar conta';
    }
}
