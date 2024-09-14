<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Traits\TraitUrlParser;
use Src\Traits\TraitGetIp;
use Src\Classes\ClassValidateCalcularRBT12;
use Smalot;

class ControllerCalcularRBT12{
    use TraitUrlParser;
    use TraitGetIp;
    
    private $render;
    private $ValidateCalcularRBT12;
    private $Smalot;

    private $request;

    public function __construct(){
        
        $this->render = new ClassRender();
        $this->render->setDir("CalcularRBT12");
        $this->render->setTitle("Calcular Simples");
        $this->render->setDescription("Pagina MVC");
        $this->render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            header("Content-Type:application/json");
        }else{
            $this->render->renderLayout();
        }

        $this->request = array();
        $this->ValidateCalcularRBT12 = new ClassValidateCalcularRBT12;
        $this->Smalot = new \Smalot\PdfParser\Parser();
    }

    public function insertRBT12(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{

            if(isset($_POST['cnpj'])){
                $cnpj = filter_var($_POST['cnpj'],FILTER_SANITIZE_ADD_SLASHES);
            }

            if(isset($_POST['anexo'])){
                $anexo = filter_var($_POST['anexo'],FILTER_SANITIZE_ADD_SLASHES);
            }

            if(isset($_POST['competencia'])){
                $competencia = filter_var($_POST['competencia'],FILTER_SANITIZE_ADD_SLASHES);
            }

            exit(json_encode($_POST));
        }
    }

    public function getRBT12_DAS_Pagamento(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{

            $jsonResponse = [];

            if(isset($_POST['cnpj'])){
                $cnpj = filter_var($_POST['cnpj'],FILTER_SANITIZE_ADD_SLASHES);
                $cnpj = preg_replace("/[^0-9]/","",$cnpj);
                $this->ValidateCalcularRBT12->validateCNPJ($cnpj);
                array_push($this->request,$cnpj);
            }

            if(isset($_POST['anexo'])){
                $anexo = filter_var($_POST['anexo'],FILTER_SANITIZE_ADD_SLASHES);
                $anexo = preg_replace("/[^0-9]/","",$anexo);
                array_push($this->request,$anexo);
            }

            if(isset($_POST['competencia'])){
                $competencia = filter_var($_POST['competencia'],FILTER_SANITIZE_ADD_SLASHES);
                $this->ValidateCalcularRBT12->validateData($competencia);
                array_push($this->request,$competencia);
            }

            $this->ValidateCalcularRBT12->validateFilds($this->request);

            if($this->ValidateCalcularRBT12->validateIssetRBT12([
                'cnpj'=>$cnpj,
                'anexo'=>$anexo,
                'competencia'=>$competencia
            ])){
                
                $returnRBT12 = $this->ValidateCalcularRBT12->validateGetRBT12([
                    'cnpj'=>$cnpj,
                    'anexo'=>$anexo,
                    'competencia'=>$competencia
                ]);

                $jsonResponse += ['dados'=>$returnRBT12];

            }else{

                $tokens = $this->ValidateCalcularRBT12->validateAutenticacaoIntegraContador();

                $competencia_query = "";
                
                $mesSubtracao = (int)explode('-',$competencia)[1];
                $anoSubtracao = (int)explode('-',$competencia)[0];

                for($i=1;$i<=1;$i++){
                    if($mesSubtracao<=1){
                        $mesSubtracao=12;
                        $anoSubtracao--;
                    }else{
                        $mesSubtracao--;
                    }
                }

                if($mesSubtracao<10){$mesSubtracao = "0".$mesSubtracao;}

                $competencia_query = "{$anoSubtracao}-{$mesSubtracao}";

                //exit(json_encode($competencia_query));

                $declaracao = $this->ValidateCalcularRBT12->validateConsultarDeclaracao([
                    'cnpj'=>$cnpj,
                    'competencia'=>$competencia_query,
                    'token_type'=>$tokens['token_type'],
                    'access_token'=>$tokens['access_token'],
                    'jwt_token'=>$tokens['jwt_token']
                ]);
                
                if($declaracao==false){
                    $jsonResponse += ['dados'=>false];
                }else{

                    $dados_apurados_rbt12 = self::getDadosDeclaracaoPDF($declaracao);

                    //exit(json_encode($dados_apurados_rbt12));

                    $retornInsertRBT12 = $this->ValidateCalcularRBT12->validateInsertRBT12([
                        'id'=>(string)uniqid('',true),
                        'competencia'=>(string)$competencia,
                        'rpa'=>(float)0,
                        'rbt12'=>(float)$dados_apurados_rbt12['rbt12_calculado'],
                        'anexo'=>(int)0,
                        'cnpj'=>(string)$cnpj
                    ]);

                    /*if($competencia!=$competencia_query){
                        
                    }else{
                        $retornInsertRBT12 = $this->ValidateCalcularRBT12->validateInsertRBT12([
                            'id'=>(string)uniqid('',true),
                            'competencia'=>(string)$competencia,
                            'rpa'=>(float)$dados_apurados_rbt12['rpa'],
                            'rbt12'=>(float)$dados_apurados_rbt12['rbt12_competencia'],
                            'anexo'=>(int)0,
                            'cnpj'=>(string)$cnpj
                        ]);
                    }*/
                    
                    if($retornInsertRBT12){
                        $returnRBT12 = $this->ValidateCalcularRBT12->validateGetRBT12([
                            'cnpj'=>$cnpj,
                            'anexo'=>$anexo,
                            'competencia'=>$competencia
                        ]);
        
                        $jsonResponse += ['dados'=>$returnRBT12];
                    }else{
                        $jsonResponse += ['dados'=>false];
                    }
                }

            }

            $jsonResponse += ['erro'=>$this->ValidateCalcularRBT12->getError()];
            $jsonResponse += ["message"=>$this->ValidateCalcularRBT12->getMessage()];

            exit(json_encode($jsonResponse));

        }
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
                "Authorization: Basic ${CHAVE_AUTENTICACAO_INTEGRA_CONTADOR}"
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

        $pdf = self::pdf_to_array(base64_encode(file_get_contents(DIRREQ.'public/vm.pdf')));

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

    private function pdf_to_array(string $base64PDF){
        file_put_contents(DIRREQ.'public/declaracao.pdf', base64_decode($base64PDF));
        $pdf = $this->Smalot->parseFile(DIRREQ.'public/declaracao.pdf');

        return explode("\n",$pdf->getText(1));
    }

    private function getDadosDeclaracaoPDF(array $declaracao){
        $pdf = self::pdf_to_array(json_decode($declaracao['dados'],true)['declaracao']['pdf']);

        $RBT12_competencia = null;
        $RBT12p = null;
        $RPA = null;

        $periodoApuracao = explode(" ",trim(preg_replace(["/[A-Z]/","/[a-z]/","/[À-ú]/","/:/"],"",$pdf[3])))[0];

        $mesApuracao= (int)explode('/',$periodoApuracao)[1];
        $anoApuracao = (int)explode('/',$periodoApuracao)[2];

        $mesSubtracao = (int)explode('/',$periodoApuracao)[1];
        $anoSubtracao = (int)explode('/',$periodoApuracao)[2];

        for($i=1;$i<=12;$i++){
            if($mesSubtracao<=1){
                $mesSubtracao=12;
                $anoSubtracao--;
            }else{
                $mesSubtracao--;
            }
        }

        if($mesSubtracao<10){$mesSubtracao = "0".$mesSubtracao;}

        $mesSubtracao = (string)$mesSubtracao;
        $anoSubtracao = (string)$anoSubtracao;

        $interruptor = true;
        for($i=0;$i<=count($pdf)-1;$i++){
            if(self::like('%CNPJ Matriz%',$pdf[$i])){
                if(preg_match('/\d+/', $pdf[$i])>0){
                    $cnpj = preg_replace("/[^0-9]/","",explode("\t",$pdf[$i])[1]);
                }
            }

            if(self::like('%(RBT12)%',$pdf[$i])){
                if(preg_match('/\d+/', $pdf[$i+1])>0){
                    $RBT12_competencia = explode("\t",$pdf[$i+1])[0];
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
                if(self::like("%{$mesSubtracao}\/{$anoSubtracao}%",$pdf[$i])){
                    $pdf[$i] = str_replace("\t"," ",$pdf[$i]);
                    $q = explode(" ",$pdf[$i]);
                    $mesSubtracaoTemp = (int)$mesSubtracao;
                    $mesSubtracaoTemp++;
                    if($mesSubtracaoTemp<10){$mesSubtracaoTemp = "0".$mesSubtracaoTemp;}

                    for($w=0;$w<=count($q)-1;$w++){
                        if(self::like("%{$mesSubtracao}\/{$anoSubtracao}%",$q[$w])){
                            $RBT12_subtracao = preg_replace("/{$mesSubtracaoTemp}\/{$anoSubtracao}.*?/","",$q[$w+1]);
                        }
                    }

                    $interruptor = false;
                }
            }
            
        }

        $RBT12_competencia_temp = (float)str_replace([".",","], ["","."], $RBT12_competencia);
        $RPATemp = (float)str_replace([".",","], ["","."], $RPA);
        $RBT12_subtracao_temp = (float)str_replace([".",","], ["","."], $RBT12_subtracao);

        $RBT12_calculado = ($RBT12_competencia_temp+$RPATemp)-$RBT12_subtracao_temp;

        return [
            'rbt12_calculado'=>$RBT12_calculado,
            'rbt12_competencia'=>$RBT12_competencia_temp,
            'rpa'=>$RPATemp,
            'competencia'=>"{$anoApuracao}-{$mesApuracao}-01",
            'cnpj'=>$cnpj,
            'q'=>$q
        ];
    }
    
}