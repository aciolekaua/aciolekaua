<?php
namespace App\Controller;
use Src\Classes\ClassValidate;
use Src\Classes\ClassRender;
use Src\Classes\ClassSessions;
use Src\Classes\ClassWrite;
use Src\Traits\TraitUrlParser;
class ControllerLancamento_Nota{
    use TraitUrlParser;
    private $Render;
    private $Session;
    private $Write;
    private $Validate;
    function __construct(){
        $this->Render=new ClassRender;
        $this->Session=new ClassSessions;
        $this->Write=new ClassWrite;
        $this->Validate=new ClassValidate;
        $this->Render->setDir("Lancamentos/Nota");
        $this->Render->setTitle("Nota");
        $this->Render->setDescription("Pagina de lançamentos MVC");
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
        
         $json=array(
            'error'=>array(),
            'pj'=>array()
        );
        
        $PJ=$this->Validate->validateGetAssociacao($_SESSION['ID']);
        if(count($PJ)<=0){
            array_push($json['error'],"Sem cnpj");
        }else{
            array_push($json['pj'],$PJ);
        }
        echo(json_encode($json));
    }
    
    public function registro(){
        
        $arrayRequired=array();
        $IdRegistro=md5(uniqid(rand(),true));
        $dataAtual=date("Y-m-d H:i:s");
        $Id=$_SESSION['ID'];
        
        if(isset($_POST['PJ'])){
            $PJ=filter_input(INPUT_POST, 'PJ', FILTER_SANITIZE_SPECIAL_CHARS);
            $arrayRequired+=["PJ"=>$PJ];
        }
        if(isset($_POST['Prestador'])){
           $Prestador=filter_input(INPUT_POST, 'Prestador', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["Prestador"=>$Prestador];
        }
        if(isset($_POST['Nota'])){
           $Nota=filter_input(INPUT_POST, 'Nota', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["Nota"=>$Nota];
           
        }
        if(isset($_POST['Valor'])){
           $Valor=filter_input(INPUT_POST, 'Valor', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["Valor"=>$Valor];
           
        }
        if(isset($_POST['Data'])){
           $Data=filter_input(INPUT_POST, 'Data', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["Data"=>$Data];
        }
        if(isset($_FILES['Comprovante'])){
            $Comprovante=$_FILES['Comprovante'];
            $arrayRequired+=["Comprovante"=>$Comprovante];
        }
         
        if(isset($_POST['Submit'])){
           $Submit=filter_input(INPUT_POST, 'Submit', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["Submit"=>$Submit];
        }
        
        $Valor=str_replace(".","",$Valor);
        $Valor=str_replace(",",".",$Valor);
        $Valor=(float)$Valor;
        
        $Nota=(int)$Nota;
        $Data=(string)$Data;
        $Prestador=(string)$Prestador;
        $IdArquivo=(string)$IdArquivo;
       
        $this->Validate->validateFilds($arrayRequired);
        $this->Validate->validateCNPJ($PJ);
        $this->Validate->validateIssetCNPJ($PJ,"verificar");
        
        if(isset($_POST['Data'])){$this->Validate->validateData($Data);}
        if(isset($_POST['Nota'])){$this->Validate->validateNumero($Nota);}
        
        if(isset($_FILES['Comprovante'])){
            $this->Validate->validateArquivo(
                $Comprovante,
                ["jpg","pdf","pnj","jpeg"],
                8388608
            );   
        }
        
        if(isset($_FILES['Comprovante'])){
            $IdArquivo=$this->Validate->validadeUploadDir($Comprovante,"public/img/lancamentos/pagamentos/");
            $IdArquivo=$IdArquivo['str_id_LancamentosArquivos'];   
        }
        
        $this->Validate->validateRegistroDeNota(
            [
                "IdRegistro"=>$IdRegistro,
                "dataAtual"=>$dataAtual,
                "PJ"=>$PJ,
                "Prestador"=>$Prestador,
                "Nota"=>$Nota,
                "Valor"=>$Valor,
                "Data"=>$Data,
                "IdArquivo"=>$IdArquivo,
                "ID"=>$Id
            ]
        );
        
        $JSON=array(
            'erros'=>$this->Validate->getError(),
            'sucessos'=>$this->Validate->getMessage()
        );
        echo(json_encode($JSON));
    }
}
?>