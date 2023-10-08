-- Cria o banco de dados
CREATE DATABASE armazena_senha WITH ENCODING 'UTF8';


--Cria as tabelas. Garanta que o banco de dados está criado antes de continuar.

-- Tabela Usuario
CREATE TABLE usuario (
    usu_id SERIAL PRIMARY KEY NOT NULL,
    usu_login VARCHAR(30) NOT NULL DEFAULT '',
    usu_nome VARCHAR(50) NOT NULL DEFAULT '',
    usu_senha VARCHAR(150) NOT NULL DEFAULT '',
    gru_id INT DEFAULT 0 NOT NULL,
    usu_status INT DEFAULT 0 NOT NULL
);

-- Tabela Grupo
CREATE TABLE grupo (
    gru_id SERIAL PRIMARY KEY,
    gru_nome VARCHAR(150) NOT NULL DEFAULT '',
    gru_status INT DEFAULT 0 NOT NULL
);
