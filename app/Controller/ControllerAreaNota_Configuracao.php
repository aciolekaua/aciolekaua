<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassValidate;
use Src\Classes\ClassValidateAreaNotaConfiguracao;
use Src\Classes\ClassJWT;
use Src\Classes\ClassRequestJSON;
use Src\Classes\ClassSessions;
use Src\Traits\TraitUrlParser;
class ControllerAreaNota_Configuracao{
    use TraitUrlParser;
    private $Validate;
    private $ValidateAreaNotaConfiguracao;
    private $Render;
    private $JWT;
    private $RequestJSON;
    private $Session;
    function __construct(){
        $this->Render=new ClassRender;
        $this->Validate=new ClassValidate;
        $this->ValidateAreaNotaConfiguracao = new ClassValidateAreaNotaConfiguracao;
        $this->JWT = new ClassJWT;
        $this->RequestJSON = new ClassRequestJSON;
        $this->Session=new ClassSessions;
        $this->Render->setDir("AreaNota/Configuracao");
        $this->Render->setTitle("Configuração de Notas");
        $this->Render->setDescription("Pagina de configurações MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            $this->Render->addSession();
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout("Home");
        }
    }
    
    public function cadastrarPJ(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            
            $arrayPost=[];
            
            if(isset($_POST['InscricaoEstadual'])){
                $InscricaoEstadual = (int)preg_replace("/[^0-9]/","",$_POST['InscricaoEstadual']);
                $InscricaoEstadual = filter_var($InscricaoEstadual,FILTER_VALIDATE_INT,FILTER_FLAG_ALLOW_OCTAL);
                $arrayPost+=["InscricaoEstadual"=>$InscricaoEstadual];
            }
            
            if(isset($_POST['InscricaoMunicipal'])){
                $InscricaoMunicipal = (int)preg_replace("/[^0-9]/","",$_POST['InscricaoMunicipal']);
                $InscricaoMunicipal = filter_var($InscricaoMunicipal,FILTER_VALIDATE_INT,FILTER_FLAG_ALLOW_OCTAL);
                $arrayPost+=["InscricaoMunicipal"=>$InscricaoMunicipal];
            }
            
            
            if(isset($_POST['IncentivadorCultural'])){
                $IncentivadorCultural = (int)preg_replace("/[^0-9]/","",$_POST['IncentivadorCultural']);
                $IncentivadorCultural = filter_var($IncentivadorCultural,FILTER_VALIDATE_INT,FILTER_FLAG_ALLOW_OCTAL);
                //$arrayPost+=["IncentivadorCultural"=>$IncentivadorCultural];
            }
            
            if(isset($_POST['CodigoCRT'])){
                $CodigoCRT = (int)preg_replace("/[^0-9]/","",$_POST['CodigoCRT']);
                $CodigoCRT = filter_var($CodigoCRT,FILTER_VALIDATE_INT,FILTER_FLAG_ALLOW_OCTAL);
                $arrayPost+=["CodigoCRT"=>$CodigoCRT];
            }
            
            if(isset($_POST['Regimento'])){
                $Regimento = (int)preg_replace("/[^0-9]/","",$_POST['Regimento']);
                $Regimento = filter_var($Regimento,FILTER_VALIDATE_INT,FILTER_FLAG_ALLOW_OCTAL);
                $arrayPost+=["Regimento"=>$Regimento];
            }
            
            if(isset($_POST['certificadoDigital'])){
                $certificadoDigital = $_POST['certificadoDigital'];
                $arrayPost+=["CertificadoDigital"=>$certificadoDigital];
            }
            
            if(isset($_POST['SenhaCD'])){
                $senhaCD = $_POST['SenhaCD'];
                $arrayPost+=["SenhaCD"=>$senhaCD];
            }
            
            if(isset($_FILES['arquivoCD'])){
                $tipo = pathinfo($_FILES['arquivoCD']['name'],PATHINFO_EXTENSION);
                if($tipo=='pfx'){
                    $certificadoArq = $_FILES['arquivoCD']['tmp_name'];
                    $certificadoArq = base64_encode(file_get_contents($certificadoArq));
                    $arrayPost+=["arquivoCD"=>$certificadoArq];
                }else{$arrayPost+=["arquivoCD"=>false];}
            }
            
            if(isset($_POST['Modelo'])){
                $modelo = (int)preg_replace("/[^0-9]/","",$_POST['Modelo']);
                $modelo = filter_var($modelo,FILTER_VALIDATE_INT,FILTER_FLAG_ALLOW_OCTAL);
                $arrayPost +=["Modelo"=>$modelo];
            }
            
            if(isset($_POST['Modulo'])){
                $modulo = (int)preg_replace("/[^0-9]/","",$_POST['Modulo']);
                $modulo = filter_var($modulo,FILTER_VALIDATE_INT,FILTER_FLAG_ALLOW_OCTAL);
                if($modulo!=false){
                    switch($modulo){
                        case 1:$modulo = "NFSe";break;
                        default:$modulo = false;break;
                    }
                }
                $arrayPost +=["Modulo"=>$modulo];
            }
            
            
            $this->ValidateAreaNotaConfiguracao->validateFilds($arrayPost);
            $retorno = $this->ValidateAreaNotaConfiguracao->validateIssetConfiguracaoEmissaoNota(["cnpj"=>(string)$_SESSION['ID']]);
            if($retorno){
                $this->ValidateAreaNotaConfiguracao->validateUpdateConfiguracaoEmissaoNota([
                    "cnpj"=>(string)$_SESSION['ID'],
                    "inscricaoEstadual"=>(string)$InscricaoEstadual,
                    "inscricaoMunicipal"=>(string)$InscricaoMunicipal,
                    "incentivadorCultural"=>(bool)$IncentivadorCultural,
                    "codigoCRT"=>(int)$CodigoCRT,
                    "regime"=>(int)$Regimento
                ]);
            }else{
                $this->ValidateAreaNotaConfiguracao->validateInsertConfiguracaoEmissaoNota([
                    "cnpj"=> (string)$_SESSION['ID'],
                    "inscricaoEstadual"=> (string)$InscricaoEstadual,
                    "inscricaoMunicipal"=> (string)$InscricaoMunicipal,
                    "incentivadorCultural"=> (bool)$IncentivadorCultural,
                    "codigoCRT"=> (int)$CodigoCRT,
                    "regime"=> (int)$Regimento,
                    "certificaDoDigital"=> (string)$certificadoDigital,
                    "senhaCD"=> (string)$senhaCD,
                    "arquivoCD"=> (string)$certificadoArq,
                    "modulo"=>$modulo,
                    "modelo"=>$modelo
                ]);
            }
            
            $retorno = $this->ValidateAreaNotaConfiguracao->validateGetEmpresaAPI($_SESSION['ID']);
            
            if($retorno[0]['Codigo']!=100){
                $this->ValidateAreaNotaConfiguracao->validateInsertEmpresaAPI([
                    "cnpj"=> (string)$_SESSION['ID'],
                    "inscricaoEstadual"=> (string)$InscricaoEstadual,
                    "inscricaoMunicipal"=> (string)$InscricaoMunicipal,
                    "incentivadorCultural"=> (bool)$IncentivadorCultural,
                    "codigoCRT"=> (int)$CodigoCRT,
                    "regime"=> (int)$Regimento,
                    "certificaDoDigital"=> (string)$certificadoDigital,
                    "senhaCD"=> (string)$senhaCD,
                    "arquivoCD"=> (string)$certificadoArq,
                    "modulo"=>$modulo,
                    "modelo"=>$modelo
                ]);
            }
            exit(json_encode([
                'sucessos'=>$this->ValidateAreaNotaConfiguracao->getMessage(),
                'erros'=>$this->ValidateAreaNotaConfiguracao->getError()
            ]));
            
        }else{
            exit(json_encode("Sei la"));
        }
        
    }
    
    public function registrarCeretificadoDigital(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            
            
            exit(json_encode([$certificadoArq]));
            
        }else{
            exit(json_encode("Sei la"));
        }
    }
    
    /*public function registrarModuloNota(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            
            $arrayPost = [];
            
            $licenciatura = [
                "CnpjEmpresa"=>$_SESSION['ID'],
                "Acao"=>1,
                "Autor"=>$_SESSION['nomeFantasia']
            ];
            
            if(isset($_POST['Modulo'])){
                $modulo = preg_replace("/[^0-9]/","",$_POST['Modulo']);
                $modulo = filter_var($modulo,FILTER_VALIDATE_INT,FILTER_FLAG_ALLOW_OCTAL);
                if($modulo!=false){
                    $modulo=(int)$modulo;
                    switch($modulo){
                        case 1:$modulo = "NFSe";break;
                        default:$modulo = false;break;
                    }
                }
                $arrayPost +=["Modulo"=>$modulo];
            }
            
            $this->ValidateEmissaoNotaConfiguracao->validateFilds($arrayPost);
            $this->ValidateEmissaoNotaConfiguracao->validateRegistrarLicenciamento([
                "LocalLancamento"=>1,
                "Modelo"=>1,
                "Acao"=>1,
                "Modulo"=>$modulo
            ]);
            
            exit(json_encode([
                "erros"=>$this->ValidateEmissaoNotaConfiguracao->getError(),
                "sucessos"=>$this->ValidateEmissaoNotaConfiguracao->getMessage()
            ]));
            
        }else{
            exit(json_encode("Envie uma requisição POST"));
        }
    }*/
    
    public function acaoModuloNota(){
        
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if(isset($_POST['acaoModulo'])==false || isset($_POST['tipoModulo'])==false){
                exit(json_encode([
                    "erros"=>"Verifique os dados"
                ]));
            }else{
                if(count($_POST['acaoModulo']) != count($_POST['tipoModulo'])){
                    exit(json_encode([
                        "erros"=>"Verifique os dados"
                    ]));
                }else{
                    $return = [];
                    
                    for($i = 0;$i<=count($_POST['acaoModulo'])-1;$i++){
                        
                        $modulo = preg_replace("/[^A-Z ^a-z]/","",$_POST['tipoModulo'][$i]);
                        $acao = (int)$_POST['acaoModulo'][$i];
                        
                        $return += [
                            $i => $this->ValidateAreaNotaConfiguracao->validateRegistrarLicenciamento([
                                "LocalLancamento"=>1,
                                "Modelo"=>1,
                                "Acao"=>$acao,
                                "Modulo"=>$modulo
                            ])
                        ];
                        
                    }
                    
                    exit(json_encode([
                        "erros"=>$this->ValidateAreaNotaConfiguracao->getError(),
                        "retornos"=>$return
                    ]));
                }
                
            }
        }else{
            exit(json_encode("Envie uma requisição POST"));
        }
    }
    
    public function getStatusModulosNotas(){
        $return = $this->ValidateAreaNotaConfiguracao->validateGetModuloPJ([
            "cnpj"=>$_SESSION['ID']
        ]);
        
        exit(json_encode([
            "erros"=>$this->ValidateAreaNotaConfiguracao->getError(),
            "dados"=>$return
        ]));
    }
    
    public function getEmpresaAPI(){
        $return = $this->ValidateAreaNotaConfiguracao->validateGetEmpresaAPI($_SESSION['ID']);
        exit(json_encode([
            "erros"=>$this->ValidateAreaNotaConfiguracao->getError(),
            "dados"=>$this->ValidateAreaNotaConfiguracao->validateGetEmpresaAPI($_SESSION['ID'])
        ]));
    }
    
    public function cadastrarServico(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            
            $arrayPost = array();
            
            if(isset($_POST['CodigoDeServico'])){
                $CodigoDeServico = (float)$_POST['CodigoDeServico'];
                $arrayPost+=['CodigoDeServico'=>$CodigoDeServico];
            }
            
            if(isset($_POST['DescricaoServico'])){
                $DescricaoServico = filter_input(INPUT_POST,"DescricaoServico",FILTER_SANITIZE_ADD_SLASHES);
                $arrayPost+=['DescricaoServico'=>$DescricaoServico];
            }
            
            $this->ValidateAreaNotaConfiguracao->validateFilds($arrayPost);
            
            $this->ValidateAreaNotaConfiguracao->validateInsertListaServico([
                "cod"=>$CodigoDeServico,
                "cnpj"=>$_SESSION['ID'],
                "descricao"=>$DescricaoServico
            ]);
            
            exit(json_encode([
                'erros'=>$this->ValidateAreaNotaConfiguracao->getError(),
                'sucessos'=>$this->ValidateAreaNotaConfiguracao->getMessage()
            ]));
        }
    }
    
    public function getServicos(){
        $return = $this->ValidateAreaNotaConfiguracao->validateGetListaServico($_SESSION['ID']);
        exit(json_encode([
            "erros"=>$this->ValidateAreaNotaConfiguracao->getError(),
            'dados'=>$return
        ]));
    }
    
    public function deleteServico(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $arrayPost = array();
            if(isset($_POST['codigoServico'])){
                $CodigoDeServico = (float)$_POST['codigoServico'];
                $arrayPost+=['codigoServico'=>$CodigoDeServico];
            }
        }
        $this->ValidateAreaNotaConfiguracao->validateFilds($arrayPost);
        $this->ValidateAreaNotaConfiguracao->validateDeleteServico([
            'codigo'=>$CodigoDeServico,
            'cnpj'=>$_SESSION['ID']
        ]);
        exit(json_encode($_POST));
    }
    
    public function validarMunicipio(){
        $this->ValidateAreaNotaConfiguracao->validateMunicipio();
    }
    
}
?>