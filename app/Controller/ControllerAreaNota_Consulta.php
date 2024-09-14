<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassValidate;
use Src\Classes\ClassJWT;
use Src\Classes\ClassRequestJSON;
use Src\Classes\ClassSessions;
use Src\Traits\TraitUrlParser;

use Src\Classes\ClassValidateAreaNotaConsulta;

class ControllerAreaNota_Consulta{
    
    use TraitUrlParser;
    private $Validate;
    private $Render;
    private $JWT;
    private $RequestJSON;
    private $Session;
    
    private $ValidateAreaNotaConsulta;
    
    public function __construct(){
        $this->Render=new ClassRender;
        $this->Validate=new ClassValidate;
        
        $this->JWT = new ClassJWT;
        $this->RequestJSON = new ClassRequestJSON;
        $this->Session=new ClassSessions;
        
        $this->ValidateAreaNotaConsulta = new ClassValidateAreaNotaConsulta;
        
        $this->Render->setDir("AreaNota/Consulta");
        $this->Render->setTitle("Consulta de Notas");
        $this->Render->setDescription("Pagina de lançamento NFSe MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            $this->Render->addSession();
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout("Home");
        }
    }
    
    public function dados(){
        if($_SESSION['TipoCliente']=="PF"){
             exit(json_encode([
                 "erros"=>$this->Validate->getError(),
                 "PJs"=>$this->Validate->validateGetAssociacao($_SESSION['ID']),
                 "TipoCliente"=>$_SESSION['TipoCliente']
            ]));
        }else if($_SESSION['TipoCliente']=="PJ"){
            exit(json_encode([
                "erros"=>$this->Validate->getError(),
                "TipoCliente"=>$_SESSION['TipoCliente'],
                "dados"=>[
                    'id'=>$_SESSION['ID'],
                    'nomeFantasia'=>$_SESSION['nomeFantasia']
                ]
            ]));
        }
    }
    
    public function consultarNotas(){
        
        if($_SERVER['REQUEST_METHOD']=="POST"){
            
            $arrayPost=[];
            $arrayValidate = [];
            
            if(isset($_POST['PJ'])){
                $PJ=preg_replace("/[^0-9]/","",$_POST['PJ']);
                $this->Validate->validateCNPJ($PJ);
                $this->Validate->validateIssetCNPJ($PJ,"Validar");
                
                $arrayPost+=["PJ"=>$PJ];
                $arrayValidate+=["PJ"=>$PJ];
            }
            
            if(isset($_POST['tipoModulo'])){
                $Modulo=mb_strtolower(preg_replace("/[^A-Z ^a-z]/","",$_POST['tipoModulo']));
                $this->Validate->validateNome($Modulo);
                
                $arrayPost+=["tipoModulo"=>$Modulo];
                $arrayValidate+=["tipoModulo"=>$tipoModulo];
            }
            
            if(isset($_POST['dataInicio'])){
                if($this->Validate->validateData($_POST['dataInicio'])){
                    $date=date_create($_POST['dataInicio']);
                    $dataInicio = date_format($date,"Y-m-d H:i:s");
                    $dataInicio = str_replace(" ","T",$dataInicio);
                    
                    $arrayPost+=["dataInicio"=>$dataInicio];
                }else{
                    $arrayPost+=["dataInicio"=>false];
                }
            }
            
            if(isset($_POST['dataFim'])){
                if($this->Validate->validateData($_POST['dataFim'])){
                    
                    $dataFim = $_POST['dataFim']."T23:59:59";
                   
                    $arrayPost+=["dataFim"=>$dataFim];
                }else{
                    $arrayPost+=["dataFim"=>false];
                }
            }
            
            if(isset($_POST['dataRadio'])){
                $dataRadio=filter_input(INPUT_POST, 'dataRadio', FILTER_SANITIZE_NUMBER_INT);
                $arrayPost+=["dataRadio"=>$dataRadio];
            }
            
            if(isset($_POST['numeroInicial'])){
                $numeroInicial = preg_replace("/[^0-9]/","",$_POST['numeroInicial']);
                $arrayPost+=["numeroInicial"=>$numeroInicial];
            }
            
            if(isset($_POST['numeroFinal'])){
                $numeroFinal = preg_replace("/[^0-9]/","",$_POST['numeroFinal']);
                $arrayPost+=["numeroFinal"=>$numeroFinal];
            }
           
            if(isset($_POST['serie'])){
                $serie=filter_input(INPUT_POST, 'serie', FILTER_SANITIZE_NUMBER_INT);
                $arrayPost+=["serie"=>$serie];
            }
            
            if(isset($_POST['statusNota'])){
                $statusNota=filter_input(INPUT_POST, 'statusNota', FILTER_SANITIZE_NUMBER_INT);
                $arrayPost+=["statusNota"=>$statusNota];
            }
            
            if(isset($_POST['emissaoInclusao'])){
                $statusNota=filter_input(INPUT_POST, 'emissaoInclusao', FILTER_SANITIZE_NUMBER_INT);
                $arrayPost+=["emissaoInclusao"=>$statusNota];
                $arrayValidate+=["emissaoInclusao"=>$emissaoInclusao];
            }
            
            //exit(json_encode($_POST));
            
            $this->Validate->validateFilds($arrayValidate);
            
            $return = $this->ValidateAreaNotaConsulta->validateConsultaNotas($arrayPost, 2);
            
            exit(json_encode([
                "erros"=>$this->ValidateAreaNotaConsulta->getError(),
                "dados"=>$return
            ]));
            
        }else{
            exit(json_encode("Envie uma requisição POST"));
        }
        
    }
    
