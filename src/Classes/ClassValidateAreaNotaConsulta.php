<?php
namespace Src\Classes;

use App\Model\ClassCadastro;
use App\Model\ClassLogin;
use App\Model\ClassHome;
use App\Model\ClassLancamentos;
use App\Model\ClassTabelas;
use App\Model\ClassGestaoDeUsuarios;
use App\Model\ClassGestaoDeConselho;
use App\Model\ClassPerfil;
use App\Model\ClassNotaFiscal;
use App\Model\ClassRecuperacaoDeSenha;
use Src\Classes\ClassPasswordHash;
use Src\Classes\ClassSessions;
use Src\Classes\ClassValidate;

use App\Model\ClassAreaNotaLancamnetoNFSE;
use Src\Classes\ClassJWT;
use Src\Classes\ClassRequestJSON;

use Src\Traits\TraitUrlParser;
use App\Model\ClassTeste;

class ClassValidateAreaNotaConsulta extends ClassValidate{
    
    private $AreaNotaLancamnetoNFSE;
    private $JWT;
    private $RequestJSON;
    
    public function __construct(){
        parent::__construct();
        $this->JWT = new ClassJWT;
        $this->RequestJSON = new ClassRequestJSON;
        $this->AreaNotaLancamnetoNFSE = new ClassAreaNotaLancamnetoNFSE;
    }

    public function validateGetChavesNotas(string $cnpj, int $ambiente=1){

        if(count($this->getError())>0){
           $this->setError("Sem dados");
           return false;
        }else{

           if($ambiente==1){
               $return = $this->AreaNotaLancamnetoNFSE->getChavesNotas($cnpj);
           }else if($ambiente==2){
               $return = $this->AreaNotaLancamnetoNFSE->getChavesNotasHomologacao($cnpj);
           }else{
               return false;
           }
           
           if($return['linhas']<=0){
               $this->setError("Sem dados");
               return false;
           }else{
               return $return['dados'];
           }
       }
    }

    private function validateGerarTokenMigrate(array $dados, int $ambiente=1){
        $time = time();
        $payLoader = array(
            "iat"=>$time,
            "exp"=>$time + 120,
            "sub"=>$dados['pj'],
            "partnerKey"=>PATNER_KEY
        );

        $token=$this->JWT->jwtEncode($payLoader,$dados["chaveAcesso"]);

        if($ambiente==1){
            $requestToken=json_decode($this->RequestJSON->request(PROD.CREATE_ACCESS_KEY,"POST",$token),true);
        }else if($ambiente==2){
            $requestToken=json_decode($this->RequestJSON->request(HOMOLOG.CREATE_ACCESS_KEY,"POST",$token),true);
        }else{
            $this->setError("Ambiente não relatado");
            return false;
        }

        return $requestToken;
    }
    
