<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Interfaces\InterfaceView;
use Src\Classes\ClassValidate;
//use Src\Classes\ClassWrite;
use Src\Traits\TraitUrlParser;
class ControllerLogin{
    use TraitUrlParser;
    private $Render;
    private $Email;
    private $Senha;
    private $TipoCliente;
    private $Validate;
    private $Write;
    private $Erros=[];
    function __construct(){
        $this->Validate=new ClassValidate;
        //$this->Write=new ClassWrite;
        $this->Render=new ClassRender;
        $this->Render->setDir("Login");
        $this->Render->setTitle("Login");
        $this->Render->setDescription("Pagina de login MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout();
        }
    }

    
    

    
 
    public function logar(){
        //exit(json_encode($_POST));
        if($_SERVER['REQUEST_METHOD']=="POST"){
            
            if(isset($_POST['email'])){
                $this->Email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
            }
            
            if(isset($_POST['senha'])){
                $this->Senha=filter_input(INPUT_POST,'senha',FILTER_SANITIZE_ADD_SLASHES);
            }

            if(isset($_POST['tipoCliente'])){
                $this->TipoCliente=filter_input(INPUT_POST,'tipoCliente',FILTER_SANITIZE_ADD_SLASHES);
            }
            
            $this->Validate->validateEmail($this->Email);
            $this->Validate->validateIssetEmail($this->Email,$this->TipoCliente,'login');
            //exit(json_encode($_POST));
            $this->Validate->validateSenha($this->Email,$this->TipoCliente,$this->Senha);
            $this->Validate->validateTempoDeTentativa();
            $this->Validate->validateConutTentativas();
            $this->Validate->validateContaAtiva($this->Email,$this->TipoCliente);
            if($this->Validate->validateTentativasFinal($this->Email,$this->TipoCliente,"home")){
                $json = array(
                    'login'=>true,
                    'erros'=>$this->Validate->getError()
                );
            }else{
                $json = array(
                    'login'=>false,
                    'erros'=>$this->Validate->getError()
                );
            }
            
            exit(json_encode($json));
        }else{
            exit(json_encode('Mende uma requisição POST'));
        }
        

        /*$this->Erros=$this->Validate->getError();
        for($i=0;$i < count($this->Erros);$i++){
            if($this->Erros[$i]=="Email não cadastrado"){unset($this->Erros[$i]);}
        }
        $this->Write->Erros($this->Erros,'divMensage','alert alert-danger');*/
        
    }
}
?>