    public function cancelarNota(){
        
        $arrayPost = [];
        $arrayValidate = [];
        
        if(isset($_POST['PJ'])){
            $PJ=filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_SPECIAL_CHARS,FILTER_FLAG_STRIP_LOW);
            $PJ=preg_replace("/[^0-9]/","",$PJ);
            $arrayPost+=["PJ"=>$PJ];
        }
        $arrayValidate+=["PJ"=>$PJ];
        
        if(isset($_POST['modelo'])){
            $modelo=filter_input(INPUT_POST,'modelo',FILTER_SANITIZE_SPECIAL_CHARS,FILTER_FLAG_STRIP_LOW);
            $arrayPost+=["modelo"=>$modelo];
        }
        $arrayValidate+=["modelo"=>$modelo];
        
        if(isset($_POST['motivoCancelamento'])){
            $motivoCancelamento=filter_input(INPUT_POST,'motivoCancelamento',FILTER_SANITIZE_SPECIAL_CHARS,FILTER_FLAG_STRIP_LOW);
            $arrayPost+=["motivoCancelamento"=>$motivoCancelamento];
        }
        $arrayValidate+=["motivoCancelamento"=>$motivoCancelamento];
        
        if(isset($_POST['numero'])){
            $numero = filter_input(INPUT_POST,'numero',FILTER_SANITIZE_NUMBER_INT);
            $arrayPost+=["numero"=>$numero];
        }
        $arrayValidate+=["numero"=>$numero];
        
        if(isset($_POST['numeroNFSE'])){
            $numeroNFSE = filter_input(INPUT_POST,'numeroNFSE',FILTER_SANITIZE_NUMBER_INT);
            $arrayPost+=["numeroNFSE"=>$numeroNFSE];
        }
        $arrayValidate+=["numeroNFSE"=>$numeroNFSE];
        
        if(isset($_POST['serie'])){
            $serie = filter_input(INPUT_POST,'serie',FILTER_SANITIZE_NUMBER_INT);
            $arrayPost+=["serie"=>$serie];
        }
        $arrayValidate+=["serie"=>$serie];
        
        if(isset($_POST['tpCodEvento'])){
            $tpCodEvento = filter_input(INPUT_POST,'tpCodEvento',FILTER_SANITIZE_NUMBER_INT);
            $arrayPost+=["tpCodEvento"=>$tpCodEvento];
        }
        $arrayValidate+=["tpCodEvento"=>$tpCodEvento];
        
        $this->Validate->validateFilds($arrayValidate);
        
        $return = $this->ValidateAreaNotaConsulta->validateCancelarNota($arrayPost);
        
        exit(json_encode([
            'erros'=>$this->ValidateAreaNotaConsulta->getError(),
            'sucessos'=>$this->ValidateAreaNotaConsulta->getMessage(),
            'dados'=>$return
        ]));
        
    }
    
    public function copiarNota(){
        
        $arrayPost = [];
        if(isset($_POST['copiarNota'])){
            $copiarNota = filter_input(INPUT_POST,'copiarNota',FILTER_SANITIZE_URL);
            $arrayPost+=['copiarNota'=>$copiarNota];
        }
        
        if($this->Validate->validateFilds($arrayPost)){
            $copiarNota = base64_decode($copiarNota);
            $xml = simplexml_load_string($copiarNota);
            exit(json_encode($xml));
        }

    }
}
?>