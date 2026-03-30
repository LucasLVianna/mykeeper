async function novoSuporte(nome, email, senha) {
    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('email', email);
    formData.append('senha', senha);

    const response = await fetch(endpointNovo, { method: 'POST', body: formData });
    return await response.json();
}