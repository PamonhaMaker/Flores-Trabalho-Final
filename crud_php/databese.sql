-- ==========================================
-- BANCO DE DADOS: crud_php
-- Projeto: Cardápio do Don Diniz
-- ==========================================

-- Criar banco de dados (se ainda não existir)
CREATE DATABASE IF NOT EXISTS crud_php
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

-- Usar o banco
USE crud_php;

-- ==========================================
-- TABELA: categorias
-- ==========================================
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Inserir dados de exemplo (opcional)
INSERT INTO categorias (nome, descricao) VALUES
('Massas', 'Pratos à base de massas italianas'),
('Carnes', 'Cortes e preparos com carne vermelha'),
('Bebidas', 'Sucos, refrigerantes e vinhos'),
('Sobremesas', 'Doces, bolos e sobremesas variadas');

-- ==========================================
-- TABELA: produtos
-- ==========================================
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    categoria_id INT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Inserir produtos de exemplo (opcional)
INSERT INTO produtos (nome, descricao, preco, categoria_id) VALUES
('Pizza Calabresa', 'Pizza tradicional com calabresa e cebola', 39.90, 1),
('Lasanha Bolonhesa', 'Massa artesanal com molho bolonhesa', 42.00, 1),
('Churrasco Misto', 'Carne bovina e linguiça suína grelhada', 59.90, 2),
('Vinho Tinto', 'Garrafa 750ml de vinho nacional', 79.00, 3),
('Pudim de Leite', 'Sobremesa clássica caramelizada', 12.50, 4);

-- ==========================================
-- TABELA: notas
-- ==========================================
CREATE TABLE IF NOT EXISTS notas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    conteudo TEXT NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Inserir notas de exemplo (opcional)
INSERT INTO notas (produto_id, titulo, conteudo) VALUES
(1, 'Muito boa!', 'Pizza saborosa e bem recheada, recomendo.'),
(2, 'Excelente', 'Molho da lasanha muito bem temperado.'),
(3, 'Delicioso churrasco', 'Carne macia e bem passada.'),
(5, 'Perfeito!', 'O pudim estava cremoso e doce na medida certa.');

-- ==========================================
-- FIM DO ARQUIVO
-- ==========================================
