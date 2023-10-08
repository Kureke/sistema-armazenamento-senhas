<?php
@session_start();

/*
ARQUIVO PRINCIPAL QUE PROCESSA AS REQUISIÇÕES DO SISTEMA E EXECUTA AS AÇÕES ---
As requisições vem criptografadas, melhorando a segurança para uso com protocolos http, ou em caso de problemas no certificado https do servidor.
*/

/* --- Timezone, data e hora e variaveis importantes ----------------------- */

//America/belem é mais compatível com o horário de verão desativado (em ambientes mais antigos)
date_default_timezone_set('America/Belem'); 
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

//endereço de ip do cliente
if(!isset($_SERVER['HTTP_X_REAL_IP']) || $_SERVER['HTTP_X_REAL_IP'] == null)
    $_SERVER['HTTP_X_REAL_IP'] = $_SERVER['REMOTE_ADDR'];

/* --- Processamento de requisições ---------------------------*/

//recebe requisições em json, valida se são válidas e carrega para a variavel req
$req = file_get_contents("php://input");
if(strlen($req) < 10) executaRetorno(array('resposta' => 0, 'mensagem'=>'Requisição inválida'));

//faz o decode do json com a requisição criptografada e carrega na variavel req
$req = json_decode($req, true);
if($req == null) executaRetorno(array('resposta' => 0, 'mensagem'=>'O conteúdo da requisição não é válido.'));

//desencripta a requisição e carrega os dados na variavel $req
if($req == null) executaRetorno(array('resposta' => 0, 'mensagem'=>"Recebemos o seu ataque, o seu endereço de IP é:. {$_SERVER['HTTP_X_REAL_IP']}"));


/* ---- requires ------------*/

/*Arquivo de configuração: Contem os dados de acesso ao banco de dados e configurações.*/
require_once './configuracao.php';


/* --- inicialização de variaveis vindas da reuqisição  ---------------------*/
global $variaveis;
$variaveis = array(
    'acao', //variaveis básicas
    'usu_login', 'usu_senha', 'usu_nome', 'usu_status' //variaveis de usuário
);

//Inicializa as variaveis padroes com valor zerado, ou recebendo do metodo post; e valida contra ataques sql injection ------------------
for ($i = 0; $i < count($variaveis); $i++) {

    //pega o nome da variavel
    $tmpVar = $variaveis[$i];

    //se a variavel não veio na requisição, continua o loop
    if(!isset($req[$tmpVar])) continue;

    //define a variavel como global e inicializa ela
    global $$tmpVar;
    $$tmpVar = '';

    //valida o valor passado na requisição, se for invalido, encerra a execução imediatamente
    $tmpValida = validaVariavel($$tmpVar, $req[$req[$tmpVar]]);
    if($tmpValida['resposta'] == 0) executaRetorno($tmpValida);

    //se passou pelas validações, recebe o valor da variavel
    $$tmpVar = $req[$tmpVar];

}


/* --- EXECUÇÃO DAS AÇÕES --------------------------- */

if($acao == 'autentica') autentica(); //realiza o login
if($acao == 'desconecta') desconecta(); //realiza o logout

//se não executou nenhuma função, devolve o retorno
executaRetorno(array('resposta' => 0, 'mensagem'=>'A função informada não é válida.'));


/* --- FUNÇÕES GERAIS --------------------------- */

//realiza a validação das variaveis da requisição e encerra a execução em caso de não valido
function validaVariavel($variavel, $valor){
    global $variaveis;

    //verifica se a variavel está dentro do array geral, caso não esteja, retorna erro
    if(!in_array($variavel, $variaveis))
        return array('resposta' => 0, 'mensagem'=>'Campo não permitido.');

    //token
    if($variavel == 'token' && strlen($valor) < 20)
        return (array('resposta' => 0, 'mensagem'=>'O conteúdo da requisição não é válido.'));

    //ação
    if($variavel == 'acao' && preg_match("/^[a-zA-Z]*$/", $valor))
        return (array('resposta' => 0, 'mensagem'=>'A ação informada não é válida.'));

    //campos de usuário
    if($variavel == 'usu_nome' && preg_match("/^[a-zA-Z]*$/", $valor))
        return (array('resposta' => 0, 'mensagem'=>'O nome do usuário possuí caracteres inválidos.'));
    
    if($variavel == 'usu_login' && strlen($valor) < 8 && strlen($valor) > 50)
        return (array('resposta' => 0, 'mensagem'=>'O usuário informado deverá possuir entre 8 e 30 caracteres.'));

    if($variavel == 'usu_senha' && strlen($valor) < 8 && strlen($valor) > 30)
        return (array('resposta' => 0, 'mensagem'=>'A senha informada deverá possuir entre 8 e 30 caracteres.'));
    
    if($variavel == 'usu_status' && ( $valor != 1 || $valor != 2))
        return (array('resposta' => 0, 'mensagem'=>'O status do usuário informado não é válido.'));

    //se passou pelas validações, retorno positivo
    array('resposta' => 1, 'mensagem'=>'Validação OK.');

}

//Executa o retorno, grava um histórico no banco de dados, e encerra a execução do programa
function executaRetorno($arrayRetorno){

    //grava o retorno da requisição no banco de dados de historico
    #colocar o código aqui...

    //exibe a mensagem de retorno e encerra a execução
    echo json_encode(json_encode($arrayRetorno));
    exit;
    
}