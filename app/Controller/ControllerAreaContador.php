<?php
namespace App\Controller;
use Src\Traits\TraitUrlParser;
use Src\Classes\ClassRender;
//use Src\Classes\ClassValidate;
use Src\Classes\ClassValidateAreaContador;
use Src\Classes\ClassSessions;
class ControllerAreaContador{
    use TraitUrlParser;
    private $Render;
    private $Validate;
    private $Session;
    private $ValidateAreaContador;
    function __construct(){
        $this->Render = new ClassRender;
        //$this->Validate = new ClassValidate;
        $this->ValidateAreaContador = new ClassValidateAreaContador();
        $this->Session=new ClassSessions;
        $this->Render->setDir("AreaContador");
        $this->Render->setTitle("Área do Contador");
        $this->Render->setDescription("Pagina área do contador MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout("Home");
        }
    }
    
    public function getHistoricos(){
        $json=[
            'erros'=>[],
            'dados'=>[
                'historicos'=>[],
                'codigos'=>[]
            ]
        ];
        
        if(isset($_POST['TipoHistorico'])){
            $TipoHistorico = filter_input(INPUT_POST,'TipoHistorico',FILTER_SANITIZE_NUMBER_INT);
        }
        if(isset($_POST['PJ'])){
            $PJ=filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_SPECIAL_CHARS,FILTER_FLAG_STRIP_LOW);
            $PJ=preg_replace("/[^0-9]/","",$PJ);
        }

        if(empty($TipoHistorico)!=true && empty($PJ)!=true){
            
            $r = $this->ValidateAreaContador->validateGetCodigoHistoricoContador(['cnpj'=>$PJ,"TipoHistorico"=>$TipoHistorico]);
            $retorno = $this->ValidateAreaContador->validateGetHistoricos(["TipoHistorico"=>$TipoHistorico]);  
            
            if($r['linhas']<=0){
                array_push($json['erros'],"Não há códigos");
            }else{
                $json['dados']['codigos']+=$r['dados'];
            }
            
        }else if(empty($TipoHistorico)!=true){
            $retorno = $this->ValidateAreaContador->validateGetHistoricos(["TipoHistorico"=>$TipoHistorico]);   
        }
        
        
        if($retorno['linhas']<=0){
            array_push($json['erros'],"Não há históricos");
        }else{
            $json['dados']['historicos']+=$retorno['dados'];
        }

        echo(json_encode($json));
    }
    
    public function inserirCodigoHistoricoContador(){
        $retorno = $this->ValidateAreaContador->validateGetHistoricos();
        if($retorno['linhas']<=0){
            echo(json_encode(["erros"=>['Sem históricos']]));
            exit();
        }else{
            $array=[];
            if(isset($_POST['PJ'])){
                $PJ=filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_SPECIAL_CHARS);
                $PJ=preg_replace("/[^0-9]/","",$PJ);
            }
            $inseridas=0;
            $atualizadas=0;
            $NaoInseridas=0;
            $NaoAtualizadas=0;
            for($i=0; $i<=($retorno['linhas']-1);$i++){
                
                $id=(string)$retorno['dados'][$i]['ID'];
                
                if(isset($_POST[$id.'_pagar']) && isset($_POST[$id.'_pagara'])){
                    if(empty($_POST[$id.'_pagar'])==false && empty($_POST[$id.'_pagara'])==false && empty($PJ)==false){
                        $return = $this->ValidateAreaContador->validateIssetCodigoHistoricoContador([
                            "IdHistorico"=>(int)$id,
                            "CHP"=>(int)$_POST[$id.'_pagara'],
                            "CP"=>(int)$_POST[$id.'_pagar'],
                            "cnpj"=>(string)$PJ
                        ]);
                        if($return){
                            $updateRetrun = $this->ValidateAreaContador->validateUpdateCodigoHistoricoContador([
                                "IdHistorico"=>(int)$id,
                                "CHP"=>(int)$_POST[$id.'_pagara'],
                                "CP"=>(int)$_POST[$id.'_pagar'],
                                "cnpj"=>(string)$PJ
                            ]);
                            
                            if($updateRetrun){
                                $atualizadas++;
                            }else{
                                $NaoAtualizadas++;
                            }
                            //$atualizadas=$updateRetrun;
                        }else{
                            $insertRetrun = $this->ValidateAreaContador->validateInsertCodigoHistoricoContador([
                                "ID"=>(string)uniqid(mt_rand(000,999),true),
                                "IdHistorico"=>(int)$id,
                                "CHP"=>(int)$_POST[$id.'_pagara'],
                                "CP"=>(int)$_POST[$id.'_pagar'],
                                "cnpj"=>(string)$PJ
                            ]);
                            
                            if($insertRetrun){
                                $inseridas++;
                            }else{
                                $NaoInseridas++;
                            }
                            
                        }
                    }
                }
                
            }
            
            echo(json_encode([
                "erros"=>[],
                "retorno"=>[
                    "atualizadas"=>$atualizadas,
                    "inseridas"=>$inseridas,
                    "NaoInseridas"=>$NaoInseridas,
                    "NaoAtualizadas"=>$NaoAtualizadas
                ]
            ]));
            
        }
    }

}
?>