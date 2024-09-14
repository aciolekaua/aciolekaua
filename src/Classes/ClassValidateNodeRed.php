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

use App\Model\ClassAreaNotaConfiguracao;
use App\Model\ClassAreaNotaLancamnetoNFSE;
use Src\Classes\ClassJWT;
use Src\Classes\ClassRequestJSON;

use Src\Traits\TraitUrlParser;
use App\Model\ClassTeste;

class ClassValidateNodeRed extends ClassValidate{
    private $AreaNotaLancamnetoNFSE;
    private $AreaNotaConfiguracao;
    private $JWT;
    private $RequestJSON;
    private $Validate;
    
    public function __construct(){
        parent::__construct();
        $this->AreaNotaLancamnetoNFSE = new ClassAreaNotaLancamnetoNFSE;
        $this->AreaNotaConfiguracao = new ClassAreaNotaConfiguracao;
        $this->JWT = new ClassJWT();
        $this->RequestJSON = new ClassRequestJSON();
        $this->Validate = new ClassValidate;
    }

    public function validateRegistrarCertificado(array $dados, int $ambiente=1){
        $payLoader = array(
            "iat"=>time(),
            "exp"=>time() + 120,
            "sub"=>SUB,
            "partnerKey"=>PATNER_KEY
        );

        if($ambiente==1){
            $token=$this->JWT->jwtEncode($payLoader,KEY_PROD);
            $requestToken=json_decode($this->RequestJSON->request(PROD.CREATE_ACCESS_KEY,"POST",$token),true);
        }else if($ambiente==2){
            $token=$this->JWT->jwtEncode($payLoader,KEY_HOMOLOG);
            $requestToken=json_decode($this->RequestJSON->request(HOMOLOG.CREATE_ACCESS_KEY,"POST",$token),true);
        }
        
        if(!isset($requestToken['accessToken'])){
            $this->setError("Falha no token");
            return false;
        }else{
           
            $certificado = [
                "Empresas"=> [
                    "CNPJ"=>[
                        (string)$dados['CNPJ']
                    ]
                ],
                "Apelido"=> (string)$dados['Nome'],
                "ArquivoPFX"=> (string)$dados['Certificado'],
                "Senha"=> (string)$dados['SenhaCertificado'],
                "Tipo"=> "A1"
            ];
            
            $certificado=json_encode($certificado,JSON_INVALID_UTF8_IGNORE);

            /*$licenca = [
                [
                "CnpjEmpresa"=> (string)$dados['CNPJ'],
                "tpAmb"=> (int)$ambiente,
                "Acao"=> (int)1,
                "Modulo"=> (string)"NFSe",
                "Modelo"=> (int)1,
                "Autor"=> (string)$dados['Nome']
                ]
            ];*/

            $header = array(
                "Authorization:{$requestToken['accessToken']}",
                "Content-Type:application/json"
            );

            if($ambiente==1){
                $returnoCertificadoApi=json_decode($this->RequestJSON->request(PROD."companiescertificates.aspx","POST",$certificado,$header),true);
            }else if($ambiente==2){
                $returnoCertificadoApi=json_decode($this->RequestJSON->request(HOMOLOG."companiescertificates.aspx","POST",$certificado,$header),true);
            }

            if($returnoCertificadoApi['Codigo']!=100){
                $this->setError("Certificado não registrado");
                return false;
            }else{

                $this->setMessage($returnoCertificadoApi["Descricao"]);

                return true;

                /*if($ambiente==1){
                    $returnoLicencaApi=json_decode($this->RequestJSON->request(PROD."companies?type=licenciamento","POST",$licenca,$header),true);
                }else if($ambiente==2){
                    $returnoLicencaApi=json_decode($this->RequestJSON->request(HOMOLOG."companies?type=licenciamento","POST",$licenca,$header),true);
                }

                if($returnoLicencaApi['Codigo']!=100){
                    //$this->setError("Licença não registrada");
                    $this->setError($licenca);
                    return false;
                }else{
                    $this->setMessage("Licenca registrada");
                    return true;
                }*/
            }
        }
    }
    public function validateInsertChavesNotas($dados,$ambiente=1){
        if(count($this->getError())>0){
            $this->setError("Sem dados");
            return false;
        }else{
            if($ambiente==1){

            }else if($ambiente==2){
                $this->AreaNotaConfiguracao->insertChaveNotasHomologacao($dados);
            }  
        }
    }
    public function validateGetChavesNotas($cnpj,$ambiente=1){
        if(count($this->getError())>0){
           $this->setError("Sem dados");
           return false;
        }else{

            if($ambiente==1){
                $return = $this->AreaNotaLancamnetoNFSE->getChavesNotas($cnpj);
            }else if($ambiente==2){
                $return = $this->AreaNotaLancamnetoNFSE->getChavesNotasHomologacao($cnpj);
            }
           
           if($return['linhas']<=0){
               $this->setError("Sem dados");
               return false;
           }else{
               return $return['dados'];
           }
       }
    }
    public function validateCadastroEmpresaMigrate($dados,$ambiente=1){

        $payLoader = array(
            "iat"=>time(),
            "exp"=>time() + 120,
            "sub"=>SUB,
            "partnerKey"=>PATNER_KEY
        );

        if($ambiente==1){
            $token=$this->JWT->jwtEncode($payLoader,KEY_PROD);
            $requestToken=json_decode($this->RequestJSON->request(PROD.CREATE_ACCESS_KEY,"POST",$token),true);
        }else if($ambiente==2){
            $token=$this->JWT->jwtEncode($payLoader,KEY_HOMOLOG);
            $requestToken=json_decode($this->RequestJSON->request(HOMOLOG.CREATE_ACCESS_KEY,"POST",$token),true);
        }
        
        if(!isset($requestToken['accessToken'])){
            $this->setError("Falha no token");
            return false;
        }else{

            $Licenciamento = array(
                array(
                    "Modulo"=> (string)"NFSe",
                    "Modelo"=> (string)1,
                    "Autor"=> (string)$dados["NomeFantazia"]
                )
            );

            $Cadastro = array(
                array(
                    "EmpNomFantasia"=> (string)$dados["NomeFantazia"],
                    "EmpApelido"=> (string)$dados["NomeFantazia"],
                    "EmpRazSocial"=> (string)$dados["RazaoSocial"],
                    "EmpCNPJ"=> (string)$dados["CNPJ"],
                    "EmpCPF"=> (string)"",
                    "EmpIE"=> (string)$dados["InscricaoEstadual"],
                    "EmpTelefone"=> (string)$dados["Telefone"],
                    "EmpEndereco"=> (string)$dados["Logradouro"],
                    "EmpNumero"=> (string) $dados["Numero"],
                    "EmpBairro"=> (string)$dados["Bairro"],
                    "EmpCEP"=> (string)$dados["CEP"],
                    "EmpComplemento"=> (string)$dados["Complemento"],
                    "EmpIM"=> (string)$dados["InscricaoMunicipal"],
                    "MunCodigo"=> (int)$dados["CodigoMunicipal"],
                    "EmpCNAE"=> (string)$dados["CNAE"],
                    "EmpCRT"=> (int)$dados["CodigoCRT"],
                    "EmpEmail"=> (string)$dados["Email"],
                    "EmpTpoEndereco"=> (string)$dados["Endereco"],
                    "Licenciamento"=>$Licenciamento
                )
            );

            $header = array(
                "Authorization:{$requestToken['accessToken']}",
                "Content-Type:application/json"
            );

            $Cadastro=json_encode($Cadastro,JSON_INVALID_UTF8_IGNORE);

            //exit($Cadastro);

            if($ambiente==1){
                $returnoCadastroApi=json_decode($this->RequestJSON->request(PROD."companies","POST",$Cadastro,$header),true);
            }else if($ambiente==2){
                $returnoCadastroApi=json_decode($this->RequestJSON->request(HOMOLOG."companies","POST",$Cadastro,$header),true);
            }
            
            if($returnoCadastroApi[0]['Codigo']!=100){
                $this->setError('Empresa não cadastrarda');
                return false;
            }else{
                
                if($returnoCadastroApi[0]['RetornoCadastro'][0]['Codigo']!=100){
                    $this->setError($returnoCadastroApi[0]['RetornoCadastro'][0]['Descricao']);
                    return false;
                }else{
                    
                    $this->setMessage("Empresa cadastrada");

                    if($ambiente==1){
                        $return = $this->AreaNotaConfiguracao->issetChaveNotas([
                            "cnpj"=>$dados['CNPJ'],
                            "chaveAcesso"=>$returnoCadastroApi[0]['RetornoCadastro'][0]['EmpAK']
                        ]);
                    }else if($ambiente==2){
                        $return = $this->AreaNotaConfiguracao->issetChaveNotasHomologacao([
                            "cnpj"=>$dados['CNPJ'],
                            "chaveAcesso"=>$returnoCadastroApi[0]['RetornoCadastro'][0]['EmpAK']
                        ]);
                    }
                    
                    if($return){
                        if($ambiente==1){
                            $return = $this->AreaNotaConfiguracao->updateChaveNotas([
                                "cnpj"=>$dados['CNPJ'],
                                "chaveAcesso"=>$returnoCadastroApi[0]['RetornoCadastro'][0]['EmpAK']
                            ]);
                        }else if($ambiente==2){
                            $return = $this->AreaNotaConfiguracao->updateChaveNotasHomologacao([
                                "cnpj"=>$dados['CNPJ'],
                                "chaveAcesso"=>$returnoCadastroApi[0]['RetornoCadastro'][0]['EmpAK']
                            ]);
                        }
                        if($return){
                            $this->setMessage("Chave atualizada");
                        }else{
                            $this->setError("Chave não atualizada");
                        }
                    }else{
                        if($ambiente==1){
                            $return = $this->AreaNotaConfiguracao->insertChaveNotas([
                                "cnpj"=>$dados['CNPJ'],
                                "chaveAcesso"=>$returnoCadastroApi[0]['RetornoCadastro'][0]['EmpAK']
                            ]);
                        }else if($ambiente==2){
                            $return = $this->AreaNotaConfiguracao->insertChaveNotasHomologacao([
                                "cnpj"=>$dados['CNPJ'],
                                "chaveAcesso"=>$returnoCadastroApi[0]['RetornoCadastro'][0]['EmpAK']
                            ]);
                        }
                        if($return){
                            $this->setMessage("Chave registrada");
                        }else{
                            $this->setError("Chave não registrada");
                        }
                    }
                    
                    return $returnoCadastroApi[0]['RetornoCadastro'][0]['EmpAK'];
                }
            }
        }
    }
    public function validateEmitirNFSENodeRed($dados,$ambiente=1){
        
        $arrayNFSE = self::validateConfigNotaNFSE($dados,2);
        exit(json_encode($arrayNFSE,JSON_UNESCAPED_UNICODE));
        /*$myfile = fopen(DIRREQ."app/Controller/validate.txt", "w");
        $txt = date("d/m/Y H:i:s")." - ".json_encode(["dados"=>$arrayNFSE],JSON_UNESCAPED_UNICODE)."\n\n";
        fwrite($myfile, $txt);
        fclose($myfile);*/

        
        if($arrayNFSE==false || count($this->getError())>0){
            $this->setError("Parâmetros errôneos");
            return false;
        }else{
            $payLoader = array(
                "iat"=>time(),
                "exp"=>time() + 120,
                "sub"=>$dados['PJ'],
                "partnerKey"=>PATNER_KEY
            );

            if($ambiente==1){
                $chave = self::validateGetChavesNotas($dados['PJ'],1);
            }else if($ambiente==2){
                $chave = self::validateGetChavesNotas($dados['PJ'],2);
            }

            /*$myfile = fopen(DIRREQ."app/Controller/chave.txt", "w");
            $txt = date("d/m/Y H:i:s")." - ".json_encode(["chave"=>$chave],JSON_UNESCAPED_UNICODE)."\n\n";
            fwrite($myfile, $txt);
            fclose($myfile);*/
            
            if($chave == false){
                $this->setError("Sem chave de acesso");
                return false;
            }else{
                $token=$this->JWT->jwtEncode($payLoader,$chave['ChaveAcesso']);
            
                //$token=$this->JWT->jwtEncode($payLoader,KEY_HOMOLOG);

                //$this->setMessage($chave['ChaveAcesso']);

                if($ambiente==1){
                    $requestToken=json_decode($this->RequestJSON->request(PROD.CREATE_ACCESS_KEY,"POST",$token),true);
                }else if($ambiente==2){
                    $requestToken=json_decode($this->RequestJSON->request(HOMOLOG.CREATE_ACCESS_KEY,"POST",$token),true);
                }
                
                
                if(!isset($requestToken['accessToken'])){
                    $this->setError("Erro ao gerar token");
                    return false;
                }else{
                    $header = array(
                        "Authorization:{$requestToken['accessToken']}",
                        "Content-Type:application/json"
                    );
                    
                    //exit(json_encode($arrayNFSE));
                    if($ambiente==1){
                        $requestNFSe=json_decode($this->RequestJSON->request(PROD.DOCNOTAS."nfse?type=Emissao","POST",json_encode($arrayNFSE,JSON_UNESCAPED_UNICODE),$header),true);
                    }else if($ambiente==2){
                        $requestNFSe=json_decode($this->RequestJSON->request(HOMOLOG.DOCNOTAS."nfse?type=Emissao","POST",json_encode($arrayNFSE,JSON_UNESCAPED_UNICODE),$header),true);
                    }
                    
                    if($requestNFSe[0]['Codigo']!=100){
                        $this->setError($requestNFSe[0]['Descricao']);
                        return false;
                    }else{
                        $this->setMessage("Nota emitida");
                        return $requestNFSe;
                    }
                    
                }
            }
        }
       
    }
    private function validateConfigNotaNFSE($dados,$ambiente=1){
       
        $dadosConfigNFSE = self::validateGetConfigEmissaoNFSE($dados['PJ']);
        //exit(json_encode($dadosConfigNFSE,JSON_UNESCAPED_UNICODE));        
        $dadosPJ = self::validateGetPJ($dados['PJ']);
       
        $dadosPJ['CEP'] = preg_replace("/[^0-9]/","",$dadosPJ['CEP']);
        $request=json_decode($this->RequestJSON->request("https://viacep.com.br/ws/{$dadosPJ['CEP']}/json/","GET"),true);
        $CodigoMunicipal = (int)$request['ibge'];
        
        $request=json_decode($this->RequestJSON->request("https://viacep.com.br/ws/{$dadosPJ['CEP']}/json/","GET"),true);
        $CodigoMunicipalDoServico= $request['ibge'];
        
        $requestTomador=json_decode($this->RequestJSON->request("https://viacep.com.br/ws/{$dados['cepTomador']}/json/","GET"),true);
        
        if($dadosConfigNFSE==false || $dadosPJ==false){
            $this->setError("Nota não emitida");
            return false;
        }else{
            
            if((int)$dadosConfigNFSE['CodigoCTR']==3){
                $simplesNacional = 0;
            }else{
                $simplesNacional = 1;
            }
            
            $arrayNFSE = array(
                array(
                    "Documento" => array(
                        "ModeloDocumento" => "NFSE",
                        "Versao" => "1",
                        "RPS" => array(
                            array(
                                "RPSNumero" => (int)$dados['NdoRPS'],
                                "RPSSerie" => (string)$dados['SerieDoRPS'],
                                "RPSTipo" => (int)1,
                                "dEmis" => (string)str_replace(" ","T",date('Y-m-d H:i:s')),
                                "dCompetencia" => (string)$dados['dataCompetencia'],
                                "natOp" => (int)$dados['naturezaOperacao'],
                                "OptSN" => (int)$simplesNacional,
                                "IncCult" => (int)$dados['incentivadorCultural'],
                                "Status" => (int)1,
                                "tpAmb" => (int)$ambiente,
                                
                                "Prestador" => array(
                                    "CNPJ_prest" => (string)$dados['PJ'],
                                    "xNome" => (string)$dadosPJ['RazaoSocial'],
                                    "xFant" => (string)$dadosPJ['NomeFantasia'],
                                    "IM" => (string)$dadosConfigNFSE['InscricaoMunicipal'],
                                    "enderPrest" => array(
                                        "TPEnd" => (string)"",
                                        "xLgr" => (string)$dadosPJ['Endereco'],
                                        "nro" => (string)$dadosPJ['NumeroEndereco'],
                                        "xCpl" => (string)$dadosPJ['Complemento'],
                                        "xBairro" => (string)$dadosPJ['Bairro'],
                                        "cMun" => (int)$CodigoMunicipal,
                                        "UF" => (string)$dadosPJ['UF'],
                                        "CEP" => (string)$dadosPJ['CEP']
                                    )
        
                                ),
                                "Servico" => array(
                                    "Valores" => array(
                                        "ValServicos" => (float)$dados['ValorTotalDosServicos'],
                                        "ValBaseCalculo" =>(float)$dados['ValorTotalDosServicos'],
                                        "ValAliqISS" => (float)$dados['ISSPercentual'],
                                        "ValLiquido" => (float)$dados['ValorTotalDosServicos'],
                                        "ValDescCond"=>(float)0
                                    ),
                                    "IteListServico" => (string)$dados['codServico'],
                                    "Cnae" => (int)$dados['atividade'],
                                    "Discriminacao" => (string)$dados['DescriminacaoDosServicos'],
                                    "cMun" => (int)$CodigoMunicipalDoServico
                                ),
                                "Tomador" => array(
                                    "TomaCNPJ" => (string)$dados['cnpjTomador'],
                                    "TomaCPF" => (string)$dados['cpfTomador'],
                                    "TomaIM"=>(string)"",
                                    "TomaRazaoSocial" => (string)$dados['nomeTomador'],
                                    "TomaEndereco" =>(string)$requestTomador['logradouro'],
                                    "TomaComplemento" => (string)$requestTomador['complemento'], 
                                    "TomaBairro" => (string)$requestTomador['bairro'],
                                    "TomacMun" => (int)$requestTomador['ibge'],
                                    "TomaUF" => (string)$requestTomador['uf'],
                                    "TomaCEP" => (int)$dados['cepTomador']
                                )
                                
                            )
                        )
                    )
                )
            );
            /*,
            */
            $dados+=['CodigoMunicipal'=>$CodigoMunicipal];
            
           $arrayNFSE = self::validatePadraoNFSE($dados, $arrayNFSE);
           
           return $arrayNFSE;
        }
        
    }
    private function validatePadraoNFSE($dados, $arrayNFSE){
        $return = self::validateMunicipio();
        
        if($return['Codigo']!=100){
            $this->setError('Padrão não achado');
            return false;
        }else{
            
            foreach($return['listaMunicipios'] as $key=>$value){
                if($value['codMunicipio']==$dados['CodigoMunicipal']){
                    
                    if(is_int(stripos($value['padNome'],"tinus"))){
                        
                        $arrayNFSE[0]["Documento"]["RPS"][0]["Servico"]+=["TributMunicipio"=>$dados['codServico']];
                        break;
                        
                    }else if(is_int(stripos($value['padNome'],"tiplan"))){
                        
                        $arrayNFSE[0]["Documento"]["RPS"][0]["Servico"]+=["TributMunicipio"=>$dados['atividade']];
                        break;
                    }
                    
                }
            }
            
            return $arrayNFSE;
        }
    }
    private function validateMunicipio(){
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
}