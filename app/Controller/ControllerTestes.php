<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassValidate;
use Src\Classes\ClassValidatePerfil;
use Src\Classes\ClassValidateSimplesNacional;
use Src\Classes\ClassValidateCalcularRBT12;
use Src\Classes\ClassMail;
use Src\Classes\ClassJWT;
use Src\Classes\ClassRequestJSON;
use GuzzleHttp;
use Smalot;
use Src\Classes\ClassConvertNFePHP;
use Src\Traits\TraitUrlParser;
class ControllerTestes{
    
    use TraitUrlParser;
    private $Render;
    private $Validate;
    private $ValidatePerfil;
    private $ValidateSimplesNacional;
    private $ValidateCalcularRBT12;
    private $Mail;
    private $Guzzle;
    private $JWT;
    private $RequestJSON;
    private $ConvertNFePHP;

    private $Smalot;

    private $request = [];
    
    function __construct(){
        /*ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);*/
        $this->Render = new ClassRender;
        $this->Validate = new ClassValidate;
        $this->ValidatePerfil = new ClassValidatePerfil;
        $this->ValidateSimplesNacional = new ClassValidateSimplesNacional;
        $this->ValidateCalcularRBT12 = new ClassValidateCalcularRBT12;
        $this->Mail = new ClassMail;
        //$this->Guzzle = new \GuzzleHttp\Client();
        $this->Smalot = new \Smalot\PdfParser\Parser();
        $this->JWT = new ClassJWT;
        $this->RequestJSON = new ClassRequestJSON;
        $this->ConvertNFePHP = new ClassConvertNFePHP;
        $this->Render->setDir("Testes");
        $this->Render->setTitle("Pagina testes");
        $this->Render->setDescription("Pagina testes MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            //$this->Render->addSession();
            //$var='Access-Control-Allow-Origin:'.DOMAIN;
            header("Content-Type:application/json");
            header('Access-Control-Allow-Origin:*');
        }else{
            $this->Render->renderLayout();
        }
    }

    public function testesCoisados(){
        $array = [
            "a"=>1,
            "b"=>2
        ];
        //$index = array_key_last($array);
        var_dump(array_key_last($array));
    }

    public function files(){
        //$dataLocal = date('d/m/Y H:i:s');
        //exit(json_encode());
        /*$array = [];
        foreach($_FILES['file']['error'] as $values){
            array_push($array, $values);
            //var_dump($values);
        }*/
        exit(json_encode(!isset($_FILES['file']['error']) || !is_array($_FILES['file']['error'])));
    }

    private function like($needle, $haystack){
        $regex = '/' . str_replace('%', '.*?', $needle) . '/';

        return preg_match($regex, $haystack) > 0;
    }

    function integraContador(){
        /*$return  = $this->RequestJSON->request(
            "https://autenticacao.sapi.serpro.gov.br/authenticate",
            "POST",
            "grant_type=client_credentials"
            ,
            [
                "Content-Type:application/x-www-form-urlencoded",
                "Role-Type: TERCEIROS",
                "Authorization: Basic QzRpdGZrZXZXX3luc2tGaGZuaDVxY2llU1gwYTpyOTNqZ0Z4QUp5cjZETWk1QUl1WklEaGJPQmdh"
            ],
            [
                "Certificado"=>DIR_CERTIFICADO."pernambucont.pem",
                "Senha"=>"1234"
            ]        
        );

        $json = json_decode($return, true);

        $return2  = $this->RequestJSON->request(

            "https://gateway.apiserpro.serpro.gov.br/integra-contador/v1/Consultar",
            "POST",
            json_encode([
                "contratante"=>[
                    "numero"=>"11316866000122",
                    "tipo"=>2
                ],
                "autorPedidoDados"=>[
                    "numero"=>"11316866000122",
                    "tipo"=>2
                ],
                "contribuinte"=>[
                    "numero"=>"11316866000122",
                    "tipo"=>2
                ],
                "pedidoDados"=>[
                    "idSistema"=>"PGDASD",
                    "idServico"=>"CONSULTIMADECREC14",
                    "versaoSistema"=> "1.0",
                    "dados"=> "{ \"periodoApuracao\": \"202305\" }"
                ]
            ]),
            [
                "Content-Type:application/json",
                "Authorization:{$json['token_type']} {$json['access_token']}",
                "jwt_token: {$json['jwt_token']}"
            ]
                  
        );

        $dados = json_decode(json_decode($return2,true)['dados'],true);*/

        $pdf = self::pdfteste(base64_encode(file_get_contents(DIRREQ.'public/vm.pdf')));

        //exit(json_encode(base64_encode(file_get_contents(DIRREQ.'public/vm.pdf'))));

        $RBT12 = null;
        $RBT12p = null;
        $RPA = null;

        $periodoApuracao = explode(" ",trim(preg_replace(["/[A-Z]/","/[a-z]/","/[À-ú]/","/:/"],"",$pdf[3])))[0];

        $mesApuracao = (int)explode('/',$periodoApuracao)[1];
        $anoApuracao = (int)explode('/',$periodoApuracao)[2];

        for($i=1;$i<=12;$i++){
        
            if($mesApuracao<=1){
                $mesApuracao=12;
                $anoApuracao--;
            }else{
                $mesApuracao--;
            }
            
        }

        if($mesApuracao<10){$mesApuracao = "0".$mesApuracao;}

        $mesApuracao = (string)$mesApuracao;
        $anoApuracao = (string)$anoApuracao;
        $interruptor = true;

        for($i=0;$i<=count($pdf)-1;$i++){
            if(self::like('%CNPJ Matriz%',$pdf[$i])){
                if(preg_match('/\d+/', $pdf[$i])>0){
                    $cnpj = preg_replace("/[^0-9]/","",explode("\t",$pdf[$i])[1]);
                }
            }

            if(self::like('%(RBT12)%',$pdf[$i])){
                if(preg_match('/\d+/', $pdf[$i+1])>0){
                    $RBT12 = explode("\t",$pdf[$i+1])[0];
                }
            }

            if(self::like('%(RPA)%',$pdf[$i])){
                if(preg_match('/\d+/', $pdf[$i])>0){
                    $RPA = explode("\t",$pdf[$i])[1];
                }
            }

            if(self::like('%(RBT12p)%',$pdf[$i])){
                if(preg_match('/\d+/', $pdf[$i+1])>0){
                    $RBT12p = explode("\t",$pdf[$i+1])[0];
                }
            }

            if($interruptor){
                if(self::like("%{$mesApuracao}\/{$anoApuracao}%",$pdf[$i])){
                    $pdf[$i] = str_replace("\t"," ",$pdf[$i]);
                    $q = explode(" ",$pdf[$i]);
                    $mesApuracaoTemp = (int)$mesApuracao;
                    $mesApuracaoTemp++;
                    if($mesApuracaoTemp<10){$mesApuracaoTemp = "0".$mesApuracaoTemp;}

                    for($w=0;$w<=count($q)-1;$w++){
                        if(self::like("%{$mesApuracao}\/{$anoApuracao}%",$q[$w])){
                            $x = preg_replace("/{$mesApuracaoTemp}\/{$anoApuracao}.*?/","",$q[$w+1]);
                        }
                    }

                    $interruptor = false;
                }
            }
            
        }

        $RBT12Temp = (float)str_replace([".",","], ["","."], $RBT12);
        $RPATemp = (float)str_replace([".",","], ["","."], $RPA);
        $xTemp = (float)str_replace([".",","], ["","."], $x);

        $valor = ($RBT12Temp+$RPATemp)-$xTemp;

        $competencia = explode('/',$periodoApuracao);
        $competencia[1] = (int)$competencia[1];

        if($competencia[1]>=12){
            $competencia[1]="01";
        }else{
            $competencia[1]++;
            if($competencia[1]<=9){
                $competencia[1] = "0".$competencia[1];
            }
        }

        $retorno = $this->ValidateCalcularRBT12->validateInsertRBT12([
            'id'=>(string)uniqid('',true),
            'competencia'=>(string)"{$competencia[2]}-{$competencia[1]}-01",
            'rpa'=>(float)0,
            'rbt12'=>(float)$RBT12Temp,
            'anexo'=>(int)0,
            'cnpj'=>(string)$cnpj
        ]);

        exit(json_encode([
            "RBT12"=>$RBT12,
            "RBT12p"=>$RBT12p,
            "RPA"=>$RPA,
            "valor"=>$valor,
            "cnpj"=>$cnpj,
            "MesApuracao"=>$mesApuracao,
            "AnoApuracao"=>$anoApuracao,
            "periodoApuracao"=>$periodoApuracao,
            "x"=>$x,
            "retorno"=>$retorno,
            "log"=>[
                'erro'=>$this->ValidateCalcularRBT12->getError(),
                'message'=>$this->ValidateCalcularRBT12->getMessage()
            ],
            "pdf"=>$pdf
        ]));
    }

    private function pdfteste(string $base64PDF){
        file_put_contents(DIRREQ.'public/declaracao.pdf', base64_decode($base64PDF));
        $pdf = $this->Smalot->parseFile(DIRREQ.'public/declaracao.pdf');

        return explode("\n",$pdf->getText(1));
    }

    /*function oi(){
        if(count($_POST)<=0){$_POST = json_decode(file_get_contents('php://input'),true);}
        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            echo json_encode(['erro'=>'Método não suportado, envie uma requisição POST'],JSON_UNESCAPED_UNICODE);
            return false;
        }else{
            http_response_code(200);

            if(isset($_POST['cnpj'])){
                $cnpj = preg_replace("/[^0-9]/","",$_POST['cnpj']);
            }
            if(isset($_POST['rbt12'])){
                $rbt12 = preg_replace("/[^0-9 . ,]/","",$_POST['rbt12']);
                $rbt12 = (float) str_replace([".",","],["","."],$rbt12);
            }

            $myfile = fopen(DIRREQ."app/Controller/POST_TESTE.txt", "a");
            $txt = date("d/m/Y H:i:s")." - ".json_encode(["cnpj"=>$cnpj,"rbt12"=>$rbt12],JSON_UNESCAPED_UNICODE)."\n\n";
            fwrite($myfile, $txt);
            fclose($myfile);

            echo json_encode($_POST,JSON_UNESCAPED_UNICODE);
            
            return true;
        }
    }*/

    public function RBT12WebScriping(){
        
        $url = "https://www.ivici.com.br/home";        
        
        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $htmlContent = curl_exec($curl);

        exit(json_encode($htmlContent, JSON_UNESCAPED_UNICODE));
        if ($htmlContent === false) {
            $error = curl_error($curl);
            exit(json_encode($error));
        }

        curl_close($curl);

        $html = str_get_html($htmlContent);

        $html = str_get_html($htmlContent);

        $name = $html->find("button.info-status status-success", 0);

        exit(json_encode($name));

    }