    public function validateConsultaNotas(array $dados, int $ambiente=1){
        if(count($this->getError())>0){
            $this->setError("Verifique os dados enviados");
            return false;
        }
        //exit(json_encode($dados));
        $url="{$dados['tipoModulo']}";
        $url.="?type=Consulta";
        $url.="&Versao=1.00";
        $url.="&tpAmb={$ambiente}";
        $url.="&ParmXMLLink=S";
        $url.="&ParmXMLCompleto=S";
        $url.="&ParmPDFLink=S";
        $url.='&ParmPDFBase64=S';
        $url.="&CnpjEmissor={$dados['PJ']}";
        
        if(!empty($dados['numeroFinal'])){$url.="&NumeroFinal={$dados['numeroFinal']}";}
        
        if(!empty($dados['numeroInicial'])){$url.="&NumeroInicial={$dados['numeroInicial']}";}
            
        if(!empty($dados['serie'])){$url.="&Serie={$dados['serie']}";}
        
        if(!empty((int)$dados['statusNota'])){$url.="&StatusDocumento={$dados['statusNota']}";}
        
        
        $date = date_create();
        
        if((int)$dados['dataRadio']==1){
            $data = date_format($date,'Y-m-d');
            $dados['dataInicio'] = $data."T00:00:00";
            $dados['dataFim'] = $data."T23:59:59";
        }else if((int)$dados['dataRadio']==2){
            $data = date_format($date,'Y-m');
            $dias = date_format($date,"t");
            $dados['dataInicio'] = $data."-01T00:00:00";
            $dados['dataFim'] = $data."-".$dias."T23:59:59";
        }else if((int)$dados['dataRadio']==3){
            $ano = date_format($date,'Y');
            $dias = cal_days_in_month(CAL_GREGORIAN, 12, $ano);
            $dados['dataInicio'] = $ano."-01-01T00:00:00";
            $dados['dataFim'] = $ano."-12-".$dias."T23:59:59";
        }else if((int)$dados['dataRadio']==4){
            $anoAtual = date_format($date,'Y');
            $dias = cal_days_in_month(CAL_GREGORIAN, 12, (int)$anoAtual);
            $dados['dataInicio'] = "2005-01-01T00:00:00";
            $dados['dataFim'] = $anoAtual."-12-".$dias."T23:59:59";
        }
        
        if((int)$dados['emissaoInclusao']==1){
            $url.="&DataEmissaoInicial={$dados['dataInicio']}";
            $url.="&DataEmissaoFinal={$dados['dataFim']}";
        }else if((int)$dados['emissaoInclusao']==2){
            $url.="&DataInclusaoInicial={$dados['dataInicio']}";
            $url.="&DataInclusaoFinal={$dados['dataFim']}";
        }
        
        //$chaves = $this->AreaNotaLancamnetoNFSE->getChavesNotas($dados['PJ'], $ambiente);
        $chaves = self::validateGetChavesNotas($dados['PJ'], $ambiente);
        //exit(json_encode($chaves));
        if($chaves==false){
            $this->setError("Sem chave de acesso");
            return false;
        }

        $requestToken = self::validateGerarTokenMigrate([
            'pj'=>$dados['PJ'],
            'chaveAcesso'=>$chaves['ChaveAcesso']
        ],$ambiente);

        if($requestToken==false){
            $this->setError("Falha na criação do token");
            return false;
        }

        /*$payLoader = array(
            "iat"=>time(),
            "exp"=>time() + 120,
            "sub"=>$dados['PJ'],
            "partnerKey"=>PATNER_KEY
        );
        
        $token=$this->JWT->jwtEncode($payLoader,$chaves['dados']['ChaveAcesso']);
        
        //exit(json_encode($token));
        
        $requestToken=json_decode($this->RequestJSON->request(PROD.CREATE_ACCESS_KEY,"POST",$token),true);*/
        
        $header = array(
            "Authorization:{$requestToken['accessToken']}",
            "Content-Type:application/json"
        );

        if($ambiente==1){
            $requestNFSe=json_decode($this->RequestJSON->request(PROD.DOCNOTAS.$url,"GET",null,$header),true);
        }else if($ambiente==2){
            $requestNFSe=json_decode($this->RequestJSON->request(HOMOLOG.DOCNOTAS.$url,"GET",null,$header),true);
        }else{
            $this->setError("Ambiente não relatado");
            return false;
        }
        
        if($requestNFSe[0]['Codigo']!=100){
            $erro = filter_var($requestNFSe[0]['Descricao'],FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
            $this->setError($erro);
            return false;
        }else{
            return $requestNFSe[0]['Documentos'];
        }
           
    }
    
    public function validateCancelarNota(array $dados, int $ambiente=1){
        if(count($this->getError())>0){
            $this->setError("Verifique os dados enviados");
            return false;
        }
        $cancelaNotaArray = [];
        
        if(strtolower($dados['modelo'])=='nfse'){
            $url="nfse?type=Evento";
            array_push($cancelaNotaArray, array(
                "ModeloDocumento"=>"NFSe",
                "Versao"=>1,
                "Evento"=>array(
                    "CNPJ"=>(string)$dados['PJ'],
                    "NFSeNumero"=>(int)$dados['numeroNFSE'],
                    "RPSNumero"=>(int)$dados['numero'],
                    "RPSSerie"=>(string)$dados['serie'],
                    "EveTp"=>110111,
                    "tpAmb"=>1,
                    "EveCodigo"=>(string)$dados['tpCodEvento'],
                    "EveMotivo"=>(string)$dados['motivoCancelamento']
                )
            ));
        }
        
        $chaves = $this->AreaNotaLancamnetoNFSE->getChavesNotas($dados['PJ']);

        if($chaves==false){
            $this->setError("Sem chave de acesso");
            return false;
        }    
    
        /*$payLoader = array(
            "iat"=>time(),
            "exp"=>time() + 120,
            "sub"=>$dados['PJ'],
            "partnerKey"=>PATNER_KEY
        );
        
        $token=$this->JWT->jwtEncode($payLoader,$chaves['dados']['ChaveAcesso']);
        
        $requestToken=json_decode($this->RequestJSON->request(PROD.CREATE_ACCESS_KEY,"POST",$token),true);*/

        $requestToken = self::validateGerarTokenMigrate([
            'pj'=>$dados['PJ'],
            'chaveAcesso'=>$chaves['ChaveAcesso']
        ],$ambiente);

        if($requestToken==false){
            $this->setError("Falha na criação do token");
            return false;
        }
        
        $header = array(
            "Authorization:{$requestToken['accessToken']}",
            "Content-Type:application/json"
        );

        $json = json_encode($cancelaNotaArray,JSON_UNESCAPED_UNICODE);

        if($ambiente==1){
            $requestNFSe=json_decode($this->RequestJSON->request(PROD.DOCNOTAS.$url,"POST",$json,$header),true);
        }else if($ambiente==2){
            $requestNFSe=json_decode($this->RequestJSON->request(HOMOLOG.DOCNOTAS.$url,"POST",$json,$header),true);
        }else{
            $this->setError("Ambiente não relatado");
            return false;
        }
        
        //$requestNFSe=json_decode($this->RequestJSON->request(PROD.DOCNOTAS.$url,"POST",$json,$header),true);
        
        //exit(json_encode($requestNFSe,JSON_UNESCAPED_UNICODE));
        
        if($requestNFSe[0]['Codigo']!=100){
            /*$erro = preg_replace("/[^A-Z ^a-z ^À-ú ,)(]/","",$requestNFSe[0]['Descricao']);
            $this->setError($erro);*/
            $this->setError($requestNFSe[0]['Descricao']);
            return false;
        }else{
            $this->setMessage("Documento cancelado");
            return $requestNFSe[0]['Documento'];
        }
            
            
        
    }
}
?>