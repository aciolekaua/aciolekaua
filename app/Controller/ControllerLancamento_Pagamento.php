<?php
namespace App\Controller;
use Src\Classes\ClassValidate;
use Src\Classes\ClassRender;
use Src\Classes\ClassSessions;
use Src\Classes\ClassWrite;
use Src\Traits\TraitUrlParser;
class ControllerLancamento_Pagamento{
    use TraitUrlParser;
    private $Render;
    private $Session;
    private $Validate;

    private $request = array();
    public function __construct(){
        $this->Render=new ClassRender;
        $this->Session=new ClassSessions;
        $this->Validate=new ClassValidate;
        $this->Render->setDir("Lancamentos/Pagamento");
        $this->Render->setTitle("Pagamento");
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
                if($value['IdDecricao']=="0" || $value['IdDecricao']=="2"){
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
                'Acao'=>1
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
       
        echo(json_encode($json));
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
        if(count($_POST)<=0){$_POST = json_decode(file_get_contents('php://input'),true);}
        //exit(json_encode($_POST));
        /*ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);*/
        $arrayRequired=array();
        $IdRegistro=md5(uniqid(rand(),true));
        $dataAtual=date("Y-m-d H:i:s");
        
        $JSON=array(
            'erros'=>array(),
            'sucessos'=>array()
        );
        
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
        if(isset($_POST['QRCodeRadio'])){
           $QRCodeRadio=filter_input(INPUT_POST, 'QRCodeRadio', FILTER_SANITIZE_SPECIAL_CHARS);
           $arrayRequired+=["QRCodeRadio"=>$QRCodeRadio];
        }
        if(isset($_POST['QRCodeLink'])){
           $QRCodeLink=filter_input(INPUT_POST, 'QRCodeLink',FILTER_SANITIZE_URL);
           //$arrayRequired+=["QRCodeLink"=>$QRCodeLink];
        }
        if(isset($_POST['QRCodeURL'])){
           $QRCodeURL=filter_input(INPUT_POST, 'QRCodeURL', FILTER_SANITIZE_URL);
           //$arrayRequired+=["QRCodeURL"=>$QRCodeURL];
        }
        if(isset($_POST['parcelasCheckBox'])){
            $parcelasCheckBox = filter_var($_POST['parcelasCheckBox'], FILTER_SANITIZE_ADD_SLASHES);
            $arrayRequired+=["parcelasCheckBox"=>$parcelasCheckBox];
        }
        if(isset($_POST['Beneficiario'])){
           $Beneficiario=filter_input(INPUT_POST, 'Beneficiario', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if(isset($_POST['Nota'])){
           $Nota=filter_input(INPUT_POST, 'Nota', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if(isset($_POST['Valor'])){
           $Valor=filter_input(INPUT_POST, 'Valor', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if(isset($_POST['Data'])){
           $Data=filter_input(INPUT_POST, 'Data', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if(isset($_FILES['Comprovante'])){
            $Comprovante=$_FILES['Comprovante'];
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
        
        //QRCode
        if(!empty($QRCodeLink) && !empty($QRCodeURL)){
            //array_push($JSON['erros'],);
            $this->Validate->setError("Verifique os dados do QRCode");
        }else if(!empty($QRCodeLink)){
            $QRCode = (string)$QRCodeLink;
            $arrayRequired+=["QRCode"=>$QRCode];
        }else if(!empty($QRCodeURL)){
            $QRCode = (string)$QRCodeURL;
            $arrayRequired+=["QRCode"=>$QRCode];
        }
        
        if(!empty($QRCode)){
            if(!$url=simplexml_load_file($QRCode)){
                //array_push($JSON['erros'],);
                $this->Validate->setError("Falha na leitura do QRCode");
            }else{
                
                $Valor=(float)$url->proc->nfeProc->NFe->infNFe->total->ICMSTot->vNF;
                $Nota=(int)$url->proc->nfeProc->NFe->infNFe->ide->nNF;
                $Data=explode("T",$url->proc->nfeProc->NFe->infNFe->ide->dhEmi)[0];
                $Beneficiario=$url->proc->nfeProc->NFe->infNFe->emit->xNome;
                $arrayRequired+=["Beneficiario"=>$Beneficiario];
                $arrayRequired+=["Data"=>$Data];
                $arrayRequired+=["Valor"=>$Valor];
                $arrayRequired+=["Nota"=>$Nota];
            }
        }else{
            $arrayRequired+=["Beneficiario"=>$Beneficiario];
            $arrayRequired+=["Comprovante"=>$Comprovante];
            $arrayRequired+=["Data"=>$Data];
            $arrayRequired+=["Valor"=>$Valor];
            $arrayRequired+=["Nota"=>$Nota];
            $Valor=str_replace(".","",$Valor);
            $Valor=str_replace(",",".",$Valor);
            $Valor=(float)$Valor;
            $QRCode = "";
        }
       
        $FormaDePagamento=(string)$FormaDePagamento;
        $TipoDePagamento=(string)$TipoDePagamento;
        $Agencia=(string)$Agencia;
        $Conta=(string)$Conta;
        $Historico=(int)$Historico;
        $Nota=(int)$Nota;
        $Data=(string)$Data;
        $Descricao=(string)$Descricao;
        $QRCodeLink=(string)$QRCodeLink;
        $Beneficiario=(string)$Beneficiario;
        $IdArquivo=(string)$IdArquivo;
        
        $this->Validate->validateCNPJ($PJ);
        $this->Validate->validateIssetCNPJ($PJ,"verificar");
        
        if(isset($_POST['Data'])){$this->Validate->validateData($Data);}
        if(isset($_POST['Nota'])){$this->Validate->validateNumero($Nota);}
        
        /*if(isset($_FILES['Comprovante'])){
            if($_FILES['Comprovante']['error']==0){
                $this->Validate->validateArquivo(
                    $Comprovante,
                    ["jpg","pdf","png","jpeg"],
                    8388608
                );
            }else if($_FILES['Comprovante']['error']==4){}else{
                $this->Validate->setError("Error no arquivo");
            }
        }*/
        
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
        
        if(isset($_POST['TipoDePagamento'])||(isset($_POST['TipoDePagamento']) && isset($_POST['Agencia']) && isset($_POST['Conta']))){
            
            $FormaDePagamento=md5(uniqid(rand(),true));
            $this->Validate->validateRegistroDeConta(
                [
                    "idConta"=>$FormaDePagamento,
                    "Banco"=>$TipoDePagamento,
                    "Agencia"=>$Agencia,
                    "Conta"=>$Conta,
                    "CPF"=>$cpf,
                    "CNPJ"=>$cnpj
                ],
                $_SESSION['TipoCliente']
            );
        }
       
        $this->Validate->validateRegistroDePagamento(
            [
                "IdRegistro"=>$IdRegistro,
                "DataAtual"=>$dataAtual,
                "PJ"=>$PJ,
                "FormaDePagamento"=>$FormaDePagamento,
                "Historico"=>$SubGrupo,
                "Descricao"=>$Descricao,
                "Beneficiario"=>$Beneficiario,
                "Nota"=>$Nota,
                "Valor"=>$Valor,
                "Data"=>$Data,
                "IdArquivo"=>(string)$IdArquivo,
                "IdGrupoComprovante"=>(string)$IdGrupoComprovante,
                "QRCodeLink"=>$QRCode,
                "Parcelas"=>(bool)$parcelasCheckBox,
                "ID"=>$cpf
            ]
        );
        
        
        
        $JSON=array(
            'erros'=>$this->Validate->getError(),
            'sucessos'=>$this->Validate->getMessage()
        );
        exit(json_encode($JSON));
    } 
}
?>