    public function getGrupoTeste(){
        if(count($_POST)<=0){$_POST = json_decode(file_get_contents('php://input'),true);}

        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            echo json_encode(['erro'=>'Metodo não suportado'],JSON_UNESCAPED_UNICODE);
            return false;
        }else{
            http_response_code(200);
            
            if(isset($_POST['cnpj'])){
                $cnpj = preg_replace("/[^0-9]/","",$_POST['cnpj']);
                array_push($this->request,$cnpj);
            }

            $this->Validate->validateFilds($this->request);

            $res = $this->Validate->validateGetGrupoLancamento([
                'Tomador'=>(string)$cnpj
            ]);

            exit(json_encode([
                'erros'=>$this->Validate->getError(),
                'dados'=>$res
            ]));
        }
    }

    public function getSubGrupoTeste(){
        if(count($_POST)<=0){$_POST = json_decode(file_get_contents('php://input'),true);}

            if($_SERVER['REQUEST_METHOD']!="POST"){
                http_response_code(405);
                echo json_encode(['erro'=>'Metodo não suportado'],JSON_UNESCAPED_UNICODE);
                return false;
            }else{

                if(isset($_POST['cnpj'])){
                    $cnpj = preg_replace("/[^0-9]/","",$_POST['cnpj']);
                    array_push($this->request,$cnpj);
                }
    
                if(isset($_POST['idGrupo'])){
                    $idGrupo = filter_var($_POST['idGrupo'], FILTER_SANITIZE_ADD_SLASHES);
                    array_push($this->request,$idGrupo);
                }

                $this->Validate->validateFilds($this->request);
                //exit(json_encode([$cnpj,$idGrupo]));
                $res = $this->Validate->validateGetSubGrupo([
                    'cnpj'=>$cnpj,
                    'idGrupo'=>$idGrupo
                ]);

                exit(json_encode([
                    'erros'=>$this->Validate->getError(),
                    'dados'=>$res
                ]));

            }
    }
    
    public function testePlanilha(){
        
    }

    function pagamentoTeste(){

        if(count($_POST)<=0){$_POST = json_decode(file_get_contents('php://input'),true);}

        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            echo json_encode(['erro'=>'Metodo não suportado'],JSON_UNESCAPED_UNICODE);
            return false;
        }else{
            //var_dump($_POST);
           
            $arrayRequired=array();
            $IdRegistro=md5(uniqid(rand(),true));
            $dataAtual=date("Y-m-d H:i:s");
            
            $JSON=array(
                'erros'=>array(),
                'sucessos'=>array()
            );
            
            if(isset($_POST['PJ'])){
                $PJ=filter_var($_POST['PJ'], FILTER_SANITIZE_SPECIAL_CHARS);
                $arrayRequired+=["PJ"=>$PJ];
            }
            if(isset($_POST['FormaDePagamento'])){
            $FormaDePagamento=filter_var($_POST['FormaDePagamento'], FILTER_SANITIZE_SPECIAL_CHARS);
            $arrayRequired+=["FormaDePagamento"=>$FormaDePagamento];
            }
            if(isset($_POST['NovaFormaDePagamento'])){
            $NovaFormaDePagamento=filter_var($_POST['NovaFormaDePagamento'], FILTER_SANITIZE_SPECIAL_CHARS);
            $arrayRequired+=["NovaFormaDePagamento"=>$NovaFormaDePagamento];
            }
            if(isset($_POST['TipoDePagamento'])){
            $TipoDePagamento=filter_var($_POST['TipoDePagamento'], FILTER_SANITIZE_SPECIAL_CHARS);
            $arrayRequired+=["TipoDePagamento"=>$TipoDePagamento];
            }
            if(isset($_POST['Agencia'])){
            $Agencia=filter_var($_POST['Agencia'], FILTER_SANITIZE_SPECIAL_CHARS);
            $arrayRequired+=["Agencia"=>$Agencia];
            }
            if(isset($_POST['Conta'])){
            $Conta=filter_var($_POST['Conta'], FILTER_SANITIZE_SPECIAL_CHARS);
            $arrayRequired+=["Conta"=>$Conta];
            }
            if(isset($_POST['Historico'])){
            $Historico=filter_var($_POST['Historico'], FILTER_SANITIZE_SPECIAL_CHARS);
            $arrayRequired+=["Historico"=>$Historico];
            }
            if(isset($_POST['Descricao'])){
            $Descricao=filter_var($_POST['Descricao'], FILTER_SANITIZE_SPECIAL_CHARS);
            $arrayRequired+=["Descricao"=>$Descricao];
            }
            if(isset($_POST['QRCodeRadio'])){
            $QRCodeRadio=filter_var($_POST['QRCodeRadio'], FILTER_SANITIZE_SPECIAL_CHARS);
            $arrayRequired+=["QRCodeRadio"=>$QRCodeRadio];
            }
            if(isset($_POST['QRCodeLink'])){
            $QRCodeLink=filter_var($_POST['QRCodeLink'],FILTER_SANITIZE_URL);
            //$arrayRequired+=["QRCodeLink"=>$QRCodeLink];
            }
            if(isset($_POST['QRCodeURL'])){
            $QRCodeURL=filter_var($_POST['QRCodeURL'], FILTER_SANITIZE_URL);
            //$arrayRequired+=["QRCodeURL"=>$QRCodeURL];
            }
            if(isset($_POST['Beneficiario'])){
                $Beneficiario=filter_var($_POST['Beneficiario'], FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if(isset($_POST['Nota'])){
                $Nota=filter_var($_POST['Nota'], FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if(isset($_POST['Valor'])){
                $Valor=filter_var($_POST['Valor'], FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if(isset($_POST['Data'])){
                $Data=filter_var($_POST['Data'], FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if(isset($_FILES['Comprovante'])){
                $Comprovante=$_FILES['Comprovante'];
            }
            if(isset($_POST['Submit'])){
            $Submit=filter_var($_POST['Submit'], FILTER_SANITIZE_SPECIAL_CHARS);
            $arrayRequired+=["Submit"=>$Submit];
            }
            
            if($_SESSION['TipoCliente']=="PJ"){
                $cpf = "00100200304";
                $cnpj = $_SESSION['ID'];
            }else if($_SESSION['TipoCliente']=="PF"){
                $cpf = $_SESSION['ID'];
                $cnpj = $PJ;
            }

            //exit(json_encode($arrayRequired));
            $this->Validate->validateInsertPagamentoTeste(
                [
                    "IdRegistro"=>(string)$IdRegistro,
                    "DataAtual"=>(string)$dataAtual,
                    "PJ"=>(string)$PJ,
                    "FormaDePagamento"=>(string)$FormaDePagamento,
                    "Historico"=>(string)$Historico,
                    "Descricao"=>(string)$Descricao,
                    "Beneficiario"=>(string)$Beneficiario,
                    "Nota"=>(int)$Nota,
                    "Valor"=>(float)$Valor,
                    "Data"=>(string)$Data,
                    "IdArquivo"=>(string)"",
                    "QRCodeLink"=>(string)"",
                    "ID"=>(string)"00100200304"
                ]
            );

            exit(json_encode([
                'sucesso'=>$this->Validate->getMessage(),
                "erro"=>$this->Validate->getError()
            ]));
        }
    }
    
    function planoDeContas(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            echo json_encode(['erro'=>'Metodo nao suportado'],JSON_UNESCAPED_UNICODE);
            return false;
        }else{
            http_response_code(200);
            //exit(json_encode($_FILES));
            $handle = fopen($_FILES['arquivo']['tmp_name'],'r');
           
            $header = fgetcsv($handle, 1000, ",");
            
            $tabela=array();
            while ($row = fgetcsv($handle, 1000, ",")) {
                array_push($tabela,array_combine($header, $row));
            }

            //exit(json_encode($tabela));

            fclose($handle);
            $codGrupo=0;
            foreach($tabela as $key => $array){
                $result = $this->ValidatePerfil->issetGrupo([
                    'cnpj'=>(string)$array['CNPJ'],
                    'codConta'=>(int)$array['COD GRUPO']
                ]);
                if($result['linhas']<=0){
                    $codGrupo=(int)$array['COD GRUPO'];
                    $result = $this->ValidatePerfil->insertGrupo([
                        'id'=>md5(mt_rand(10000,99999)),
                        'tipoAcao'=>(int)$array['TIPO DE ACAO'],
                        'nome'=>(string)$array['DESC GRUPO'],
                        'codConta'=>(int)$array['COD GRUPO'],
                        'cnpj'=>(string)$array['CNPJ']
                    ]);
                }
                
            }

            foreach($tabela as $key => $array){
                $result = $this->ValidatePerfil->issetGrupo([
                    'cnpj'=>(string)$array['CNPJ'],
                    'codConta'=>(int)$array['COD GRUPO']
                ]);
                
                if($result['linhas']>0){
                    $r = $this->ValidatePerfil->validateIssetContasContabil([
                        "numeroconta"=>(int)$array['COD SUB GRUPO'],
                        "cnpj"=>(string)$array['CNPJ']
                    ]);
                    
                    if(!$r){
                        $this->ValidatePerfil->validateInsertContasContabil([
                            "id"=>md5(mt_rand(10000,99999)),
                            "numeroconta"=>(int)$array['COD SUB GRUPO'],
                            "nome"=>(string)$array['DESC SUB GRUPO'],
                            "descricao"=>(string)"",
                            "palavrachave"=>(string)"",
                            "grupoconta"=>(string)$result["dados"][0]['Id'],
                            "cnpj"=>(string)$array['CNPJ']
                        ]);
                    }
                }
            }

            echo json_encode([$this->ValidatePerfil->getMessage(),$this->ValidatePerfil->getError()],JSON_UNESCAPED_UNICODE);
            
            return false;
        }
    }

    function getInformacoesAnexo(){
        $array_post=array();
        if(isset($_POST['RBT12'])){
            $RBT12 = (float) str_replace([".",","],["","."],$_POST['RBT12']);
            $array_post+=['RBT12'=>$RBT12];
        }
        if(isset($_POST['anexo'])){
            $anexo = (int)filter_input(INPUT_POST,'anexo',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=['anexo'=>$anexo];
        }
        
        $result = $this->Validate->validateGetInformacoesAnexo([
            'RBT12'=>$RBT12,
            'anexo'=>$anexo
        ]);
        
        echo(json_encode([
            "erros"=>$this->Validate->getError(),
            'dados'=>$result
        ]));
    }
    
    function historicos(){
        $historicos=$this->Validate->validateGetHistoricos([],"getHistoricos");
        $json = array(
            'error'=>[],
            'historico'=>[]
        );
        if($historicos['linhas']<=0){
            $json['error']+=["Sem históricos"];
        }else{
            $json['historico']+=$historicos['dados'];
        }
        echo(json_encode($json));
    }
    
    function consultarNota(){
        
        $url="nfse?type=Consulta";
        $url.="&Versao=1.00";
        $url.="&tpAmb=2";
        $url.="&ParmXMLLink=S";
        //$url.="&ParmXMLCompleto=S";
        //$url.="&ParmPDFBase64=S";
        $url.="&ParmPDFLink=S";
        //$url.="&ParmEventos=S";
        //$url.="&ParmSituacao=S";
        
        $array_post = [];
        if(isset($_POST['PJ'])){
            $PJ=filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_SPECIAL_CHARS,FILTER_FLAG_STRIP_LOW);
            $PJ=preg_replace("/[^0-9]/","",$PJ);
            $array_post+=["PJ"=>$PJ];
            
            $url.="&CnpjEmissor={$PJ}";
            
        }
        if(isset($_POST['dtInicialEmissao'])){
            if(empty($_POST['dtInicialEmissao'])){
                $dtInicialEmissao=false;
            }else{
                if($this->Validate->validateData($_POST['dtInicialEmissao'])){
                    $date=date_create($_POST['dtInicialEmissao']);
                    $dtInicialEmissao = date_format($date,"Y-m-d H:i:s");
                    $dtInicialEmissao = str_replace(" ","T",$dtInicialEmissao);
                    
                    //$url.="&DataEmissaoInicial={$dtInicialEmissao}";
                    $url.="&DataInclusaoInicial={$dtInicialEmissao}";
                    
                }else{
                    $dtInicialEmissao = false;
                    //$dtInicialEmissao = "0000-00-00T00:00:00";
                }
            }
            
            $array_post+=["dtInicialEmissao"=>$dtInicialEmissao];
        }
        if(isset($_POST['dtFinalEmissao'])){
            if(empty($_POST['dtFinalEmissao'])){
                $dtFinalEmissao=false;
            }else{
                if($this->Validate->validateData($_POST['dtFinalEmissao'])){
                    $date=date_create($_POST['dtFinalEmissao']);
                    $dtFinalEmissao = date_format($date,"Y-m-d H:i:s");
                    $dtFinalEmissao = str_replace(" ","T",$dtFinalEmissao);
                    
                    //$url.="&DataEmissaoFinal={$dtFinalEmissao}";
                    $url.="&DataInclusaoFinal={$dtFinalEmissao}";
                    
                }else{
                    $dtFinalEmissao = false;
                    //$dtFinalEmissao = "0000-00-00T00:00:00";
                }
            }
            
            $array_post+=["dtFinalEmissao"=>$dtInicialEmissao];
        }
        if(isset($_POST['numeroInicial'])){
            $numeroInicial=filter_input(INPUT_POST, 'numeroInicial', FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["numeroInicial"=>$numeroInicial];
            
            if(!empty($numeroInicial)){$url.="&NumeroInicial={$numeroInicial}";}
            
        }
        if(isset($_POST['numeroFinal'])){
            $numeroFinal=filter_input(INPUT_POST, 'numeroFinal', FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["numeroFinal"=>$numeroFinal];
            
            if(!empty($numeroFinal)){$url.="&NumeroFinal={$numeroFinal}";}
            
        }
        if(isset($_POST['serie'])){
            $serie=filter_input(INPUT_POST, 'serie', FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["serie"=>$serie];
            
            if(!empty($serie)){$url.="&Serie={$serie}";}
            
        }
        if(isset($_POST['statusDocumento'])){
            $statusDocumento=filter_input(INPUT_POST, 'statusDocumento', FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["statusDocumento"=>$statusDocumento];
            if(!empty($statusDocumento)){$url.="&StatusDocumento={$statusDocumento}";}
        }
        if(isset($_POST['EmitidoRecebido'])){
            $EmitidoRecebido=filter_input(INPUT_POST, 'EmitidoRecebido', FILTER_SANITIZE_ADD_SLASHES);
            $array_post+=["EmitidoRecebido"=>$EmitidoRecebido];
            if(!empty($EmitidoRecebido)){$url.="&EmitidoRecebido={$EmitidoRecebido}";}
        }
        
        //exit(json_encode($array_post));
        
        //$url.="&CnpjEmpresa={$PJ}";
        
        //$url.="&dhUF=26";
        //$url.="&ChaveAcesso=".KEY_HOMOLOG;
        
        
        //$url.="&DataInclusaoInicial={$dtInicialEmissao}";
        //$url.="&DataInclusaoFinal={$dtFinalEmissao}";
        //$url.="&ParmTipoImpressao=S";
        //$url.="&DocumentosResumo=S";
        //$url.="&ParmAutorizadoDownload=S";
        
        //exit(json_encode($url));
        
        $time = time();
        $payLoader = array(
            "iat"=>$time,
            "exp"=>$time + 120,
            "sub"=>SUB,
            "partnerKey"=>PATNER_KEY
        );
        
        $token=$this->JWT->jwtEncode($payLoader,KEY_HOMOLOG);
        
        //exit(json_encode($token));
        
        $requestToken=json_decode($this->RequestJSON->request(HOMOLOG.CREATE_ACCESS_KEY,"POST",$token),true);
        
        //exit(json_encode($requestToken));
        
        $header = array(
            "Authorization:{$requestToken['accessToken']}",
            "Content-Type:application/json"
        );
       
        $requestNFSe=json_decode($this->RequestJSON->request(HOMOLOG.DOCNOTAS.$url,"GET",null,$header),true);
        
        echo(json_encode([
            'erros'=>$this->Validate->getError(),
            'sucessos'=>$this->Validate->getMessage(),
            'retorno'=>$requestNFSe
        ]));
        
    }
    
    function cancelarNota(){
        $array_post = [];
        if(isset($_POST['PJ'])){
            $PJ=filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_SPECIAL_CHARS,FILTER_FLAG_STRIP_LOW);
            $PJ=preg_replace("/[^0-9]/","",$PJ);
            $array_post+=["PJ"=>$PJ];
        }
        if(isset($_POST['motivoCencelamento'])){
            $motivoCencelamento = filter_input(INPUT_POST,'motivoCencelamento',FILTER_SANITIZE_ADD_SLASHES);
            //$motivoCencelamento = filter_var($motivoCencelamento,FILTER_SANITIZE_STRING);
            $array_post+=["motivoCencelamento"=>$motivoCencelamento];
        }
        if(isset($_POST['numeroNFSe'])){
            $numeroNFSe = filter_input(INPUT_POST,'numeroNFSe',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["numeroNFSe"=>$numeroNFSe];
        }
        if(isset($_POST['numeroRPS'])){
            $numeroRPS = filter_input(INPUT_POST,'numeroRPS',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["numeroRPS"=>$numeroRPS];
        }
        if(isset($_POST['serieRPS'])){
            $serieRPS = filter_input(INPUT_POST,'serieRPS',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["serieRPS"=>$serieRPS];
        }
        if(isset($_POST['tpCodEvento'])){
            $tpCodEvento = filter_input(INPUT_POST,'tpCodEvento',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["tpCodEvento"=>$tpCodEvento];
        }
        
        $cancelaNotaArray = array(
            array(
                "ModeloDocumento"=>"NFSe",
                "Versao"=>1,
                "Evento"=>array(
                    "CNPJ"=>(string)$PJ,
                    "NFSeNumero"=>(int)$numeroNFSe,
                    "RPSNumero"=>(int)$numeroRPS,
                    "RPSSerie"=>(string)$serieRPS,
                    "EveTp"=>110111,
                    "tpAmb"=>2,
                    "EveCodigo"=>(string)$tpCodEvento,
                    "EveMotivo"=>(string)$motivoCencelamento
                )
            )
        );
        
        $time = time();
        $payLoader = array(
            "iat"=>$time,
            "exp"=>$time + 120,
            "sub"=>SUB,
            "partnerKey"=>PATNER_KEY
        );
        
        $token=$this->JWT->jwtEncode($payLoader,KEY_HOMOLOG);
        
        $requestToken=json_decode($this->RequestJSON->request(HOMOLOG.CREATE_ACCESS_KEY,"POST",$token),true);
        
        $url="nfse?type=Evento";
        
        $header = array(
            "Authorization:{$requestToken['accessToken']}",
            "Content-Type:application/json"
        );
        
        $requestNP=json_decode($this->RequestJSON->request(HOMOLOG.DOCNOTAS.$url,"POST",json_encode($cancelaNotaArray),$header),true);
        
        exit(json_encode($requestNP));
    }
    
    
    
    function getCNAE(){
        //preg_replace("/[^0-9]/", "", $string);
        if(isset($_POST['atividade'])){
            $atividade=filter_input(INPUT_POST,'atividade',FILTER_SANITIZE_NUMBER_INT);
        }
        $json = array(
            'erros'=>$this->Validate->getError(),
            'dados'=>$this->Validate->validateGetCNAE($atividade)
        );
        echo(json_encode($json));
    }
    
    function getServico(){
        if(isset($_POST['PJ'])){
            $PJ=filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
            $PJ=str_replace(["-",".","/"],"",$PJ);
        }
        $json = array(
            'erros'=>$this->Validate->getError(),
            'dados'=>$this->Validate->validateGetListaServico($PJ)
        );
        echo(json_encode($json));
    }
    
    function getTributosMunicipais(){
        if(isset($_POST['PJ'])){
            $PJ=filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
            $PJ=str_replace(["-",".","/"],"",$PJ);
        }
        $json = array(
            'erros'=>$this->Validate->getError(),
            'dados'=>$this->Validate->validateGetTributosMunicipais($PJ)
        );
        echo(json_encode($json));
    }
    
    function getNaturezaOperacao(){
        
        if(isset($_POST['PJ'])){
            $PJ=filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_SPECIAL_CHARS);
            $PJ=preg_replace("/[^0-9]/","",$PJ);
        }
        
        if(isset($_POST['inscricaoMunicipal'])){
            $inscricaoMunicipal = preg_replace("/[^0-9]/","",$_POST['inscricaoMunicipal']);
        }
        
        //exit(json_encode($inscricaoMunicipal));
        
        $time = time();
        $payLoader = array(
            "iat"=>$time,
            "exp"=>$time + 120,
            "sub"=>$PJ,
            "partnerKey"=>PATNER_KEY
        );
        
        //$chave="oe7RXXf1611AGbtEpEZLcO3bIGQm0ruO";
        
        $token=$this->JWT->jwtEncode($payLoader,KEY_PROD);
        
        $requestToken=json_decode($this->RequestJSON->request(PROD.CREATE_ACCESS_KEY,"POST",$token),true);

        $url="senddocuments/nfse?type=naturezaoperacao&Versao=1.00&tpAmb=1&CNPJEmissor={$PJ}&IMEmissor={$inscricaoMunicipal}";
        //exit(json_encode($requestToken));
        //$url="senddocuments/nfse?type=naturezaoperacao&Versao=1.00&CNPJEmissor={$PJ}&tpAmb=2";
        
        $header = array(
            "Authorization:{$requestToken['accessToken']}",
            "Content-Type:application/json"
        );
        
        $requestNP=json_decode($this->RequestJSON->request(PROD.$url,"GET",null,$header),true);
        
        echo(json_encode([
            'NaturezaOperacao'=>$requestNP
        ]));
    }
    
    function calcularSimplesOriginal(){
        $json = array(
            "dadosAliquota"=>[
                "IRPJ"=>[],
                "CSLL"=>[],
                "COFINS"=>[],
                "PIS"=>[],
                "CPP"=>[],
                "ICMS"=>[],
                "IPI"=>[],
                "ISS"=>[]
            ],
            "notaComR"=>[]
        );
        
        $RBT12 = (float)$_GET['RBT12'];
        $anexo = (int)$_GET['anexo'];
        $valorDaNota= (float)$_GET['ValorTotalDosServicos'];
        $aliquota = (float)$_GET['aliquota'];
        $pclDeduzir = (float)$_GET['pclDeduzir'];
        $pagamento = (float)$_GET['pagamento'];
        
        if($aliquota>=1){$aliquota = $aliquota/100;}
        
        $aliquotaArray = [    
            "a"=>[
                1=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1274,
                    "PIS"=>0.0276,
                    "CPP"=>0.415,
                    "ICMS"=>0.34,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                2=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1151,
                    "PIS"=>0.0249,
                    "CPP"=>0.375,
                    "IPI"=>0.075,
                    "ICMS"=>0.32,
                    "ISS"=>0.0
                ],
                3=>[
                    "IRPJ"=>0.04,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1282,
                    "PIS"=>0.0278,
                    "CPP"=>0.434,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.335
                ],
                4=>[
                    "IRPJ"=>0.188,
                    "CSLL"=>0.152,
                    "COFINS"=>0.1767,
                    "PIS"=>0.0383,
                    "CPP"=>0.0,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.445
                ],
                5=>[
                    "IRPJ"=>0.25,
                    "CSLL"=>0.15,
                    "COFINS"=>0.141,
                    "PIS"=>0.0305,
                    "CPP"=>0.2885,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.14
                ]
        ],
            "b"=>[
                1=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1274,
                    "PIS"=>0.0276,
                    "CPP"=>0.415,
                    "ICMS"=>0.34,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                2=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1151,
                    "PIS"=>0.0249,
                    "CPP"=>0.375,
                    "IPI"=>0.075,
                    "ICMS"=>0.32,
                    "ISS"=>0.0
                ],
                3=>[
                    "IRPJ"=>0.04,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1405,
                    "PIS"=>0.0305,
                    "CPP"=>0.434,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.32
                ],
                4=>[
                    "IRPJ"=>0.198,
                    "CSLL"=>0.152,
                    "COFINS"=>0.2055,
                    "PIS"=>0.0445,
                    "CPP"=>0.0,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.4
                ],
                5=>[
                    "IRPJ"=>0.23,
                    "CSLL"=>0.15,
                    "COFINS"=>0.141,
                    "PIS"=>0.0305,
                    "CPP"=>0.2785,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.17
                ]
        ],
            "c"=>[
                1=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1274,
                    "PIS"=>0.0276,
                    "CPP"=>0.42,
                    "ICMS"=>0.335,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                2=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1151,
                    "PIS"=>0.0249,
                    "CPP"=>0.375,
                    "IPI"=>0.075,
                    "ICMS"=>0.32,
                    "ISS"=>0.0
                ],
                3=>[
                    "IRPJ"=>0.04,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1364,
                    "PIS"=>0.0296,
                    "CPP"=>0.434,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.325
                ],
                4=>[
                    "IRPJ"=>0.208,
                    "CSLL"=>0.152,
                    "COFINS"=>0.1973,
                    "PIS"=>0.0427,
                    "CPP"=>0.0,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.4
                ],
                5=>[
                    "IRPJ"=>0.24,
                    "CSLL"=>0.15,
                    "COFINS"=>0.1492,
                    "PIS"=>0.0323,
                    "CPP"=>0.2385,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.19
                ]
        ],
            "d"=>[
                1=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1274,
                    "PIS"=>0.0276,
                    "CPP"=>0.42,
                    "ICMS"=>0.335,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                2=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1151,
                    "PIS"=>0.0249,
                    "CPP"=>0.375,
                    "IPI"=>0.075,
                    "ICMS"=>0.32,
                    "ISS"=>0.0
                ],
                3=>[
                    "IRPJ"=>0.04,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1364,
                    "PIS"=>0.0296,
                    "CPP"=>0.434,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.325
                ],
                4=>[
                    "IRPJ"=>0.178,
                    "CSLL"=>0.192,
                    "COFINS"=>0.189,
                    "PIS"=>0.041,
                    "CPP"=>0.0,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.4
                ],
                5=>[
                    "IRPJ"=>0.21,
                    "CSLL"=>0.15,
                    "COFINS"=>0.1574,
                    "PIS"=>0.0341,
                    "CPP"=>0.2385,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.21
                ]
        ],
            "e"=>[
                1=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1274,
                    "PIS"=>0.0276,
                    "CPP"=>0.42,
                    "ICMS"=>0.335,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                2=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1151,
                    "PIS"=>0.0249,
                    "CPP"=>0.375,
                    "IPI"=>0.075,
                    "ICMS"=>0.32,
                    "ISS"=>0.0
                ],
                3=>[
                    "IRPJ"=>0.23,
                    "CSLL"=>0.15,
                    "COFINS"=>0.141,
                    "PIS"=>0.0305,
                    "CPP"=>0.2785,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.17
                ],
                4=>[
                    "IRPJ"=>0.188,
                    "CSLL"=>0.192,
                    "COFINS"=>0.1808,
                    "PIS"=>0.0392,
                    "CPP"=>0.0,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.4
                ],
                5=>[
                    "IRPJ"=>0.23,
                    "CSLL"=>0.125,
                    "COFINS"=>0.141,
                    "PIS"=>0.0305000000000001,
                    "CPP"=>0.2385,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.235
                ]
        ],
            "f"=>[
                1=>[
                    "IRPJ"=>0.135,
                    "CSLL"=>0.1,
                    "COFINS"=>0.2827,
                    "PIS"=>0.0613,
                    "CPP"=>0.421,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                2=>[
                    "IRPJ"=>0.085,
                    "CSLL"=>0.075,
                    "COFINS"=>0.2096,
                    "PIS"=>0.0454,
                    "CPP"=>0.235,
                    "IPI"=>0.35,
                    "ICMS"=>0.0,
                    "ISS"=>0.0
                ],
                3=>[
                    "IRPJ"=>0.35,
                    "CSLL"=>0.15,
                    "COFINS"=>0.1603,
                    "PIS"=>0.0347,
                    "CPP"=>0.305,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                4=>[
                    "IRPJ"=>0.535,
                    "CSLL"=>0.215,
                    "COFINS"=>0.2055,
                    "PIS"=>0.0445,
                    "CPP"=>0.0,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                5=>[
                    "IRPJ"=>0.35,
                    "CSLL"=>0.155,
                    "COFINS"=>0.1644,
                    "PIS"=>0.0356,
                    "CPP"=>0.295,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ]
        ],
        ];
        
        $evento = null;
        if($RBT12 <= 180000){
            $evento = "a";
        }else if($RBT12>  180000  && $RBT12 <= 360000){
            $evento = "b";
        }else if($RBT12>  360000  && $RBT12 <= 720000){
            $evento = "c";
        }else if($RBT12>  720000  && $RBT12 <= 1800000){
            $evento = "d";
        }else if($RBT12>  1800000  && $RBT12 <= 3600000){
            $evento = "e";
        }else if($RBT12>  3600000  && $RBT12 <= 4800000){
            $evento = "f";
        }
        
        $conta_fator_R = $pagamento/$RBT12;
        $resultado_Fator_R = $conta_fator_R * 100;
        if($resultado_Fator_R >= 28){$anexo=3;}
        
        $Calculo_Aliquota_Efetiva =  (($RBT12 * $aliquota) - $pclDeduzir) / $RBT12;
        $total = substr((string)$Calculo_Aliquota_Efetiva, 0, 5);
        
        $ALIQEfetiva = (float)$total * 100;
        //$ALIQEfetiva = (float)$total;
        $json +=["aliquotaEfetiva"=>number_format($ALIQEfetiva, 2, ",", ".")];
        
        $Calculo_Aliquota_Total = $RTM * $total; 
        $json +=["aliquotaTotal"=>number_format($Calculo_Aliquota_Total, 2, ",", ".")];
        
        $valores_recebidos = 0;
        foreach($aliquotaArray[$evento][$anexo] as $key => $value){
            if($value>0 && $value<1){
                $valores_recebidos+=$value;
                $json["dadosAliquota"][$key]+=[$key."Repeticao "=>number_format($value, 4, ",", ".")];
            }
        }
        
        $json+=['totalSomaPercentual'=>$valores_recebidos];
        
        $valor_total_aliquota = 0;
        foreach($aliquotaArray[$evento][$anexo] as $key => $value){
            if($value>0 && $value<1){
                //$cal=($total * $value);
                $cal=($total * 100 * $value);
                $valor_total_aliquota+=$cal;
                $json["dadosAliquota"][$key]+=[$key."EfetivaImposto "=>number_format($cal, 9, ",", ".")];
            }
        }
        
        $json+=["totalAliquota"=>number_format($valor_total_aliquota, 2, ",", ".")];
      
        $valor_total_calculo = 0;
        foreach($aliquotaArray[$evento][$anexo] as $key => $value){
            if($value>0 && $value<1){
                $valor_total_calculo+=(($RTM * ($total * 100 *$value))/100);
                $valor_total_calculo+=(($RTM * ($total * 100 *$value))/100);
                $json["dadosAliquota"][$key]+=[$key."Valor "=>number_format((($RTM * ($total * 100 *$value))/100), 2, ",", ".")];
            }
        }
        
        $json+=["valorRecolher"=>number_format($valor_total_calculo, 2, ",", ".")];

        exit(json_encode($json));
    }
    
    function calcularSimples(){
        
        $json = array(
            "dadosAliquota"=>[
                "IRPJ"=>[],
                "CSLL"=>[],
                "COFINS"=>[],
                "PIS"=>[],
                "CPP"=>[],
                "ICMS"=>[],
                "IPI"=>[],
                "ISS"=>[]
            ]
        );
        
        $array_post = array();
        if(isset($_POST['RBT12'])){
            $RBT12 = (float) str_replace([".",","],["","."],$_POST['RBT12']);
            $array_post+=['RBT12'=>$RBT12];
        }
        if(isset($_POST['anexo'])){
            $anexo = (int)filter_input(INPUT_POST,'anexo',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=['anexo'=>$anexo];
        }
        if(isset($_POST['ValorTotalDosServicos'])){
             $ValorTotalDosServicos = (float) str_replace([".",","],["","."],$_POST['ValorTotalDosServicos']);
             $array_post+=['ValorTotalDosServicos'=>$ValorTotalDosServicos];
        }
        if(isset($_POST['aliquota'])){
            $aliquota = str_replace(",",".",$_POST['aliquota']);
            $aliquota = (float)filter_input(INPUT_POST,'aliquota',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $array_post+=['aliquota'=>$aliquota];
        }
        if(isset($_POST['ValorTotalDasDeducoes'])){
            $pclDeduzir = (float) str_replace([".",","],["","."],$_POST['ValorTotalDasDeducoes']);
            $array_post+=['ValorTotalDasDeducoes'=>$pclDeduzir];
        }
        
        
        exit(json_encode($array_post));
        
        $this->Validate->validateFilds($array_post);
        
        if($aliquota>=1){$aliquota = $aliquota/100;}
        
        $aliquotaArray = [    
            "1"=>[
                1=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1274,
                    "PIS"=>0.0276,
                    "CPP"=>0.415,
                    "ICMS"=>0.34,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                2=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1151,
                    "PIS"=>0.0249,
                    "CPP"=>0.375,
                    "IPI"=>0.075,
                    "ICMS"=>0.32,
                    "ISS"=>0.0
                ],
                3=>[
                    "IRPJ"=>0.04,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1282,
                    "PIS"=>0.0278,
                    "CPP"=>0.434,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.335
                ],
                4=>[
                    "IRPJ"=>0.188,
                    "CSLL"=>0.152,
                    "COFINS"=>0.1767,
                    "PIS"=>0.0383,
                    "CPP"=>0.0,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.445
                ],
                5=>[
                    "IRPJ"=>0.25,
                    "CSLL"=>0.15,
                    "COFINS"=>0.141,
                    "PIS"=>0.0305,
                    "CPP"=>0.2885,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.14
                ]
            ],
            "2"=>[
                1=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1274,
                    "PIS"=>0.0276,
                    "CPP"=>0.415,
                    "ICMS"=>0.34,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                2=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1151,
                    "PIS"=>0.0249,
                    "CPP"=>0.375,
                    "IPI"=>0.075,
                    "ICMS"=>0.32,
                    "ISS"=>0.0
                ],
                3=>[
                    "IRPJ"=>0.04,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1405,
                    "PIS"=>0.0305,
                    "CPP"=>0.434,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.32
                ],
                4=>[
                    "IRPJ"=>0.198,
                    "CSLL"=>0.152,
                    "COFINS"=>0.2055,
                    "PIS"=>0.0445,
                    "CPP"=>0.0,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.4
                ],
                5=>[
                    "IRPJ"=>0.23,
                    "CSLL"=>0.15,
                    "COFINS"=>0.141,
                    "PIS"=>0.0305,
                    "CPP"=>0.2785,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.17
                ]
            ],
            "3"=>[
                1=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1274,
                    "PIS"=>0.0276,
                    "CPP"=>0.42,
                    "ICMS"=>0.335,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                2=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1151,
                    "PIS"=>0.0249,
                    "CPP"=>0.375,
                    "IPI"=>0.075,
                    "ICMS"=>0.32,
                    "ISS"=>0.0
                ],
                3=>[
                    "IRPJ"=>0.04,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1364,
                    "PIS"=>0.0296,
                    "CPP"=>0.434,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.325
                ],
                4=>[
                    "IRPJ"=>0.208,
                    "CSLL"=>0.152,
                    "COFINS"=>0.1973,
                    "PIS"=>0.0427,
                    "CPP"=>0.0,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.4
                ],
                5=>[
                    "IRPJ"=>0.24,
                    "CSLL"=>0.15,
                    "COFINS"=>0.1492,
                    "PIS"=>0.0323,
                    "CPP"=>0.2385,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.19
                ]
            ],
            "4"=>[
                1=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1274,
                    "PIS"=>0.0276,
                    "CPP"=>0.42,
                    "ICMS"=>0.335,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                2=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1151,
                    "PIS"=>0.0249,
                    "CPP"=>0.375,
                    "IPI"=>0.075,
                    "ICMS"=>0.32,
                    "ISS"=>0.0
                ],
                3=>[
                    "IRPJ"=>0.04,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1364,
                    "PIS"=>0.0296,
                    "CPP"=>0.434,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.325
                ],
                4=>[
                    "IRPJ"=>0.178,
                    "CSLL"=>0.192,
                    "COFINS"=>0.189,
                    "PIS"=>0.041,
                    "CPP"=>0.0,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.4
                ],
                5=>[
                    "IRPJ"=>0.21,
                    "CSLL"=>0.15,
                    "COFINS"=>0.1574,
                    "PIS"=>0.0341,
                    "CPP"=>0.2385,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.21
                ]
            ],
            "5"=>[
                1=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1274,
                    "PIS"=>0.0276,
                    "CPP"=>0.42,
                    "ICMS"=>0.335,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                2=>[
                    "IRPJ"=>0.055,
                    "CSLL"=>0.035,
                    "COFINS"=>0.1151,
                    "PIS"=>0.0249,
                    "CPP"=>0.375,
                    "IPI"=>0.075,
                    "ICMS"=>0.32,
                    "ISS"=>0.0
                ],
                3=>[
                    "IRPJ"=>0.23,
                    "CSLL"=>0.15,
                    "COFINS"=>0.141,
                    "PIS"=>0.0305,
                    "CPP"=>0.2785,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.17
                ],
                4=>[
                    "IRPJ"=>0.188,
                    "CSLL"=>0.192,
                    "COFINS"=>0.1808,
                    "PIS"=>0.0392,
                    "CPP"=>0.0,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.4
                ],
                5=>[
                    "IRPJ"=>0.23,
                    "CSLL"=>0.125,
                    "COFINS"=>0.141,
                    "PIS"=>0.0305000000000001,
                    "CPP"=>0.2385,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.235
                ]
            ],
            "6"=>[
                1=>[
                    "IRPJ"=>0.135,
                    "CSLL"=>0.1,
                    "COFINS"=>0.2827,
                    "PIS"=>0.0613,
                    "CPP"=>0.421,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                2=>[
                    "IRPJ"=>0.085,
                    "CSLL"=>0.075,
                    "COFINS"=>0.2096,
                    "PIS"=>0.0454,
                    "CPP"=>0.235,
                    "IPI"=>0.35,
                    "ICMS"=>0.0,
                    "ISS"=>0.0
                ],
                3=>[
                    "IRPJ"=>0.35,
                    "CSLL"=>0.15,
                    "COFINS"=>0.1603,
                    "PIS"=>0.0347,
                    "CPP"=>0.305,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                4=>[
                    "IRPJ"=>0.535,
                    "CSLL"=>0.215,
                    "COFINS"=>0.2055,
                    "PIS"=>0.0445,
                    "CPP"=>0.0,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ],
                5=>[
                    "IRPJ"=>0.35,
                    "CSLL"=>0.155,
                    "COFINS"=>0.1644,
                    "PIS"=>0.0356,
                    "CPP"=>0.295,
                    "ICMS"=>0.0,
                    "IPI"=>0.0,
                    "ISS"=>0.0
                ]
            ],
        ];
        
        $evento = null;
        if($RBT12 <= 180000){
            $evento = "1";
        }else if($RBT12>  180000  && $RBT12 <= 360000){
            $evento = "2";
        }else if($RBT12>  360000  && $RBT12 <= 720000){
            $evento = "3";
        }else if($RBT12>  720000  && $RBT12 <= 1800000){
            $evento = "4";
        }else if($RBT12>  1800000  && $RBT12 <= 3600000){
            $evento = "5";
        }else if($RBT12>  3600000  && $RBT12 <= 4800000){
            $evento = "6";
        }
        
        $conta_fator_R = $pagamento/$RBT12;
        $resultado_Fator_R = $conta_fator_R * 100;
        if($resultado_Fator_R >= 28){$anexo=3;}
        
        $ALIQEfetiva =  (($RBT12 * $aliquota) - $pclDeduzir) / $RBT12;
        $json +=["aliquotaEfetiva"=>number_format(($ALIQEfetiva * 100), 2, ".", "")];
        
        $ValorTributadoAliquota = $ValorTotalDosServicos * $ALIQEfetiva; 
        $json +=["valorTributadoAliquota"=>number_format($ValorTributadoAliquota, 2, ".", "")];
        
        $valores_recebidos = 0;
        foreach($aliquotaArray[$evento][$anexo] as $key => $value){
            if($value>0 && $value<1){
                $valores_recebidos+=$value;
                $json["dadosAliquota"][$key]+=[$key."_Decimal"=>number_format($value, 4, ".", "")];
                $json["dadosAliquota"][$key]+=[$key."_Percentual"=>number_format(($value * 100), 4, ".", "")];
            }
        }
        $json+=['totalSomaPercentual'=>($valores_recebidos*100)];
        
        $valor_total_aliquota = 0;
        foreach($aliquotaArray[$evento][$anexo] as $key => $value){
            if($value>0 && $value<1){
                $cal=($ValorTributadoAliquota * $value);
                $valor_total_aliquota+=$cal;
                $json["dadosAliquota"][$key]+=[$key."_ValorImposto"=>number_format($cal, 2, ".", "")];
            }
        }
        $json+=["erros"=> $this->Validate->getError()];
        exit(json_encode($json));
    }
    
    function nfseAPI(){
        //exit(json_encode($_POST));
        $array_post = array();
        if(isset($_POST['PJ'])){
            $PJ=filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_SPECIAL_CHARS);
            $PJ=preg_replace("/[^0-9]/","",$PJ);
            $array_post+=["PJ"=>$PJ];
        }
        if(isset($_POST['nomeTomador'])){
            $nomeTomador=filter_input(INPUT_POST,'nomeTomador',FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
            $array_post+=["nomeTomador"=>$nomeTomador];
        }
        if(isset($_POST['CpfCnpjTomador'])){
            $CpfCnpjTomador=filter_input(INPUT_POST,'CpfCnpjTomador',FILTER_SANITIZE_SPECIAL_CHARS);
            $CpfCnpjTomador=preg_replace("/[^0-9]/","",$CpfCnpjTomador);
            $array_post+=["CpfCnpjTomador"=>$CpfCnpjTomador];
        }
        if(isset($_POST['cepTomador'])){
            $cepTomador=filter_input(INPUT_POST,'cepTomador',FILTER_SANITIZE_SPECIAL_CHARS);
            $cepTomador=preg_replace("/[^0-9]/","",$cepTomador);
            $array_post+=["cepTomador"=>$cepTomador];
        }
        if(isset($_POST['simplesNacional'])){
            $simplesNacional=filter_input(INPUT_POST,'simplesNacional',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["simplesNacional"=>$simplesNacional];
        }
        if(isset($_POST['localPrestacaoServico'])){
            $localPrestacaoServico=filter_input(INPUT_POST,'localPrestacaoServico',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["localPrestacaoServico"=>$localPrestacaoServico];
        }
        if(isset($_POST['cepServico'])){
            $cepServico = preg_replace("/[^0-9]/","",$_POST['cepServico']);
            $array_post+=["cepServico"=>$cepServico];
        }
        if(isset($_POST['cepIncidencia'])){
            $cepIncidencia = preg_replace("/[^0-9]/","",$_POST['cepIncidencia']);
            $array_post+=["cepIncidencia"=>$cepIncidencia];
        }
        if(isset($_POST['atividade'])){
            $atividade=filter_input(INPUT_POST,'atividade',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["atividade"=>$atividade];
        }
        if(isset($_POST['codServico'])){
            $codServico=filter_input(INPUT_POST,'codServico',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $array_post+=["codServico"=>$codServico];
        }
        if(isset($_POST['codTribMunicipal'])){
            $codTribMunicipal=filter_input(INPUT_POST,'codTribMunicipal',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["codTribMunicipal"=>$codTribMunicipal];
        }
        if(isset($_POST['codTribMunicipalCad'])){
            $codTribMunicipalCad=filter_input(INPUT_POST,'codTribMunicipalCad',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["codTribMunicipalCad"=>$codTribMunicipalCad];
        }
        if(isset($_POST['DescricaoTribMunicipal'])){
            $DescricaoTribMunicipal=filter_input(INPUT_POST,'DescricaoTribMunicipal',FILTER_SANITIZE_SPECIAL_CHARS);
            $array_post+=["DescricaoTribMunicipal"=>$DescricaoTribMunicipal];
        }
        if(isset($_POST['incentivadorCultural'])){
            $incentivadorCultural = filter_input(INPUT_POST,'incentivadorCultural',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["incentivadorCultural"=>$incentivadorCultural];
        }
        if(isset($_POST['inscricaoMunicipal'])){
            $inscricaoMunicipal = preg_replace("/[^0-9]/","",$_POST['inscricaoMunicipal']);
            $array_post+=["inscricaoMunicipal"=>$inscricaoMunicipal];
        }
        if(isset($_POST['naturezaOperacao'])){
            $naturezaOperacao=filter_input(INPUT_POST,'naturezaOperacao',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["naturezaOperacao"=>$naturezaOperacao];
        }
        if(isset($_POST['Prestador'])){
            $Prestador=filter_input(INPUT_POST,'Prestador',FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
            $array_post+=["Prestador"=>$Prestador];
        }
        if(isset($_POST['Valor'])){
            $Valor=str_replace([".",","],["","."],$_POST['Valor']);
            $Valor=filter_var($Valor,FILTER_VALIDATE_FLOAT);
            $array_post+=["Valor"=>$Valor];
        }
        if(isset($_POST['DescriminacaoDosServicos'])){
            $DescriminacaoDosServicos=filter_input(INPUT_POST,'DescriminacaoDosServicos',FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
            $array_post+=["DescriminacaoDosServicos"=>$DescriminacaoDosServicos];
        }
        
        if(isset($_POST['COFINSValor'])){
            $COFINSValor=(float)str_replace([".",","],["","."],$_POST['COFINSValor']);
            $COFINSValor=filter_var($COFINSValor,FILTER_VALIDATE_FLOAT);
            $array_post+=["COFINSValor"=>$COFINSValor];
        }
        if(isset($_POST['COFINSDecimal'])){
            $COFINSDecimal=(float)filter_input(INPUT_POST,'COFINSDecimal',FILTER_VALIDATE_FLOAT);
            $array_post+=["COFINSDecimal"=>$COFINSDecimal];
        }
        if(isset($_POST['cofinsRetido'])){
            $cofinsRetido=filter_input(INPUT_POST,'cofinsRetido',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["cofinsRetido"=>$cofinsRetido];
        }else{
            $cofinsRetido=2;
            $array_post+=["cofinsRetido"=>$cofinsRetido];
        }
        
        if(isset($_POST['CSLLValor'])){
            $CSLLValor=(float)str_replace([".",","],["","."],$_POST['CSLLValor']);
            $CSLLValor=filter_var($CSLLValor,FILTER_VALIDATE_FLOAT);
            $array_post+=["CSLLValor"=>$CSLLValor];
        }
        if(isset($_POST['CSLLDecimal'])){
            $CSLLDecimal=(float)filter_input(INPUT_POST,'CSLLDecimal',FILTER_VALIDATE_FLOAT);
            $array_post+=["CSLLDecimal"=>$CSLLDecimal];
        }
        if(isset($_POST['csllRetido'])){
            $csllRetido=filter_input(INPUT_POST,'csllRetido',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["csllRetido"=>$csllRetido];
        }else{
            $csllRetido=2;
            $array_post+=["csllRetido"=>$csllRetido];
        }
        
        if(isset($_POST['ISSValor'])){
            $ISSValor=(float)str_replace([".",","],["","."],$_POST['ISSValor']);
            $ISSValor=filter_var($ISSValor,FILTER_VALIDATE_FLOAT);
            $array_post+=["ISSValor"=>$ISSValor];
        }
        if(isset($_POST['ISSDecimal'])){
            $ISSDecimal=(float)filter_input(INPUT_POST,'ISSDecimal',FILTER_VALIDATE_FLOAT);
            $array_post+=["ISSDecimal"=>$ISSDecimal];
        }
        if(isset($_POST['issRetido'])){
            $issRetido=filter_input(INPUT_POST,'issRetido',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["issRetido"=>$issRetido];
        }else{
            $issRetido=2;
            $array_post+=["issRetido"=>$issRetido];
        }
        
        if(isset($_POST['IRPJValor'])){
            $IRPJValor=(float)str_replace([".",","],["","."],$_POST['IRPJValor']);
            $IRPJValor=filter_var($IRPJValor,FILTER_VALIDATE_FLOAT);
            $array_post+=["IRPJValor"=>$IRPJValor];
        }
        if(isset($_POST['IRPJDecimal'])){
            $IRPJDecimal=(float)filter_input(INPUT_POST,'IRPJDecimal',FILTER_VALIDATE_FLOAT);
            $array_post+=["IRPJDecimal"=>$IRPJDecimal];
        }
        if(isset($_POST['irpjRetido'])){
            $irpjRetido=filter_input(INPUT_POST,'irpjRetido',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["irpjRetido"=>$irpjRetido];
        }else{
            $irpjRetido=2;
            $array_post+=["irpjRetido"=>$irpjRetido];
        }
        
        if(isset($_POST['PISValor'])){
            $PISValor=(float)str_replace([".",","],["","."],$_POST['PISValor']);
            $PISValor=filter_var($PISValor,FILTER_VALIDATE_FLOAT);
            $array_post+=["PISValor"=>$PISValor];
        }
        if(isset($_POST['PISDecimal'])){
            $PISDecimal=(float)filter_input(INPUT_POST,'PISDecimal',FILTER_VALIDATE_FLOAT);
            $array_post+=["PISDecimal"=>$PISDecimal];
        }
        if(isset($_POST['pisRetido'])){
            $pisRetido=filter_input(INPUT_POST,'pisRetido',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["pisRetido"=>$pisRetido];
        }else{
            $pisRetido=2;
            $array_post+=["pisRetido"=>$pisRetido];
        }
        
        if(isset($_POST['CPPValor'])){
            $CPPValor=(float)str_replace([".",","],["","."],$_POST['CPPValor']);
            $CPPValor=filter_var($CPPValor,FILTER_VALIDATE_FLOAT);
            $array_post+=["CPPValor"=>$CPPValor];
        }
        if(isset($_POST['CPPDecimal'])){
            $CPPDecimal=(float)filter_input(INPUT_POST,'CPPDecimal',FILTER_VALIDATE_FLOAT);
            $array_post+=["CPPDecimal"=>$CPPDecimal];
        }
        if(isset($_POST['cppRetido'])){
            $cppRetido=filter_input(INPUT_POST,'cppRetido',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["cppRetido"=>$cppRetido];
        }else{
            $cppRetido=2;
            $array_post+=["cppRetido"=>$cppRetido];
        }
        
        if(isset($_POST['IPIValor'])){
            $IPIValor=(float)str_replace([".",","],["","."],$_POST['IPIValor']);
            $IPIValor=filter_var($IPIValor,FILTER_VALIDATE_FLOAT);
            $array_post+=["IPIValor"=>$IPIValor];
        }
        if(isset($_POST['IPIDecimal'])){
            $IPIDecimal=(float)filter_input(INPUT_POST,'IPIDecimal',FILTER_VALIDATE_FLOAT);
            $array_post+=["IPIDecimal"=>$IPIDecimal];
        }
        if(isset($_POST['ipiRetido'])){
            $ipiRetido=filter_input(INPUT_POST,'ipiRetido',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["ipiRetido"=>$ipiRetido];
        }else{
            $ipiRetido=2;
            $array_post+=["ipiRetido"=>$ipiRetido];
        }
        
        if(isset($_POST['ICMSValor'])){
            $ICMSValor=(float)str_replace([".",","],["","."],$_POST['ICMSValor']);
            $ICMSValor=filter_var($ICMSValor,FILTER_VALIDATE_FLOAT);
            $array_post+=["ICMSValor"=>$ICMSValor];
        }
        if(isset($_POST['ICMSDecimal'])){
            $ICMSDecimal=(float)filter_input(INPUT_POST,'ICMSDecimal',FILTER_VALIDATE_FLOAT);
            $array_post+=["ICMSDecimal"=>$ICMSDecimal];
        }
        if(isset($_POST['icmsRetido'])){
            $icmsRetido=filter_input(INPUT_POST,'icmsRetido',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["icmsRetido"=>$icmsRetido];
        }else{
            $icmsRetido=2;
            $array_post+=["icmsRetido"=>$icmsRetido];
        }
        
        
        if(isset($_POST['ValorRecolhidoAliquota'])){
            $ValorRecolhidoAliquota=(float)str_replace([".",","],["","."],$_POST['ValorRecolhidoAliquota']);
            $ValorTotalDosServicos=filter_var($ValorRecolhidoAliquota,FILTER_VALIDATE_FLOAT);
            $array_post+=["ValorRecolhidoAliquota"=>$ValorRecolhidoAliquota];
        }
        
        if(isset($_POST['ValorTotalDosServicos'])){
            $ValorTotalDosServicos=(float)str_replace([".",","],["","."],$_POST['ValorTotalDosServicos']);
            $ValorTotalDosServicos=filter_var($ValorTotalDosServicos,FILTER_VALIDATE_FLOAT);
            $array_post+=["ValorTotalDosServicos"=>$ValorTotalDosServicos];
        }
        if(isset($_POST['ValorTotalDasDeducoes'])){
            $ValorTotalDasDeducoes=(float)str_replace([".",","],["","."],$_POST['ValorTotalDasDeducoes']);
            $ValorTotalDasDeducoes=filter_var($ValorTotalDasDeducoes,FILTER_VALIDATE_FLOAT);
            $array_post+=["ValorTotalDasDeducoes"=>$ValorTotalDasDeducoes];
        }
        if(isset($_POST['DescontosCondicionados'])){
            $DescontosCondicionados=(float)str_replace([".",","],["","."],$_POST['DescontosCondicionados']);
            $DescontosCondicionados=filter_var($DescontosCondicionados,FILTER_VALIDATE_FLOAT);
            $array_post+=["DescontosCondicionados"=>$DescontosCondicionados];
        }
        if(isset($_POST['DescontosIncondicionados'])){
            $DescontosIncondicionados=(float)str_replace([".",","],["","."],$_POST['DescontosIncondicionados']);
            $DescontosIncondicionados=filter_var($DescontosIncondicionados,FILTER_VALIDATE_FLOAT);
            $array_post+=["DescontosIncondicionados"=>$DescontosIncondicionados];
        }
        
        if(isset($_POST['TipoRPS'])){
            $TipoRPS=filter_input(INPUT_POST,'TipoRPS',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["TipoRPS"=>$TipoRPS];
        }
        if(isset($_POST['NdoRPS'])){
            $NdoRPS=filter_input(INPUT_POST,'NdoRPS',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["NdoRPS"=>$NdoRPS];
        }
        if(isset($_POST['SerieDoRPS'])){
            $SerieDoRPS=filter_input(INPUT_POST,'SerieDoRPS',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["SerieDoRPS"=>$SerieDoRPS];
        }
        if(isset($_POST['dataCompetencia'])){
            $dataCompetencia=date_format(date_create($_POST['dataCompetencia']),'Y-m-d H:i:s');
            $dataCompetencia=str_replace(" ","T",$dataCompetencia);
            $array_post+=["dataCompetencia"=>$dataCompetencia];
        }
        /*if(isset($_POST['sim'])){
            $sim=filter_input(INPUT_POST,'sim',FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
            $array_post+=["sim"=>$sim];
        }*/
        if(isset($_POST['QuantasParcelas'])){
            $QuantasParcelas=filter_input(INPUT_POST,'QuantasParcelas',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["QuantasParcelas"=>$QuantasParcelas];
        }
        if(isset($_POST['ValorDaParcela'])){
            $ValorDaParcela=str_replace([".",","],["","."],$_POST['ValorDaParcela']);
            $ValorDaParcela=filter_var($ValorDaParcela,FILTER_VALIDATE_FLOAT);
            $array_post+=["ValorDaParcela"=>$ValorDaParcela];
        }
        if(isset($_POST['NumeroDaFatura'])){
            $NumeroDaFatura=filter_input(INPUT_POST,'NumeroDaFatura',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["NumeroDaFatura"=>$NumeroDaFatura];
        }
        if(isset($_POST['FormaDePagamento'])){
            $FormaDePagamento=filter_input(INPUT_POST,'FormaDePagamento',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["FormaDePagamento"=>$FormaDePagamento];
        }
        /*if(isset($_POST['simser'])){
            $simser=filter_input(INPUT_POST,'simser',FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
            $array_post+=["simser"=>$simser];
        }*/
        if(isset($_POST['CodigoDeServico'])){
            $codSer=filter_var($_POST['CodigoDeServico'],FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $array_post+=["codSer"=>$codSer];
        }
        if(isset($_POST['DescricaoServico'])){
            $DescricaoServico = filter_var($_POST['DescricaoServico'],FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
            $array_post+=["DescricaoServico"=>$DescricaoServico];
        }
        
        $dataEmissao=date('Y-m-d H:i:s');
        $dataEmissao=str_replace(" ","T",$dataEmissao);
        $array_post+=["dataEmissao"=>$dataEmissao];
        
        if((int)$simplesNacional==1){
            if($issRetido==2){$ISSValor=0;}
            if($irpjRetido==2){$IRPJValor=0;}
            if($pisRetido==2){$PISValor=0;}
            if($cofinsRetido==2){$COFINSValor=0;}
            if($csllRetido==2){$CSLLValor=0;}
            if($cppRetido==2){$CPPValor=0;}
            if($ipiRetido==2){$IPIValor=0;}
            if($icmsRetido==2){$ICMSValor=0;}
        }
        
        //exit(json_encode($array_post));
        
        if(empty($codSer) || empty($DescricaoServico)){
            $codServico=(float)$codServico;
        }else{
            $this->Validate->validateInsertListaServico([
                "cod"=>$codSer,
                "cnpj"=>$PJ,
                "descricao"=>$DescricaoServico
            ]);
            $codServico = (float)$codSer;
        }
    
        if(isset($_POST['codTribMunicipalCad']) && isset($_POST['DescricaoTribMunicipal'])){
            if(empty($codTribMunicipalCad)==true || empty($DescricaoTribMunicipal)==true){
                
            }else{
                $this->Validate->validateInsertTributosMunicipais([
                    "cod"=>(string)$codTribMunicipalCad,
                    "cnpj"=>(string)$PJ,
                    "descricao"=>(string)$DescricaoTribMunicipal
                ]);
                $codTribMunicipal = $codTribMunicipalCad;
            }
           
        }    
        
        
        if(strlen($CpfCnpjTomador)>11){
            $cnpjTomador = $CpfCnpjTomador;
        }else{
            $cpfTomador = $CpfCnpjTomador;
        }
        
        $dadosDoPJ = $this->Validate->validateGetPJ($PJ);
        
        $TPEndereco = explode(" ",$dadosDoPJ['Endereco']);
        $dadosDoPJ['CEP'] = preg_replace("/[^0-9]/","",$dadosDoPJ['CEP']);
        
        $request=json_decode($this->RequestJSON->request("https://viacep.com.br/ws/{$dadosDoPJ['CEP']}/json/","GET"),true);
        $CodigoMunicipal = $request['ibge'];
        
        $request=json_decode($this->RequestJSON->request("https://viacep.com.br/ws/{$cepIncidencia}/json/","GET"),true);
        $CodigoMunicipalIncidencia = $request['ibge'];
        
        $request=json_decode($this->RequestJSON->request("https://receitaws.com.br/v1/cnpj/{$PJ}","GET"),true);
        
        $NomeFantasia = $request['fantasia'];
        $NomePJ = $request['nome'];
        
        $requestTomador=json_decode($this->RequestJSON->request("https://viacep.com.br/ws/{$cepTomador}/json/","GET"),true);
        
        $TPEnderecoTomador = explode(" ",$requestTomador['logradouro']);
        
        $requestServico=json_decode($this->RequestJSON->request("https://viacep.com.br/ws/{$cepServico}/json/","GET"),true);
        
        /*"LocalPrestacao" => array(
            "SerEndTpLgr" => "",
            "SerEndLgr" => "",
            "SerEndNumero" => "",
            "SerEndComplemento" => "",
            "SerEndBairro" => '',
            "SerEndxMun" => "",
            "SerEndcMun" => 0,
            "SerEndCep" => 0,
            "SerEndSiglaUF" => "",
        ),
        "ListaItens" => array(
            array(
                "ItemSeq" => (int)1,
                "ItemCod" => (string)1,
                "ItemDesc" =>(string)"",
                "ItemQtde" => (int)1,
                "ItemvUnit" => (int)399,
                "ItemuMed" => (string)"UN",
                "ItemvlDed" => (int)0,
                "ItemcCnae" => (string)$atividade,
                "ItemTributMunicipio" => (string)$codTribMunicipal,
                "ItemvIss" => (float)11.97,
                "ItemvDesconto" => (float)0,
                "ItemAliquota" => (float)0.03,
                "ItemVlrTotal" => (float)399,
                "ItemBaseCalculo" => (float)399,
                "ItemvlrISSRetido" => (float)0,
                "ItemIssRetido" => (int)$issRetido,
                "ItemIteListServico" => (string)$codServico,
                "ItemExigibilidadeISS" => (int)$naturezaOperacao,
                "ItemVlrLiquido" => (float)399
            )
        ),
        */
        
        $ValOutrasRetencoes = (float)$IPIValor + (float)$ICMSValor;
        $ValBaseCalculo = ((float)$ValorTotalDosServicos-(float)$ValorTotalDasDeducoes)-(float)$DescontosIncondicionados;
        $ValLiquido = (float)$ValBaseCalculo - (float)$ValorRecolhidoAliquota;
        
        $arrayNFSE = array(
            array(
                "Documento" => array(
                    "ModeloDocumento" => "NFSE",
                    "Versao" => "1",
                    "RPS" => array(
                        array(
                            "RPSNumero" => (int)$NdoRPS,
                            "RPSSerie" => (string)$SerieDoRPS,
                            "RPSTipo" => (int)1,
                            "dEmis" => (string)$dataEmissao,
                            "dCompetencia" => (string)$dataCompetencia,
                            "LocalPrestServ" => (int)$localPrestacaoServico,
                            "natOp" => (int)$naturezaOperacao,
                            "OptSN" => (int)$simplesNacional,
                            "IncCult" => (int)$incentivadorCultural,
                            "Status" => (int)1,
                            "tpAmb" => (int)1,
                            "NFSOutrasinformacoes" =>(string)"",
                            "Arquivo" =>(string)"",
                            "ExtensaoArquivo" =>(string)"",
                            
                            "Prestador" => array(
                                "CNPJ_prest" => (string)$PJ,
                                "xNome" => (string)$NomePJ,
                                "xFant" => (string)$NomeFantasia,
                                "IM" => (string)$inscricaoMunicipal,
                                "enderPrest" => array(
                                    "TPEnd" => (string)$TPEndereco[0],
                                    "xLgr" => (string)$dadosDoPJ['Endereco'],
                                    "nro" => (string)$dadosDoPJ['NumeroEndereco'],
                                    "xCpl" => (string)$dadosDoPJ['Complemento'],
                                    "xBairro" => (string)$dadosDoPJ['Bairro'],
                                    "cMun" => (int)$CodigoMunicipal,
                                    "UF" => (string)$dadosDoPJ['UF'],
                                    "CEP" => (string)$dadosDoPJ['CEP']
                                )
    
                            ),
    
                            "Servico" => array(
                                
                                "Valores" => array(
                                    "RespRetencao"=>(int)0,
                                    "Tributavel"=>(string)"",
                                    "ValDeducoes"=>(float)$ValorTotalDasDeducoes,
                                    "ValServicos" => (float)$ValorTotalDosServicos,
                                    "ValISS" => (float)$ISSValor,
                                    "ValPIS"=>(float)$PISValor,
                                    "ValCOFINS"=>(float)$COFINSValor,
                                    "ValIR"=>(float)$IRPJValor,
                                    "ValCSLL"=>(float)$CSLLValor,
                                    "ValCpp"=>(float)$CPPValor,
                                    "ValINSS"=>(float)$CPPValor,
                                    "ValOutrasRetencoes"=>(float)$ValOutrasRetencoes,
                                    "ValAliqISS" => (float)$ISSDecimal,    
                                    "ValAliqPIS" => (float)$PISDecimal,    
                                    "ValAliqCOFINS" => (float)$COFINSDecimal,    
                                    "ValAliqIR" => (float)$IRPJDecimal,    
                                    "ValAliqCSLL" => (float)$CSLLDecimal, 
                                    "ValAliqCpp" => (float)$CPPDecimal, 
                                    "ValAliqINSS" => (float)$CPPDecimal, 
                                    "ISSRetido" =>(int)$issRetido,
                                    "PISRetido"=>(int)$pisRetido,
                                    "COFINSRetido"=>(int)$cofinsRetido,
                                    "IRRetido"=>(int)$irpjRetido,
                                    "CSLLRetido"=>(int)$csllRetido,
                                    "CppRetido"=>(int)$cppRetido,
                                    "INSSRetido"=>(int)0,
                                    "ValISSRetido"=>(float)0,
                                    "ValDescIncond"=>(float)$DescontosIncondicionados,
                                    "ValDescCond"=>(float)$DescontosCondicionados,
                                    "ValBaseCalculo" =>(float)$ValBaseCalculo,
                                    "ValLiquido" => (float)$ValLiquido,
                                    "ValAliqISSoMunic"=>(float)0,
                                    "InfValPIS"=>(float)0,
                                    "InfValCOFINS"=>(float)0
                                    
                                ),
                                
                                "IteListServico" => (string)$codServico,
                                "Cnae" => (int)$atividade,
                                "TributMunicipio" => (string)$codTribMunicipal,
                                "TributMunicDesc" => (string)$DescricaoTribMunicipal,
                                "Discriminacao" => (string)$DescriminacaoDosServicos,
                                "cMun" => (int)$requestServico['ibge'],
                                "cMunIncidencia"=> (int)$CodigoMunicipalIncidencia
                            ),
    
                            "Tomador" => array(
                                "TomaCNPJ" => (string)$cnpjTomador,
                                "TomaCPF" => (string)$cpfTomador,
                                "TomaIM"=>(string)"",
                                "TomaRazaoSocial" => (string)$nomeTomador,
                                "TomaEndereco" =>(string)$requestTomador['logradouro'],
                                "TomaComplemento" => (string)$requestTomador['complemento'], 
                                "TomaBairro" => (string)$requestTomador['bairro'],
                                "TomacMun" => (int)$requestTomador['ibge'],
                                "TomaUF" => (string)$requestTomador['uf'],
                                "TomaCEP" => (int)$cepTomador,
                                "TomaTelefone"=>(string)"",
                                "TomaEmail"=>(string)"",
                                "TomaSite"=>(string)""
                                
                            )
                        )
                    )
                )
            )
        );

        exit(json_encode($arrayNFSE));
        
        $time = time();
        $payLoader = array(
            "iat"=>$time,
            "exp"=>$time + 120,
            "sub"=>$PJ,
            "partnerKey"=>PATNER_KEY
        );
        
        $token=$this->JWT->jwtEncode($payLoader,KEY_PROD);
        
        //exit(json_encode($token));
        
        $requestToken=json_decode($this->RequestJSON->request(PROD.CREATE_ACCESS_KEY,"POST",$token),true);
        
        //exit(json_encode($requestToken));
        
        $header = array(
            "Authorization:{$requestToken['accessToken']}",
            "Content-Type:application/json"
        );
        $json = json_encode($arrayNFSE);
        $requestNFSe=json_decode($this->RequestJSON->request(PROD.DOCNOTAS."nfse?type=Emissao","POST",$json,$header),true);
        
        echo(json_encode([
            'erros'=>$this->Validate->getError(),
            'sucessos'=>$this->Validate->getMessage(),
            'retorno'=>$requestNFSe
        ]));
        
    }
    
    function enviar(){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        $xml = $_FILES['certificado']['tmp_name'];
        $txt=$this->ConvertNFePHP->nfexml2txt($xml);
        var_dump($txt);
        exit();
        if($_FILES['certificado']){
           /* $certificado=file_get_contents($_FILES['certificado']['tmp_name']);
            var_dump($certificado);*/
            //var_dump(base64_encode());
        }
        //Caminho do Certificado
        /*$pfxCertPrivado = 'certificado.pfx';
        $cert_password  = 'senha';
        
        if (!file_exists($pfxCertPrivado)) {
           echo "Certificado n���o encontrado!! " . $pfxCertPrivado;
        }
        
        $pfxContent = file_get_contents($pfxCertPrivado);
        
        if (!openssl_pkcs12_read($pfxContent, $x509certdata, $cert_password)) {
           echo "O certificado n���o pode ser lido!!";
        } else {
        
           $CertPriv   = array();
           $CertPriv   = openssl_x509_parse(openssl_x509_read($x509certdata['cert']));
        
           $PrivateKey = $x509certdata['pkey'];
        
           $pub_key = openssl_pkey_get_public($x509certdata['cert']);
           $keyData = openssl_pkey_get_details($pub_key);
        
           $PublicKey  = $keyData['key'];
        
           echo '<br>'.'<br>'.'--- Dados do Certificado ---'.'<br>'.'<br>';
           echo $CertPriv['name'].'<br>';                           //Nome
           echo $CertPriv['hash'].'<br>';                           //hash
           echo $CertPriv['subject']['C'].'<br>';                   //Pa���s
           echo $CertPriv['subject']['ST'].'<br>';                  //Estado
           echo $CertPriv['subject']['L'].'<br>';                   //Munic���pio
           echo $CertPriv['subject']['CN'].'<br>';                  //Raz���o Social e CNPJ / CPF
           echo date('d/m/Y', $CertPriv['validTo_time_t'] ).'<br>'; //Validade
           echo $CertPriv['extensions']['subjectAltName'].'<br>';   //Emails Cadastrados separado por ,
           echo $CertPriv['extensions']['authorityKeyIdentifier'].'<br>'; 
           echo $CertPriv['issuer']['OU'].'<br>';                   //Emissor 
           echo '<br>'.'<br>'.'--- Chave P���blica ---'.'<br>'.'<br>';
           print_r($PublicKey);
           echo '<br>'.'<br>'.'--- Chave Privada ---'.'<br>'.'<br>';
           echo $PrivateKey;
        }*/
    }
    
    function cadastroempresaapi(){
        $a=array();
        if(isset($_POST['CNPJ'])){
            $CNPJ=filter_input(INPUT_POST,'CNPJ',FILTER_SANITIZE_NUMBER_INT);
            $CNPJ=str_replace("-","",$CNPJ);
            $CNPJ=str_replace(".","",$CNPJ);
            array_push($a,$CNPJ);
        }
        if(isset($_POST['RazaoSocial'])){
            $NomeRazao=filter_input(INPUT_POST,'RazaoSocial',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$NomeRazao);
        }
        if(isset($_POST['Apelido'])){
            $NomeApelido=filter_input(INPUT_POST,'Apelido',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$NomeApelido);
        }
        if(isset($_POST['NomeFantazia'])){
            $NomeFantasia=filter_input(INPUT_POST,'NomeFantazia',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$NomeFantasia);
        }
        if(isset($_POST['Email'])){
            $Email=filter_input(INPUT_POST,'Email',FILTER_SANITIZE_EMAIL);
            array_push($a,$Email);
        }
        if(isset($_POST['Tel'])){
            $Telefone=filter_input(INPUT_POST,'Tel',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$Telefone);
        }
        if(isset($_POST['Cep'])){
            $Cep=(int)filter_input(INPUT_POST,'Cep',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$Cep);
        }
        if(isset($_POST['Endereco'])){
            $Endereco=filter_input(INPUT_POST,'Endereco',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$Endereco);
        }
        if(isset($_POST['TipoEndereco'])){
            $TipoEndereco=filter_input(INPUT_POST,'TipoEndereco',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$TipoEndereco);
        }
        if(isset($_POST['Numero'])){
            $Numero=filter_input(INPUT_POST,'Numero',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$Numero);
        }
        if(isset($_POST['Complemento'])){
            $Complemento=filter_input(INPUT_POST,'Complemento',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$Complemento);
        }
        if(isset($_POST['Bairro'])){
            $Bairro=filter_input(INPUT_POST,'Bairro',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$Bairro);
        }
        if(isset($_POST['Cidade'])){
            $Cidade=filter_input(INPUT_POST,'Cidade',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$Cidade);
        }
        if(isset($_POST['Uf'])){
            $Uf=filter_input(INPUT_POST,'Uf',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$Uf);
        }
        if(isset($_POST['filial'])){
            $filial=filter_input(INPUT_POST,'filial',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$filial);
        }
        if(isset($_POST['cnaeText'])){
            $cnaeText=filter_input(INPUT_POST,'cnaeText',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$cnaeText);
        }
        if(isset($_POST['cnaeCode'])){
            $cnaeCode=(int)filter_input(INPUT_POST,'cnaeCode',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$cnaeCode);
        }
        if(isset($_POST['Matriz'])){
            $Matriz=(int)filter_input(INPUT_POST,'Matriz',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$Matriz);
        }
        if(isset($_POST['InscricaoEstadual'])){
            $InscricaoEstadual=(int)filter_input(INPUT_POST,'InscricaoEstadual',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$InscricaoEstadual);
        }
        if(isset($_POST['InscricaoMunicipal'])){
            $InscricaoMunicipal=(int)filter_input(INPUT_POST,'InscricaoMunicipal',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$InscricaoMunicipal);
        }
        if(isset($_POST['CRT'])){
            $CRT=(int)filter_input(INPUT_POST,'CRT',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$CRT);
        }
        if(isset($_POST['TipoCertificado'])){
            $TipoCertificado=filter_input(INPUT_POST,'TipoCertificado',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$TipoCertificado);
        }
        if(isset($_POST['ApelidoGE'])){
            $ApelidoGE=filter_input(INPUT_POST,'ApelidoGE',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$ApelidoGE);
        }
        if(isset($_POST['Senha'])){
            $Senha=filter_input(INPUT_POST,'Senha',FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($a,$Senha);
        }
        if(isset($_POST['ModuloNFSe'])){
            $ModuloNFSe=strtolower(filter_input(INPUT_POST,'ModuloNFSe',FILTER_SANITIZE_SPECIAL_CHARS));
            if($ModuloNFSe=="on"){$ModuloNFSe=true;}else{$ModuloNFSe=false;}
            array_push($a,$ModuloNFSe);
        }
        if(isset($_POST['ModuloNFe'])){
            $ModuloNFe=strtolower(filter_input(INPUT_POST,'ModuloNFe',FILTER_SANITIZE_SPECIAL_CHARS));
            if($ModuloNFe=="on"){$ModuloNFe=true;}else{$ModuloNFe=false;}
            array_push($a,$ModuloNFe);
        }
        if(isset($_POST['ModuloMDFe'])){
            $ModuloMDFe=strtolower(filter_input(INPUT_POST,'ModuloMDFe',FILTER_SANITIZE_SPECIAL_CHARS));
            if($ModuloMDFe=="on"){$ModuloMDFe=true;}else{$ModuloMDFe=false;}
            array_push($a,$ModuloMDFe);
        }
        if(isset($_POST['ModuloNFCe'])){
            $ModuloNFCe=strtolower(filter_input(INPUT_POST,'ModuloNFCe',FILTER_SANITIZE_SPECIAL_CHARS));
            if($ModuloNFCe=="on"){$ModuloNFCe=true;}else{$ModuloNFCe=false;}
            array_push($a,$ModuloNFCe);
        }
        if(isset($_POST['ModuloCTe'])){
            $ModuloCTe=strtolower(filter_input(INPUT_POST,'ModuloCTe',FILTER_SANITIZE_SPECIAL_CHARS));
            if($ModuloNFCe=="on"){$ModuloCTe=true;}else{$ModuloCTe=false;}
            array_push($a,$ModuloCTe);
        }
        
        if(isset($_FILES['arqCertificado'])){
            $tipo = pathinfo($_FILES['arqCertificado']['name'],PATHINFO_EXTENSION);
            if($tipo!='pfx'){die("Arquivo não permitido");}
            $certificadoArq = $_FILES['arqCertificado']['tmp_name'];
            $certificadoArq = base64_encode(file_get_contents($certificadoArq));
            //$senhaCertificado='1234pj';
            //openssl_pkcs12_read($certificado,$certificado_info,"1234pj");
            //var_dump($certificado_info);
        }
       
         
        //$url="https://servicodados.ibge.gov.br/api/v1/localidades/estados/26/municipios";
        $url="https://servicodados.ibge.gov.br/api/v1/localidades/municipios?orderBy=nome";
        $request=$this->RequestJSON->request($url,null);
        $municipios=json_decode($request);
        
        for($i=0;$i<=(count($municipios)-1);$i++){
            $M1=strtolower($municipios[$i]->nome);
            $M2=strtolower($Cidade);
            if($M1==$M2){$CodigoMunicipal=($municipios[$i]->id);}
        }

        //$url = 'https://apibrhomolog.invoicy.com.br/oauth2/invoicy/auth';
        $url="https://apibr.invoicy.com.br/oauth2/invoicy/auth";
        $time = time();
        $payLoader = array(
            "iat"=>$time,
            "exp"=>$time + 120,
            "sub"=>'11316866000122',
            "partnerKey"=>'WO7OOVO/G34tUwRiNnNz7w=='
        );
        
        //$chave="oe7RXXf1611AGbtEpEZLcLInvIub900R";
        $chave="oe7RXXf1611AGbtEpEZLcO3bIGQm0ruO";
        
        $token=$this->JWT->jwtEncode($payLoader,$chave);
    
        $requestToken=$this->RequestJSON->request($url,$token);
        
        /* $Cadastro = array(
            array(
                "EmpNomFantasia"=>$EmpNomFantasia,
                "EmpApelido"=> $EmpApelido,
                "EmpRazSocial"=> $EmpRazSocial,
                "EmpCNPJ"=> $EmpCNPJ,
                "EmpCPF"=> $EmpCPF,
                "EmpIE"=> $EmpIE,
                "EmpTelefone"=> $EmpTelefone,
                "EmpEndereco"=> $EmpEndereco,
                "EmpNumero"=> $EmpNumero,
                "EmpBairro"=> $EmpBairro,
                "EmpCEP"=> $EmpCEP,
                "EmpComplemento"=> $EmpComplemento,
                "EmpIM"=> $EmpIM,
                "MunCodigo"=> $MunCodigo,
                "EmpCNAE"=> $EmpCNAE,
                "EmpCRT"=> $EmpCRT,
                "EmpIEST"=> $EmpIEST,
                "EmpMarca"=> $EmpMarca,
                "EmpMarcaExtensao"=> $EmpMarcaExtensao,
                "EmpEmail"=> $EmpEmail,
                "EmpObservacao"=> $EmpObservacao,
                "EmpTpoEndereco"=> $EmpTpoEndereco,
                "Certificado"=>$Certificado,
                "Usuarios"=> $Usuarios,
                "CaixaEnvioEmail"=> $CaixaEnvioEmail,
                "CaixasLeituraEmail"=> $CaixasLeituraEmail,
                "Parametros"=> $Parametro,
                "NFSe"=> $NFSe,
                "MDFe"=> $MDFe,
                "NFCe"=> $NFCe,
                "CTe"=> $CTe,
                "Licenciamento"=> $Licenciamento,
                "Impressao"=> $Impressao,
                "Extensao"=> $Extensao
            )
        );*/
    
        $EmpNomFantasia = (string)$NomeFantasia;
        $EmpApelido = (string)$NomeApelido;
        $EmpRazSocial = (string)$NomeRazao;
        $EmpCNPJ = (string)$CNPJ;
        $EmpCPF = "";
        $EmpIE = (string)$InscricaoEstadual;
        $EmpTelefone = (string)$Telefone;
        $EmpEndereco = (string)$Endereco;
        $EmpNumero = (string)$Numero;
        $EmpBairro = (string)$Bairro;
        $EmpCEP = (string)$Cep;
        $EmpComplemento = (string)$Complemento;
        $EmpIM = (string)$InscricaoMunicipal;
        $MunCodigo = (int)$CodigoMunicipal;
        $EmpCNAE = (string)$cnaeCode;
        $EmpCRT = (int)$CRT;
        $EmpIEST = (string)"";
        $EmpMarca = (string)"";
        $EmpMarcaExtensao = (string)"";
        $EmpEmail = (string)$Email;
        $EmpObservacao = (string)"";
        $EmpTpoEndereco = (string)$TipoEndereco;
        $senhaCertificado = (string)$Senha;
        $TipoCertificado = (int)$TipoCertificado;
        $Certificado = array(
            "ArquivoPFX"=> (string)$certificadoArq,
            "Senha"=> (string)$senhaCertificado,
            "TipoCertificado"=> (string)$TipoCertificado
        );
        
        $Licenciamento = array();
        
        if($ModuloNFSe){
            array_push($Licenciamento,array(
                "Modulo"=> "NFSe",
                "Modelo"=> "1",
                "Autor"=> ""
            ));
        }
        if($ModuloMDFe){
            array_push($Licenciamento,array(
                "Modulo"=> "MDFe",
                "Modelo"=> "1",
                "Autor"=> ""
            ));
        }
        if($ModuloNFCe){
            array_push($Licenciamento,array(
                "Modulo"=> "NFCe",
                "Modelo"=> "1",
                "Autor"=> ""
            ));
        }
        if($ModuloCTe){
            array_push($Licenciamento,array(
                "Modulo"=> "CTe",
                "Modelo"=> "1",
                "Autor"=> ""
            ));
        }
        if($ModuloNFe){
            array_push($Licenciamento,array(
                "Modulo"=> "NFe",
                "Modelo"=> "1",
                "Autor"=> ""
            ));
        }
        
        $Usuarios = array(
            /*array(
                "UsrNome"=> "Ana",
                "UsrEmail"=> "email@gmail.com",
                "UsrSenha"=> "789",
                "Permissoes"=>array(
                    "PermissaoCTe"=> array(
                        "Visualizar"=> "S",
                        "Baixar"=> "N"
                    ),
                    "PermissaoMDFe"=> array(
                        "Visualizar"=> "N",
                        "Baixar"=> "N"
                    ),
                    "PermissaoNFSe"=> array(
                        "Visualizar"=> "N",
                        "Baixar"=> "N",
                        "EnviarConsultarDocs"=> "N"
                    ),
                    "PermissaoNFe"=> array(
                        "Visualizar"=> "S",
                        "Baixar"=> "S"
                    ),
                    "PermissaoNFCe"=> array(
                        "Visualizar"=> "N",
                        "Baixar"=> "N"
                    ),
                    "PermissoesGerais"=> array(
                        "ImportarDocumentos"=> "N",
                        "AlterarDadosDoUsuario"=> "N",
                        "AlterarDadosDaEmpresa"=> "N",
                        "AlterarMarcasDaEmpresa"=> "N",
                        "AlterarCertificadosDaEmpresa"=> "N",
                        "AlterarConfiguracoesParametros"=> "N",
                        "CadastrarEmpresas"=> "N",
                        "AlterarCaixasDeEmail"=> "S",
                        "AlterarPermissoesDeUsuario"=> "N",
                        "AdicionarNovosUsuarios"=> "N",
                        "VisualizarChaveAcesso"=> "S",
                        "VisualizarAcoesDeUsuarios"=> "N",
                        "VisualizarQuantidadesEmitidas"=> "S",
                        "VisualizarLicencas"=> "S",
                        "ConfiguracaoSenha"=> "N",
                        "GerarRelatorios"=> "S",
                        "InutilizarDocumentos"=> "S",
                        "FerramentasIntegracao"=> "S"
                    )
                )
            )*/
        );
        
        $CaixaEnvioEmail = array(
            "EmlValCertificado"=> "N",
            "EmlTmpEspera"=> 100,
            "EmlAutenticacao"=> "S",
            "EmlSSL"=> "S",
            "EmlPorta"=> 587 ,
            "EmlHost"=> "smtp.gmail.com",
            "EmlSenha"=> "1234",
            "EmlUsuario"=> "email@gmail.com",
            "EmlNomeRemetente"=> "Rementente",
            "EmlEmailRemetente"=> "remetente@gmail.com"
        );
        
        $CaixasLeituraEmail = array( 
            array(
                "EmlValCertificado"=> "N",
                "EmlTmpEspera"=> 100,
                "EmlAutenticacao"=> "S",
                "EmlSSL"=> "S",
                "EmlPorta"=> 995 ,
                "EmlHost"=> "pop.gmail.com",
                "EmlSenha"=> "1234",
                "EmlUsuario"=> "email@gmail.com",
                "EmlNomeRemetente"=> "Caixa Leitura",
                "EmlEmailRemetente"=> "leitura@gmail.com"
            )
        );
        
        $Parametro  = array(
            "NFe"=> array(
                "FormaRetornoPDFIntegracao"=> 3,
                "FormaRetornoXMLIntegracao"=> 3,
                "UltimoNSU"=> "000000000029704",
                "JustInut"=> "",
                "JustCanc"=> "",
                "JustCont"=> "",
                "TextoEmailAutorizado"=> "",
                "TextoEmailCancelado"=> "",
                "TextoEmailCCe"=> "",
                "EmailTitulo"=> "",
                "EnviarPDFEmail"=> "S",
                "EnviarXMLEmail"=> "S",
                "OrdemContingencia"=>array( 
                        array(
                            "OrdemContingenciaNFe"=> 0
                        )
                )
            )
            
        );
        
        $NFSe = array(
            "CodCMC"=> "0",
            "AmbienteEmissao"=> 2,
            "MaxRPSLote"=> 1,
            "TipoProcessamento"=> "S",
            "UsuarioAutent"=> "",
            "SenhaAutent"=> "",
            "ImprimeNFSeEfetivada"=> "N",
            "EnviarNFSeTomador"=> "S",
            "EmpRetImpPrefeitura"=> "S",
            "EmpConcatOutrasInfo"=> "N",
            "EmpImprimeCanhoto"=> 2,
            "EmpChavePrimaria"=> "",
            "FormaRetornoPDFIntegracao"=> 3,
            "FormaRetornoXmlIntegracao"=> 3,
            "EmpDiscriminacaoBetha"=> "N",
            "EmpAutorizacaoRegimeRPS"=> "",
            "EmpEspelhoNovo"=> "S",
            "EmpEnviaCPFPrestador"=> "N",
            "VerCodigo"=> 0,
            "DataAdesaoSimplesNacional"=> "0000-00-00",
            "EmpEnviaEmailCompactado"=> "S",
            "ImprimeItensEspelho"=> "S",
            "EmpClientId"=> "",
            "EmpClientSecret"=> "",
            "EmpImgRodapeBase64"=> "",
            "FaixaRPSAutorizadoInicial"=> 0,
            "FaixaRPSAutorizadoFinal"=> 0,
            "ImprimirOutrasInformacoes"=> "",
            "ImprimirRetencoesFederais"=> "",
            "XMLRetornoRequisicao"=> "S",
            "NomeCanhoto"=> "",
            "ReceberEmailEmpresaTrancada"=> "",
            "ReenvioAutomatico"=>"S"
        );
        
        $MDFe = array(
            "FormaRetornoPDFIntegracao"=> 0,
            "FormaRetornoXMLIntegracao"=> 0,
            "UltimoNSU"=> "",
            "JustCanc"=> "",
            "JustCont"=> ""
        );
        
        $NFCe = array(
            "FormaRetornoPDFIntegracao"=> 0,
            "FormaRetornoXMLIntegracao"=> 0,
            "IDTokenCscSEFAZ"=> "",
            "CscSEFAZ"=> "",
            "PossuiLeituraX"=> "",
            "JustInut"=> "",
            "JustCanc"=> "",
            "JustCont"=> "",
            "TextoEmailAutorizado"=> "",
            "TextoEmailCancelado"=> "",
            "EmailTitulo"=> "",
            "EnviarPDFEmail"=> "",
            "EnviarXMLEmail"=> "",
            "OrdemContingencia"=> array(
                array(
                    "OrdemContingenciaNFCe"=> 0
                )
            )
        );
        
        $CTe = array(
            "FormaRetornoPDFIntegracao"=> 0,
            "FormaRetornoXMLIntegracao"=> 0,
            "UltimoNSU"=> "",
            "JustInut"=> "",
            "JustCanc"=> "",
            "JustCont"=> "",
            "TextoEmailAutorizado"=> "",
            "TextoEmailCancelado"=> "",
            "TextoEmailCCe"=> "",
            "EmailTitulo"=> "",
            "EnviarPDFEmail"=> "",
            "EnviarXMLEmail"=> "",
            "OrdemContingencia"=> array(
                array(
                    "OrdemContingenciaCTe"=> 0
                )
            )
        );
        
        $Impressao =  array(
            "NFe"=> array(
                "OrientacaoNFe"=> 1,
                "ImprimirDataHoraImpressao"=> "S",
                "ImprimirTributos"=> "3",
                "TextoImpressaoTributos"=> "Impressão dos tributos",
                "ExibirDescontoEIcmsNoItem"=> "N",
                "LocalImpressaoCanhoto"=> "C",
                "MolduraNaLogomarca"=> "S",
                "ModeloDANFE"=> 1,
                "ExibirEndEntregaInfoAdic"=> "N",
                "ImprimirDuplicatas"=> "S",
                "UtilizarImagemInfoEmitente"=> "N",
                "ImprimirVolumesItensDestacados"=> "N",
                "ImprimirTotalPISCOFINS"=> "N",
                "InfoComplementar"=> "",
                "DestaqueProdutosPerigosos"=> "",
                "TamanhoFonteInfComplementares"=> 0,
                "ImprimeUNTribDiferenteComercial"=> "",
                "ImprimirEnderecoEntregaRetirada"=> 0,
                "ImprimirCamposDIFAL"=> "",
                "ImprimirICMSCST51"=> "",
                "TamanhoFonteProdutos"=> "2",
                "TamanhoFonteInfComplementaresProd"=> "2",
                "ImprimirICMSDesonerado"=> "4",
                "ImprimirEmitenteCentralizado"=> "N",
                "ImprimirFatura"=> "S",
                "ImprimirVolumes"=> "S",
                "ImprimirVolumesNegrito"=> "N",
                "ImprimirVolumesEspacados"=> "S",
                "ImprimirItensEspacados"=> "N",
                "AgruparInfoAdicProdutos"=> "N",
                "ImprimirTotalAFRMM"=> "N",
                "ImprimirICMSSTItem"=> "N",
                "ImprimirTotalImpostoImportacao"=> "N",
                "ImprimirFCP"=> "N",
                "ImprimirTextosNegrito"=> "N",
                "ImprimirFCI"=> "N",
                "ImprimirConfirmEntregaCanhoto"=> "N"
            ),
            "MDFe"=> array(
                "OrientacaoMDFe"=> 1,
                "MolduraNaLogomarca"=> "S"
            ),
            "CTe"=> array(
                "OrientacaoCTe"=> 1,
                "MolduraNaLogomarca"=> "S",
                "LocalImpressaoCanhoto"=> "R",
                "TextoImpressaoTributos"=> ""
            ),
            "NFCe"=> array(
                "ModeloDANFE"=> "1",
                "ImpAcrescDescItens"=> "S",
                "FormatoDANFE"=> "D"
            )
        );
        
        $Extensao = array(
            array(
                "TipoExtensao"=> 4,
                "Modulos"=>array(
                    array(
                        "Modulo"=> "NFe"
                    )
                ),
                "ParametrosExt"=> array(
                    "NumeroConsultasDiarias"=> 12,
                    "ArmazenarEveTerceiros"=> "S",
                    "BaixarDocsNaoArmazenados"=> "S",
                    "CienciaAutomatica"=> 1,
                    "Justificativa"=> "",
                    "ValorMin"=> "0.00",
                    "Email"=> "",
                    "TipoNotificacao"=> 0,
                    "BuscarDocsRetroativos"=> ""
                ),
                "Ativar"=> "S"
            ),
            array(
                "TipoExtensao"=> 3,
                "Modulos"=> array(
                    array(
                        "Modulo"=> "NFe"
                    ), 
                    array(
                        "Modulo"=> "CTe"
                    ), 
                    array(
                        "Modulo"=> "MDFe"
                    ), 
                    array(
                        "Modulo"=> "NFSe"
                    ), 
                    array(
                        "Modulo"=> "NFCe"
                    )
                ),
                "ParametrosExt"=> array(
                    "NumeroConsultasDiarias"=> 12,
                    "ArmazenarEveTerceiros"=> "",
                    "BaixarDocsNaoArmazenados"=> "",
                    "CienciaAutomatica"=> 0,
                    "Justificativa"=> "",
                    "ValorMin"=> "0.00",
                    "Email"=> "useremail@mail.com",
                    "TipoNotificacao"=> 0,
                    "BuscarDocsRetroativos"=> "",
                    "TipoConsultaNFSe"=> "E"
                ),
                "Ativar"=> "S"
            )
        );
        
        $Cadastro = array(
            array(
                "EmpNomFantasia"=>$EmpNomFantasia,
                "EmpApelido"=> $EmpApelido,
                "EmpRazSocial"=> $EmpRazSocial,
                "EmpCNPJ"=> $EmpCNPJ,
                "EmpCPF"=> $EmpCPF,
                "EmpIE"=> $EmpIE,
                "EmpTelefone"=> $EmpTelefone,
                "EmpEndereco"=> $EmpEndereco,
                "EmpNumero"=> $EmpNumero,
                "EmpBairro"=> $EmpBairro,
                "EmpCEP"=> $EmpCEP,
                "EmpComplemento"=> $EmpComplemento,
                "EmpIM"=> $EmpIM,
                "MunCodigo"=> $MunCodigo,
                "EmpCNAE"=> $EmpCNAE,
                "EmpCRT"=> $EmpCRT,
                "EmpIEST"=> $EmpIEST,
                "EmpMarca"=> $EmpMarca,
                "EmpMarcaExtensao"=> $EmpMarcaExtensao,
                "EmpEmail"=> $EmpEmail,
                "EmpObservacao"=> $EmpObservacao,
                "EmpTpoEndereco"=> $EmpTpoEndereco,
                "Certificado"=>$Certificado,
                "Licenciamento"=> $Licenciamento
            )
        );
        
        // echo(json_encode($Cadastro));
        
        // exit();
   
        $requestToken=json_decode($requestToken);
        //var_dump($a->accessToken);
        $url='https://apibr.invoicy.com.br/companies';
        $header=[
            'Content-Type:application/json',
            "Authorization:Bearer {$requestToken->accessToken}"
        ];
        
        //var_dump($header);

        $Cadastro=json_encode($Cadastro,JSON_INVALID_UTF8_IGNORE);
        $retorno=$this->RequestJSON->request($url,$Cadastro,$header);
        echo $retorno;
    }
    
    function base64UrlEncod($data){
        return str_replace(['+','/','='],['-','_',''],base64_encode($data));
    }
    
    function jwt(){
        $url = 'https://apibrhomolog.invoicy.com.br/oauth2/invoicy/auth';
        $hearder = array(
            "alg"=>'HS256',
            "typ"=>'JWT'
        );
    
        $hearder = json_encode($hearder);
        $hearder = $this->base64UrlEncode($hearder);
        
        
        $time = time();
        $payLoader = array(
            "iat"=>$time,
            "exp"=>$time + 120,
            "sub"=>'11316866000122',
            "partnerKey"=>'WO7OOVO/G34tUwRiNnNz7w=='
        );
        
        $payLoader = json_encode($payLoader);
        $payLoader = $this->base64UrlEncode($payLoader);
    
        $chave="oe7RXXf1611AGbtEpEZLcLInvIub900R";
        
        $signature = hash_hmac('sha256', "{$hearder}.{$payLoader}",$chave,true);
        
        $signature = $this->base64UrlEncode($signature);
        $token = "{$hearder}.{$payLoader}.{$signature}";
        //exit($token);
        $tokenJSON = array("token"=>$token);
        
        $tokenJSON = json_encode($tokenJSON);
        
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $tokenJSON);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $resultado = curl_exec($ch);
        
        curl_close($ch);
        
        echo '<pre>'.print_r(json_decode($resultado),true).'</pre>';
        }
        
        function leitornotafiscal(){
        $url = 'http://nfce.sefaz.pe.gov.br/nfce-web/consultarNFCe?p=26221018538487000207650060000312911060478578|2|1|1|E99A5C4FDC4D206BE753BD8609311CBB820215E0';
        $result=simplexml_load_file($url);
        //var_dump($result->proc->nfeProc->NFe->infNFe->pag);
        /*foreach($result->proc->nfeProc->NFe->infNFe->pag->detPag->vPag as $array){
            var_dump($array);
        }*/
        $valor=$result->proc->nfeProc->NFe->infNFe->emit->xNome;
        var_dump($valor);
    }
    
    function email(){
        
        if(isset($_POST['assunto']) && isset($_POST['corpo']) && isset($_POST['email'])){
            $this->Mail->sendMail($_POST['email'],"Mateus",null,$_POST['assunto'],$_POST['corpo']);
            /*echo"{$_POST['email']}";
            echo"{$_POST['assunto']}";
            echo"{$_POST['corpo']}";*/
        }else{
            echo"NOP";
        }
    }
    
    function notafiscalcomercil(){
        if(isset($_FILES['xml'])){
            
            foreach($_FILES['xml']["tmp_name"] as $tmp_name){
                $xml = simplexml_load_file($tmp_name);
                var_dump($xml->protNFe);
            }
            
        }
    }
    
    function notafiscal(){

        if(isset($_FILES['xml'])){
            $c=true;
            
            foreach($_FILES['xml']["error"] as $error){if($error!=0){$c=false;}}
            $alfa=[];
            $omega=[];
            $beta=[];
            if($c){
                foreach($_FILES['xml']["tmp_name"] as $tmp_name){
                    
                    $xml = simplexml_load_file($tmp_name);
                    $file=$_FILES['xml']["name"];
                    //Nota Fical Bruta 
                    foreach($xml->ListaNfse->CompNfse as $reg){
                        
                        $ID=md5(uniqid (rand(),true));
                        //Nota Fical Bruta 
                        $Numero = (int)filter_var($reg->Nfse->InfNfse->Numero,FILTER_SANITIZE_SPECIAL_CHARS);
                        $CodigoVerificacao = (string)filter_var($reg->Nfse->InfNfse->CodigoVerificacao,FILTER_SANITIZE_SPECIAL_CHARS);
                        $DataEmissao = (string)str_replace("T"," ",filter_var($reg->Nfse->InfNfse->DataEmissao,FILTER_SANITIZE_SPECIAL_CHARS));
                        $NaturezaOperacao = (int)filter_var($reg->Nfse->InfNfse->NaturezaOperacao,FILTER_SANITIZE_SPECIAL_CHARS);
                        $OptanteSimplesNacional = (int)filter_var($reg->Nfse->InfNfse->OptanteSimplesNacional,FILTER_SANITIZE_SPECIAL_CHARS);
                        $IncentivadorCultural = (float)filter_var($reg->Nfse->InfNfse->IncentivadorCultural,FILTER_SANITIZE_SPECIAL_CHARS);
                        $Competencia = (string)str_replace("T"," ",filter_var($reg->Nfse->InfNfse->Competencia,FILTER_SANITIZE_SPECIAL_CHARS));
                        $ValorCredito = (float)filter_var($reg->Nfse->InfNfse->ValorCredito,FILTER_SANITIZE_SPECIAL_CHARS);
                        $CodigoMunicipio = (int)filter_var($reg->Nfse->InfNfse->OrgaoGerador->CodigoMunicipio,FILTER_SANITIZE_SPECIAL_CHARS);
                        $Uf = (string)filter_var($reg->Nfse->InfNfse->OrgaoGerador->Uf,FILTER_SANITIZE_SPECIAL_CHARS);
                        
                        //Servico
                        $ValorServicos = (int)filter_var($reg->Nfse->InfNfse->Servico->Valores->ValorServicos,FILTER_SANITIZE_SPECIAL_CHARS);
                        $IssRetido = (int)filter_var($reg->Nfse->InfNfse->Servico->Valores->IssRetido,FILTER_SANITIZE_SPECIAL_CHARS);
                        $ValorIss = (float)filter_var($reg->Nfse->InfNfse->Servico->Valores->ValorIss,FILTER_SANITIZE_SPECIAL_CHARS);
                        $BaseCalculo = (int)filter_var($reg->Nfse->InfNfse->Servico->Valores->BaseCalculo,FILTER_SANITIZE_SPECIAL_CHARS);
                        $Aliquota = (float)filter_var($reg->Nfse->InfNfse->Servico->Valores->Aliquota,FILTER_SANITIZE_SPECIAL_CHARS);
                        $ValorLiquidoNfse = (int)filter_var($reg->Nfse->InfNfse->Servico->Valores->ValorLiquidoNfse,FILTER_SANITIZE_SPECIAL_CHARS);
                        $ItemListaServico = (int)filter_var($reg->Nfse->InfNfse->Servico->ItemListaServico,FILTER_SANITIZE_SPECIAL_CHARS);
                        $CodigoTributacaoMunicipio = (int)filter_var($reg->Nfse->InfNfse->Servico->CodigoTributacaoMunicipio,FILTER_SANITIZE_SPECIAL_CHARS);
                        $Discriminacao = (string)filter_var($reg->Nfse->InfNfse->Servico->Discriminacao,FILTER_SANITIZE_SPECIAL_CHARS);
                        $CodigoMunicipio = (int)filter_var($reg->Nfse->InfNfse->Servico->CodigoMunicipio,FILTER_SANITIZE_SPECIAL_CHARS);
                        
                        //Prestador
                        if(!empty($reg->Nfse->InfNfse->PrestadorServico->IdentificacaoPrestador->Cnpj)){
                            $cnpjCpfPrestador = (int)filter_var($reg->Nfse->InfNfse->PrestadorServico->IdentificacaoPrestador->Cnpj, FILTER_SANITIZE_SPECIAL_CHARS);
                        }else if(!empty($reg->Nfse->InfNfse->PrestadorServico->IdentificacaoPrestador->Cpf)){
                            $cnpjCpfPrestador = (int)filter_var($reg->Nfse->InfNfse->PrestadorServico->IdentificacaoPrestador->Cpf, FILTER_SANITIZE_SPECIAL_CHARS);
                        }
                            
                        $InscricaoMunicipalPrestador = (int)filter_var($reg->Nfse->InfNfse->PrestadorServico->IdentificacaoPrestador->InscricaoMunicipal,FILTER_SANITIZE_SPECIAL_CHARS);
                        $RazaoSocialPrestador = (string)strtoupper(filter_var($reg->Nfse->InfNfse->PrestadorServico->RazaoSocial,FILTER_SANITIZE_SPECIAL_CHARS));
                        $EnderecoPrestador = (string)strtoupper(filter_var($reg->Nfse->InfNfse->PrestadorServico->Endereco->Endereco,FILTER_SANITIZE_SPECIAL_CHARS));
                        $NumeroEnderecoPrestador = (int)filter_var($reg->Nfse->InfNfse->PrestadorServico->Endereco->Numero,FILTER_SANITIZE_SPECIAL_CHARS);
                        $ComplementoPrestador = (string)filter_var($reg->Nfse->InfNfse->PrestadorServico->Endereco->Complemento,FILTER_SANITIZE_SPECIAL_CHARS);
                        $BairroPrestador = (string)filter_var($reg->Nfse->InfNfse->PrestadorServico->Endereco->Bairro,FILTER_SANITIZE_SPECIAL_CHARS);
                        $CodigoMunicipioPrestador = (int)filter_var($reg->Nfse->InfNfse->PrestadorServico->Endereco->CodigoMunicipio,FILTER_SANITIZE_SPECIAL_CHARS);
                        $UfPrestador = (string)filter_var($reg->Nfse->InfNfse->PrestadorServico->Endereco->Uf,FILTER_SANITIZE_SPECIAL_CHARS);
                        $CepPrestador = (int)filter_var($reg->Nfse->InfNfse->PrestadorServico->Endereco->Cep,FILTER_SANITIZE_SPECIAL_CHARS);
                        $TelefonePrestador = (string)filter_var($reg->Nfse->InfNfse->PrestadorServico->Contato->Telefone,FILTER_SANITIZE_SPECIAL_CHARS);
                        $EmailPrestador = (string)strtolower(filter_var($reg->Nfse->InfNfse->PrestadorServico->Contato->Email,FILTER_SANITIZE_SPECIAL_CHARS));
                        
                        //Tomador
                        if(!empty($reg->Nfse->InfNfse->TomadorServico->IdentificacaoTomador->CpfCnpj->Cnpj)){
                            $cnpjCpfTomador = (int)filter_var($reg->Nfse->InfNfse->TomadorServico->IdentificacaoTomador->CpfCnpj->Cnpj,FILTER_SANITIZE_SPECIAL_CHARS);
                        }else if(!empty($reg->Nfse->InfNfse->TomadorServico->IdentificacaoTomador->CpfCnpj->Cpf)){
                            $cnpjCpfTomador = (int)filter_var($reg->Nfse->InfNfse->TomadorServico->IdentificacaoTomador->CpfCnpj->Cpf,FILTER_SANITIZE_SPECIAL_CHARS);
                        }
                            
                        $InscricaoMunicipalTomador = (int)filter_var($reg->Nfse->InfNfse->TomadorServico->IdentificacaoTomador->InscricaoMunicipal,FILTER_SANITIZE_SPECIAL_CHARS)."<br>";
                        $RazaoSocialTomador = (string)strtoupper(filter_var($reg->Nfse->InfNfse->TomadorServico->RazaoSocial,FILTER_SANITIZE_SPECIAL_CHARS));
                        $EnderecoTomador = (string)strtoupper(filter_var($reg->Nfse->InfNfse->TomadorServico->Endereco->Endereco,FILTER_SANITIZE_SPECIAL_CHARS));
                        $NumeroEnderecoTomador = (int)filter_var($reg->Nfse->InfNfse->TomadorServico->Endereco->Numero,FILTER_SANITIZE_SPECIAL_CHARS);
                        $ComplementoTomador= (string)filter_var($reg->Nfse->InfNfse->TomadorServico->Endereco->Complemento,FILTER_SANITIZE_SPECIAL_CHARS);
                        $BairroTomador = (string)filter_var($reg->Nfse->InfNfse->TomadorServico->Endereco->Bairro,FILTER_SANITIZE_SPECIAL_CHARS);
                        $CodigoMunicipioTomador = (int)filter_var($reg->Nfse->InfNfse->TomadorServico->Endereco->CodigoMunicipio,FILTER_SANITIZE_SPECIAL_CHARS);
                        $UfTomador = (string)filter_var($reg->Nfse->InfNfse->TomadorServico->Endereco->Uf,FILTER_SANITIZE_SPECIAL_CHARS);
                        $CepTomador = (int)filter_var($reg->Nfse->InfNfse->TomadorServico->Endereco->Cep,FILTER_SANITIZE_SPECIAL_CHARS);
                        $TelefoneTomador = (string)filter_var($reg->Nfse->InfNfse->TomadorServico->Contato->Telefone,FILTER_SANITIZE_SPECIAL_CHARS);
                        $EmailTomador = (string)strtolower(filter_var($reg->Nfse->InfNfse->TomadorServico->Contato->Email,FILTER_SANITIZE_SPECIAL_CHARS));
                        
                        
                        /*$this->Validate->validateFilds([
                            "Numero"=>$Numero,
                            "CodigoVerificacao"=>$CodigoVerificacao
                        ]);*/
                        
                        if(!empty($Numero)&&!empty($CodigoVerificacao)){
                            
                            $g1=$this->Validate->validateInsertNotaFiscalBruta([
                                "ID"=>$ID,
                                "Numero"=>$Numero,
                                "CodigoVerificacao"=>$CodigoVerificacao,
                                "cnpjCpfPrestador"=>$cnpjCpfPrestador,
                                "DataEmissao"=>$DataEmissao,
                                "NaturezaOperacao"=>$NaturezaOperacao,
                                "OptanteSimplesNacional"=>$OptanteSimplesNacional,
                                "IncentivadorCultural"=>$IncentivadorCultural,
                                "Competencia"=>$Competencia,
                                "ValorCredito"=>$ValorCredito,
                                "CodigoMunicipio"=>$CodigoMunicipio,
                                "Uf"=>$Uf
                            ]);
                            
                            $g2=$this->Validate->validateInsertNotaFiscalServico([
                                "ID"=>$ID,
                                "Numero"=>$Numero,
                                "CodigoVerificacao"=>$CodigoVerificacao,
                                "Competencia"=>$Competencia,
                                "cnpjCpfPrestador"=>$cnpjCpfPrestador,
                                "ValorServicos"=>$ValorServicos,
                                "IssRetido"=>$IssRetido,
                                "ValorIss"=>$ValorIss,
                                "BaseCalculo"=>$BaseCalculo,
                                "Aliquota"=>$Aliquota,
                                "ValorLiquidoNfse"=>$ValorLiquidoNfse,
                                "ItemListaServico"=>$ItemListaServico,
                                "CodigoTributacaoMunicipio"=>$CodigoTributacaoMunicipio,
                                "Discriminacao"=>$Discriminacao,
                                "CodigoMunicipio"=>$CodigoMunicipio
                            ]);
                            
                            $g3=$this->Validate->validateInsertNotaFiscalPrestador([
                                "ID"=>$ID,
                                "Numero"=>$Numero,
                                "CodigoVerificacao"=>$CodigoVerificacao,
                                "Competencia"=>$Competencia,
                                "cnpjCpfPrestador"=>$cnpjCpfPrestador,
                                "InscricaoMunicipal"=>$InscricaoMunicipalPrestador,
                                "RazaoSocial"=>$RazaoSocialPrestador,
                                "Endereco"=>$EnderecoPrestador,
                                "NumeroEndereco"=>$NumeroEnderecoPrestador,
                                "Complemento"=>$ComplementoPrestador,
                                "Bairro"=>$BairroPrestador,
                                "CodigoMunicipio"=>$CodigoMunicipioPrestador,
                                "Uf"=>$UfTomador,
                                "Cep"=>$CepTomador,
                                "Telefone"=>$TelefoneTomador,
                                "Email"=>$EmailTomador
                            ]);
                            
                            $g4=$this->Validate->validateInsertNotaFiscalTomador([
                                "ID"=>$ID,
                                "Numero"=>$Numero,
                                "CodigoVerificacao"=>$CodigoVerificacao,
                                "Competencia"=>$Competencia,
                                "cnpjCpfPrestador"=>$cnpjCpfPrestador,
                                "cnpjCpfTomador"=>$cnpjCpfTomador,
                                "InscricaoMunicipal"=>$InscricaoMunicipalTomador,
                                "RazaoSocial"=>$RazaoSocialTomador,
                                "Endereco"=>$EnderecoTomador,
                                "NumeroEndereco"=>$NumeroEnderecoTomador,
                                "Complemento"=>$ComplementoTomador,
                                "Bairro"=>$BairroTomador,
                                "CodigoMunicipio"=>$CodigoMunicipioTomador,
                                "Uf"=>$UfTomador,
                                "Cep"=>$CepTomador,
                                "Telefone"=>$TelefoneTomador,
                                "Email"=>$EmailTomador
                            ]);
                        }else{
                            $g1=false;
                            $g2=false;
                            $g3=false;
                            $g4=false;
                        }
                        if($g1 && $g2 && $g3 && $g4){
                            $resistrado++;
                        }else{
                            $nResgistrado++;
                            array_push($alfa,$Numero);
                            array_push($omega,$CodigoVerificacao);
                            array_push($beta,$cnpjCpfPrestador);
                        }
                        
                    }
                    
                   
                   /* //Servico
                    foreach($xml->ListaNfse->CompNfse as $reg){
                        $Numero = (int)filter_var($reg->Nfse->InfNfse->Numero,FILTER_SANITIZE_SPECIAL_CHARS);
                        $CodigoVerificacao = (string)filter_var($reg->Nfse->InfNfse->CodigoVerificacao,FILTER_SANITIZE_SPECIAL_CHARS);
                        
                        
                        $this->Validate->validateFilds([
                            "Numero"=>$Numero
                        ]);
                        
                    }
                
                    //Prestador
                    foreach($xml->ListaNfse->CompNfse as $reg){
                        
                        $Numero = (int)filter_var($reg->Nfse->InfNfse->Numero,FILTER_SANITIZE_SPECIAL_CHARS);
                        $CodigoVerificacao = (string)filter_var($reg->Nfse->InfNfse->CodigoVerificacao,FILTER_SANITIZE_SPECIAL_CHARS);
                        
                        $this->Validate->validateFilds([
                            "Numero"=>$Numero
                        ]);
                        
                        
                        
                    }
                
                    //Tomador
                    foreach($xml->ListaNfse->CompNfse as $reg){
                        
                        $Numero = (int)filter_var($reg->Nfse->InfNfse->Numero,FILTER_SANITIZE_SPECIAL_CHARS);
                        $CodigoVerificacao = (string)filter_var($reg->Nfse->InfNfse->CodigoVerificacao,FILTER_SANITIZE_SPECIAL_CHARS);
                        
                        
                        $this->Validate->validateFilds([
                            "Numero"=>$Numero
                        ]);
                        
                        
                        
                    }*/
                    
                }
            }else{
                //$this->Validate->gsetError("XML não lido");
            }
        }
        echo("Registrados: {$resistrado} <br>");
        echo("Não registrados: {$nResgistrado} <br><hr>");
        var_dump($alfa);
        echo"<hr>";
        var_dump($omega);
        echo"<hr>";
        var_dump($beta);
        /*if(count($this->Validate->getError())>0){
            $this->Write->Erros($this->Validate->getError(),'divMensage','alert alert-danger');
            
            $this->Write->Mensage("{}");
        }else if(count($this->Validate->getMessage())>0){
            $this->Write->Erros($this->Validate->getMessage(),'divMensage','alert alert-success');
        }*/
       
    }
    

}
?>