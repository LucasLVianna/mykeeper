-- Criar tabela de listas de compras
CREATE TABLE IF NOT EXISTS lista_compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    status ENUM('ativa', 'concluida', 'arquivada') DEFAULT 'ativa',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);

-- Criar tabela de produtos na lista de compras
CREATE TABLE IF NOT EXISTS lista_compras_produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_lista_compras INT NOT NULL,
    id_produto INT,
    nome VARCHAR(255) NOT NULL,
    quantidade DECIMAL(10, 2) NOT NULL,
    unidade VARCHAR(50),
    comprado TINYINT DEFAULT 0,
    data_adicao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_lista_compras) REFERENCES lista_compras(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produto) REFERENCES produto(id) ON DELETE SET NULL
);
