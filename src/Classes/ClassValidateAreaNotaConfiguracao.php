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

use Src\Classes\ClassJWT;
use Src\Classes\ClassRequestJSON;

use App\Model\ClassAreaNotaConfiguracao;
use App\Model\ClassAreaNotaLancamnetoNFSE;

use Src\Traits\TraitUrlParser;
use App\Model\ClassTeste;

class ClassValidateAreaNotaConfiguracao extends ClassValidate{
    
    private $AreaNotaLancamnetoNFSE;
    private $AreaNotaConfiguracao;
    private $JWT;
    private $RequestJSON;
    
    public function __construct(){
        parent::__construct();
        $this->AreaNotaLancamnetoNFSE = new ClassAreaNotaLancamnetoNFSE;
        $this->AreaNotaConfiguracao = new ClassAreaNotaConfiguracao;
        $this->JWT = new ClassJWT();
        $this->RequestJSON = new ClassRequestJSON();
    }

    public function validateInsertRBT12(array $dados):bool{
        if(count($this->getError())>0){
            $this->setError("Verifique os dados do formulário.");
            return false;
        }else{
            $return = $this->AreaNotaConfiguracao->insertRBT12($dados);
            if(!$return){
                $this->setError("Dados não registrados.");
                return false;
            }else{
                $this->setMessage("Dados registrado");
                return true;
            }

        }
    }
    
    public function validateInsertEmpresaAPI($dados){
        $payLoader = array(
            "iat"=>time(),
            "exp"=>time() + 120,
            "sub"=>SUB,
            "partnerKey"=>PATNER_KEY
        );
        
        $token=$this->JWT->jwtEncode($payLoader,KEY_PROD);
        
        $requestToken=json_decode($this->RequestJSON->request(PROD.CREATE_ACCESS_KEY,"POST",$token),true);
        
        if(!isset($requestToken['accessToken'])){
            $this->setError("Falha no token");
            return false;
        }else{
            
            $cep = json_decode($this->RequestJSON->request(
                "https://viacep.com.br/ws/".preg_replace("/[^0-9]/","",$_SESSION['cep'])."/json/",
                "GET"
            ),true);
            
            $Licenciamento = array(
                array(
                    "Modulo"=> (string)$dados['modulo'],
                    "Modelo"=> (string)$dados['modelo'],
                    "Autor"=> (string)$_SESSION['nomeFantasia']
                )
            );
            
            $Certificado = array(
                "ArquivoPFX"=> (string)$dados['arquivoCD'],
                "Senha"=> (string)$dados['senhaCD'],
                "TipoCertificado"=> (int)$dados['certificaDoDigital']
            );
            
            $Cadastro = array(
                array(
                    "EmpNomFantasia"=>(string)$_SESSION['nomeFantasia'],
                    "EmpApelido"=> (string)$_SESSION['nomeFantasia'],
                    "EmpRazSocial"=> (string)$_SESSION['razaoSocial'],
                    "EmpCNPJ"=> (string)$_SESSION['ID'],
                    "EmpCPF"=> (string)"",
                    "EmpIE"=> (string)$dados['inscricaoEstadual'],
                    "EmpIM"=> (string)$dados['inscricaoMunicipal'],
                    "MunCodigo"=> (int)$cep['ibge'],
                    "EmpCRT"=> (int)$dados['codigoCRT'],
                    "EmpTpoEndereco"=> (string)"AVENIDA",
                    "Certificado"=>$Certificado,
                    "Licenciamento"=>$Licenciamento,
                    "EmpTelefone"=> (string)$_SESSION['telefone'],
                    "EmpEndereco"=> (string)$_SESSION['endereco'],
                    "EmpNumero"=> (string)$_SESSION['numero'],
                    "EmpBairro"=> (string)$_SESSION['bairro'],
                    "EmpCEP"=> (string)$_SESSION['cep'],
                    "EmpComplemento"=> (string)$_SESSION['complemento']
                )
            );
            
            $header=[
                "Content-Type: application/json",
                "Authorization: Bearer {$requestToken['accessToken']}"
            ];
        
            $Cadastro = json_encode($Cadastro,JSON_UNESCAPED_UNICODE);
            
            $returnoCadastroApi = json_decode($this->RequestJSON->request(PROD.'companies',"POST",$Cadastro,$header),true);
            
            if($returnoCadastroApi[0]['Codigo']!=100){
                $this->setError('Empresa não cadastrarda');
                return false;
            }else{
                if($returnoCadastroApi[0]['RetornoCadastro'][0]['Codigo']!=100){
                    $this->setError($returnoCadastroApi[0]['RetornoCadastro'][0]['Descricao']);
                    return false;
                }else{
                    
                    $this->setMessage("Empresa cadastrada");
                    
                    $return = $this->AreaNotaConfiguracao->issetChaveNotas([
                        "cnpj"=>$dados['cnpj'],
                        "chaveAcesso"=>$returnoCadastroApi[0]['RetornoCadastro'][0]['EmpAK']
                    ]);
                    
                    if($return){
                        $return = $this->AreaNotaConfiguracao->updateChaveNotas([
                            "cnpj"=>$dados['cnpj'],
                            "chaveAcesso"=>$returnoCadastroApi[0]['RetornoCadastro'][0]['EmpAK']
                        ]);
                        if($return){
                            $this->setMessage("Chave atualizada");
                        }else{
                            $this->setError("Chave não atualizada");
                        }
                    }else{
                        $return = $this->AreaNotaConfiguracao->insertChaveNotas([
                            "cnpj"=>$dados['cnpj'],
                            "chaveAcesso"=>$returnoCadastroApi[0]['RetornoCadastro'][0]['EmpAK']
                        ]);
                        if($return){
                            $this->setMessage("Chave registrada");
                        }else{
                            $this->setError("Chave não registrada");
                        }
                    }
                    
                    return true;
                }
            }
        }
        
        
    }
    
