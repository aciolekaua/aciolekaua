<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassValidate;
use Src\Classes\ClassMail;
use Src\Classes\ClassWrite;
use Src\Traits\TraitUrlParser;
class ControllerRecuperarSenha{
    use TraitUrlParser;
    private $Render;
    private $Validate;
    private $Mail;
    private $Write;
    private $Body;
    private $Token;
    private $Alfabeto;
    
    private $b;
    
    function __construct(){
        $this->Render = new ClassRender;
        $this->Validate = new ClassValidate;
        $this->Mail = new ClassMail;
        $this->Write = new ClassWrite;
        
        $this->Render->setDir("RecuperarSenha");
        $this->Render->setTitle("Recuperação de Senha");
        $this->Render->setDescription("Pagina de recuperação de senha");
        $this->Render->setKeywords("");
        $url=$this->parseUrl();
        if(isset($url[1])){
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout();
        }
        
        $this->Alfabeto = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
        
        $this->Token = strtoupper(str_shuffle($this->Alfabeto[round(rand(0,25))].$this->Alfabeto[round(rand(0,25))].$this->Alfabeto[round(rand(0,25))].$this->Alfabeto[round(rand(0,25))].mt_rand(1000,9999)));
        
        $this->Body = "<h1>{$this->Token}</h1>";

    }
    
    function enviarEmail(){
        
        if(isset($_POST['email'])){$email=(string)filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);}
        
        if(isset($_POST['PFPJ'])){$TipoCliente=(string)filter_input(INPUT_POST,'PFPJ',FILTER_SANITIZE_ADD_SLASHES);}
        
        if($this->Validate->validateEmail($email) && $this->Validate->validateIssetEmail($email,$TipoCliente,"existencia")){
            $emailValidate=false;
            $tokenValidate = false;
            if($this->Mail->sendMail($email,"Suporte Elai",null,"Recuperação de Senha",$this->Body)){
                $emailValidate=true;
                if($this->Validate->validateInsertToken($email,$this->Token)){
                    $this->Validate->setMessage("Email enviado");
                    $tokenValidate = true;
                }else{
                    $this->Validate->setError("Email não enviado");
                }
            }else{
                $this->Validate->setError("Email não enviado");
            }
            
        }
        $json = array(
            'sucessos'=>$this->Validate->getMessage(),
            'erros'=>$this->Validate->getError(),
            'email'=>$emailValidate,
            'token'=>$tokenValidate
        );
        echo(json_encode($json));
        
    }
    
    function mudarSenha(){
        
        if(isset($_POST['PFPJTemp'])){
            $PfPj = (string)filter_input(INPUT_POST,'PFPJTemp',FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if(isset($_POST['codigo'])){
            $codigo = (string)filter_input(INPUT_POST,'codigo',FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if(isset($_POST['senha'])){
            $senha = (string)filter_input(INPUT_POST,'senha',FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if(isset($_POST['cSenha'])){
            $cSenha = (string)filter_input(INPUT_POST,'cSenha',FILTER_SANITIZE_SPECIAL_CHARS);
        }
        
        if(empty($codigo) || empty($senha) || empty($cSenha) || empty($PfPj)){
            $this->Validate->setError("Preecha os campos");
        }else{
            
            if($senha!=$cSenha){
                $this->Validate->setError("Senhas diferentes");
            }else{
                if($this->Validate->validateIssetToken("",$codigo)){
                    $email=$this->Validate->validateGetEmail_Token($codigo)['Email'];
                    if($email!=false){
                        $this->Validate->validateUpdateSenha($email,$senha,$PfPj);
                    }
                }  
            }
        }
        $json = array(
            'sucessos'=>$this->Validate->getMessage(),
            'erros'=>$this->Validate->getError()
        );
        echo(json_encode($json));
    }
    
}
?>