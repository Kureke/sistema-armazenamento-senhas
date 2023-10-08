<?php
@session_start();


/*
ARQUIVO CONTENDO TODAS AS CONFIGURAÇÕES DO SISTEMA
Esse arquivo contem informações sobre banco de dados, chaves de criptografia para armazenamento das senhas, entre outros.
Altere conforme a sua necessidade.
*/

/*
Primeira chave de criptografia: É utilizada para criptografar as senhas salvas no banco de dados.
Importante: Altere ela para uma de sua preferência antes de salvar a primeira senha.
Se você altera-la após salvar as senhas, as senhas anteriores gravadas serão perdidas, pois não será possível descriptografa-las.
*/

function getChaveCripto(){
    return 'Informe a chave aqui';
}

/* Conexão com o Banco de dados */
function getDbInfo() {
    return [
        //dbTipo: Postgres=1,  Mysql=2 
        'dbTipo' => 0,

        //dados de conexão com o banco de dados
        'dbHost' => '192.168.1.200',
        'dbLogin' => 'postgres',
        'dbSenha' => 'postgres',
        'dbNome' => 'armazena_senha',

        //porta: Postgres: 5434, Mysql: 3306
        'dbPorta' => '5432',

        //schema do banco de dados, usado apenas no postgres, ignorado no mysql
        'dbSchema' => 'public'
    ];
}