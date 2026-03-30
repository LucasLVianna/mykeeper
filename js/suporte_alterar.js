async function alterarSuporte(id, nome, email, senha) {
    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('email', email);
    formData.append('senha', senha);

    const response = await fetch(`${endpointAlterar}?id=${encodeURIComponent(id)}`, { method: 'POST', body: formData });
    return await response.json();
}