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

class ClassValidateAreaNotaLancamnetoNFSE extends ClassValidate{
    
    private $AreaNotaLancamnetoNFSE;
    private $JWT;
    private $RequestJSON;
    private $Validate;
    
    public function __construct(){
        parent::__construct();
        $this->AreaNotaLancamnetoNFSE = new ClassAreaNotaLancamnetoNFSE;
        $this->JWT = new ClassJWT();
        $this->RequestJSON = new ClassRequestJSON();
        $this->Validate = new ClassValidate;
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

    public function validateGetNaturezaOperacao(array $dados, int $ambiente=1){
        if(count($this->getError())>0){
            $this->setError("Verifique os dados enviados");
            return false;
        }

        $configuracoes_nota = self::validateGetConfigEmissaoNFSE($dados['pj']);
        if($configuracoes_nota==false){
            $this->setError("Sem configurações de nota");
            return false;
        }

        $chaves = self::validateGetChavesNotas($dados['pj'], $ambiente);
      
        if($chaves==false){
            $this->setError("Sem chave de acesso");
            return false;
        }

        $requestToken = self::validateGerarTokenMigrate([
            'pj'=>$dados['pj'],
            'chaveAcesso'=>$chaves['ChaveAcesso']
        ],$ambiente);

        if($requestToken==false){
            $this->setError("Falha na criação do token");
            return false;
        }

        //exit(json_encode($configuracoes_nota));

        $url="senddocuments/nfse?type=naturezaoperacao&Versao=1.00&tpAmb={$ambiente}&CNPJEmissor={$dados['pj']}&IMEmissor={$configuracoes_nota['InscricaoMunicipal']}";

        $header = array(
            "Authorization:{$requestToken['accessToken']}",
            "Content-Type:application/json"
        );

        if($ambiente==1){
            $requestNP=json_decode($this->RequestJSON->request(PROD.$url,"GET",null,$header),true);
        }else if($ambiente==2){
            $requestNP=json_decode($this->RequestJSON->request(HOMOLOG.$url,"GET",null,$header),true);
        }else{
            $this->setError("Ambiente não relatado");
            return false;
        }

        return $requestNP;
        
    }
    
    public function validateGetUltimoRPS(array $dados, int $ambiente=1){
        if(count($this->getError())>0){
            $this->setError("Verifique os dados enviados");
            return false;
        }

        $url="{$dados['tipoModulo']}";
        $url.="?type=Consulta";
        $url.="&Versao=1.00";
        $url.="&tpAmb={$ambiente}";
        $url.="&ParmXMLLink=N";
        $url.="&ParmXMLCompleto=N";
        $url.="&ParmPDFLink=N";
        $url.='&ParmPDFBase64=N';
        $url.="&CnpjEmissor={$dados['PJ']}";

        $date = date_create();
        $ano = date_format($date,'Y');

        $url.="&DataEmissaoInicial={$ano}-01-01T00:00:00";
        $url.="&DataEmissaoFinal={$ano}-12-31T23:59:59";

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
        
        $header = array(
            "Authorization:{$requestToken['accessToken']}",
            "Content-Type:application/json"
        );

        if($ambiente==1){
            $requestNFSe = json_decode($this->RequestJSON->request(PROD.DOCNOTAS.$url,"GET",null,$header),true);
        }else if($ambiente==2){
            $requestNFSe = json_decode($this->RequestJSON->request(HOMOLOG.DOCNOTAS.$url,"GET",null,$header),true);
        }else{
            $this->setError("Ambiente não relatado");
            return false;
        }
        
        //exit(json_encode($requestNFSe));
        if($requestNFSe[0]['Codigo'] != 100){
            $erro = filter_var($requestNFSe[0]['Descricao'],FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
            $this->setError($erro);
            return false;
        }else{
            return $requestNFSe[0]['Documentos'][0];
        }
        
    }

    public function validateGetAssociadosAPI($cpf){
        if($this->Validate->validateCPF($Param)){
            if($this->Validate->validateIssetCPF($Param,"verificar")){
                
                /*if(!$var=$this->Lancamento->getAssociacao($Param)){
                    $this->setError("Informação não contrada");
                    return array();
                }else{return $var;}*/
                
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function validateGetConfigEmissaoNFSE($cnpj){
        
        if(count($this->getError())>0){
            $this->setError("Sem dados");
            return false;
        }else{
            $return = $this->AreaNotaLancamnetoNFSE->getConfigEmissaoNFSE($cnpj);
        
            if($return['linhas']<=0){
                $this->setError("Sem dados");
                return false;
            }else{
                return $return['dados'];
            }
        }
        
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

    public function validateGetPJ($cnpj){
        
        $return = $this->AreaNotaLancamnetoNFSE->getPJ($cnpj);
        if($return['linhas']<=0){
            $this->setError("PJ não encontrado");
            return false;
        }else{
            return $return['dados'];
        }
    }

    public function validateIssetClonaNFSE($dados){
        return $this->AreaNotaLancamnetoNFSE->issetClonaNFSE($dados);
    }

    public function validateInsertClonaNFSE($dados){
        //exit(json_encode($dados));
        if(count($this->getError())>0){
            $this->setError('Nota não clonada (Verifique os dados)');
            return false;
        }else{
            
            if(self::validateIssetClonaNFSE($dados)){
                $this->setError("Nota clonada já existente");
                return false;
            }else{
                $return = $this->AreaNotaLancamnetoNFSE->insertClonaNFSE($dados);
    
                if(!$return){
                    $this->setError('Nota não clonada');
                    return false;
                }else{
                    $this->setMessage('Nota clonada');
                    return true;
                } 
            }
            
        }
        
    }

    public function validateGetClonaNFSE($dados){
        if(count($this->getError())>0){
            $this->setError('Sem notas clonadas (Verifique os dados)');
            return false;
        }else{
            //exit(json_encode($dados));
            $return = $this->AreaNotaLancamnetoNFSE->getClonaNFSE($dados);
            if($return['linhas']<=0){
                $this->setError('Sem notas clonadas');
                return false; 
            }else{
                return $return['dados'];
            }   
        }
    }

    public function validateGetDadosNotaClonata($dados){
        $return = $this->AreaNotaLancamnetoNFSE->getDadosNotaClonata($dados);
        if($return['linhas']<=0){
            $this->setError('Sem dados da nota');
            return false;
        }else{
            return $return['dados'];
        }
    }

    public function validateEmitirNFSE(array $dados, int $ambiente=1){
        
        if(count($this->getError())>0){
            $this->setError("Verifique o formulário");
            return false;
        }

        $arrayNFSE = self::validateConfigNotaNFSE($dados, $ambiente);

        if($arrayNFSE==false){
            $this->setError("Erro na configuração da nota");
            return false;
        }

        //exit(json_encode($arrayNFSE));

        $chaves = self::validateGetChavesNotas($dados['PJ'], $ambiente);
        
        if($chaves == false){
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

        //exit(json_encode($ambiente));

        $header = array(
            "Authorization:{$requestToken['accessToken']}",
            "Content-Type:application/json"
        );

        if($ambiente==1){
            $requestNFSe=json_decode($this->RequestJSON->request(PROD.DOCNOTAS."nfse?type=Emissao","POST",json_encode($arrayNFSE,JSON_UNESCAPED_UNICODE),$header),true);
        }else if($ambiente==2){
            $requestNFSe=json_decode($this->RequestJSON->request(HOMOLOG.DOCNOTAS."nfse?type=Emissao","POST",json_encode($arrayNFSE,JSON_UNESCAPED_UNICODE),$header),true);
        }else{
            $this->setError("Ambiente não relatado");
            return false;
        }
        
        if($requestNFSe[0]['Codigo']!=100){
            $this->setError($requestNFSe[0]['Descricao']);
            return false;
        }else{
            $this->setMessage("Nota emitida");
            return $requestNFSe;
        }
            
        
        
    }

    public function validateEmitirNFSENodeRed($dados,$ambiente=2){
        
        $arrayNFSE = self::validateConfigNotaNFSE($dados,$ambiente);

        //exit(json_encode($arrayNFSE,JSON_UNESCAPED_UNICODE));
        /*$myfile = fopen(DIRREQ."app/Controller/validate.txt", "w");
        $txt = date("d/m/Y H:i:s")." - ".json_encode(["dados"=>$arrayNFSE],JSON_UNESCAPED_UNICODE)."\n\n";
        fwrite($myfile, $txt);
        fclose($myfile);*/
        
        if($arrayNFSE==false || count($this->getError())>0){
            $this->setError("Parâmetros errônios");
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

            //$chave = self::validateGetChavesNotas($dados['PJ']);

            if($chave == false){
                $this->setError("Sem chave de acesso");
                return false;
            }else{

                $token=$this->JWT->jwtEncode($payLoader,$chave['ChaveAcesso']);

                //$token=$this->JWT->jwtEncode($payLoader,KEY_HOMOLOG);

                //$this->setError($chave['ChaveAcesso']);
               
                //$requestToken=json_decode($this->RequestJSON->request($ambiente.CREATE_ACCESS_KEY,"POST",$token),true);

                if($ambiente==1){
                    $requestToken=json_decode($this->RequestJSON->request(PROD.CREATE_ACCESS_KEY,"POST",$token),true);
                }else if($ambiente==2){
                    $requestToken=json_decode($this->RequestJSON->request(HOMOLOG.CREATE_ACCESS_KEY,"POST",$token),true);
                }

                //exit(json_encode($requestToken));
                
                if(!isset($requestToken['accessToken'])){
                    $this->setError("Erro ao gerar token");
                    return false;
                }else{
                    $header = array(
                        "Authorization:{$requestToken['accessToken']}",
                        "Content-Type:application/json"
                    );
                    
                    //exit(json_encode($arrayNFSE));
                   
                    /*$requestNFSe=json_decode($this->RequestJSON->request($ambiente.DOCNOTAS."nfse?type=Emissao","POST",json_encode($arrayNFSE,JSON_UNESCAPED_UNICODE),$header),true);*/

                    if($ambiente==1){
                        $requestNFSe=json_decode($this->RequestJSON->request(PROD.DOCNOTAS."nfse?type=Emissao","POST",json_encode($arrayNFSE,JSON_UNESCAPED_UNICODE),$header),true);
                    }else if($ambiente==2){
                        $requestNFSe=json_decode($this->RequestJSON->request(HOMOLOG.DOCNOTAS."nfse?type=Emissao","POST",json_encode($arrayNFSE,JSON_UNESCAPED_UNICODE),$header),true);
                    }

                    //exit(json_encode($requestNFSe));
                    
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
                                "LocalPrestServ"=>(int)$dados['localServico'],
                                "tpAmb" => (int)$ambiente,
                                
                                "Prestador" => array(
                                    "CNPJ_prest" => (string)$dados['PJ'],
                                    "xNome" => (string)$dadosPJ['RazaoSocial'],
                                    "xFant" => (string)$dadosPJ['NomeFantasia'],
                                    "IM" => (string)$dadosConfigNFSE['InscricaoMunicipal'],
                                    "enderPrest" => array(
                                        "TPEnd" => (string)$TPEndereco[0],
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

    public function validateUltimaSerie($cnpj){
        $payLoader = array(
            "iat"=>time(),
            "exp"=>time() + 120,
            "sub"=>$cnpj,
            "partnerKey"=>PATNER_KEY
        );
        $chave = self::validateGetChavesNotas($cnpj);
        if($chave == false){
            $this->setError("Sem chave de acesso");
            return false;
        }else{
            $token=$this->JWT->jwtEncode($payLoader,$chave['ChaveAcesso']);
           
            $requestToken=json_decode($this->RequestJSON->request(PROD.CREATE_ACCESS_KEY,"POST",$token),true);
            
            if(!isset($requestToken['accessToken'])){
                return false;
            }else{
                $header = array(
                    "Authorization:{$requestToken['accessToken']}",
                    "Content-Type:application/json"
                );
                    
                $url = "companies/series?CNPJEmissor={$cnpj}&ModeloDocumento=nfse";

                //exit(json_encode(PROD.$url));
                
                $requestSerie=json_decode($this->RequestJSON->request(PROD.$url,"GET",null,$header),true);

                return $requestSerie;
                /*if($requestSerie[0]['Codigo']!=100){
                    $this->setError($requestSerie[0]['Descricao']);
                    return false;
                }else{
                    //$this->setMessage("Nota emitida");
                    return $requestSerie;
                }*/
            }
        }
    }
    
}
