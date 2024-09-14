<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassValidate;
use Src\Classes\ClassJWT;
use Src\Classes\ClassRequestJSON;
use Src\Classes\ClassSessions;
use Src\Traits\TraitUrlParser;

use Dompdf\Dompdf;
use Dompdf\Options;

use Src\Classes\ClassValidateAreaNotaLancamnetoNFSE;
use Src\Classes\ClassValidateAreaNotaConfiguracao;
use Src\Classes\ClassValidateAreaNotaConsulta;

class ControllerAreaNota_LancamentoNFSE{
    use TraitUrlParser;
    private $Validate;
    private $Render;
    private $JWT;
    private $RequestJSON;
    private $Session;
    private $DomPDF;
    private $DomPDFOpt;
    
    private $ValidateAreaNotaLancamnetoNFSE;
    private $ValidateAreaNotaConfiguracao;
    private $ValidateAreaNotaConsulta;
    
    private $ArrayRequest = [];
    
    function __construct(){
        $this->Render=new ClassRender;
        $this->Validate=new ClassValidate;
        
        $this->ValidateAreaNotaLancamnetoNFSE = new ClassValidateAreaNotaLancamnetoNFSE;
        $this->ValidateAreaNotaConfiguracao = new ClassValidateAreaNotaConfiguracao;
        $this->ValidateAreaNotaConsulta = new ClassValidateAreaNotaConsulta;
        
        $this->JWT = new ClassJWT;
        $this->RequestJSON = new ClassRequestJSON;
        
        $this->DomPDFOpt = new Options();
        $this->DomPDFOpt->set('isRemoteEnabled', TRUE);
        
        $this->DomPDF = new Dompdf($this->DomPDFOpt);
        
        $this->Session=new ClassSessions;
        $this->Render->setDir("AreaNota/Lancamento/NFSE");
        $this->Render->setTitle("Lançamento de NFSe");
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
                "erros"=>$this->ValidateAreaNotaLancamnetoNFSE->getError(),
                "TipoCliente"=>$_SESSION['TipoCliente'],
                "dados"=>[
                    'id'=>$_SESSION['ID'],
                    'nomeFantasia'=>$_SESSION['nomeFantasia']
                ],
                "ultimaSerie"=>$this->ValidateAreaNotaLancamnetoNFSE->validateGetUltimoRPS(["PJ"=>$_SESSION['ID'],"tipoModulo"=>"nfse"],2)
            ]));
        }else{
            
        }
    }

    public function consultarUltimoRPS(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            if(isset($_POST['PJ'])){
                $PJ=preg_replace("/[^0-9]/","",$_POST['PJ']);
                $this->Validate->validateCNPJ($PJ);
                $this->Validate->validateIssetCNPJ($PJ,"Validar");
            }
            if(isset($_POST['tipoModulo'])){
                $tipoModulo = filter_input(INPUT_POST,'tipoModulo',FILTER_SANITIZE_ADD_SLASHES);
                $tipoModulo = mb_strtolower($tipoModulo, 'UTF-8');
            }

            $this->Validate->validateFilds([$PJ,$tipoModulo]);

            $return = $this->ValidateAreaNotaLancamnetoNFSE->validateGetUltimoRPS(["PJ"=>$PJ,"tipoModulo"=>$tipoModulo], 2);

            exit(json_encode([
                'erros'=>$this->ValidateAreaNotaLancamnetoNFSE->getError(),
                'dados'=>$return
            ]));
        }else{
             exit(json_encode("Envie uma requisição POST"));
        }
    }
    
    public function getNotasClonadas(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            if(isset($_POST['PJ'])){
                $PJ=preg_replace("/[^0-9]/","",$_POST['PJ']);
                $this->Validate->validateCNPJ($PJ);
                $this->Validate->validateIssetCNPJ($PJ,"Validar");
            }
            
            $this->Validate->validateFilds([$PJ]);
           
            $return = $this->ValidateAreaNotaLancamnetoNFSE->validateGetClonaNFSE($PJ);
            
            exit(json_encode([
                'erros'=>$this->ValidateAreaNotaLancamnetoNFSE->getError(),
                'dados'=>$return
            ]));
        }else{
            exit(json_encode('Envie uma requisição POST'));
        }
  
    }
    
    public function getDadosNotaClonata(){
        
        if(isset($_POST['notaClonada'])){
            $notaClonada = filter_input(INPUT_POST,'notaClonada',FILTER_SANITIZE_ADD_SLASHES);
        }
        
        $this->Validate->validateFilds([$notaClonada]);
        
        $return = $this->ValidateAreaNotaLancamnetoNFSE->validateGetDadosNotaClonata($notaClonada);
        
        exit(json_encode([
            'erros'=>$this->ValidateAreaNotaLancamnetoNFSE->getError(),
            'dados'=>$return
        ]));
    }
    
    public function getNaturezaOperacao(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            exit(json_encode("Envie uma requisição POST"));
        }
        
        if(isset($_POST['PJ'])){
            $PJ=preg_replace("/[^0-9]/","",$_POST['PJ']);
            $this->Validate->validateCNPJ($PJ);
            $this->Validate->validateIssetCNPJ($PJ,"Validar");
        }

        $this->Validate->validateFilds([$PJ]);

        $requestNP = $this->ValidateAreaNotaLancamnetoNFSE->validateGetNaturezaOperacao(['pj'=>$PJ],2);
        
        exit(json_encode([
            'NaturezaOperacao'=>$requestNP,
            'erros'=>$this->ValidateAreaNotaLancamnetoNFSE->getError()
        ]));
        
 
    }
    
    public function getServicos(){
        
        if(isset($_POST['PJ'])){
            $PJ=preg_replace("/[^0-9]/","",$_POST['PJ']);
            $this->Validate->validateCNPJ($PJ);
            $this->Validate->validateIssetCNPJ($PJ,"Validar");
        }

        $return = $this->ValidateAreaNotaConfiguracao->validateGetListaServico($PJ);
        exit(json_encode([
            "erros"=>$this->ValidateAreaNotaConfiguracao->getError(),
            'dados'=>$return
        ]));
    }
    
    public function clonarNota(){
        
        if(isset($_POST['PJ'])){
            $PJ=preg_replace("/[^0-9]/","",$_POST['PJ']);
            $this->Validate->validateCNPJ($PJ);
            $this->Validate->validateIssetCNPJ($PJ,"Validar");
            $this->ArrayRequest+=["PJ"=>$PJ];
        }
        
        if(isset($_POST['atividade'])){
            $atividade=filter_input(INPUT_POST,'atividade',FILTER_SANITIZE_NUMBER_INT);
            $this->ArrayRequest+=["atividade"=>$atividade];
        }
        
        if(isset($_POST['naturezaOperacao'])){
            $naturezaOperacao=filter_input(INPUT_POST,'naturezaOperacao',FILTER_SANITIZE_NUMBER_INT);
            $this->ArrayRequest+=["naturezaOperacao"=>$naturezaOperacao];
        }
        
        if(isset($_POST['codServico'])){
            $codServico=filter_input(INPUT_POST,'codServico',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $this->ArrayRequest+=["codServico"=>$codServico];
        }
        
        if(isset($_POST['DescriminacaoDosServicos'])){
            $DescriminacaoDosServicos=filter_input(INPUT_POST,'DescriminacaoDosServicos',FILTER_SANITIZE_ADD_SLASHES);
            $this->ArrayRequest+=["DescriminacaoDosServicos"=>$DescriminacaoDosServicos];
        }
        
        if(isset($_POST['CpfCnpjTomador'])){
            $CpfCnpjTomador=preg_replace("/[^0-9]/","",$_POST['CpfCnpjTomador']);
            $this->ArrayRequest+=["CpfCnpjTomador"=>$CpfCnpjTomador];
        }
        
        if(isset($_POST['nomeTomador'])){
            $nomeTomador=filter_input(INPUT_POST,'nomeTomador',FILTER_SANITIZE_ADD_SLASHES);
            $this->ArrayRequest+=["nomeTomador"=>$nomeTomador];
        }
        
        if(isset($_POST['ValorTotalDosServicos'])){
            $ValorTotalDosServicos = filter_input(INPUT_POST,'ValorTotalDosServicos',FILTER_SANITIZE_ADD_SLASHES);
            $this->ArrayRequest+=["ValorTotalDosServicos"=>$ValorTotalDosServicos];
        }
        
         $this->ArrayRequest['id']=md5(mt_rand(1000,9999));
        
        $this->ValidateAreaNotaLancamnetoNFSE->validateInsertClonaNFSE($this->ArrayRequest);
        
        exit(json_encode([
            'erros'=>$this->ValidateAreaNotaLancamnetoNFSE->getError(),
            'sucessos'=>$this->ValidateAreaNotaLancamnetoNFSE->getMessage(),
            'pj'=>$this->ArrayRequest['PJ']
        ]));
    }
    
    public function emitirNFSE(){
        //exit(json_encode($_POST));
        $array_post = array();
        if(isset($_POST['PJ'])){
            $PJ=preg_replace("/[^0-9]/","",$_POST['PJ']);
            $this->Validate->validateCNPJ($PJ);
            $this->Validate->validateIssetCNPJ($PJ,"Validar");
            $array_post+=["PJ"=>$PJ];
        }
        if(isset($_POST['atividade'])){
            $atividade=filter_input(INPUT_POST,'atividade',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["atividade"=>$atividade];
        }
        if(isset($_POST['naturezaOperacao'])){
            $naturezaOperacao=filter_input(INPUT_POST,'naturezaOperacao',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["naturezaOperacao"=>$naturezaOperacao];
        }
        if(isset($_POST['codServico'])){
            $codServico=filter_input(INPUT_POST,'codServico',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $array_post+=["codServico"=>$codServico];
        }
        if(isset($_POST['dataCompetencia'])){
            $this->ValidateAreaNotaConfiguracao->validateData($_POST['dataCompetencia']);
            $dataCompetencia=date_format(date_create($_POST['dataCompetencia']),'Y-m-d H:i:s');
            $dataCompetencia=str_replace(" ","T",$dataCompetencia);
            $array_post+=["dataCompetencia"=>$dataCompetencia];
        }
        if(isset($_POST['NdoRPS'])){
            $NdoRPS=filter_input(INPUT_POST,'NdoRPS',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["NdoRPS"=>$NdoRPS];
        }
        if(isset($_POST['SerieDoRPS'])){
            $SerieDoRPS=filter_input(INPUT_POST,'SerieDoRPS',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["SerieDoRPS"=>$SerieDoRPS];
        }
        if(isset($_POST['DescriminacaoDosServicos'])){
            $DescriminacaoDosServicos=filter_input(INPUT_POST,'DescriminacaoDosServicos',FILTER_SANITIZE_ADD_SLASHES);
            $array_post+=["DescriminacaoDosServicos"=>$DescriminacaoDosServicos];
        }
        if(isset($_POST['CpfCnpjTomador'])){
            $CpfCnpjTomador=preg_replace("/[^0-9]/","",$_POST['CpfCnpjTomador']);
            $array_post+=["CpfCnpjTomador"=>$CpfCnpjTomador];
        }
        if(isset($_POST['nomeTomador'])){
            $nomeTomador=filter_input(INPUT_POST,'nomeTomador',FILTER_SANITIZE_ADD_SLASHES);
            $array_post+=["nomeTomador"=>$nomeTomador];
        }
        if(isset($_POST['cepTomador'])){
            $cepTomador=preg_replace("/[^0-9]/","",$_POST['cepTomador']);
            $array_post+=["cepTomador"=>$cepTomador];
        }
        if(isset($_POST['ValorTotalDosServicos'])){
            $ValorTotalDosServicos=(float)str_replace([".",","],["","."],$_POST['ValorTotalDosServicos']);
            $ValorTotalDosServicos=filter_var($ValorTotalDosServicos,FILTER_VALIDATE_FLOAT);
            $array_post+=["ValorTotalDosServicos"=>$ValorTotalDosServicos];
        }
        if(isset($_POST['ISSPercentual'])){
            $ISSPercentual = (int)filter_input(INPUT_POST,'ISSPercentual',FILTER_SANITIZE_NUMBER_INT);
            if($ISSPercentual>0 && $ISSPercentual>1){$ISSPercentual /= 100;}
            $array_post+=["ISSPercentual"=>$ISSPercentual];
        }
        if(isset($_POST['FormaDePagamento'])){
            $FormaDePagamento=filter_input(INPUT_POST,'FormaDePagamento',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["FormaDePagamento"=>$FormaDePagamento];
        }
        if(isset($_POST['QuantasParcelas'])){
            $QuantasParcelas=filter_input(INPUT_POST,'QuantasParcelas',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["QuantasParcelas"=>$QuantasParcelas];
        }
        if(isset($_POST['ValorDaParcela'])){
            $ValorDaParcela=(float)str_replace([".",","],["","."],$_POST['ValorDaParcela']);
            $ValorDaParcela=filter_var($ValorDaParcela,FILTER_VALIDATE_FLOAT);
            $array_post+=["ValorDaParcela"=>$ValorDaParcela];
        }
        if(isset($_POST['NumeroDaFatura'])){
            $NumeroDaFatura=filter_input(INPUT_POST,'NumeroDaFatura',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=["NumeroDaFatura"=>$NumeroDaFatura];
        }
        
        if(strlen($CpfCnpjTomador)<=11){
            $array_post+=['cpfTomador' => $CpfCnpjTomador];
        }else{
            $array_post+=['cnpjTomador' => $CpfCnpjTomador];
        }
        
        $this->Validate->validateFilds($array_post);
        
        $result = $this->ValidateAreaNotaLancamnetoNFSE->validateEmitirNFSE($array_post, 2);
        
        exit(json_encode([
            'erros'=>$this->ValidateAreaNotaLancamnetoNFSE->getError(),
            'sucessos'=>$this->ValidateAreaNotaLancamnetoNFSE->getMessage(),
            'dados'=>$result
        ]));
        
    }
    
    public function printNota(){
       
        if(isset($_GET['file'])){
            $html = base64_decode(str_replace(["-","_"],["+","/"],$_GET['file']));
            $this->DomPDF->loadHtml($html);
            $this->DomPDF->setPaper('A4', 'landscape');
            $this->DomPDF->render();
            $this->DomPDF->stream('Nota');
        }
       
    }
    
    public function getUltimaSerie(){
        
        if(isset($_POST['PJ'])){
            $PJ=preg_replace("/[^0-9]/","",$_POST['PJ']);
            $this->Validate->validateCNPJ($PJ);
            $this->Validate->validateIssetCNPJ($PJ,"Validar");
        }
        
        $this->Validate->validateFilds($PJ);
        
        $result = $this->ValidateAreaNotaLancamnetoNFSE->validateUltimaSerie($PJ);
        
        exit(json_encode([
            'erros'=>$this->ValidateAreaNotaLancamnetoNFSE->getError(),
            'dados'=>$result
        ]));
        
    }
    
}
?>