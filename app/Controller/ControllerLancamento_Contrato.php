<?php
namespace App\Controller;
use Src\Classes\ClassValidate;
use Src\Classes\ClassRender;
use Src\Classes\ClassSessions;
use Src\Classes\ClassWrite;
use Src\Traits\TraitUrlParser;
class ControllerLancamento_Contrato{
    use TraitUrlParser;
    private $Render;
    private $Session;
    private $Write;
    private $Validate;
    public function __construct(){
        $this->Render=new ClassRender;
        $this->Session=new ClassSessions;
        $this->Write=new ClassWrite;
        $this->Validate=new ClassValidate;
        $this->Render->setDir("Lancamentos/Contrato");
        $this->Render->setTitle("Contrato");
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
            'historico'=>array(),
            'pagamento'=>array(),
            'contas'=>array(),
            'pj'=>array()
        );
        
        $PJ=$this->Validate->validateGetAssociacao($_SESSION['ID']);
        if(count($PJ)<=0){
            array_push($json['error'],"Sem cnpj");
        }else{
            array_push($json['pj'],$PJ);
        }
 
        $historicos=$this->Validate->validateGetHistoricos([],"getHistoricos");
        if($historicos['linhas']<=0){
            array_push($json['error'],"Sem históricos");
        }else{
            array_push($json['historico'],$historicos['dados']);
        }
        
        $pagamentos=$this->Validate->getTiposDePagamento();
        if($pagamentos['linhas']<=0){
            array_push($json['error'],"Sem pagamentos");
        }else{
            array_push($json['pagamento'],$pagamentos['dados']);
        }
       
        $contas=$this->Validate->validateGetContas($_SESSION['ID']);
        if(count($contas)<=0){
            array_push($json['error'],"Sem contas");
        }else{
            array_push($json['contas'],$contas);
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
        if(isset($_POST['FormaDePagamento'])){
           $FormaDePagamento=filter_input(INPUT_POST, 'FormaDePagamento', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["FormaDePagamento"=>$FormaDePagamento];
        }
        if(isset($_POST['NovaFormaDePagamento'])){
           $NovaFormaDePagamento=filter_input(INPUT_POST, 'NovaFormaDePagamento', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["NovaFormaDePagamento"=>$NovaFormaDePagamento];
        }
        if(isset($_POST['TipoDePagamento'])){
           $TipoDePagamento=filter_input(INPUT_POST, 'TipoDePagamento', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["TipoDePagamento"=>$TipoDePagamento];
        }
        if(isset($_POST['Agencia'])){
           $Agencia=filter_input(INPUT_POST, 'Agencia', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["Agencia"=>$Agencia];
        }
        if(isset($_POST['Conta'])){
           $Conta=filter_input(INPUT_POST, 'Conta', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["Conta"=>$Conta];
        }
        if(isset($_POST['Descricao'])){
           $Descricao=filter_input(INPUT_POST, 'Descricao', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["Descricao"=>$Descricao];
        }
        if(isset($_POST['Beneficiario'])){
           $Beneficiario=filter_input(INPUT_POST, 'Beneficiario', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["Beneficiario"=>$Beneficiario];
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
        
        $FormaDePagamento=(string)$FormaDePagamento;
        $TipoDePagamento=(string)$TipoDePagamento;
        $Agencia=(string)$Agencia;
        $Conta=(string)$Conta;
        $Nota=(int)$Nota;
        $Data=(string)$Data;
        $Descricao=(string)$Descricao;
        $QRCodeLink=(string)$QRCodeLink;
        $Beneficiario=(int)$Beneficiario;
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
        
        if(isset($_POST['TipoDePagamento'])||(isset($_POST['TipoDePagamento']) && isset($_POST['Agencia']) && isset($_POST['Conta']))){
            
            $idConta=md5(uniqid(rand(),true));
            $this->Validate->validateRegistroDeConta([
                "idConta"=>$idConta,
                "Banco"=>$TipoDePagamento,
                "Agencia"=>$Agencia,
                "Conta"=>$Conta,
                "ID"=>$Id
            ]
            );
           
            $this->Validate->validateRegistroDeContrato(
                [
                    "IdRegistro"=>$IdRegistro,
                    "DataAtual"=>$dataAtual,
                    "PJ"=>$PJ,
                    "FormaDePagamento"=>$idConta,
                    "Beneficiario"=>$Beneficiario,
                    "Descricao"=>$Descricao,
                    "Nota"=>$Nota,
                    "Valor"=>$Valor,
                    "Data"=>$Data,
                    "IdArquivo"=>$IdArquivo,
                    "ID"=>$Id
                ]
            );
          
        }else{
            
            $this->Validate->validateRegistroDeContrato(
                [
                    "IdRegistro"=>$IdRegistro,
                    "DataAtual"=>$dataAtual,
                    "PJ"=>$PJ,
                    "FormaDePagamento"=>$FormaDePagamento,
                    "Beneficiario"=>$Beneficiario,
                    "Descricao"=>$Descricao,
                    "Nota"=>$Nota,
                    "Valor"=>$Valor,
                    "Data"=>$Data,
                    "IdArquivo"=>$IdArquivo,
                    "ID"=>$Id
                ]
            );    
        }
        
        $JSON=array(
            'erros'=>$this->Validate->getError(),
            'sucessos'=>$this->Validate->getMessage()
        );
        echo(json_encode($JSON));
    }
}
?>