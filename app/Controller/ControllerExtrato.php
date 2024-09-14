<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassValidate;
use Src\Classes\ClassJWT;
use Src\Classes\ClassRequestJSON;
use Src\Classes\ClassSessions;
use Src\Traits\TraitUrlParser;
use Src\Classes\ClassMail;
use Src\Classes\ClassValidateExtrato;

class ControllerExtrato{

    use TraitUrlParser;
    private $Validate;
    private $Render;
    private $JWT;
    private $RequestJSON;
    private $Session;
    private $Email;
    private $ValidateExtrato;
    private $RequestPost;

    function __construct(){
        $this->RequestPost = [];
        $this->Render = new ClassRender;
        $this->Validate = new ClassValidate;
        $this->JWT = new ClassJWT;
        $this->RequestJSON = new ClassRequestJSON;
        $this->Session = new ClassSessions;
        $this->Email = new ClassMail;
        $this->ValidateExtrato = new ClassValidateExtrato;

        $this->Render->setDir("Extrato");
        $this->Render->setTitle("Extrato");
        $this->Render->setDescription("Pagina de extratos");
        $this->Render->setKeywords("mvc, mvc teste");

        $url=$this->parseUrl();
        if(isset($url[1])){
            $this->Render->addSession();
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout("Home");
        }
    }

    public function dadosPJ(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            exit(json_encode(
                "Envie uma requisição POST",
                JSON_UNESCAPED_UNICODE
            ));
        }else{
            exit(json_encode(
                [
                    "cnpj"=>$_SESSION['ID']
                ],
                JSON_UNESCAPED_UNICODE
            ));
        }
        
    }

    public function enviarExtrato(){
        
        if($_SESSION['TipoCliente']=="PJ"){
            $cnpj = $_SESSION['ID'];
        }else if($_SESSION['TipoCliente']=="PF"){

        }
       
        if(isset($_POST['mes'])){
            $mes =  (int)filter_input(INPUT_POST, 'mes',FILTER_SANITIZE_NUMBER_INT);
            array_push($this->RequestPost,$mes);
        }
        
        if(isset($_POST['ano'])){
            $ano =  (int)filter_input(INPUT_POST, 'ano',FILTER_SANITIZE_NUMBER_INT);
            array_push($this->RequestPost,$ano);
        }

        if(isset($_FILES['extrato'])){
            $arquivo = $_FILES['extrato'];
            $this->Validate->validateArquivo($arquivo,["xml","pdf","csv","ofx","xlsx","jpeg","png","jpg"]);
            array_push($this->RequestPost,$arquivo);
            /*$this->ValidateExtrato->validateEnviarArquivo($_FILES['extrato']);
            $nomeArquivo = $_FILES['extrato']['name'];
            //$infos = "{$ano},{$mes},{$nomeArquivo}";
            $extrato = $_FILES['extrato']["tmp_name"];*/
        }

        $this->Validate->validateFilds($this->RequestPost);
        
        $this->ValidateExtrato->validateEnviarArquivo([
            "arquivo"=>$arquivo,
            "dataCompetencia"=>$ano.'-'.$mes.'-01',
            "tomador"=>$cnpj
        ]);
        //grupovmpe.kaua@gmail.com
        //$emailEnviar = 'dp01@vmcontabil.net.br';
        //$this->Validate->validadeUploadDir($Arquivo,'caminho');
        //$this->Email->sendMailExtrato($emailEnviar,'Para Bel','Envio de Extratos',$infos,$extrato,$nomeArquivo);

        exit(json_encode([
            'sucessos'=>$this->ValidateExtrato->getMessage(),
            'erros'=>$this->ValidateExtrato->getError()
        ]));
    }

    public function getExtrato():void{

        if($_SERVER['REQUEST_METHOD']!="POST"){
           
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));

        }else{
            //exit(json_encode("OI",JSON_UNESCAPED_UNICODE));
            if($_SESSION['TipoCliente']=="PJ"){
                $cnpj = $_SESSION['ID'];
            }

            $return = $this->ValidateExtrato->validateGetExtrato([
                'tomador'=>$cnpj
            ]);

            exit(json_encode([
                'dados'=>$return,
                'erros'=>$this->ValidateExtrato->getError()
            ],JSON_UNESCAPED_UNICODE));
        }
    }

    public function deleteExtrato(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
           
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));

        }else{
            //exit(json_encode($_POST));
            if(isset($_POST['id'])){
                $id = filter_var($_POST['id'], FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->RequestPost,$id);
            }

            if($_SESSION['TipoCliente']=="PJ"){
                $cnpj = $_SESSION['ID'];
            }

            $this->Validate->validateFilds($this->RequestPost);

            $this->ValidateExtrato->validateDeleteExtrato([
                'id'=>$id,
                "cnpj"=>$cnpj
            ]);

            exit(json_encode([
                "erro"=>$this->ValidateExtrato->getError(),
                "sucesso"=>$this->ValidateExtrato->getMessage()
            ]));

        }
    }

    public function updateExtrato(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            exit(json_encode(
                "Envie uma requisição POST",
                JSON_UNESCAPED_UNICODE
            ));
        }else{

            if(isset($_POST['IdExtrato'])){
                $idExtrato = filter_var($_POST['IdExtrato'],FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->RequestPost,$idExtrato);
            }

            if(isset($_POST['anoEditar'])){
                $anoEditar = filter_var($_POST['anoEditar'],FILTER_SANITIZE_NUMBER_INT);
                array_push($this->RequestPost,$anoEditar);
            }

            if(isset($_POST['cnpjEditar'])){
                $cnpjEditar = filter_var($_POST['cnpjEditar'],FILTER_SANITIZE_NUMBER_INT);
                array_push($this->RequestPost,$cnpjEditar);
            }

            if(isset($_POST['mesEditar'])){
                $mesEditar = filter_var($_POST['mesEditar'],FILTER_SANITIZE_NUMBER_INT);
                array_push($this->RequestPost,$mesEditar);
            }

            if(isset($_FILES['extratoEditar'])){
                $arquivo = $_FILES['extratoEditar'];    
                $this->Validate->validateArquivo($arquivo,["xml","pdf","csv","ofx","xlsx","jpeg","png","jpg"]);
                array_push($this->RequestPost,$arquivo);
            }

            $this->Validate->validateFilds($this->RequestPost);

            $competencia = "{$anoEditar}-{$mesEditar}-01";

            $this->ValidateExtrato->validateUpdateExtrato([
                "idExtrato"=>$idExtrato,
                "competencia"=>$competencia,
                "cnpj"=>$cnpjEditar,
                "arquivo"=>$arquivo
            ]);

            exit(json_encode([
                "erro"=>$this->ValidateExtrato->getError(),
                "sucesso"=>$this->ValidateExtrato->getMessage()
            ]));
        }
    }
}
?>