    public function validateInsertConfiguracaoEmissaoNota($dados){
        
        $return = $this->AreaNotaConfiguracao->insertConfiguracaoEmissaoNota($dados);

        if($return > 0){
            $this->setMessage('Configurações salvas');
            return true;
        }else{
            $this->setError('Confgurações não salvas');
            return false;
        }
        
    }
    
    public function validateIssetConfiguracaoEmissaoNota($dados){
        
        $return = $this->AreaNotaConfiguracao->issetConfiguracaoEmissaoNota($dados);
        
        if($return > 0){
            return true;
        }else{
            return false;
        }
        
    }
    
    public function validateUpdateConfiguracaoEmissaoNota($dados){
        
        $return = $this->AreaNotaConfiguracao->updateConfiguracaoEmissaoNota($dados);
        
        if($return > 0){
            $this->setMessage('Configurações atualizadas');
            return true;
        }else{
            $this->setError('Confgurações não atualizadas');
            return false;
        }
        
    }
    
    public function validateRegistrarLicenciamento($dados){
        
        $return = $this->AreaNotaLancamnetoNFSE->getChavesNotas($_SESSION['ID']);
        if($return['linhas']<=0){
            $this->setError("Verifique os dados mandados");
            return false;
        }else{
            $payLoader = array(
                "iat"=>time(),
                "exp"=>time() + 120,
                "sub"=>$_SESSION['ID'],
                "partnerKey"=>PATNER_KEY
            );
            
            $token=$this->JWT->jwtEncode($payLoader,$return['dados']['ChaveAcesso']);
            
            $requestToken=json_decode($this->RequestJSON->request(PROD.CREATE_ACCESS_KEY,"POST",$token),true);
            
            if(!isset($requestToken['accessToken'])){
                $this->setError("Falha no token");
                return false;
            }else{
                $header=[
                    'Content-Type:application/json',
                    "Authorization:{$requestToken['accessToken']}"
                ];
                $json= array(
                    array(
                        "CnpjEmpresa"=>(string)$_SESSION['ID'],
                        "tpAmb"=>(int)$dados['LocalLancamento'],
                        "Acao"=>(int)$dados['Acao'],
                        "Modulo"=>(string)$dados['Modulo'],
                        "Modelo"=>(int)$dados['Modelo'],
                        "Autor"=>(string)$_SESSION['nomeFantasia']
                    )
                );
                //exit(json_encode($json));
                $return = json_decode($this->RequestJSON->request(PROD.'companies?type=licenciamento',"POST",json_encode($json,JSON_UNESCAPED_UNICODE),$header), true);
                 
                if($return[0]['Codigo']!=100){
                    $this->setError("Licença não registrada");
                    return false; 
                }else{
                    
                    if($return[0]['Detalhes'][0]['Codigo']!=100){
                        $this->setError("Licença não registrada");
                        return false;
                    }else{
                       
                        $this->setMessage("Licença registrada");
                        $returnModulo = $this->AreaNotaConfiguracao->issetModuloPJ([
                            "nfse"=>(int)$dados['Acao'],
                            "cnpj"=>(string)$_SESSION['ID']
                        ]);
                        
                        if($returnModulo>0){
                            $return = $this->AreaNotaConfiguracao->updateModuloPJ([
                                "nfse"=>(int)$dados['Acao'],
                                "cnpj"=>(string)$_SESSION['ID']
                            ]);
                            if($return){
                                $this->setMessage("Configuração de modulo registrado");
                            }else{
                                $this->setError("Configuração de modulo não registrado");
                            }
                        }else{
                            $return = $this->AreaNotaConfiguracao->insertModuloPJ([
                                "nfse"=>(int)$dados['Acao'],
                                "cnpj"=>(string)$_SESSION['ID']
                            ]);
                            if($return){
                                $this->setMessage("Configuração de modulo atualizada");
                            }else{
                                $this->setError("Configuração de modulo não atualizada");
                            }
                        }
                        return true;
                    }
                }
            }
        }
       
    }
    
