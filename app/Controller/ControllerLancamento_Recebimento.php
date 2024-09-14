<?php
namespace App\Controller;
use Src\Classes\ClassValidate;
use Src\Classes\ClassRender;
use Src\Classes\ClassSessions;
use Src\Classes\ClassWrite;
use Src\Traits\TraitUrlParser;
class ControllerLancamento_Recebimento{
    use TraitUrlParser;
    private $Render;
    private $Session;
    private $Write;
    private $Validate;
    private $request = array();
    public function __construct(){
        $this->Render=new ClassRender;
        $this->Session=new ClassSessions;
        $this->Write=new ClassWrite;
        $this->Validate=new ClassValidate;
        $this->Render->setDir("Lancamentos/Recebimento");
        $this->Render->setTitle("Recebimento");
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
    
    function dados(){
        $json=array(
            'error'=>array(),
            'historico'=>array(),
            'grupo'=>array(),
            'pagamento'=>array(),
            'contas'=>array(),
            'pj'=>array()
        );
        
        if($_SESSION['TipoCliente']=='PF'){
            $PJ=$this->Validate->validateGetAssociacao($_SESSION['ID']);
            if(count($PJ)<=0){
                array_push($json['error'],"Sem históricos");
            }else{
                array_push($json['pj'],$PJ);
            }
        }else if($_SESSION['TipoCliente']=='PJ'){
            array_push($json['pj'],[[
                "CNPJ"=>$_SESSION['ID'],
                'Nome'=>$_SESSION['nomeFantasia']
            ]]);
        }
        
        
        /*$historicos=$this->Validate->validateGetHistoricos();
        if($historicos['linhas']<=0){
            array_push($json['error'],"Sem históricos");
        }else{
            foreach($historicos['dados'] as $key=>$value){
                if($value['IdDecricao']=="1" || $value['IdDecricao']=="2"){
                    array_push($json['historico'],$value);
                }
            }
        }*/
        
       
        
        $pagamentos=$this->Validate->getTiposDePagamento();
        if($pagamentos['linhas']<=0){
            array_push($json['error'],"Sem pagamentos");
        }else{
            array_push($json['pagamento'],$pagamentos['dados']);
        }
       
        if($_SESSION['TipoCliente']=='PF'){
            //$contas=$this->Validate->validateGetContas($_SESSION['ID']);
            /*if(isset($_POST['cnpj'])){
                $cnpj = str_replace("/[^0-9]/","",$_POST);
                $contas=$this->Validate->validateGetContas($cnpj);
            }*/
        }else if($_SESSION['TipoCliente']=='PJ'){
            $grupo = $this->Validate->validateGetGrupoLancamento([
                'Tomador'=>$_SESSION['ID'],
                'Acao'=>2
            ]);

            if(!$grupo){
                array_push($json['error'],"Sem grupo");
            }else{
                array_push($json['grupo'],$grupo);
            }

            $contas=$this->Validate->validateGetContas($_SESSION['ID']);
            if(!$contas){
                array_push($json['error'],"Sem contas");
            }else{
                array_push($json['contas'],$contas['dados']);
            }
        }
       
        exit(json_encode($json));
    }

    public function getContasPF(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{
            if(isset($_POST['cnpj'])){
                $cnpj = str_replace("/[^0-9]/","",$_POST['cnpj']);
            }
            $contas=$this->Validate->validateGetContas($cnpj);
            if(!$contas){
                exit(json_encode(['contas'=>"Sem contas"],JSON_UNESCAPED_UNICODE));
            }else{
                exit(json_encode(['contas'=>[$contas['dados']]],JSON_UNESCAPED_UNICODE));
            }
        }
    }
    
    public function getSubGrupo(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{
            //exit(json_encode($_POST));
            if(isset($_POST['PJ'])){
                $pj = preg_replace('/[^0-9]/',"",$_POST['PJ']);
                array_push($this->request,$pj);
            }

            if(isset($_POST['Grupo'])){
                $idGrupo = filter_var($_POST['Grupo'],FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->request,$idGrupo);
            }

            $this->Validate->validateFilds($this->request);

            $res = $this->Validate->validateGetSubGrupo([
                'cnpj'=>$pj,
                'idGrupo'=>$idGrupo
            ]);

            exit(json_encode([
                'erros'=>$this->Validate->getError(),
                'dados'=>$res
            ]));
        }
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
        if(isset($_POST['FormaDeRecebimento'])){
           $FormaDeRecebimento=filter_input(INPUT_POST, 'FormaDeRecebimento', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["FormaDeRecebimento"=>$FormaDeRecebimento];
        }
        if(isset($_POST['NovaFormaDeRecebimento'])){
           $NovaFormaDeRecebimento=filter_input(INPUT_POST, 'NovaFormaDeRecebimento', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["NovaFormaDeRecebimento"=>$NovaFormaDeRecebimento];
        }
        if(isset($_POST['TipoDeRecebimento'])){
           $TipoDeRecebimento=filter_input(INPUT_POST, 'TipoDeRecebimento', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["TipoDeRecebimento"=>$TipoDeRecebimento];
        }
        if(isset($_POST['Agencia'])){
           $Agencia=filter_input(INPUT_POST, 'Agencia', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["Agencia"=>$Agencia];
        }
        if(isset($_POST['Conta'])){
           $Conta=filter_input(INPUT_POST, 'Conta', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["Conta"=>$Conta];
        }
        if(isset($_POST['Historico'])){
           $Historico=filter_input(INPUT_POST, 'Historico', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["Historico"=>$Historico];
        }
        if(isset($_POST['Descricao'])){
           $Descricao=filter_input(INPUT_POST, 'Descricao', FILTER_SANITIZE_SPECIAL_CHARS);
           //$arrayRequired+=["Descricao"=>$Descricao];
        }
        if(isset($_POST['SubGrupo'])){
            $SubGrupo=filter_var($_POST['SubGrupo'],FILTER_SANITIZE_ADD_SLASHES);
            $arrayRequired+=["SubGrupo"=>$SubGrupo];
        }
        if(isset($_POST['Ofertante'])){
           $Ofertante=filter_input(INPUT_POST, 'Ofertante', FILTER_SANITIZE_SPECIAL_CHARS);
           //$arrayRequired+=["Ofertante"=>$Ofertante];
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
            //$arrayRequired+=["Comprovante"=>$Comprovante];
        }
         
        if(isset($_POST['Submit'])){
           $Submit=filter_input(INPUT_POST, 'Submit', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["Submit"=>$Submit];
        }

        if($_SESSION['TipoCliente']=="PJ"){
            $cpf = "00100200304";
            $cnpj = $_SESSION['ID'];
        }else if($_SESSION['TipoCliente']=="PF"){
            $cpf = $_SESSION['ID'];
            $cnpj = $PJ;
        }
        
        $Valor=str_replace(".","",$Valor);
        $Valor=str_replace(",",".",$Valor);
        $Valor=(float)$Valor;
        
        $FormaDeRecebimento=(string)$FormaDeRecebimento;
        $TipoDeRecebimento=(string)$TipoDeRecebimento;
        $Agencia=(string)$Agencia;
        $Conta=(string)$Conta;
        $Historico=(int)$Historico;
        $Data=(string)$Data;
        $Descricao=(string)$Descricao;
        $Ofertante=(string)$Ofertante;
        $IdArquivo=(string)$IdArquivo;

        //exit(json_encode($arrayRequired));
        
        $this->Validate->validateFilds($arrayRequired);
        $this->Validate->validateCNPJ($PJ);
        $this->Validate->validateIssetCNPJ($PJ,"verificar");
        
        if(isset($_POST['Data'])){$this->Validate->validateData($Data);}
        
        /*if(isset($_FILES['Comprovante'])){
            
            if($_FILES['Comprovante']['error']==0){
                $this->Validate->validateArquivo(
                    $Comprovante,
                    ["jpg","pdf","pnj","jpeg"],
                    8388608
                );  
            }else if($_FILES['Comprovante']['error']==4){}else{
                $this->Validate->setError("Error no arquivo");
            }
        }*/
        //exit(json_encode($_FILES['Comprovante']));
        if($Comprovante['size'][0]!=0){
            $this->Validate->validateArquivo(
                $Comprovante,
                ["jpg","pdf","png","jpeg"],
                8388608
            );
            $retornoUpload = $this->Validate->validadeUploadDir($Comprovante,"public/img/lancamentos/pagamentos/");
            $IdArquivo = $retornoUpload['str_id_LancamentosArquivos'];
            $IdGrupoComprovante = $retornoUpload['str_grupo_LancamentosArquivos'];
        }
        
        if(isset($_POST['TipoDeRecebimento'])||(isset($_POST['TipoDeRecebimento']) && isset($_POST['Agencia']) && isset($_POST['Conta']))){
            $idConta=md5(uniqid(rand(),true));
            $resul=$this->Validate->validateRegistroDeConta([
                "idConta"=>$idConta,
                "Banco"=>$TipoDeRecebimento,
                "Agencia"=>$Agencia,
                "Conta"=>$Conta,
                "CPF"=>$cpf,
                "CNPJ"=>$cnpj
            ]);

            $FormaDeRecebimento = $idConta;
           
            /*$this->Validate->validateRegistroDeRecebimento(
                [
                    "IdRegistro"=>$IdRegistro,
                    "DataAtual"=>$dataAtual,
                    "PJ"=>$PJ,
                    "FormaDeRecebimento"=>$idConta,
                    "Historico"=>$SubGrupo,
                    "Descricao"=>$Descricao,
                    "Ofertante"=>$Ofertante,
                    "Valor"=>$Valor,
                    "Data"=>$Data,
                    "IdArquivo"=>(string)$IdArquivo,
                    "ID"=>$cpf
                ]
            );
            */
            
        }
            
        $this->Validate->validateRegistroDeRecebimento(
            [
                "IdRegistro"=>$IdRegistro,
                "DataAtual"=>$dataAtual,
                "PJ"=>$PJ,
                "FormaDeRecebimento"=>$FormaDeRecebimento,
                "Historico"=>$SubGrupo,
                "Descricao"=>$Descricao,
                "Ofertante"=>$Ofertante,
                "Valor"=>$Valor,
                "Data"=>$Data,
                "IdArquivo"=>(string)$IdArquivo,
                "IdGrupoComprovante"=>(string)$IdGrupoComprovante,
                "ID"=>$cpf
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