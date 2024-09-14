<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Traits\TraitUrlParser;
use Src\Traits\TraitGetIp;
use Src\Classes\ClassValidateCalcularRBT12;
use Src\Classes\ClassRequestJSON;
use Smalot;

class ControllerCalcularSimples{
    use TraitUrlParser;
    use TraitGetIp;

    private $render;
    private $ValidateCalcularRBT12;
    private $Smalot;
    private $RequestJSON;
    private $request;

    public function __construct(){
        $this->render = new ClassRender();
        $this->render->setDir("CalcularSimples/DAS");
        $this->render->setTitle("Calcular Simples");
        $this->render->setDescription("Pagina MVC");
        $this->render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            header("Content-Type:application/json");
        }else{
            $this->render->renderLayout();
        }

        $this->request = [];
        $this->ValidateCalcularRBT12 = new ClassValidateCalcularRBT12;
        $this->Smalot = new \Smalot\PdfParser\Parser();
        $this->RequestJSON = new ClassRequestJSON();
    }

    public function testePDFDeclaracao(){

        /*$data = date('Y-m-01', strtotime('-1 month', strtotime('2024-08-01')));
        exit(json_encode($data));*/
        $path = DIRREQ."public/arquivos/declaracoes/{$_POST['competencia']}/{$_POST['cnpj']}_{$_POST['competencia']}.pdf";
        $pdf = self::pdf_to_array([
            'path'=>$path
        ]);
        $return = [];
        for($i=0;$i<=count($pdf)-1;$i++){
            if(self::like('%Data de abertura no CNPJ:%',$pdf[$i])){
                if(preg_match('/\d+/', $pdf[$i])>0){
                    $data_abertura = preg_replace('/[^0-9\/]/','',$pdf[$i]);
                    $data_abertura = date_format(date_create_from_format('d/m/Y', $data_abertura), 'Y-m-d');
                }
                array_push($return, ['data_abertura'=>$data_abertura]);
            }

            if(self::like('%Regime de Apuração:%',$pdf[$i])){
                $regime_apuracao = explode("\t",$pdf[$i])[1];
                array_push($return, ['regime_apuracao'=>$regime_apuracao]);
            }

            if(self::like('%\(RPA\)%',$pdf[$i])){
                if(preg_match('/\d+/', $pdf[$i])>0){
                    $RPA = explode("\t",$pdf[$i])[1];
                    $RPA = (float)str_replace(['.',','],['','.'],$RPA);
                }
                array_push($return, ['RPA'=>$RPA]);
            }

            if(self::like('%\(RBA\)%',$pdf[$i])){
                if(preg_match('/\d+/', $pdf[$i+1])>0){
                    $RBA = explode("\t",$pdf[$i+1])[0];
                    $RBA = (float)str_replace(['.',','],['','.'],$RBA);
                }
                array_push($return, ['RBA'=>$RBA]);
            }

            if(self::like('%\(RBT12\)%',$pdf[$i])){
                if(preg_match('/\d+/', $pdf[$i+1])>0){
                    $RBT12_competencia = explode("\t",$pdf[$i+1])[0];
                    $RBT12_competencia = (float)str_replace(['.',','],['','.'],$RBT12_competencia);
                }
                array_push($return, ['RBT12'=>$RBT12_competencia]);
            }

            if(self::like('%\(RBT12p\)%',$pdf[$i])){
                $RBT12p = false;
                if(preg_match('/\d+/', $pdf[$i+1])>0){
                    $RBT12p = str_replace("\t"," ",$pdf[$i+1]);
                    $RBT12p = explode(" ",$RBT12p)[2];
                    $RBT12p = (float)str_replace(['.',','],['','.'],$RBT12p);
                }
                array_push($return, ['RBT12p'=>$RBT12p]);
            }

            if(self::like('%Receitas Brutas Anteriores%',$pdf[$i])){
                //array_push($return, $pdf[$i+1]);
                if(self::like('%Mercado Interno%',$pdf[$i+1])){
                    $valores_temp = [];
                    $valores = [];
                    $competecias_anteriores = [];
                    for($e=2;$e<=6;$e++){
                        if(self::like('%Mercado Externo%',$pdf[$i+$e])){
                            $e = 7;
                        }else{
                            $linha = str_replace("\t"," ",$pdf[$i+$e]);
                            preg_match_all('/\d{2}\/\d{4}/', $linha, $match);
                            array_push($competecias_anteriores, $match[0]);
                            array_push($valores_temp, array_filter(explode(" ",preg_replace('/\d{2}\/\d{4}/',"",$linha))));
                        }
                    }
                    $tabela = [];
                    //array_push($return,["competencias anteriores"=>$competecias_anteriores]);
                    foreach($valores_temp as $key1 => $array){
                        foreach($array as $key2 => $value){
                            $valores_temp[$key1][$key2] = $value;
                            $valores[$key1][($key2-1)] = $value;
                        }
                    }
                    foreach($competecias_anteriores as $key => $array){
                        foreach($array as $key2 => $competencia){
                            $competencia = date_format(date_create_from_format('m/Y', $competencia), 'Y-m-01');
                            $valor_temp = (float)str_replace(['.',','],['','.'],$valores[$key][$key2]);
                            array_push($tabela,[
                                "competencia"=>$competencia,
                                "receita_bruta"=>$valor_temp
                            ]);
                        }
                    }
                    array_push($return,["competencias_anteriores"=>$tabela]);

                }else{
                    array_push($return, ["competencias_anteriores"=>[]]);
                }
            }
        }
        $ano_abertura = (int)date('Y', strtotime($data_abertura));
        $ano_competencia =  (int)date('Y', strtotime($_POST['competencia']));
        if(!($ano_abertura < $ano_competencia)){
            $mes_abertura = (int)date('m', strtotime($data_abertura));
            $mes_competencia =  (int)date('m', strtotime($_POST['competencia']));
            $RBT12p_calculado = ($RBA/(($mes_competencia - $mes_abertura) + 1)) * 12;
            //array_push($return, ["meses"=>$_POST['competencia']]);
            array_push($return,["RBT12p_calculado"=>$RBT12p_calculado]);
        }
        array_push($return,["pdf"=>$pdf]);
        exit(json_encode($return));
    }
    
    public function testeCNPJ(){
        $this->ValidateCalcularRBT12->validate_testeCNPJ();
        //$return = $this->RequestJSON->request("https://receitaws.om.br/v1/cnpj/55458588000113","GET",null,null);

        exit(json_encode("Retorno: "));
    }

    public function testeCronJobs(){
        //$this->ValidateCalcularRBT12->validate_testeCronJobs();
    }

    public function getRBT12(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{

            $date=date_create(date("Y-m"));
            date_sub($date,date_interval_create_from_date_string("1 month"));
            $competencia = date_format($date,"Y-m-01");

            $jsonResponse = [];
            
            if(!isset($_POST['rogeri0'])){exit(json_encode("Envie uma requisição com requisitos certos"));}

            $jsonResponse += ['dados'=>$this->ValidateCalcularRBT12->validateGetRBT12_Empresas($competencia, [])];

            $jsonResponse += ['erro'=>$this->ValidateCalcularRBT12->getError()];

            exit(json_encode($jsonResponse));

        }
    }

    public function getRBT12_DAS_Pagamento(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{
            //exit(json_encode(["post"=>$_POST]));
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
                //array_push($this->request,$anexo);
            }

            if(isset($_POST['competencia'])){
                $competencia = filter_var($_POST['competencia'],FILTER_SANITIZE_ADD_SLASHES);
                $this->ValidateCalcularRBT12->validateData($competencia);
                array_push($this->request,$competencia);
            }else{
                $date=date_create(date("Y-m"));
                date_sub($date,date_interval_create_from_date_string("1 month"));
                //$_POST += ['competencia'=>date_format($date,"Y-m-d")];
                $competencia = date_format($date,"Y-m-d");
                array_push($this->request,$competencia);
            }

            //exit(json_encode($this->request));
            /*exit(json_encode([
                "erros"=>$this->ValidateCalcularRBT12->getError(),
                "post"=>$_POST
            ]));*/

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

                    $dados_apurados_rbt12 = self::getDadosDeclaracaoPDF($declaracao,$cnpj,$competencia);

                    //exit(json_encode($dados_apurados_rbt12));

                    $rbt12_calculado = 0;

                    $ano_abertura = (int)date('Y', strtotime($dados_apurados_rbt12['data_abertura']));
                    $ano_competencia =  (int)date('Y', strtotime($dados_apurados_rbt12['competencia']));
                    if(!($ano_abertura < $ano_competencia)){
                        $mes_abertura = (int)date('m', strtotime($dados_apurados_rbt12['data_abertura']));
                        $mes_competencia =  (int)date('m', strtotime($dados_apurados_rbt12['competencia']));
                        $rbt12_calculado = ($dados_apurados_rbt12['rba']/(($mes_competencia - $mes_abertura) + 1)) * 12;
                    }else{
                        $competencia_temp = date('Y-m-01',strtotime('-1 year',strtotime($dados_apurados_rbt12['competencia'])));
                        foreach ($dados_apurados_rbt12['competencias_anteriores'] as $key => $array) {
                            if($array['competencia'] == $competencia_temp){
                                $rbt12_calculado = ($dados_apurados_rbt12['rbt12_competencia'] + $dados_apurados_rbt12['rpa']) - $array['receita_bruta'];
                            }
                        }
                    }

                    foreach ($dados_apurados_rbt12['competencias_anteriores'] as $key => $array) {

                        $ano_competencia_enterior_temp = (int)date('Y', strtotime($dados_apurados_rbt12['competencia']));
                        $ano_competencia =  (int)date('Y', strtotime($array['competencia']));

                        if($ano_competencia == $ano_competencia_enterior_temp){
                            if($this->ValidateCalcularRBT12->validateIssetRBT12([
                                'cnpj'=>$cnpj,
                                'anexo'=>$anexo,
                                'competencia'=>$array['competencia']
                            ])){
                                $this->ValidateCalcularRBT12->validateUpdateRBT12([
                                    'cnpj'=>(string)$cnpj,
                                    'competencia'=>(string)$array['competencia'],
                                    'rpa'=>(float)$array['receita_bruta']
                                ]);
                            }else{
                                $this->ValidateCalcularRBT12->validateInsertRBT12([
                                    'id'=>(string)uniqid('',true),
                                    'competencia'=>(string)$array['competencia'],
                                    'rpa'=>(float)$array['receita_bruta'],
                                    'rba'=>(float)0,
                                    'rbt12'=>(float)0,
                                    'anexo'=>(int)0,
                                    'cnpj'=>(string)$cnpj
                                ]);
                            }
                        }

                    }

                    if($this->ValidateCalcularRBT12->validateIssetRBT12([
                        'cnpj'=>$cnpj,
                        'anexo'=>$anexo,
                        'competencia'=>$dados_apurados_rbt12['competencia']
                    ])){
                        
                        $this->ValidateCalcularRBT12->validateUpdateRBT12([
                            'cnpj'=>(string)$cnpj,
                            'competencia'=>(string)$dados_apurados_rbt12['competencia'],
                            'rpa'=>(float)$dados_apurados_rbt12['rpa']
                        ]);
                        /*exit(json_encode([
                            'cnpj'=>(string)$cnpj,
                            'competencia'=>(string)$dados_apurados_rbt12['competencia'],
                            'rba'=>(float)$dados_apurados_rbt12['rba'],
                            'rbt12'=>(float)$dados_apurados_rbt12['rbt12_competencia']
                        ]));*/
                        $this->ValidateCalcularRBT12->validateUpdateRBT12([
                            'cnpj'=>(string)$cnpj,
                            'competencia'=>(string)$dados_apurados_rbt12['competencia'],
                            'rba'=>(float)$dados_apurados_rbt12['rba'],
                            'rbt12'=>(float)$dados_apurados_rbt12['rbt12_competencia']
                        ]);
                    }else{
                        $this->ValidateCalcularRBT12->validateInsertRBT12([
                            'id'=>(string)uniqid('',true),
                            'competencia'=>(string)$dados_apurados_rbt12['competencia'],
                            'rpa'=>(float)$dados_apurados_rbt12['rpa'],
                            'rba'=>(float)$dados_apurados_rbt12['rba'],
                            'rbt12'=>(float)$dados_apurados_rbt12['rbt12_competencia'],
                            'anexo'=>(int)0,
                            'cnpj'=>(string)$cnpj
                        ]);
                    }

                    $rba_temp = $dados_apurados_rbt12['rba'] + $dados_apurados_rbt12['rpa'];
                    $retornInsertRBT12 = $this->ValidateCalcularRBT12->validateInsertRBT12([
                        'id'=>(string)uniqid('',true),
                        'competencia'=>(string)$competencia,
                        'rpa'=>(float)0,
                        'rba'=>(float)$rba_temp,
                        'rbt12'=>(float)$rbt12_calculado,
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

    public function calcularSimples(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{

            $json = array(
                "aliquotaEfetiva"=>"",
                "anexo"=>"",
                "fatorR"=>"",
                "valorComRetencao"=>"",
                "valorSemRetencao"=>"",
                "valorDaDeclaracao"=>"",
                "valorDAS"=>"",
                "dadosAliquota"=>[
                    'semRetencao'=>[
                        "IRPJ"=>[],
                        "CSLL"=>[],
                        "COFINS"=>[],
                        "PIS"=>[],
                        "CPP"=>[],
                        "ICMS"=>[],
                        "IPI"=>[],
                        "ISS"=>[]
                    ],
                    'comRetencao'=>[
                        "IRPJ"=>[],
                        "CSLL"=>[],
                        "COFINS"=>[],
                        "PIS"=>[],
                        "CPP"=>[],
                        "ICMS"=>[],
                        "IPI"=>[],
                        "ISS"=>[]
                    ],
                    'declaracao'=>[
                        "IRPJ"=>[],
                        "CSLL"=>[],
                        "COFINS"=>[],
                        "PIS"=>[],
                        "CPP"=>[],
                        "ICMS"=>[],
                        "IPI"=>[],
                        "ISS"=>[]
                    ],
                    'DAS'=>[
                        "IRPJ"=>[],
                        "CSLL"=>[],
                        "COFINS"=>[],
                        "PIS"=>[],
                        "CPP"=>[],
                        "ICMS"=>[],
                        "IPI"=>[],
                        "ISS"=>[]
                    ]
                ]
            );
            
            if(isset($_POST['rbt12'])){
                if(!filter_var($_POST['rbt12'],FILTER_VALIDATE_FLOAT)){
                    $rbt12 = (float)str_replace([".",","],["","."],$_POST['rbt12']);
                }else{
                    $rbt12 = (float)$_POST['rbt12'];
                }
            }

            if(isset($_POST['folha'])){
                if(!filter_var($_POST['folha'],FILTER_VALIDATE_FLOAT)){
                    $folha = (float)str_replace([".",","],["","."],$_POST['folha']);
                }else{
                    $folha = (float)$_POST['folha'];
                }
            }

            /*if(isset($_POST['faturamentoDoMes'])){
                if(!filter_var($_POST['faturamentoDoMes'],FILTER_VALIDATE_FLOAT)){
                    $faturamentoDoMes = (float)str_replace([".",","],["","."],$_POST['faturamentoDoMes']);
                }else{
                    $faturamentoDoMes = (float)$_POST['faturamentoDoMes'];
                }
            }*/

            if(isset($_POST['faturamentoSemRetencao'])){
                if(!filter_var($_POST['faturamentoSemRetencao'],FILTER_VALIDATE_FLOAT)){
                    $faturamentoSemRetencao = (float)str_replace([".",","],["","."],$_POST['faturamentoSemRetencao']);
                }else{
                    $faturamentoSemRetencao = (float)$_POST['faturamentoSemRetencao'];
                }
            }

            if(isset($_POST['faturamentoComRetencao'])){
                if(!filter_var($_POST['faturamentoComRetencao'],FILTER_VALIDATE_FLOAT)){
                    $faturamentoComRetencao = (float)str_replace([".",","],["","."],$_POST['faturamentoComRetencao']);
                }else{
                    $faturamentoComRetencao = (float)$_POST['faturamentoComRetencao']; 
                }
            }

            if(isset($_POST['anexo'])){
                $anexo = (int)$_POST['anexo'];
            }

            $faturamentoDoMes = (float)$faturamentoSemRetencao + $faturamentoComRetencao;


            //exit(json_encode($faturamentoDoMes));

            $aliquotaNominalArray = [    
                1=>[
                    1=>["Aliquota"=>4,"Desconto"=>0],
                    2=>["Aliquota"=>7.3,"Desconto"=>5940],
                    3=>["Aliquota"=>9.5,"Desconto"=> 13860],
                    4=>["Aliquota"=>10.7,"Desconto"=>22500],
                    5=>["Aliquota"=>14.3,"Desconto"=>87300],
                    6=>["Aliquota"=>19,"Desconto"=>378000]
                ],
                2=>[
                    1=>["Aliquota"=>4.5,"Desconto"=>0],
                    2=>["Aliquota"=>7.8,"Desconto"=>5940],
                    3=>["Aliquota"=>10,"Desconto"=> 13860],
                    4=>["Aliquota"=>11.2,"Desconto"=>22500],
                    5=>["Aliquota"=>14.7,"Desconto"=>85500],
                    6=>["Aliquota"=>30,"Desconto"=>720000]
                ],
                3=>[
                    1=>["Aliquota"=>6,"Desconto"=>0],
                    2=>["Aliquota"=>11.2,"Desconto"=>9360],
                    3=>["Aliquota"=>13.5,"Desconto"=> 17640],
                    4=>["Aliquota"=>16,"Desconto"=>35640],
                    5=>["Aliquota"=>21,"Desconto"=>125640],
                    6=>["Aliquota"=>33,"Desconto"=>648000]
                ],
                4=>[
                    1=>["Aliquota"=>4.5,"Desconto"=>0],
                    2=>["Aliquota"=>9,"Desconto"=>8100],
                    3=>["Aliquota"=>10.2,"Desconto"=> 12420],
                    4=>["Aliquota"=>14,"Desconto"=>39780],
                    5=>["Aliquota"=>22,"Desconto"=>183780],
                    6=>["Aliquota"=>33,"Desconto"=>828000]
                ],
                5=>[
                    1=>["Aliquota"=>15.5,"Desconto"=>0],
                    2=>["Aliquota"=>18,"Desconto"=>4500],
                    3=>["Aliquota"=>19.5,"Desconto"=> 9900],
                    4=>["Aliquota"=>20.5,"Desconto"=>17100],
                    5=>["Aliquota"=>23,"Desconto"=>62100],
                    6=>["Aliquota"=>30.5,"Desconto"=>540000]
                ]
            ];

            $aliquotaImpostoArray = [    
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
            
            $faixa = null;
            if($rbt12 <= 180000){
                $faixa = 1;
            }else if($rbt12>  180000  && $rbt12 <= 360000){
                $faixa = 2;
            }else if($rbt12>  360000  && $rbt12 <= 720000){
                $faixa = 3;
            }else if($rbt12>  720000  && $rbt12 <= 1800000){
                $faixa = 4;
            }else if($rbt12>  1800000  && $rbt12 <= 3600000){
                $faixa = 5;
            }else if($rbt12>  3600000  && $rbt12 <= 4800000){
                $faixa = 6;
            }

            $resultado_Fator_R = 0;
            $json+=['anexoOriginal'=>$anexo];
            if($anexo==5){
                $conta_fator_R = $folha/$rbt12;
                $resultado_Fator_R = $conta_fator_R * 100;
                if($resultado_Fator_R >= 28){
                    $anexo=3;
                    $json+=['anexoOriginal'=>5];
                }
            }
            

            $json['fatorR'] = (string)number_format($resultado_Fator_R,2,'.','');
            $json['anexo'] = (string)$anexo;

            $aliquota = $aliquotaNominalArray[$anexo][$faixa]['Aliquota'];
            $desconto = $aliquotaNominalArray[$anexo][$faixa]['Desconto'];

            $aliquota/=100;
           
            $ALIQEfetiva =  (($rbt12 * $aliquota) - $desconto) / $rbt12;
            //exit(json_encode($ALIQEfetiva));
            $json['aliquotaEfetiva'] = (string)number_format(($ALIQEfetiva * 100), 2, ".", "");

            $valorDaDeclaracao = $faturamentoDoMes * $ALIQEfetiva; 
            $valorComRetencao = $faturamentoComRetencao * $ALIQEfetiva;
            $valorSemRetencao = $faturamentoSemRetencao * $ALIQEfetiva;

            $valorComRetencaoReal = 0;
            $valorDAS = 0;

            //exit(json_encode($faturamentoDoMes));

            foreach($aliquotaImpostoArray[$faixa][$anexo] as $key => $value){
                if($value>0 && $value<1){
                    //$valores_recebidos+=$value;

                    if($faturamentoDoMes>0){
                        $json["dadosAliquota"]['declaracao'][$key]+=[$key."_Decimal"=>number_format($value, 4, ".", "")];
                        $json["dadosAliquota"]['declaracao'][$key]+=[$key."_Percentual"=>number_format(($value * 100), 4, ".", "")];
                        
                        $cal=(float)($valorDaDeclaracao * $value);
                        $faturamentoDoMes=(float)$faturamentoDoMes;
                        $json["dadosAliquota"]['declaracao'][$key]+=[$key."_PercentualAplicado"=>number_format((($cal*100)/$faturamentoDoMes), 4, ".", "")];
                        $json["dadosAliquota"]['declaracao'][$key]+=[$key."_ValorImposto"=>number_format($cal, 2, ".", "")];
                    }

                    if($faturamentoSemRetencao>0){

                        $json["dadosAliquota"]['semRetencao'][$key]+=[$key."_Decimal"=>number_format($value, 4, ".", "")];
                        $json["dadosAliquota"]['semRetencao'][$key]+=[$key."_Percentual"=>number_format(($value * 100), 4, ".", "")];
                        
                        $cal=(float)($valorSemRetencao * $value);
                        $json["dadosAliquota"]['semRetencao'][$key]+=[$key."_PercentualAplicado"=>number_format((($cal*100)/$faturamentoSemRetencao), 4, ".", "")];
                        $json["dadosAliquota"]['semRetencao'][$key]+=[$key."_ValorImposto"=>number_format($cal, 2, ".", "")];
                    }

                    if($faturamentoComRetencao>0){
                        if($anexo==1 || $anexo==2){
                            if($key=="ICMS"){$value=0;}
                        }else if($anexo==3 || $anexo==4 || $anexo==5){
                            if($key=="ISS"){$value=0;}
                        }
                        $json["dadosAliquota"]['comRetencao'][$key]+=[$key."_Decimal"=>number_format($value, 4, ".", "")];
                        $json["dadosAliquota"]['comRetencao'][$key]+=[$key."_Percentual"=>number_format(($value * 100), 4, ".", "")];
                        
                        $cal=(float)($valorComRetencao * $value);
                        $valorComRetencaoReal+=$cal;
                        $json["dadosAliquota"]['comRetencao'][$key]+=[$key."_PercentualAplicado"=>number_format((($cal*100)/$faturamentoComRetencao), 4, ".", "")];
                        $json["dadosAliquota"]['comRetencao'][$key]+=[$key."_ValorImposto"=>number_format($cal, 2, ".", "")];

                    }

                    $valorImpostoComRetencao = 0;
                    $valorImpostoSemRetencao = 0;

                    if(isset($json["dadosAliquota"]['comRetencao'][$key][$key."_ValorImposto"])){
                        $valorImpostoComRetencao=(float)$json["dadosAliquota"]['comRetencao'][$key][$key."_ValorImposto"];
                    }
                    if(isset($json["dadosAliquota"]['semRetencao'][$key][$key."_ValorImposto"])){
                        $valorImpostoSemRetencao=(float)$json["dadosAliquota"]['semRetencao'][$key][$key."_ValorImposto"];
                    }

                    $cal = $valorImpostoComRetencao+$valorImpostoSemRetencao;
                    $valorDAS+=$cal;
                    $json["dadosAliquota"]['DAS'][$key]+=[$key."_ValorImposto"=>number_format($cal, 2, ".", "")];
                  
                }
            }

            $json["valorDaDeclaracao"] = number_format($valorDaDeclaracao, 2, ".", "");
            $json["valorSemRetencao"] = number_format($valorSemRetencao,2,".","");
            $json["valorComRetencao"] = number_format($valorComRetencaoReal,2,".","");
            $json["valorDAS"] = number_format($valorDAS,2,".","");

            exit(json_encode($json));
        }
    }

    private function like($needle, $haystack){
        $regex = '/' . str_replace('%', '.*?', $needle) . '/';

        return preg_match($regex, $haystack) > 0;
    }

    private function pdf_to_array(array $param){

        $path_full = "";
        if(isset($param['base64PDF']) && isset($param['id_file']) && isset($param['date'])){
            $data = date('Y-m-01', strtotime('-1 month', strtotime($param['date'])));
            //exit(json_encode($data));
            $path_full = self::uploadDeclaracoes(
                $param['base64PDF'],
                $param['id_file'],
                $data
            );
        }else if(isset($param['path'])){
            $path_full = $param['path'];
        }else{
            return false;
        }

        //exit(json_enode($path_full));

        /*$path_full = DIRREQ.'public/arquivos/declaracoes/'.$data.'/'.$id_file.'_'.$data.'.pdf';
        $dir = DIRREQ.'public/arquivos/declaracoes/'.$data;*/

        //$pdf = "";
        //file_put_contents($path_full, base64_decode($base64PDF));
        //$pdf = $this->Smalot->parseFile($path_full);
        //exit(json_encode($pdf->getText(1)));

        /*if(is_dir($dir)){
            file_put_contents($path_full, base64_decode($base64PDF));
            $pdf = $this->Smalot->parseFile($path_full);
        }else{
            if(mkdir($dir, 0777, true)){
                if(file_exists($path)){
                    file_put_contents($path_full, base64_decode($base64PDF));
                    $pdf = $this->Smalot->parseFile($path_full);
                }else{
                    exit(json_encode("Esse caminho não existe"));
                }
            }
        }*/

        $pdf = $this->Smalot->parseFile($path_full);

        return explode("\n",$pdf->getText(1));
    }

    private function uploadDeclaracoes(string $base64PDF, string $id_file, string $data){
        
        $path_full = DIRREQ.'public/arquivos/declaracoes/'.$data.'/'.$id_file.'_'.$data.'.pdf';
        $dir = DIRREQ.'public/arquivos/declaracoes/'.$data;

        if(is_dir($dir)){
            if(!is_numeric(file_put_contents($path_full, base64_decode($base64PDF)))){
                return false;
            }
        }else{
            if(!mkdir($dir, 0777, true)){
               return false;
            }
            if(!file_exists($path)){
                return false;
             }
             if(!is_numeric(file_put_contents($path_full, base64_decode($base64PDF)))){
                 return false;
             }
        }

        //exit(json_encode($data));

        return $path_full;
    }

    private function getDadosDeclaracaoPDF(array $declaracao, string $cnpj, string $competencia){
        $pdf = self::pdf_to_array([
            "base64PDF"=>json_decode($declaracao['dados'],true)['declaracao']['pdf'],
            "id_file"=>$cnpj,
            "date"=>$competencia
        ]);

        //exit(json_encode($pdf));

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
        $tabela = [];
        for($i=0;$i<=count($pdf)-1;$i++){
            if(self::like('%Data de abertura no CNPJ:%',$pdf[$i])){
                if(preg_match('/\d+/', $pdf[$i])>0){
                    $data_abertura = preg_replace('/[^0-9\/]/','',$pdf[$i]);
                    $data_abertura = date_format(date_create_from_format('d/m/Y', $data_abertura), 'Y-m-d');
                }
                //array_push($return, ['data_abertura'=>$data_abertura]);
            }
            if(self::like('%CNPJ Matriz%',$pdf[$i])){
                if(preg_match('/\d+/', $pdf[$i])>0){
                    $cnpj = preg_replace("/[^0-9]/","",explode("\t",$pdf[$i])[1]);
                }
            }

            if(self::like('%\(RBT12\)%',$pdf[$i])){
                if(preg_match('/\d+/', $pdf[$i+1])>0){
                    $RBT12_competencia = explode("\t",$pdf[$i+1])[0];
                    $RBT12_competencia = (float)str_replace(['.',','],['','.'],$RBT12_competencia);
                }
            }

            if(self::like('%\(RPA\)%',$pdf[$i])){
                if(preg_match('/\d+/', $pdf[$i])>0){
                    $RPA = explode("\t",$pdf[$i])[1];
                    $RPA = (float)str_replace(['.',','],['','.'],$RPA);
                }
            }

            if(self::like('%\(RBA\)%',$pdf[$i])){
                if(preg_match('/\d+/', $pdf[$i+1])>0){
                    $RBA = explode("\t",$pdf[$i+1])[0];
                    $RBA = (float)str_replace(['.',','],['','.'],$RBA);
                }
                //array_push($return, ['RBA'=>$RBA]);
            }

            if(self::like('%\(RBT12p\)%',$pdf[$i])){
                //$RBT12p = false;
                if(preg_match('/\d+/', $pdf[$i+1])>0){
                    $RBT12p = str_replace("\t"," ",$pdf[$i+1]);
                    $RBT12p = explode(" ",$RBT12p)[2];
                    $RBT12p = (float)str_replace(['.',','],['','.'],$RBT12p);
                }
            }

            if(self::like('%Receitas Brutas Anteriores%',$pdf[$i])){
                //exit(json_encode($pdf[$i]));
                //array_push($return, $pdf[$i+1]);
                if(self::like('%Mercado Interno%',$pdf[$i+1])){
                    $valores_temp = [];
                    $valores = [];
                    $competecias_anteriores = [];
                    for($e=2;$e<=6;$e++){
                        if(self::like('%Mercado Externo%',$pdf[$i+$e])){
                            $e = 7;
                        }else{
                            $linha = str_replace("\t"," ",$pdf[$i+$e]);
                            preg_match_all('/\d{2}\/\d{4}/', $linha, $match);
                            array_push($competecias_anteriores, $match[0]);
                            array_push($valores_temp, array_filter(explode(" ",preg_replace('/\d{2}\/\d{4}/',"",$linha))));
                        }
                    }
                    //array_push($return,["competencias anteriores"=>$competecias_anteriores]);
                    foreach($valores_temp as $key1 => $array){
                        foreach($array as $key2 => $value){
                            $valores_temp[$key1][$key2] = $value;
                            $valores[$key1][($key2-1)] = $value;
                        }
                    }
                    foreach($competecias_anteriores as $key1 => $array){
                        foreach($array as $key2 => $competencia){
                            $competencia = date_format(date_create_from_format('m/Y', $competencia), 'Y-m-01');
                            $valor_temp = (float)str_replace(['.',','],['','.'],$valores[$key1][$key2]);
                            array_push($tabela,[
                                "competencia"=>$competencia,
                                "receita_bruta"=>$valor_temp
                            ]);
                        }
                    }
                    //array_push($return,["competencias_anteriores"=>$tabela]);

                }
            }

            /*if($interruptor){
                if(self::like("%{$mesSubtracao}\/{$anoSubtracao}%",$pdf[$i])){
                    $pdf[$i] = str_replace("\t"," ",$pdf[$i]);
                    $q = explode(" ",$pdf[$i]);
                    $mesSubtracaoTemp = (int)$mesSubtracao;
                    $mesSubtracaoTemp++;
                    if($mesSubtracaoTemp<10){$mesSubtracaoTemp = "0".$mesSubtracaoTemp;}

                    for($w=0;$w<=count($q)-1;$w++){
                        if(self::like("%{$mesSubtracao}\/{$anoSubtracao}%",$q[$w])){
                            $RBT12_subtracao = preg_replace("/{$mesSubtracaoTemp}\/{$anoSubtracao}.*?/","",$q[$w+1]);
                            $RBT12_subtracao = (float)str_replace(['.',','],['','.'],$RBT12_subtracao);
                        }
                    }

                    $interruptor = false;
                }
            }*/
            
        }

        //exit(json_encode(["tabela"=>$tabela]));

        /*$RBT12_competencia_temp = (float)str_replace([".",","], ["","."], $RBT12_competencia);
        $RPATemp = (float)str_replace([".",","], ["","."], $RPA);
        $RBT12_subtracao_temp = (float)str_replace([".",","], ["","."], $RBT12_subtracao);*/

        //$RBT12_calculado = ($RBT12_competencia_temp+$RPATemp)-$RBT12_subtracao_temp;
        $periodoApuracao = date_format(date_create_from_format('d/m/Y', $periodoApuracao), 'Y-m-d');
        return [
            //'rbt12_calculado'=>$RBT12_calculado,
            'rbt12_competencia'=>$RBT12_competencia,
            'rpa'=>$RPA,
            'rba'=>$RBA,
            'competencia'=>$periodoApuracao,
            'cnpj'=>$cnpj,
            'competencias_anteriores'=>$tabela,
            'data_abertura'=>$data_abertura
        ];
    }

    public function emitirDAS(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{

            if(isset($_POST['cnpj'])){
                $cnpj = filter_var($_POST['cnpj'],FILTER_SANITIZE_ADD_SLASHES);
                $cnpj = preg_replace("/[^0-9]/","",$cnpj);
                $this->ValidateCalcularRBT12->validateCNPJ($cnpj);
                array_push($this->request,$cnpj);
            }

            /*if(isset($_POST['anexo'])){
                /*$anexo = filter_var($_POST['anexo'],FILTER_SANITIZE_ADD_SLASHES);
                $anexo = preg_replace("/[^0-9]/","",$anexo);
                array_push($this->request,$anexo);

                $anexo = [];
                if(is_array($_POST['anexo'])){
                    foreach($_POST['anexo'] as $key=>$value){
                        array_push(
                            $anexo,
                            (int)preg_replace(
                                "/[^0-9]/",
                                "",
                                filter_var(
                                    $value,
                                    FILTER_SANITIZE_ADD_SLASHES
                                )
                            )
                        );
                    }
                    
                }
                array_push($this->request,$anexo);
            }

            if(isset($_POST['tp_tributacao'])){
                $tp_tributacao = [];
                if(is_array($_POST['tp_tributacao'])){
                    foreach($_POST['tp_tributacao'] as $key=>$value){
                        array_push(
                            $tp_tributacao,
                            (int)preg_replace(
                                "/[^0-9]/",
                                "",
                                filter_var(
                                    $value,
                                    FILTER_SANITIZE_ADD_SLASHES
                                )
                            )
                        );
                    }
                    
                }
                array_push($this->request,$tp_tributacao);
            }

            if(isset($_POST['valor_atividade'])){
                $valor_atividade = [];
                if(is_array($_POST['valor_atividade'])){
                    foreach($_POST['valor_atividade'] as $key=>$value){
                        array_push(
                            $valor_atividade,
                            (float)str_replace(
                                ['.',','], 
                                ['','.'],
                                filter_var(
                                    $value,
                                    FILTER_SANITIZE_ADD_SLASHES
                                )
                            )
                        );
                    }
                    
                }
                array_push($this->request,$valor_atividade);
            }*/

            /*if(isset($_POST['competencia_rbt12'])){
                $competencia_rbt12 = filter_var($_POST['competencia_rbt12'],FILTER_SANITIZE_ADD_SLASHES);
                $this->ValidateCalcularRBT12->validateData($competencia_rbt12);
                array_push($this->request,$competencia_rbt12);
            }else{
                $date=date_create(date("Y-m"));
                date_sub($date,date_interval_create_from_date_string("1 month"));
                //$_POST += ['competencia'=>date_format($date,"Y-m-d")];
                $competencia_rbt12 = date_format($date,"Y-m-d");
                array_push($this->request,$competencia_rbt12);
            }*/

            //exit(json_encode($competencia_rbt12));

            if(isset($_POST['competencia'])){
                $competencia = filter_var($_POST['competencia'],FILTER_SANITIZE_ADD_SLASHES);
                $this->ValidateCalcularRBT12->validateData($competencia);
                array_push($this->request,$competencia);
            }

            /*if(isset($_POST['competencia'])){
                $competencia = filter_var($_POST['competencia'],FILTER_SANITIZE_ADD_SLASHES);
                $this->ValidateCalcularRBT12->validateData($competencia);
                $competencia = date_create($competencia);
                $competencia = (int)str_replace('-','',date_format($competencia,"Y-m"));
                array_push($this->request,$competencia);
            }else{
                $date=date_create(date("Y-m"));
                date_sub($date,date_interval_create_from_date_string("1 month"));
                //$_POST += ['competencia'=>date_format($date,"Y-m-d")];
                $competencia = (int)str_replace('-','',date_format($date,"Y-m"));
                array_push($this->request,$competencia);
            }*/

            $this->ValidateCalcularRBT12->validateFilds($this->request);

            $array_faturas = $this->ValidateCalcularRBT12->validateGetFatulra([
                'cnpj'=>(string)$cnpj,
                'competencia'=>(string)$competencia
            ]);

            /*exit(json_encode([
                "erro"=>$this->ValidateCalcularRBT12->geterror(),
                "faturas"=>$array_faturas
            ]));*/

            $retorno_rbt12 = json_decode($this->RequestJSON->request(
                DIRPAGE."calcular-simples/getRBT12_DAS_Pagamento",
                "POST",
                [
                    "cnpj"=>$cnpj,
                    "competencia"=>$competencia,
                    "anexo"=>$anexo
                ],
                [
                    "Content-type: multipart/form-data"
                ]
            ),true);

            /*exit(json_encode([
                "erro"=>$this->ValidateCalcularRBT12->geterror(),
                "faturas"=>$array_faturas,
                "rbt12"=>$retorno_rbt12
            ]));*/

            $valor_com_retencao = [
                1=>0,
                2=>0,
                3=>0,
                4=>0,
                5=>0
            ];
            $valor_sem_retencao = [
                1=>0,
                2=>0,
                3=>0,
                4=>0,
                5=>0
            ];

            foreach ($array_faturas as $key => $array) {
                $value = (int)$array['anexo'];
                switch($value){

                    case 1:
                        $valor_sem_retencao[1]+=(float)$array['faturamento_nao_retido'];
                        $valor_com_retencao[1]+=(float)$array['faturamento_retido'];
                    break;

                    case 2:
                        $valor_sem_retencao[2]+=(float)$array['faturamento_nao_retido'];
                        $valor_com_retencao[2]+=(float)$array['faturamento_retido'];
                    break;

                    case 3:
                        $valor_sem_retencao[3]+=(float)$array['faturamento_nao_retido'];
                        $valor_com_retencao[3]+=(float)$array['faturamento_retido'];
                    break;

                    case 4:
                        $valor_sem_retencao[4]+=(float)$array['faturamento_nao_retido'];
                        $valor_com_retencao[4]+=(float)$array['faturamento_retido'];
                    break;

                    case 5:
                        $valor_sem_retencao[5]+=(float)$array['faturamento_nao_retido'];
                        $valor_com_retencao[5]+=(float)$array['faturamento_retido'];
                    break;

                    default:break;
                }
            }

            $valor_sem_retencao = array_filter($valor_sem_retencao);
            $valor_com_retencao = array_filter($valor_com_retencao);

            /*exit(json_encode([
                "sem_retencao"=>$valor_sem_retencao,
                com_retencao"=>$valor_com_retencao
            ]));*/

            $retorno_calculo_simples = [];

            //$faturamento_mensal = 0;

            for ($i=1;$i<=5;$i++) {

                $valor_sem_retencao_temp = 0;
                $valor_com_retencao_temp = 0;

                if(isset($valor_sem_retencao[$i]) || isset($valor_com_retencao[$i])){
                    if(isset($valor_sem_retencao[$i])){$valor_sem_retencao_temp = $valor_sem_retencao[$i];}
                    if(isset($valor_com_retencao[$i])){$valor_com_retencao_temp = $valor_com_retencao[$i];}

                    $faturamento_mensal_temp = $valor_com_retencao_temp + $valor_sem_retencao_temp;
                    //$faturamento_mensal += $faturamento_mensal_temp;

                    array_push($retorno_calculo_simples, json_decode($this->RequestJSON->request(
                        DIRPAGE."calcular-simples/calcularSimples",
                        "POST",
                        [
                            "anexo"=>$i,
                            "rbt12"=>$retorno_rbt12['dados']['rbt12'],
                            "folha"=>0,
                            "faturamentoDoMes"=>$faturamento_mensal_temp,
                            "faturamentoSemRetencao"=>$valor_sem_retencao_temp,
                            "faturamentoComRetencao"=>$valor_com_retencao_temp
                        ],
                        [
                            "Content-type: multipart/form-data"
                        ]
                    ),true));
                }

            }

            /*$valor_atividade = [
                "com_retencao"=>$valor_com_retencao,
                "sem_retencao"=>$valor_sem_retencao
            ];*/

            //exit(json_encode([$valor_com_retencao,$valor_sem_retencao]));

            //$faturamento_mensal = $valor_com_retencao + $valor_sem_retencao;

            /*$retorno_calculo_simples = json_decode($this->RequestJSON->request(
                DIRPAGE."calcular-simples/calcularSimples",
                "POST",
                [
                    "anexo"=>$anexo,
                    "rbt12"=>$retorno_rbt12['dados']['rbt12'],
                    "folha"=>0,
                    "faturamentoDoMes"=>$faturamento_mensal,
                    "faturamentoSemRetencao"=>$valor_sem_retencao,
                    "faturamentoComRetencao"=>$valor_com_retencao
                ],
                [
                    "Content-type: multipart/form-data"
                ]
            ),true);*/

            exit(json_encode([
                "rbt12"=>$retorno_rbt12,
                "calculo_simples"=>$retorno_calculo_simples
            ]));

            /*$return = self::configuracao_emissao_DAS([
                'cnpj'=>(string)$cnpj,
                'competencia'=>(string)$competencia,
                'valor_atividade'=>(array)$valor_atividade,
                'calculo_sinmples'=>(array)$retorno_calculo_simples
            ]);*/

            //$return = self::pdf_to_array("JVBERi0xLjUKJafj8fEKMiAwIG9iago8PAovVHlwZSAvQ2F0YWxvZwovUGFnZXMgNCAwIFIKL0Fjcm9Gb3JtIDUgMCBSCi9WZXJzaW9uIC8xIzJFNQo+PgplbmRvYmoKMTEgMCBvYmoKPDwKL0ZpbHRlciAvRmxhdGVEZWNvZGUKL0xlbmd0aCAxMAo+PgpzdHJlYW0NCnicK+QCAADuAHwNCmVuZHN0cmVhbQplbmRvYmoKMTIgMCBvYmoKPDwKL0ZpbHRlciAvRmxhdGVEZWNvZGUKL0xlbmd0aCAxMAo+PgpzdHJlYW0NCnicK+QCAADuAHwNCmVuZHN0cmVhbQplbmRvYmoKMTMgMCBvYmoKPDwKL0ZpbHRlciAvRmxhdGVEZWNvZGUKL0xlbmd0aCAxMAo+PgpzdHJlYW0NCnicK+QCAADuAHwNCmVuZHN0cmVhbQplbmRvYmoKMTQgMCBvYmoKPDwKL0ZpbHRlciAvRmxhdGVEZWNvZGUKL0xlbmd0aCAxMAo+PgpzdHJlYW0NCnicK+QCAADuAHwNCmVuZHN0cmVhbQplbmRvYmoKMTUgMCBvYmoKPDwKL0ZpbHRlciAvRmxhdGVEZWNvZGUKL0xlbmd0aCAxMAo+PgpzdHJlYW0NCnicK+QCAADuAHwNCmVuZHN0cmVhbQplbmRvYmoKMTYgMCBvYmoKPDwKL0ZpbHRlciAvRmxhdGVEZWNvZGUKL0xlbmd0aCAxMAo+PgpzdHJlYW0NCnicK+QCAADuAHwNCmVuZHN0cmVhbQplbmRvYmoKMTcgMCBvYmoKPDwKL0ZpbHRlciAvRmxhdGVEZWNvZGUKL0xlbmd0aCAxMAo+PgpzdHJlYW0NCnicK+QCAADuAHwNCmVuZHN0cmVhbQplbmRvYmoKMTggMCBvYmoKPDwKL0ZpbHRlciAvRmxhdGVEZWNvZGUKL0xlbmd0aCAyMDU5Cj4+CnN0cmVhbQ0KeJzdWt1v2zYQf/dfwYc9JMDm8JvSUAxI/TFsWLu2C4Y97EVLvM5DHKeKsxb963dHkY4l8igFKPYwBI5lHX939zsej6SoD7OXVzPDmaslu7qZcfaN0eFCxDtCJxc8veXihY0XT7cMXlysJROcXf05Ewz/2vezM3bOrv6GJu/hw3utT35r8UX0SPt/U7O6mr2dffAfyX6Eu9/7a6FRzplSzAjmTM2ud7OL7e49Z8s9tIAeF76BiPKrXQCB0m+OV6D+pKmUYm6ZcxW2vliDkxLdfWG4k3ZtHfwXdmmF5NpZ439pu3ZScvyGu/DfKmegjbEr5++BxIBEOAntjVUeI1Zupez6OyR/NG4cGrcWjb/oFBpla7t03C7AnAI1K4DjvbXFq4XkcunNouKFFeiS02sF33VQ32doJHPAPdCrPbs+vPMMlK69EgcfbyoqG/bFiXJRublhQLTTL4N+wzFWqyU43Y8Id+bJorrMuCvr+lSjCPlzxsUF1xfAXrCGKR5/nGd9/AD/8QpD/dHfMRqUCgmqd74w+Mvb2S8AezuMFo7+XTZ358fcLYcFtNi67jN4oYRcQRBqDIZPldpa+KinDggppbCvnfadISG1at/aTOgOSHxb9fvibPH6zY/sVXNot5+/Pc/EW+q5NE+wkCKDHAK9Tvf1vt7vNmyzu283D027bW5LyiOWVG5FX/myOTTsZsOaPzbt4bFt2N2eIZGSkaiDNKKrvpGf7w/N3WHD7je3e/bLdnd/u3lgr5vr7f6uTEdXI5aUGYwHrAM4rpY4Dp4zGoLFqPA4gDFHsEoYp1eXMFyxQojc6AdvpOx7o1cvL70XYlhIJngSlZHced13FdNeoSWlV4brYBlLm0//BTpua/ztsOZC0QvDw5c/oAbfzvtqp/oKbpjaDtJ1c/fX4655Tr0wFY/1orvM1wtTyS9QL4w1w3oh5WqYJLFGjM0SU2oF2NT9vjqTc8GW24frdrvb3jWH7T97HITvNteb7aF5yMcOA/PRx0hpJjXOB0KxdgOx6kSyxnsorWQiVBWnRNpKGof2IBWDPZmxB9IOJxN7eVGwlxeiPR7tSZ6xxwOuL/T28qJgLy8Ee7oq2UMpYY8QdfYIIdqzRXuWtpcXBXt5IdrTRXuatpcXBXt5IdpTvJAvKCXyhRAFe0PhcEKGodqvRFf7Q3N7Oq7Yy/YRv34/e/fV7+eZeUdxibUXNM2PE0vldb3atNfNzZ79APNYe7fPYSs9d0Xs6hOF1bUg7HoOGQTylbrXtpv8sKjXXRnXsCyGmhZLOlYzmAxhMVcZ6a/qsMadOscppedVYvdM8jnn/GvOc8y0mKsUQrWGNekzDWAghOy3D/3N/sDuZs314+7xtrnBtc0Du9l/3rDd5gFWILgmabd7WFedn24WUCP3Hpw1e/bmEtPl5ZWQ+YxRNewsDK/6HtSjERkiKHpcP1O/wTB+6YDo6jQg9+3+ft92y7ftZ1QUQnSfjRHinSznqj3NVdFt9OCz6LZ0fnmy9hL8Xvqt3gKXL1avRLcjA6nCDaPfCj6t40+dsB0JdPaS6E1McG0H0ZZmrDsTSDHBn2UAHTf/RfREWAz6304m0dMn0aPCh4NB6wE7Nxq9IaI4GJ6jH/1Wg8HwE6y5YDMC80LbGxbDrM4WeShFOlUJWcNLRRCmlXoailjyQY9C7mTWSgpmfV0nqza/t0eZ85uJvhD2BDhTEVApFUIocDeJE1ilHQnUUkS9GaR2PPqUAyNTWEOTTEFWYpqHRqYEODDNYz1TAhiZ5pGRKQFGprCQIZmCrMQ0D41MCXBgmsd6pgQwMs0jI1MCjEylopmCrMQ0D41MCXBgmsd6pgQwMs0jI1MCjEyFyA9gWVdkCFBWCAEBDSGgwF0ICCyGgAKGEBDIEAIKjEwrQzMFWYlpHhqZEuDANI/1TAlgZJpHRqYEGJk6uiijrMQ0D41MCXBgmsd6pgQwMs0jI1MCjEwNXZRRVmKah0amBDgwzWM9UwIYmeaRkWkCHm4yVZU8yYGNQbLDvDyupOnNJmpzbrAQnMu5AH3j201E28GTYi7wUX1uBSIMnwuTQeQXLMLpbjYeNpeUAQmdWk/WD1VinlOvKPXK2TnPIFRh0SVlt94YGtGUkW5xngB0cXmpzOCJOjdjnZAgyp2QNLcjnTBRf+iEpLUjOwHGnp3uf+yApHlFGTAwRvVk/Rh8NThp4PVY8BNEOfjD5oKPBH+i/hD8RD05gmPwJ+qPwU8MkCM4BH+ifgy+NLnyI3LRlMDWpIjCtjd2QGJEUkZCBySAYgckrRWlPnbARP0YIJhEkuouT6o7/UAQ0Zw/t7oniHJok+Zj1X2i/hDapDVd3UNoJ+qPuZ00Jyt7yO2J+iH4cni4O1rVU0Qx+Gnzkao+VX8X/LT1WFWfqj8EP20+UtWn6sfgD0/AR6t6iigHf9h8rKpP1R+Cn6gfq+pT9cfgJwZGqvpU/Rj84RsChaoegp8gysFPmo9U9Kn6Q/CT1mMVvaifeB4nueq288Q2QYr+mwv+jFkpPHHR1q7twlbxoN2fMQu7iE9i/Snz4Flsd/aM5zZSyzp/EA96nnEQf2QiYM9UYiJs/z0EmMQ0TGHr5rBvWZvPIRGPu48vQlh8d6p7nQs/Ck+dVt05O76GgE+f/Rm7f0snf6Z+9LgWZYe5HTpswOFfm1u/HVtvP+0f8m7XauD1qIeAPzZ/ekjNurfATm4of8NTOo4Grqyfk/zbdb/9KbqX6/4F+ZqCzQ0KZW5kc3RyZWFtCmVuZG9iagoxOSAwIG9iago8PAovRmlsdGVyIC9GbGF0ZURlY29kZQovTGVuZ3RoIDg0Cj4+CnN0cmVhbQ0KeJwL5HIK4TJQCCni0ndJLctMTg1yd1JILgYKgWBxMpe+m7GCpUJIGpchWMRQwcjIRMHMwlwhJJdLw8BAzwCC9YHYUNfQQFMhJAtinmsIFwDe1hQLDQplbmRzdHJlYW0KZW5kb2JqCjIwIDAgb2JqCjw8Ci9GaWx0ZXIgL0ZsYXRlRGVjb2RlCi9MZW5ndGggNzkKPj4Kc3RyZWFtDQp4nAvkcgrhMlAIKeLSd0kty0xODXJ3UkguBgqBYHEyl76bsYKlQkgalyFYxFDByMhEwczcRCEkl0vDNcLVN8DHX1MhJAtiiGsIFwAeOBLHDQplbmRzdHJlYW0KZW5kb2JqCjIxIDAgb2JqCjw8Ci9GaWx0ZXIgL0ZsYXRlRGVjb2RlCi9MZW5ndGggODIKPj4Kc3RyZWFtDQp4nAvkcgrhMlAIKeLSd0kty0xODXJ3UkguBgqBYHEyl76bsYKlQkgalyFYxFDByMhEwczMUCEkl0vD0FTfwELf0NLSRFMhJAtijmsIFwBIqxKsDQplbmRzdHJlYW0KZW5kb2JqCjIyIDAgb2JqCjw8Ci9GaWx0ZXIgL0ZsYXRlRGVjb2RlCi9MZW5ndGggNzUKPj4Kc3RyZWFtDQp4nAvkcgrhMlAIKeLSd0kty0xODXJ3UkguBgqBYHEyl76bsYKlQkgalyFYxFDByMhEwczEQiEkl0sjODNXUyEkC2KAawgXANR8EdcNCmVuZHN0cmVhbQplbmRvYmoKMjMgMCBvYmoKPDwKL0ZpbHRlciAvRmxhdGVEZWNvZGUKL0xlbmd0aCA4NAo+PgpzdHJlYW0NCnicC+RyCuEyUAgp4tJ3SS3LTE4NcndSSC4GCoFgcTKXvpuxgqVCSBqXIVjEUMHIyETBzMhIISSXS8MAAYwMjAwNTAwMDDUVQrIgJrqGcAEABmYUcA0KZW5kc3RyZWFtCmVuZG9iagoyNCAwIG9iago8PAovRmlsdGVyIC9GbGF0ZURlY29kZQovTGVuZ3RoIDE0NAo+PgpzdHJlYW0NCnicdY/RCsIwDEXf8xX5g7VJmjEQYbOtz0r/oExQ8MXBvt9YHwYTOeSSXEguucBUwGF5QRfn9V7n63nCupj1YanQZcEByw18czwGh2ILTzhIyqNGDT1pJqeinpyIBmU9qTfXpz6xZh7J8R5q5U2lzbb7j58c00AtZ1Da7lPalN2+N5gihyOWx/fjVOANeZ413Q0KZW5kc3RyZWFtCmVuZG9iagoyNSAwIG9iago8PAovRmlsdGVyIC9GbGF0ZURlY29kZQovTGVuZ3RoIDExOQo+PgpzdHJlYW0NCnicC+RyCuEyUAgp4tJ3SS3LTE4NcndSSC4GCoFgcTKXvpuJgqVCSBqXIVjEUMHUQMEYqCGXy8bE0NzU3MTM1MwVSFqaGZsZupq7Gpu5GTsaGRjDoZErEWwaQlMDV0Mzc6D7XM0Mge4ytFMIyYL42DWECwABSTSUDQplbmRzdHJlYW0KZW5kb2JqCjI3IDAgb2JqCjw8Ci9GaWx0ZXIgL0ZsYXRlRGVjb2RlCi9MZW5ndGggMTAKPj4Kc3RyZWFtDQp4nCvkAgAA7gB8DQplbmRzdHJlYW0KZW5kb2JqCjI4IDAgb2JqCjw8Ci9GaWx0ZXIgL0ZsYXRlRGVjb2RlCi9MZW5ndGggMTAKPj4Kc3RyZWFtDQp4nCvkAgAA7gB8DQplbmRzdHJlYW0KZW5kb2JqCjI5IDAgb2JqCjw8Ci9GaWx0ZXIgL0ZsYXRlRGVjb2RlCi9MZW5ndGggMTAKPj4Kc3RyZWFtDQp4nCvkAgAA7gB8DQplbmRzdHJlYW0KZW5kb2JqCjMwIDAgb2JqCjw8Ci9GaWx0ZXIgL0ZsYXRlRGVjb2RlCi9MZW5ndGggMTAKPj4Kc3RyZWFtDQp4nCvkAgAA7gB8DQplbmRzdHJlYW0KZW5kb2JqCjMxIDAgb2JqCjw8Ci9GaWx0ZXIgL0ZsYXRlRGVjb2RlCi9MZW5ndGggMjQ1Mwo+PgpzdHJlYW0NCnicxVtLbxxHDr7Pr+hDDjLgHdX7IRgLyNJMoCCblSxlsQdfJtY40EKyYtnG/v0lq+bVTbJ6OjGwMDTubn4fm6wii+yans+zt3czr7qYTXd3P1Pd32zeHGiPB6dL02nV3X2c6Q7/vfw+O+ledXf/Acjv8Kd66P25199FTYibA2O3iO+jWIf0F/RMvZf6Pja7nUI8WNzNbmafy5/pfoLrP87U3Hf/LfMZQmdchFNtu5f17HYjMhmvSVIketsiEukNBpDu0EjdwaTHBPPzBC7qLqOHb6wxCxtMNsqb4KONPlyGpVHBBW2Uc8EHGy6CjiboRQTo8u84EuDcoeI412h2qrrNRjdqBLYPOVZtJproN8ca7hTgjibkei+TIuIjnF8GDxbAvcJlVIBxi/OwgPMMuMzc3xo795wBIWgwfhkNuOfgf4fnxbklOrfIwRTjlkNXK8Ikb4xjb6ldmmcccd+75YlRc6XUa6VeUY5Trpg55KQeQQgZsLMx85IUicm1iIIUidFsRYYhEimJNRDQWIsYay7DfAacGJhriKulx9hrRZ1REAllIh1GKU4kRstFQZaICQucSC46NQxP7plCASn0Q8ddQnwuQLNdYAzmsLTnGEROe7P59C467S78uctu4ZLj7m1yKoPc137y6/KsO79mQgRNiW4LTgV8++23x4enh6/r7n7dvVt/WD98XXXnn76tHrv3J+9+eP/qrNNziCE58DZWDBS/gVko+QWjnmvAwydkXqx5u4TRTZihOF/OuktvzdJlbz3O1KImDYyExZFxi8O1oR/Dn+ETj2ABnQfvMIbwMoaY03OoIU8zvLo5eYRQghHGw+BMkdUTq6pMza3diurxRnIj3mmvYa9O9dRVUT1WR6pTB+p8Sofq1F7dVnKzzywffQcDya/SENg4WdbIaxm3fm3TA6ISl9S60NbrJY2AVZddmGwoMGXRrdO9XeXsOZc8pgtG0XUdVGB+lHytajAH4Ua2Lp7FCA05jcutjwnrADFoWWVwvdaB4oC5BCewasD/pR6Zku/gJhzn3Wpw4OZC17uZ5eHVXr06dEeXEvgG6xxGcQjAxzXEogawHteRsqqgpdv71WqE9pZKBPaWMrFbd3a5w1iAQ1xsHnizGQ/qyXI3xZu8Iz4oU31wdSZAC2rLECA5nuP4lpG10dZxjmpjCVfKQJ/P/Sk+2S4zb1++wefVp4/PL0+r+9VZ9+6HrlXiPDYDsa9rpLDBUHd+WGO08oIgCAyjBYaJAsMagWGTwHBWYLgsMNA/HF+4rol/rCAIjOIfK4gCo/jHCpLAKP6xgkwYvTUrxLmDAfD9wnX17vonJka0MRz64vbnnzl0NPPAoP+5vPrllqt1EJ6M9uur29Pr1Zf1HxwlxnlizP/l9vb04por09axLlxd/IMzyebM6r++4ppE71jwLafZlzQZQO+ev64eGXAIc5zeXRMQC9o5PpO10RzcJAEeHY7IEK6Vfp0NN+aWV29eq8TBE6veWsObY23m8LBoC3jokALFS428txPQXrG2H9X1e6drp8BlHS62zva1Xq9ePqwfV53ml+pjGzOv1b4x25wcNGYe7Nm1Pg6a633rsxGV461krJNC3F5digfqNqJ6vJEcdFJu20kNV10XTK/F2gvKksyUG14QBAYux7wgCgxcjnlBEhi4HPOCLDDQP5v5csMLgsAo/rGCKDCKf6wgCYziHyvIAgP9M1GYce2EGVdGmHFWEARGGRFWEAVGGRFWkARGGRFWkAUG+Gez5mecFwSBgf7xgigw0D9ekAQG+scLssBA/2LmZ9yGwM+49Y6fcV4QBEYZEVYQBUYZEVaQBEYZEVaQBQb656ww46wgCIziHyuIAqP4xwqSwCj+sYJMGDfDpxKl+08S2Nk8fOnun7vFl6+r39aP6w8PT+tPX5+5qgvrf8p9/r9Wj88vu6eZ57Pmo4zJsNDsn2VS71mm1/moORTp4AYPyX9qv7E8KucQF5flARu45m19cIS/8vAZpce40oM7byb04ATd7MEput2DE/x4D07NH+vBKaPVg1N0owenYLEHJ9BmD+6cntKDE3i7ByfwkR6cqm/24AQ+0oNT9e0enOCbPfix6NqDE3RqJr/Jxya/DtOSf7ub5DbpHooMd2/223K+n/S6+XVETX7lpiT/EN1OfoIeSf4h/ojkJ+aPJj9hNJOfoFvJT8By8g+hYvJjfNtsj4pYbewUdJyi29gpuk2aohtq+hR0nqK75vyxaK8mjQlkvE16NOONTnNAkq8ax8o9Lewj2Wx9mJDNBN3MZopuZzPBj2czNX8smymjlc0U3chmChazmUCbpdw634+udikn8HYpJ/CRUk7VN0s5gY+Ucqq+XcoJvp3WR6JrKSfoo7bTjM/8E6NxkX9i5AVBYOATFS+IAgOfqHhBEhj4RMULssBA/2zgnxh5QRAYxT9WEAVG8Y8VJIFR/GMFWWCgf1rxE6tz4ieWFwSBgY7zgigw0HFekAQGOs4LssBA/1LkJ5YXBIFR/GMFUWAU/1hBEhjFP1aQBQb6F7QwsS4LE8sKgsAojrOCKDCK46wgCYziOCvIAgP9s0mYWFYQBEbxjxVEgVH8YwVJYBT/WEEmjOEXGCbF3ps5J2ae3sMqjkW3+3H9Ap/3q27x9MfL+suK/8LZxP7WC/uc5gOUGBP0xK7tL23SjPd4xuUJPR5BN3s8im73eAQ/3uNR88d6PMpo9XgU3ejxKFjs8Qi02eMZm6b0eATe7vEIfKTHo+qbPR6Bj/R4VH27xyP4Zo93LLr2eAQtbtfgKmD8+CpQdmuMHr5a9X/ZrTFKTcn9Ibqd+wQ9kvtD/BG5T8wfzX3CaOY+Qbdyn4Dl3B9Cm7s1ev8VwhG7NUej4xTddbfmaHSaorvu1hyNzlN015Q/Fl13a45G4yCG0YSvmzU62GkJP32zRns9IZkJupnMFN1OZoIfT2Zq/lgyU0YrmSm6kcwULCYzgTYLuXaqH1ztQk7g7UJO4COFnKpvFnICHynkVH27kBN8O6uPRNdCTtCtzZr9q0J695aQ77KDIcMXgepRfQ1o+IVx3q0Iw9/vzMu98Pc75H5DJXH3U4Gq5A0M9GLsJwvbn7rsXrQ94gc0bTOGG8ygSdefzpSXrRNa0ntdWG9eJdalAbmEtcxGO2YL+863gZz1QwNOlD1V6RSWQhjdcObSmbL81+4+DixfLM83L4fvXmzejBeuubwNOvp59ENdFbM73UdZVyPs4IItF8ow73QqG3DrUHUfQOe/P+ru8hnG/X/spEDvDQplbmRzdHJlYW0KZW5kb2JqCjMyIDAgb2JqCjw8Ci9GaWx0ZXIgL0ZsYXRlRGVjb2RlCi9MZW5ndGggMTA0Cj4+CnN0cmVhbQ0KeJwL5HIK4TJQCCni0ndJLctMTg1yd1JILgYKgWBxMpe+m7GCpUJIGpchWMRQwdRQwcwSKJLLpeHsF+Cl4FpckpiUmpOanJmbmleSb6VgYKBnAMH6QGyoa2CgqRCSBbHENYQLAD4zG5QNCmVuZHN0cmVhbQplbmRvYmoKMzMgMCBvYmoKPDwKL0ZpbHRlciAvRmxhdGVEZWNvZGUKL0xlbmd0aCA4Mgo+PgpzdHJlYW0NCnicC+RyCuEyUAgp4tJ3SS3LTE4NcndSSC4GCoFgcTKXvpuJgqVCSBqXIVjEUMHQ3EzB1FwhJJdLw8BAD4wMYKSBga6BpkJIFsRE1xAuAAaNFGYNCmVuZHN0cmVhbQplbmRvYmoKMzQgMCBvYmoKPDwKL0ZpbHRlciAvRmxhdGVEZWNvZGUKL0xlbmd0aCAxNDQKPj4Kc3RyZWFtDQp4nHWP0QrCMAxF3/MV+YO1SZoxEGGzrc9K/6BMUPDFwb7fWB8GEznkklxILrnAVMBheUEX5/Ve5+t5wrqY9WGp0GXBAcsNfHM8BodiC084SMqjRg09aSanop6ciAZlPak316c+sWYeyfEeauVNpc22+4+fHNNALWdQ2u5T2pTdvjeYIocjlsf341TgDXmeNd0NCmVuZHN0cmVhbQplbmRvYmoKMzUgMCBvYmoKPDwKL0ZpbHRlciAvRmxhdGVEZWNvZGUKL0xlbmd0aCAxMTkKPj4Kc3RyZWFtDQp4nAvkcgrhMlAIKeLSd0kty0xODXJ3UkguBgqBYHEyl76biYKlQkgalyFYxFDB1EDBGKghl8vGxNDc1NzEzNTMFUhamhmbGbqauxqbuRk7GhkYw6GRKxFsGkJTA1dDM3Og+1zNDIHuMrJTCMmC+Ng1hAsAAVc0lQ0KZW5kc3RyZWFtCmVuZG9iagozNyAwIG9iago8PAovRmlsdGVyIC9GbGF0ZURlY29kZQovTGVuZ3RoIDEwCj4+CnN0cmVhbQ0KeJwr5AIAAO4AfA0KZW5kc3RyZWFtCmVuZG9iagozOCAwIG9iago8PAovRmlsdGVyIC9GbGF0ZURlY29kZQovTGVuZ3RoIDEwCj4+CnN0cmVhbQ0KeJwr5AIAAO4AfA0KZW5kc3RyZWFtCmVuZG9iagozOSAwIG9iago8PAovRmlsdGVyIC9GbGF0ZURlY29kZQovTGVuZ3RoIDEwCj4+CnN0cmVhbQ0KeJwr5AIAAO4AfA0KZW5kc3RyZWFtCmVuZG9iago0MCAwIG9iago8PAovRmlsdGVyIC9GbGF0ZURlY29kZQovTGVuZ3RoIDE0Ngo+PgpzdHJlYW0NCnicZY7NCgIxDITveYp5Adekf3FBBMWu4E3owbuyB2GRvv/FdIV1QUpLMpn50kqnQpGhvUN5EmMj0opc6EZ1vg5X0y9Wm1XAdgTRQXcWmWg7OPQoI+2DaNSQYsr29sknyZp9GvzxgPJqyBXAvJ3GP8jXtLTLOkbgZlwJfhYsUH9Q9qkLbfIw5n0UnN/27w+QLi2/DQplbmRzdHJlYW0KZW5kb2JqCjQxIDAgb2JqCjw8Ci9GaWx0ZXIgL0ZsYXRlRGVjb2RlCi9MZW5ndGggNzkKPj4Kc3RyZWFtDQp4nAvkcgrhMlAIKeLSd0kty0xODXJ3UkguBgqBYHEyl76bsYKlQkgalyFYxFDB0NxMwdzCSCEkl0vDAAT0kEgopakQkgUx1TWECwBZTRUtDQplbmRzdHJlYW0KZW5kb2JqCjQyIDAgb2JqCjw8Ci9GaWx0ZXIgL0ZsYXRlRGVjb2RlCi9MZW5ndGggMTQzCj4+CnN0cmVhbQ0KeJx1j1EKAjEMRP9zitxg2yTNsiDCrm39VnqDsoKCPy54fmNFFhV5ZGAGkiEHmAo4LDfo4nw/1/m4n7AuFj1ZKnSZccByAt8Sj8Gh2MIVNpLyqFFDT5rJqagnJ6JBWXfqLfWpT6yZR3L8DbXxptK87f7jp8c0UOsZlNb7lFZ98+mYKXLYYrm8fk4FHuPnNj8NCmVuZHN0cmVhbQplbmRvYmoKNDMgMCBvYmoKPDwKL0ZpbHRlciAvRmxhdGVEZWNvZGUKL0xlbmd0aCAxMjEKPj4Kc3RyZWFtDQp4nAvkcgrhMlAIKeLSd0kty0xODXJ3UkguBgqBYHEyl76bsYKlQkgalyFYxFDB1EDBGKghl8vGxNDc1NzEzNTMFUhamhmbGbqauxqbuRk7GhkYw6GRK3Y2mgwNoamBq6GZOdCFrmaGQJcZ2ymEZEH87BrCBQBpIDT4DQplbmRzdHJlYW0KZW5kb2JqCjU0IDAgb2JqCjw8Ci9UeXBlIC9YT2JqZWN0Ci9TdWJ0eXBlIC9JbWFnZQovV2lkdGggMTQwCi9IZWlnaHQgMzMKL01hc2sgWzIzOCAyMzhdCi9Db2xvclNwYWNlIFsvSW5kZXhlZCAvRGV2aWNlUkdCIDI1NSA8MTgxMjEwRjlGOEY4M0YzQTM4NjU2MTYwOEI4ODg3MUUxOTE3QTRBMkExRkNGQ0ZDRjVGNUY1RDdENkQ2MjIxQzFBMzMyRTJDQjFBRkFFNEM0NzQ1RTRFM0UzQkVCQ0JDNTg1NDUzN0U3QjdBRkFGOUY5RkRGREZEMjYyMDFFRjFGMUYxMUMxNjE0MjExQjE5MUExNDEyMjUxRjFERkFGQUZBRjRGNEY0QTRBMUEwMTkxMzExRjZGNkY2OTk5Njk1MUIxNTEzRkJGQkZCMzQyRjJEMUQxODE2NTY1MTUwNjQ2MDVGQjdCNUI0RjNGM0YzMkYyOTI3OEY4QzhCN0E3Njc1NTc1MjUxQzFDMEJGNDAzQjM5N0Q3QTc5QTlBN0E2MjYyMTFGRURFQ0VDRDhEN0Q3MUQxNzE1ODk4Njg1RTNFMkUyRjdGN0Y3QTNBMDlGNzA2QzZCNkQ2OTY4OTE4RjhFM0QzODM2Q0JDQUNBQkRCQkJCOTY5MzkyREFEOUQ5RERERERDNzg3NTczNjM1RjVFRUZFRUVFNDc0MjQxMzUzMDJFM0EzNTM0MjAxQTE4MzgzMzMxMzIyRDJCRUVFREVEMjMxRDFCNjA1QzVCMjkyNDIyNUI1NzU1RDNEMUQxQTVBM0EyN0I3Nzc2REJEQURBMzYzMTJGOTA4RThERThFOEU4RTlFOUU5MjgyMzIxOEU4QjhBNTQ0RjRFREZERURFOEQ4QTg5NEQ0OTQ3MjcyMjIwRUFFQUU5Q0NDQkNCODI3RjdFRDZENUQ1QjVCM0IyRDREM0QzM0UzOTM3QjlCN0I3NEI0NjQ0NDEzQzNBNkM2ODY3MkUyODI2NDQ0MDNFRTVFNEU0MkEyNTIzRDVENEQ0Q0RDQ0NCRDlEOEQ4RTdFN0U3ODY4MjgxRTFFMEUwNDk0NDQzQTdBNUE0OTM5MDhGRUJFQkVBNTU1MDRGRTBERkRGNEY0QjQ5NkU2QTY5NDg0MzQyMzkzMzMyMzAyQjI5RjJGMkYyNjI1RTVENUQ1OTU3NTI0RDRDNjk2NTYzODA3RDdDQUNBOUE5NUY1QTU5RUNFQkVCQkFCOEI4NTM0RTRENDY0MTQwQUZBREFEOTQ5MTkwODc4MzgyNzI2RTZENDMzRTNDQUFBOEE3REVERUREQjRCMkIxOUE5ODk3N0M3ODc3MUYxOTE3QzVDNEMzQzJDMUMwM0IzNjM1NTc1MzUyODU4MjgwNzc3NDcyODQ4MTgwQjBBRUFEOEM4OTg4NzQ3MTcwMkIyNjI0OTc5NDkzRENEQkRBQzZDNEM0QjNCMUIwREREQ0RCMzEyQzJBNjY2MjYxNzE2RDZDOEE4Nzg2NDIzRDNCRDBDRkNFQkNCQUJBQTA5RDlEN0Y3QzdCQjJCMEFGQkZCREJDOUU5QzlCRjhGOEY4NUU1QTU4ODg4NTg0OUY5QzlDODc4NDgzQURBQUFBNzk3NTc0QUVBQ0FDMzAyQTI4QzlDN0M3OUM5QTk5NjA1QjVBMkQyNzI2RDREMkQyNkE2NjY0NkY2QjZBQTZBNEEzMjQxRTFDQjdCNkI1NEU0QTQ4NEQ0ODQ2QjZCNEIzNEE0NTQ0QzBCRUJERTZFNUU1QURBQkFCQzNDMkMxNzM3MDZGQUJBOUE4RTJFMUUxM0EzNDMzM0MzNzM1NkI2ODY2OUI5OTk4Q0ZDRUNERDFEMENGOTA4RDhDQjhCN0I2Q0VDRENDQ0FDOEM4NzM2RjZFOUQ5QjlBNUM1ODU2Njg2NDYyQzBCRkJFOTU5MjkxQkJCOUI5QzhDNkM2QThBNkE1RTdFNkU2NDMzRjNEQTI5RjlFNDU0MDNGOTg5NTk0NzU3MjcxRjBFRkVGNTk1NTUzNjc2MzYyMkMyNjI1OUE5Nzk2QzdDNUM1RkZGRkZGMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwPl0KL0JpdHNQZXJDb21wb25lbnQgOAovRmlsdGVyIC9GbGF0ZURlY29kZQovTGVuZ3RoIDE1MDAKPj4Kc3RyZWFtDQp4nOWX9VdbSRTHb4CQoA0JhQQr7u5WimsLFChQKMVKC3V3d3f3bmXr7ltdd3d33/s37J1574UXAi3n7MnuD/s9J+/N3HvnzWd8gohxU1DU4ksHP87G/1AehyaIqcgoACgbrhWzA1/+11n+DBITo+uAa5bksd7FnrpgL1tb2xhPCnhsy+S1m5k9bnvxzDYV4mCe5AoewotOqJR8okJibOVKaRaskemHrYOWu9g28GxpU44Y7uwmsCxkGT91XFJacSml1F3MqE+iKgU/FHqQ+ayYKVagah10q2joVvKul3yS7MBU4czo+K6Utf+ylvIzIVqKr4/ldrfEQzn3Fvgb7AMghrGUMKO7czeL8m0yp4iZMcQy1qSal64gHpR8RpYAUxZW6RtuMgMbnUD43Vig4fp7Z8rkJa4yFgcOTiwDJPN6Mm8S01bE4mRaTxa1WPIZWZRm/TK6QGiZaAnGhiIIHSGbPVrnbSvy3aUShqm9suyguIyeLHpN0Dyh8RNr+2LRF0ZZcY15H/FrZnE9bremnAcPxZX0fNhjNntMPz9SrKmjV5bxfjhJ6l8ji/IY6tbwGr0z+2Kx36oQpUM/PrJdeVTDEZb6QXuN0T6DZrq+kH/tuV5Z3KfiW/Ty9TZhiadi43jr7/bFUhYia/F4oV3ftftUpv+8ZXADrmL56snmMHk7mGejGYu/ko9tOD03u5qw0DY1+iTvl4q+WAISB3EdjaHVvk9sWUBJ2k22YDGKZ5u2l5rT1AOf7j1YRm6mxwFkjQq/L2fx3W8TzbsF8pOfOnf9yTN3WHfefelZRGlr8D99wgzmHkCLGUvQLXosy6bpXfa6Sb90K/Lp64h7BkyUWWK/EsaIy7DvrzxTlkiAGnOWb2iW3JlFqcIP3HtlScWnsxRwz6evyHaYKEWiLEAfuqpxzdRuFlq3N81YyhV7aDzYrvgwe2cvLIZon75Z3JaesmbK3egnmKtmBRo7Z8AL0EPDlndP5GdhiBnLb2QV5OislLP4pq1wcbFZKZzzIou2B4u9bCsLmd7+7eDgWlx9briwn4XNjjWMc4pY8ij8RtgRqWXGJd5S7GfGokFbsZtVVSYsyumy4RVYxuETWBrdA/QAF1gyjEc34pxUrXiazpG6ZokUHu2CvbC0CoNsjVNMWezMWIbtuODClYLxnMXdbqAoT/ychyyKo+jbPLkFU8ql8tcklkDJkp7ZG0syPyzhI+H7T2IxahQOEXZkg6uoCGxN4K61bZltP/Ea5qLnUOkqlbRILJklfdETe2PBIP7ZXUK/94tFI7J0a4YOa8Skr/C6QcV2NUsfmBTBXYe1KJc5y3b2vrP4H7E4qdBvidyQyi5FqDN+Qbd7g03WXTSVp4HH0l2qg71fRMwUmdrZ24FYrHjEJFmhlT3HqOddKoomqc+bxmxRvQr7Ie0gG1KWGnErS1wkunR60+Y6O4zelTrUVTJHjXynjLcx0XpcHWZqieFhu2s6RzqNXZu2vao/JJaXql898r+WwkKixegRokJtCCXUfHNIrk2m+cpOq9LVNC5qH9TRj6Joc/dR0wqKsbKQApMxPTRC0dI1CC/5lziiyqvYd8+PcYX5Hr92Fu0cW9HuUP1hc8lalXpU6COcUlB9DHEjWEj31TgcYEMnJGIau1ifhzrahjqUfyjmQ34oLGija9kW+i92jk6GuE8AWhFtLMXioEYXOpHWQRiG6u3r4gLBRnU5OF5Z0Kps8jxhKNpAm9887zEEXAaO8eBmZ3EWUlYFWF8FRyd2j8fvE945DicRM9xOs8sPnFm8xz8XfnkAbtmWZllGR9zRRrBXwnwNdOYtK2wzVDcnKDNfm+jqpXfYS8fSq97eAeDfkeAbbDd3mqVY6jzxFuR4AeRkwJx50EUVPQ8ZkyH2yinQK2FaJIRWNEHUfNgcEQup7MxecDHX2iLKXaHFFM1M3WeaxC8OoGK5pmpmRH74iIHlqTg7Z8aoet0DzSZ8rNm/aWkSXt7rkqsJDGz5Gy9EwLUNCmVuZHN0cmVhbQplbmRvYmoKNTUgMCBvYmoKPDwKL1R5cGUgL1hPYmplY3QKL1N1YnR5cGUgL0Zvcm0KL1Jlc291cmNlcyA1NiAwIFIKL0JCb3ggWzAgMCAxMDAgMTAwXQovRm9ybVR5cGUgMQovTWF0cml4IFsxIDAgMCAxIDAgMF0KL0ZpbHRlciAvRmxhdGVEZWNvZGUKL0xlbmd0aCA4Cj4+CnN0cmVhbQ0KeJwDAAAAAAENCmVuZHN0cmVhbQplbmRvYmoKMSAwIG9iago8PAovVHlwZSAvT2JqU3RtCi9OIDIxCi9GaXJzdCAxNDEKL0ZpbHRlciAvRmxhdGVEZWNvZGUKL0xlbmd0aCA1NyAwIFIKPj4Kc3RyZWFtDQp4nL2TbWsTQRDHv8qAL5ogZndnZvf2pBRMY95IsUShQpsXaW4NJ/VO7i6g397Zm1pMxIKl+Gbnbh7+89uHIbDA4GwED85HCOAiQgEUChCfs1BCoFIyIDADBghFkCgUUiKOgqXeQxE9cIDoCFgKRYgjxIKBS4hlCV50nBc9KMsCPIpegeAJnPMMXroilnB6ai67ttpvUwcTnPEMGW4mPKOZo5spTM15lzZD3TaLzZBgsniNFtFGSy5wdPjK0om1J1Nz0VZHGew8svUvLY4ZZ2e518cf3xKYy80u9ea83TcDkHlXVz1cBzmVlZxCXmNe11qxrNNdjq/NYiUHI4FjJXORqnozb7/DtZW4Lz1ExrVZpb7dd9vU55OUOmnYDKkZRMy5sY9DNaSG1Xg1CuSUyEU1IwCgVaMqqCqoKqgqOKqsBbCTlsBPA8dwBI6Kg4qDikOKQ4pDikOKQ4pDz4JDxzikOKQ4pDisOKw4rDhMfwG4v+U2O0ev+fT+9kvaDvmNP1BqPBzGi+N4PIz/9lqWLs9Dji4xj8T4RXkqxi/Oc/GQXH/dyfbvYT5LpX+i0B/FByWPJOql5E2ZD/vbYfzLPmfmmz6Nm83j09Wpe4GLeXtXmbfNtq3qZgfmqm7eNH39y/HPis8o9d/hZPkJhcliAg0KZW5kc3RyZWFtCmVuZG9iago1NyAwIG9iago0OTQKZW5kb2JqCjU4IDAgb2JqCjw8Ci9TaXplIDU5Ci9Sb290IDIgMCBSCi9JbmZvIDMgMCBSCi9JRCBbPDlBNzY5QjZGQzk1Q0U5MTVGRDI0NzNCRTQ3REQwNjA3PiA8OUE3NjlCNkZDOTVDRTkxNUZEMjQ3M0JFNDdERDA2MDc+XQovVHlwZSAvWFJlZgovSW5kZXggWzAgNTldCi9XIFsxIDIgMl0KL0RMIDI5NQovRmlsdGVyIC9GbGF0ZURlY29kZQovTGVuZ3RoIDE4MQo+PgpzdHJlYW0NCnicLc8/EsFgEAXw3SRIJJH4M2MGCWmUTGZoHEKtUOidwQUUTqChUCkUeoUjmOECzqDQxHuS5rfzivftfiKSZTqeiKgEIgbGHyUGMYlFSqRMKiorNq5AbbIkF2BYZEHOwDXJAXgz8gT+GtQc8s632RqcEIMvCOfkSD6g8wLdLegNQVTc52h0R4zbhO/FN9Dfg8EUJMVnqsQlHvFJjQQkJHXSIE1NHuiONnm3pekOMcUtPyiFFvkNCmVuZHN0cmVhbQplbmRvYmoKc3RhcnR4cmVmCjEyNzA2CiUlRU9GCg==");

            /*exit(json_encode([
                "rbt12"=>$retorno_rbt12,
                "simples"=>$retorno_calculo_simples
            ]));*/
        }
    }

    private function configuracao_emissao_DAS(array $dados){
        
        exit(json_encode($dados));

        $atividades = [];

        $receitaPaCompetenciaInterno = 0;
        foreach ($dados['valor_atividade']['com_retencao'] as $key => $array) {
            /*foreach ($array as $key => $value) {
                $key = (int)$key;
                $atividades += match ($key) {
                    $key == 1 => ,
                    $key>= 3 || 5<=$key =>[
                        [
                            'idAtividade'=>15,
                            'valorAtividade'=>$value
                        ]
                    ]
                }
            }*/
            
            
            $atividades += [
                [
                    'idAtividade'=>$value,
                    'valorAtividade'=>$value
                ]
            ];
            $receitaPaCompetenciaInterno += $value;
            $atividades[$key] += ['valorAtividade'=>$value];
            $atividades[$key] += ['receitasAtividade'=>['valor'=>$value]];
        }

        $particao_DAS = [];

        /*foreach($dados['calculo_sinmples']['dadosAliquota']['DAS'] as $key=>$array){
            if(!empty($array[$key."_ValorImposto"])){
                switch ($key) {
                    case 'IRPJ':
                        array_push($particao_DAS,[
                            "codigoTributo" => 1001, 
                            "valor" => $array['IRPJ_ValorImposto']
                        ]);
                    break;

                    case 'CSLL':
                        array_push($particao_DAS,[
                            "codigoTributo" => 1002, 
                            "valor" => $array['CSLL_ValorImposto']
                        ]);
                    break;
                    
                    case 'COFINS':
                        array_push($particao_DAS,[
                            "codigoTributo" => 1004, 
                            "valor" => $array['COFINS_ValorImposto']
                        ]);
                    break;

                    case 'PIS':
                        array_push($particao_DAS,[
                            "codigoTributo" => 1005, 
                            "valor" => $array['PIS_ValorImposto']
                        ]);
                    break;

                    case 'CPP':
                        array_push($particao_DAS,[
                            "codigoTributo" => 1006, 
                            "valor" => $array['CPP_ValorImposto']
                        ]);

                    break;

                    case 'ICMS':
                        array_push($particao_DAS,[
                            "codigoTributo" => 1007, 
                            "valor" => $array['ICMS_ValorImposto']
                        ]);
                    break;

                    case 'IPI':
                        array_push($particao_DAS,[
                            "codigoTributo" => 1008, 
                            "valor" => $array['IPI_ValorImposto']
                        ]);
                    break;

                    case 'ISS':
                        array_push($particao_DAS,[
                            "codigoTributo" => 1010, 
                            "valor" => $array['ISS_ValorImposto']
                        ]);
                    break;
                }
            }
        }*/

        $array_DAS = [
            "IRPJ"=>0,
            "CSLL"=>0,
            "COFINS"=>0,
            "PIS"=>0,
            "CPP"=>0,
            "ICMS"=>0,
            "IPI"=>0,
            "ISS"=>0
        ];

        for($i=0;$i<=count($dados['calculo_sinmples']);$i++){
            foreach($dados['calculo_sinmples'][$i]['dadosAliquota']['DAS']  as $key => $array){
                if(!empty($array[$key."_ValorImposto"])){
                    switch ($key) {
                        case 'IRPJ':
                            $array_DAS['IRPJ'] += $array['IRPJ_ValorImposto'];
                        break;
    
                        case 'CSLL':
                            $array_DAS['CSLL'] += $array['CSLL_ValorImposto'];
                        break;
                        
                        case 'COFINS':
                            $array_DAS['COFINS'] += $array['COFINS_ValorImposto'];
                        break;
    
                        case 'PIS':
                            $array_DAS['PIS'] += $array['PIS_ValorImposto'];
                        break;
    
                        case 'CPP':
                            $array_DAS['CPP'] += $array['CPP_ValorImposto'];
                        break;
    
                        case 'ICMS':
                            $array_DAS['ICMS'] += $array['ICMS_ValorImposto'];
                        break;
    
                        case 'IPI':
                            $array_DAS['IPI'] += $array['IPI_ValorImposto'];
                        break;
    
                        case 'ISS':
                            $array_DAS['ISS'] += $array['ISS_ValorImposto'];
                        break;
                    }
                }
            }
        }

        /*[
            "idAtividade" => $dados['tp_tributacao'],
            "valorAtividade" => 6000,
            "receitasAtividade" => [
                [
                    "valor" => 6000,
                    "codigoOutroMunicipio" => 9701,
                    "outraUf" => "DF",
                    "isencoes" => null,
                    "reducoes" => null,
                    "qualificacoesTributarias" => null,
                    "exigibilidadesSuspensas" => null
                ],
            ],
        ]*/

        $array_DAS = array_filter($array_DAS);

        foreach($array_DAS as $key => $value){
            $array_das_temp = [];
            switch ($key) {
                case 'IRPJ': array_push($array_das_temp,["codigoTributo"=>1001]); break;
                case 'CSLL': array_push($array_das_temp,["codigoTributo"=>1002]); break;
                case 'COFINS': array_push($array_das_temp,["codigoTributo"=>1004]); break;
                case 'PIS': array_push($array_das_temp,["codigoTributo"=>1005]); break;
                case 'ICMS': array_push($array_das_temp,["codigoTributo"=>1007]); break;
                case 'CPP': array_push($array_das_temp,["codigoTributo"=>1006]); break;
                case 'IPI': array_push($array_das_temp,["codigoTributo"=>1008]); break;
                case 'ISS': array_push($array_das_temp,["codigoTributo"=>1010]); break;
            }
            array_push($array_das_temp,["valor"=>$value]);
            array_push($particao_DAS,$array_das_temp);
        }

        /*exit(json_encode([
            "DAS"=>$particao_DAS,
            "simples_array"=>$dados['calculo_sinmples']
        ]));*/

        $array = [

            "cnpjCompleto" => $dados['cnpj'],
            "pa" => $dados['competencia'],
            "indicadorTransmissao" => true,
            "indicadorComparacao" => true,

            "declaracao" => [
                "tipoDeclaracao" => 1,
                "receitaPaCompetenciaInterno" => $receitaPaCompetenciaInterno,
                "receitaPaCompetenciaExterno" => 0,
                "estabelecimentos" => [
                    [
                        "cnpjCompleto" => $dados['cnpj'],
                        "atividades" =>$atividades,
                    ],
                ],
            ],

            "valoresParaComparacao" => $particao_DAS
        ];

        return $array;
    }

    public function empresas_faturamentoDAS(){

        /*if($_SERVER['REQUEST_METHOD']!="POST"){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{
            if($_POST['']){}
        }*/

        exit(json_encode([
            "empresas" => $this->ValidateCalcularRBT12->validateGetEmpresasFaturamentoDAS(),
            'erro'=>$this->ValidateCalcularRBT12->getError()
        ]));
    }

    public function calcularDAS(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{

            if(isset($_POST['cnpj'])){
                $cnpj = filter_var($_POST['cnpj'],FILTER_SANITIZE_ADD_SLASHES);
                $cnpj = preg_replace("/[^0-9]/","",$cnpj);
                $this->ValidateCalcularRBT12->validateCNPJ($cnpj);
                array_push($this->request,$cnpj);
            }

            if(isset($_POST['competencia'])){
                $competencia = filter_var($_POST['competencia'],FILTER_SANITIZE_ADD_SLASHES);
                $this->ValidateCalcularRBT12->validateData($competencia);
                array_push($this->request,$competencia);
            }else{
                $date=date_create(date("Y-m"));
                date_sub($date,date_interval_create_from_date_string("1 month"));
                //$_POST += ['competencia'=>date_format($date,"Y-m-d")];
                $competencia = date_format($date,"Y-m-01");
                array_push($this->request,$competencia);
            }

            $this->ValidateCalcularRBT12->validateFilds($this->request);

            $array_faturas = $this->ValidateCalcularRBT12->validateGetFatulra([
                'cnpj'=>(string)$cnpj,
                'competencia'=>(string)$competencia
            ]);

            $retorno_rbt12 = json_decode($this->RequestJSON->request(
                DIRPAGE."calcular-simples/getRBT12_DAS_Pagamento",
                "POST",
                [
                    "cnpj"=>$cnpj,
                    "competencia"=>$competencia,
                    "anexo"=>$anexo
                ],
                [
                    "Content-type: multipart/form-data"
                ]
            ),true);

            /*exit(json_encode([
                'erro'=>$this->ValidateCalcularRBT12->getError(),
                'dados'=>$retorno_rbt12
            ]));*/

            $valor_com_retencao = [
                1=>0,
                2=>0,
                3=>0,
                4=>0,
                5=>0
            ];
            $valor_sem_retencao = [
                1=>0,
                2=>0,
                3=>0,
                4=>0,
                5=>0
            ];

            foreach ($array_faturas as $key => $array) {
                $value = (int)$array['anexo'];
                switch($value){

                    case 1:
                        $valor_sem_retencao[1]+=(float)$array['faturamento_nao_retido'];
                        $valor_com_retencao[1]+=(float)$array['faturamento_retido'];
                    break;

                    case 2:
                        $valor_sem_retencao[2]+=(float)$array['faturamento_nao_retido'];
                        $valor_com_retencao[2]+=(float)$array['faturamento_retido'];
                    break;

                    case 3:
                        $valor_sem_retencao[3]+=(float)$array['faturamento_nao_retido'];
                        $valor_com_retencao[3]+=(float)$array['faturamento_retido'];
                    break;

                    case 4:
                        $valor_sem_retencao[4]+=(float)$array['faturamento_nao_retido'];
                        $valor_com_retencao[4]+=(float)$array['faturamento_retido'];
                    break;

                    case 5:
                        $valor_sem_retencao[5]+=(float)$array['faturamento_nao_retido'];
                        $valor_com_retencao[5]+=(float)$array['faturamento_retido'];
                    break;

                    default:break;
                }
            }

            $valor_sem_retencao = array_filter($valor_sem_retencao);
            $valor_com_retencao = array_filter($valor_com_retencao);

            $retorno_calculo_simples = [];

            for ($i=1;$i<=5;$i++) {

                $valor_sem_retencao_temp = 0;
                $valor_com_retencao_temp = 0;

                if(isset($valor_sem_retencao[$i]) || isset($valor_com_retencao[$i])){
                    if(isset($valor_sem_retencao[$i])){$valor_sem_retencao_temp = $valor_sem_retencao[$i];}
                    if(isset($valor_com_retencao[$i])){$valor_com_retencao_temp = $valor_com_retencao[$i];}

                    $faturamento_mensal_temp = $valor_com_retencao_temp + $valor_sem_retencao_temp;
                    //$faturamento_mensal += $faturamento_mensal_temp;

                    array_push($retorno_calculo_simples, json_decode($this->RequestJSON->request(
                        DIRPAGE."calcular-simples/calcularSimples",
                        "POST",
                        [
                            "anexo"=>$i,
                            "rbt12"=>$retorno_rbt12['dados']['rbt12'],
                            "folha"=>0,
                            "faturamentoDoMes"=>$faturamento_mensal_temp,
                            "faturamentoSemRetencao"=>$valor_sem_retencao_temp,
                            "faturamentoComRetencao"=>$valor_com_retencao_temp
                        ],
                        [
                            "Content-type: multipart/form-data"
                        ]
                    ),true));
                }

            }

            exit(json_encode([
                "rbt12"=>$retorno_rbt12,
                "calculo_simples"=>$retorno_calculo_simples
            ]));
        }
    }

    public function getFaturas(){

        if($_SERVER['REQUEST_METHOD']!="POST"){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
            return false;
        }

        if(isset($_POST['cnpj'])){
            $cnpj = filter_var($_POST['cnpj'],FILTER_SANITIZE_ADD_SLASHES);
            $cnpj = preg_replace("/[^0-9]/","",$cnpj);
            $this->ValidateCalcularRBT12->validateCNPJ($cnpj);
            array_push($this->request,$cnpj);
        }

        if(isset($_POST['competencia'])){
            $competencia = filter_var($_POST['competencia'],FILTER_SANITIZE_ADD_SLASHES);
            $this->ValidateCalcularRBT12->validateData($competencia);
            array_push($this->request,$competencia);
        }else{
            $date=date_create(date("Y-m"));
            date_sub($date,date_interval_create_from_date_string("1 month"));
            $competencia = date_format($date,"Y-m-01");
        }

        $array_faturas = $this->ValidateCalcularRBT12->validateGetFatulra([
            'cnpj'=>(string)$cnpj,
            'competencia'=>(string)$competencia
        ]);


        exit(json_encode([
            'erro'=>$this->ValidateCalcularRBT12->getError(),
            'dados'=>$array_faturas
        ]));

    }

    public function atualizarDAS_Empresas(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
            return false;
        }

        if(!isset($_POST['rogeri0'])){
            exit(json_encode("Não foi possível encontrar o token de autenticação",JSON_UNESCAPED_UNICODE));
            return false;
        }

        if(isset($_POST['competencia'])){
            $competencia = filter_var($_POST['competencia'],FILTER_SANITIZE_ADD_SLASHES);
            $this->ValidateCalcularRBT12->validateData($competencia);
            array_push($this->request,$competencia);
        }else{
            $date=date_create(date("Y-m"));
            date_sub($date,date_interval_create_from_date_string("1 month"));
            //$_POST += ['competencia'=>date_format($date,"Y-m-d")];
            $competencia = date_format($date,"Y-m-01");
            array_push($this->request,$competencia);
        }

        $empresas = $this->ValidateCalcularRBT12->validateGetEmpresasDAS();

        if(!$empresas){
            exit(json_encode("No have empresas"));
            return false;
        }

        $variavel = [];
        $retorno_rbt12 = [];
        foreach($empresas as $key => $array){
            array_push($retorno_rbt12, json_decode($this->RequestJSON->request(
                DIRPAGE."calcular-simples/getRBT12_DAS_Pagamento",
                "POST",
                [
                    "cnpj"=>$array['cnpj'],
                    "competencia"=>$competencia,
                    "anexo"=>$anexo
                ],
                [
                    "Content-type: multipart/form-data"
                ]
            ),true));
            //array_push($variavel,$value);
        }

        exit(json_encode($retorno_rbt12));
    }
}
    
?>