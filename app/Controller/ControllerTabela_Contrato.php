<?php
namespace App\Controller;
use Src\Classes\ClassValidate;
use Src\Classes\ClassRender;
use Src\Classes\ClassSessions;
use Src\Classes\ClassWrite;
class ControllerTabela_Contrato{
    private $Render;
    private $Session;
    private $Write;
    private $Validate;
    public function __construct(){
        $this->Render=new ClassRender;
        $this->Session=new ClassSessions;
        $this->Write=new ClassWrite;
        $this->Validate=new ClassValidate;
        $this->Render->setDir("Tabelas/Contrato");
        $this->Render->setTitle("Contrato");
        $this->Render->setDescription("Pagina de lançamentos MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $this->Render->renderLayout("Home");
    }
    
    public function executar(){
        
        if(isset($_POST['excluir'])){
            if(isset($_POST['sel'])){
                 $sel=filter_input_array(INPUT_POST,array(
                    'sel'=>array(
                        'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
                        'flags'  => FILTER_REQUIRE_ARRAY
                    )
                ));
            }
            
            $this->Validate->validateFilds(array('sel'=>$sel));
            $resul=$this->Validate->validateDeleteContrato($sel['sel']);
            
            if(count($this->Validate->getError())>0){
                $erro=$this->Validate->getError();
                $this->Write->Erros($erro,'mensage','alert alert-danger');  
            }else{
                if($resul['apagados']>0){
                    $this->Write->Mensage("{$resul['apagados']} linha(s) apagada(s)","mensage","alert alert-success");
                }else if($resul['nApagados']>0){
                    $this->Write->Mensage("{$resul['nApagados']} linha(s) NÃO apagada(s)","mensage","alert alert-danger");
                }else if($resul==false){
                    $this->Write->Mensage(" Nenhum linha apagada","mensage","alert alert-danger");
                }
               
            }
        }
        
         if(isset($_POST['aprovar'])){
            if(isset($_POST['sel'])){
                $sel=filter_input_array(INPUT_POST,array(
                    'sel'=>array(
                        'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
                        'flags'  => FILTER_REQUIRE_ARRAY
                    )
                ));
                
                $this->Validate->validateFilds(array('sel'=>$sel));
                $nAprovado=0;
                $Aprovado=0;
                foreach($sel as $key => $array){
                    
                    foreach($array as $key => $value){
                        $id=md5(uniqid(mt_rand(),true));
                    
                        $result=$this->Validate->validateAprovaConselho([
                            "ID"=>$id,
                            "IdTabela"=>$value,
                            "cnpj"=>"",
                            "cpf"=>$_SESSION["ID"]
                        ],
                        "Contrato");
                        
                        if($result["nAprovado"]>0){
                            $nAprovado+=$result["nAprovado"];
                        }else if($result["Aprovado"]>0){
                            $Aprovado+=$result["Aprovado"];
                        }
                        
                    }
                    
                }
                
                if($nAprovado>0){
                    $this->Validate->setError("{$nAprovado}  não aprovado(s)");
                    $this->Write->Erros($this->Validate->getError(),"mensage","alert alert-danger");
                }else if($Aprovado>0){
                    $this->Validate->setMessage("{$Aprovado} aprovado(s)");
                    $this->Write->Erros($this->Validate->getMessage(),"mensage","alert alert-success");
                }
                
            }
        }
    }
}
?>