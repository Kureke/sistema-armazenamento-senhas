-- Tabela Usuario
CREATE TABLE usuario (
    usu_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    usu_login VARCHAR(30) NOT NULL DEFAULT '',
    usu_nome VARCHAR(50) NOT NULL DEFAULT '',
    usu_senha VARCHAR(150) NOT NULL DEFAULT '',
    gru_id INT(3) DEFAULT 0 NOT NULL,
    usu_status INT(1) DEFAULT 0 NOT NULL
);

-- Tabela Grupo
CREATE TABLE grupo (
    gru_id INT(3) PRIMARY KEY AUTO_INCREMENT,
    gru_nome VARCHAR(150) NOT NULL DEFAULT '',
    gru_status INT(1) DEFAULT 0 NOT NULL
);
