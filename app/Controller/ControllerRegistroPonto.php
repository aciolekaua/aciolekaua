<?php
namespace App\Controller;

use Src\Classes\ClassRender;
use Src\Classes\ClassValidate;
use Src\Traits\TraitUrlParser;

class ControllerRegistroPonto{
    use TraitUrlParser;
    private $Render;
    private $Validate;
    private $RequestArray = [];
    
    function __construct(){
        $this->Render = new ClassRender;
        $this->Validate = new ClassValidate;
        $this->Render->setDir("RegistroDePonto");
        $this->Render->setTitle("Registro de Ponto");
        $this->Render->setDescription("Pagina de registro de ponto");
        $this->Render->setKeywords("");
        $url=$this->parseUrl();
        if(isset($url[1])){
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout();
        }
    }
    
    function insertRegistroPonto(){
        exit(json_encode("OI"));
    }
    
    function login(){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            
            if(isset($_POST['cpf'])){
                $cpf = preg_replace("/[^0-9]/","",$_POST['cpf']);
                $this->Validate->validateCPF($cpf);
                $this->RequestArray += ['cpf'=>$cpf];
            }
            
            if(isset($_POST['codigo'])){
                $codigo = preg_replace("/[^0-9]/","",$_POST['codigo']);
                $this->RequestArray += ['codigo'=>$codigo];
            }
            
            $this->Validate->validateFilds($this->RequestArray);
            
        }else{
            exit(json_encode("Mande uma requisição POST"));   
        }
    }
}
?>