    public function validateGetModuloPJ($dados){
        
        $return = $this->AreaNotaConfiguracao->getModuloPJ($dados);
        
        if($return['linhas']<=0){
            $this->setError("Modulo já existente");
            return false;
        }else{
            return $return['dados'];
        }
        
    }

    public function validateGetEmpresaAPI($cnpj){
        
        $return = $this->AreaNotaLancamnetoNFSE->getChavesNotas($cnpj);
        if($return['linhas']<=0){
            $this->setError("Chave de acesso não encontrada");
            return false;
        }else{
            $payLoader = array(
                "iat"=>time(),
                "exp"=>time() + 120,
                "sub"=>$cnpj,
                "partnerKey"=>PATNER_KEY
            );
            
            $token=$this->JWT->jwtEncode($payLoader,$return['dados']['ChaveAcesso']);
            
            $requestToken=json_decode($this->RequestJSON->request(PROD.CREATE_ACCESS_KEY,"POST",$token),true);
            
            if(!isset($requestToken['accessToken'])){
                $this->setError("Falha no token");
                return false;
            }else{
                $header=[
                    "Content-Type: application/json",
                    "Authorization: Bearer {$requestToken['accessToken']}"
                ];
                //exit(json_encode(PROD.'companies?CNPJ='.$cnpj));
                return json_decode($this->RequestJSON->request(PROD.'companies?CNPJ='.$cnpj,"GET",null,$header),true);
            }
        }
        
    }
    
    public function validateMunicipio(){
        $payLoader = array(
            "iat"=>time(),
            "exp"=>time() + 120,
            "sub"=>SUB,
            "partnerKey"=>PATNER_KEY
        );
        
        $token=$this->JWT->jwtEncode($payLoader,KEY_PROD);
        
        $requestToken=json_decode($this->RequestJSON->request(PROD.CREATE_ACCESS_KEY,"POST",$token),true);
        
        if(!isset($requestToken['accessToken'])){
            $this->setError("Falha no token");
            return false;
        }else{
            $url = "&tpAmb=1";
            $url .= "&Versao=1.00";
            $url .= "&ModeloDocumento=NFSe";
            //$url += "&CodMunicipio=1.00";
            $url .= "&CnpjEmissor=11316866000122";
            $url .= "&UF=PE";
            $header=[
                "Authorization:{$requestToken['accessToken']}"
            ];
            //exit(json_encode($requestToken));
            $return = $this->RequestJSON->request(PROD.'cities/companies?Type=ConsultaMunicipios'.$url,"GET",null,$header);
            
            return json_decode($return,true);
        }
    }    
    public function validateInsertListaServico($dados){
        
        $r = $this->AreaNotaConfiguracao->issetListaServico([
            "cod"=>$dados['cod'],
            "cnpj"=>$dados['cnpj']
        ]);
        
        if(!$r){
            $result = $this->AreaNotaConfiguracao->insertListaServico([
                "cod"=>(float)$dados['cod'],
                "cnpj"=>(string)$dados['cnpj'],
                "descricao"=>(string)$dados['descricao']
            ]);
        }
        if($result){
            $this->setMessage("Serviço registrado");
            return true;
        }else{
            $this->setError("Serviço não registrado");
            return false;
        }
    }
    
    public function validateGetListaServico($cnpj){
        $result = $this->AreaNotaConfiguracao->getListaServico($cnpj);
        if($result['linhas']<=0){
            $this->setError("Sem serviço");
            return false;
        }else{
            return $result['dados'];
        }
    }
    
    public function validateDeleteServico($dados){
        if(count($this->getError())>0){
            $this->setError("Serviço não deletado(Verifique os dados)");
            return false;
        }else{
            $result = $this->AreaNotaConfiguracao->deleteListaServico($dados);
            if(!$result){
                $this->setError("Serviço não deletado");
                return false;
            }else{
                $this->setMessage("Serviço deletado");
                return true;
            }
        }
        
    }
}
?>