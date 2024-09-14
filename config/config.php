<?php
    //$pastaInterna="cash/";
    $pastaInterna="";
   
    //Host
    define('DIRPAGE',"https://{$_SERVER['HTTP_HOST']}/{$pastaInterna}");
    //Domínio
    define("DOMAIN",$_SERVER['HTTP_HOST']);
    //Diretório Raiz
    if(substr($_SERVER['DOCUMENT_ROOT'],-1)=="/"){
        define('DIRREQ',"{$_SERVER['DOCUMENT_ROOT']}{$pastaInterna}");
    }else{
        define('DIRREQ',"{$_SERVER['DOCUMENT_ROOT']}/{$pastaInterna}");
    }
    
    //Serviço de email
    define("HOSTMAIL",'smtp.hostinger.com');
    define("USERMAIL",'suporte@ivici.com.br');
    define("PASSMAIL",'!Suporteivici11$');
    
    define("HOSTMAILEXTRATO",'smtp.hostinger.com');
    define("USERMAILEXTRATO",'contabilidade.extrato@ivici.com.br');
    define("PASSMAILEXTRATO",'<CONT123cont$/>');

    //Banco de dados
    //define('HOST','154.49.247.204');
    //define('HOST','srv1070.hstgr.io');
    define('HOST','localhost');
    define('DB','u604934573_ElaiBD');
    define('USER','u604934573_kaua');
    define('PASS','<KAU154kau$/>');
    
    
    //Api PagSeguro
    define('TOKENHOMLOGPAGSEGURO','7D3AB61CCEB34F93B8259ECF32388EDB');
    define('URLHOMOLOG','https://sandbox.api.pagseguro.com/orders');
    define('TOKENPRODPAGSEGURO','d208deed-ff3b-4bf2-9299-ff616d0b41e3b1498f934c36b818eab236b846ff2a23baf9-c471-4e70-aad0-e9a913102089');    
    define('URLPDROD','https://pagseguro.uol.com.br');
    
    
    //Api Chez
    define("URLPAYMENT","https://chez-api-develop.herokuapp.com/transaction/payment");
    define("URLTRANSACTION","https://chez-api-develop.herokuapp.com/transaction");
    
    //Api AppSing
    define('token_acesso','dlO7UR3YNTP7nGcV6wfVg5Zvh20racX0mFTNotPgHMh2NawDVG3d6j6uE887osw298zt1YYftSPu2zHzHnjJWotvBaCG4LkvnEnBc7lZ1vwNVJAccerdB3gq9jZLFMDg0ssti3ID5OY0bp9Xx5ItF1oXtBZpmTK2pGTYnW2217KNMEz34RmMiF1YLxpx46fUq936wNXYrfJfyHRctwreBCZdv9GDq4Ad3gnXQFlLcaDSqB4r5sgOpsrJYNr8rKLooAWHlJCXpK4brtXCWPOazdO20O56jZVQl9NKN6bACAMQdSL5EVkjV7FcFMCRMQgNEevEuYeHOye3VPH5W');
    define('URL_APP_SING',"https://app.plugsign.com.br/api");
    define('UPLOAD_URL',URL_APP_SING.'/files/upload');
    

    //API Invoyci
    define('DOCNOTAS','senddocuments/');
    define('CREATE_ACCESS_KEY','oauth2/invoicy/auth');
    
    define('KEY_HOMOLOG','oe7RXXf1611AGbtEpEZLcLInvIub900R');
    define('KEY_PROD','oe7RXXf1611AGbtEpEZLcO3bIGQm0ruO');
    //define('KEY_PROD','/6ra1Ugxf6WRx/tuCzZlC+EFdDwoiFbz');
    define('SUB','11316866000122');
    define('PATNER_KEY','WO7OOVO/G34tUwRiNnNz7w==');
    
    define('HOMOLOG',"https://apibrhomolog.invoicy.com.br/");
    define('PROD',"https://apibr.invoicy.com.br/");

    //Integra Contador
    //define('CONTRATANTE','11316866000122');
    //define('AUTOR_PEDIDO_DADOS','11316866000122');
    //define('CHAVE_AUTENTICACAO_INTEGRA_CONTADOR','QzRpdGZrZXZXX3luc2tGaGZuaDVxY2llU1gwYTpyOTNqZ0Z4QUp5cjZETWk1QUl1WklEaGJPQmdh');
    define('CONTRATANTE','56088614000121');
    define('AUTOR_PEDIDO_DADOS','56088614000121');
    define('CHAVE_AUTENTICACAO_INTEGRA_CONTADOR','cHVrWFFRVmZIbEJCa0d0Zl9QeExWVGpGSEg0YToyUXRDd0IwMU9CZnlwTWpDZFRGNDJEN2hISDhh');

    //Outros diretórios
    #CSS
    if(substr($_SERVER['HTTP_HOST'],-1)=="/"){
        define('DIRCSS',"https://{$_SERVER['HTTP_HOST']}{$pastaInterna}public/css/");
    }else{
        define('DIRCSS',"https://{$_SERVER['HTTP_HOST']}/{$pastaInterna}public/css/");
    }
    
    #JS
    if(substr($_SERVER['HTTP_HOST'],-1)=="/"){
        define('DIRJS',"https://{$_SERVER['HTTP_HOST']}{$pastaInterna}public/js/");
    }else{
        define('DIRJS',"https://{$_SERVER['HTTP_HOST']}/{$pastaInterna}public/js/");
    }

    #IMG
    if(substr($_SERVER['HTTP_HOST'],-1)=="/"){
        define('DIRIMG',"https://{$_SERVER['HTTP_HOST']}{$pastaInterna}public/img/");
    }else{
        define('DIRIMG',"https://{$_SERVER['HTTP_HOST']}/{$pastaInterna}public/img/");
    }
    
    #Certificados
    define('DIR_CERTIFICADO',DIRREQ.'public/certificados/');
    define('PASS_CER_ELAI','ROB1234rob');

    #Tentativas de Logar
    define('NUMERO_DE_TENTATIVAS',15);

    #Tempo de Sessao
    define('TEMPO_DE_SESSAO',3600);
?>