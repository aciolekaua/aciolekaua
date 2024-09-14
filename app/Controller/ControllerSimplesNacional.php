<?php 
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassSessions;
use Src\Traits\TraitUrlParser;
use Src\Classes\ClassValidate;
use Src\Classes\ClassValidateSimplesNacional;
class ControllerSimplesNacional {
     use TraitUrlParser;
     private $Render;
     private $Session;
     private $ValidateSimples;
     private $Validate;
     private $arrayRequest = array();
     function __construct(){
        $this->Render= new ClassRender;
        $this->Validate = new ClassValidate;
        $this->ValidateSimples = new ClassValidateSimplesNacional;
        $this->Session= new ClassSessions;
        $this->Render->setDir("SimplesNacional");
        $this->Render->setTitle("Simples Nacional");
        $this->Render->setDescription("Pagina de Simples Nacional MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            $this->Render->addSession();
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout("Home");
        }
    }

    public function dados():void{
        if($_SERVER['REQUEST_METHOD']!='POST'){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{
            if($_SESSION['TipoCliente']=="PJ"){
                exit(json_encode([
                    
                    [
                        'CNPJ'=>$_SESSION['ID'],
                        "Nome"=>$_SESSION['nomeFantasia']
                    ]

                ]));
            }else if($_SESSION['TipoCliente']=="PF"){
                $PJ=$this->Validate->validateGetAssociacao($_SESSION['ID']);
                exit(json_encode($PJ));
            }
            
        } 
    }

    public function registroSimples():void{
        if($_SERVER['REQUEST_METHOD']!='POST'){

            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));

        }else {

            //exit(json_encode($_POST));
            
            if($_POST['MesCompetencia']){
                $MesCompetencia = (int)filter_input(INPUT_POST,'MesCompetencia',FILTER_SANITIZE_NUMBER_INT);
                array_push($this->arrayRequest,$MesCompetencia);
            }

            if($_POST['AnoCompetencia']){
                $AnoCompetencia = (int)filter_input(INPUT_POST,'AnoCompetencia',FILTER_SANITIZE_NUMBER_INT);
                array_push($this->arrayRequest,$AnoCompetencia);
            }

            if($_POST['Anexo']){
                $Anexo = (int)filter_input(INPUT_POST,'Anexo',FILTER_SANITIZE_NUMBER_INT);
                array_push($this->arrayRequest,$Anexo);
            }

            if($_POST['ValorCompetencia']){
                $ValorCompetencia = (float)str_replace(['.',','],['','.'],$_POST['ValorCompetencia']);
                $ValorCompetencia = filter_var($ValorCompetencia,FILTER_VALIDATE_FLOAT);
                array_push($this->arrayRequest,$ValorCompetencia);
            }

            if($_SESSION['TipoCliente']=='PJ'){
                $cnpj = $_SESSION['ID'];
            }else if($_SESSION['TipoCliente']=='PF'){
                if($_POST['PJ']){$cnpj = filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_NUMBER_INT);}
            }
            array_push($this->arrayRequest,$cnpj);

            $this->Validate->validateFilds($this->arrayRequest);
            
            $this->ValidateSimples->validateInsertSimples([
                "id"=>uniqid(mt_rand(100000,999999),true),
                "data"=>(string)$AnoCompetencia."-".$MesCompetencia."-"."01",
                "valor"=>(float)$ValorCompetencia,
                "anexo"=>(int)$Anexo,
                "cnpj"=>(string)$cnpj
            ]);

            exit(json_encode([
                "erros"=>$this->ValidateSimples->getError(),
                "sucessos"=>$this->ValidateSimples->getMessage()
            ]));

        }
        
    }
    
    public function getSimples():void{
        if($_SERVER['REQUEST_METHOD']!='POST'){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{
            if($_SESSION['TipoCliente']=='PJ'){
                $cnpj = $_SESSION['ID'];
            }else if($_SESSION['TipoCliente']=='PF'){
                if(isset($_POST['PJ'])){
                    $cnpj = (string)filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_NUMBER_INT);
                }
            }

            if(isset($_POST['Anexo'])){
                $anexo = (int)filter_input(INPUT_POST,'Anexo',FILTER_SANITIZE_NUMBER_INT);
                array_push($this->arrayRequest,$anexo);
            }

            $this->Validate->validateFilds($this->arrayRequest);

            $return = $this->ValidateSimples->validateGetSimples([
                "tomador"=>$cnpj,
                "anexo"=>$anexo
            ]);

            exit(json_encode([
                'erros'=>$this->ValidateSimples->getError(),
                'dados'=>$return
            ]));

        }
    }

    public function deleteSimples(string $id):void{
        //exit(json_encode($id));
        $this->ValidateSimples->validateDeleteSimples($id);

        exit(json_encode([
            "erros"=>$this->ValidateSimples->getError(),
            "sucessos"=>$this->ValidateSimples->getMessage()
        ],JSON_UNESCAPED_UNICODE));
    }

    public function updateSimples():void{

        if($_POST['IdSimples']){
            $IdSimples = (string)filter_input(INPUT_POST,'IdSimples',FILTER_SANITIZE_ADD_SLASHES);
            array_push($this->arrayRequest,$IdSimples);
        }

        if($_POST['MesCompetencia']){
            $MesCompetencia = (int)filter_input(INPUT_POST,'MesCompetencia',FILTER_SANITIZE_NUMBER_INT);
            array_push($this->arrayRequest,$MesCompetencia);
        }

        if($_POST['AnoCompetencia']){
            $AnoCompetencia = (int)filter_input(INPUT_POST,'AnoCompetencia',FILTER_SANITIZE_NUMBER_INT);
            array_push($this->arrayRequest,$AnoCompetencia);
        }

        if($_POST['Anexo']){
            $Anexo = (int)filter_input(INPUT_POST,'Anexo',FILTER_SANITIZE_NUMBER_INT);
            array_push($this->arrayRequest,$Anexo);
        }

        if($_POST['ValorCompetencia']){
            $ValorCompetencia = (float)str_replace(['.',','],['','.'],$_POST['ValorCompetencia']);
            $ValorCompetencia = filter_var($ValorCompetencia,FILTER_VALIDATE_FLOAT);
            array_push($this->arrayRequest,$ValorCompetencia);
        }

        $this->Validate->validateFilds($this->arrayRequest);

        $Data = $AnoCompetencia."-".$MesCompetencia."-01";

        $this->ValidateSimples->validateUpdateSimples([
            'Id'=>$IdSimples,
            'Data'=>$Data,
            'Anexo'=>$Anexo,
            'Valor'=>$ValorCompetencia
        ]);

        exit(json_encode([
            "erros"=>$this->ValidateSimples->getError(),
            "sucessos"=>$this->ValidateSimples->getMessage()
        ],JSON_UNESCAPED_UNICODE));
    }

    public function calcularSimples():void{
        if($_SERVER['REQUEST_METHOD']!='POST'){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else {

            if($_POST['MesCompetencia']){
                $MesCompetencia = (int)filter_input(INPUT_POST,'MesCompetencia',FILTER_SANITIZE_NUMBER_INT);
                array_push($this->arrayRequest,$MesCompetencia);
            }

            if($_POST['AnoCompetencia']){
                $AnoCompetencia = (int)filter_input(INPUT_POST,'AnoCompetencia',FILTER_SANITIZE_NUMBER_INT);
                array_push($this->arrayRequest,$AnoCompetencia);
            }

            if($_SESSION['TipoCliente']=='PJ'){
                $cnpj = $_SESSION['ID'];
            }else if($_SESSION['TipoCliente']=='PF'){
                if($_POST['PJ']){$cnpj = filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_NUMBER_INT);}
            }
            array_push($this->arrayRequest,$cnpj);

            $this->ValidateSimples->validateCalcularSimples([
                "Tomador"=>$cnpj,
                "Data"=>$AnoCompetencia."-".$MesCompetencia."-01"
            ]);

        }
    }
    
}