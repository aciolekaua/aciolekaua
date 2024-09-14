<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassValidate;
use Src\Classes\ClassMail;
use Src\Traits\TraitUrlParser;
class ControllerMudaSenha{
    use TraitUrlParser;
    private $Render;
    private $Validate;
    private $Mail;
    function __construct(){
        $this->Render = new ClassRender;
        $this->Validate = new ClassValidate;
        $this->Mail = new ClassMail;
        $this->Render->setDir("MudaSenha");
        $this->Render->setTitle("Mudar Senha");
        $this->Render->setDescription("Pagina de alteração de senha MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            $this->Render->addSession();
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout("Home");
        }
    }
    
    public function mudarSenha(){
       
        $arrayRequired=array();
        if(isset($_POST['confirmarSenha'])){
            $confirmarSenha = filter_input(INPUT_POST, 'confirmarSenha', FILTER_SANITIZE_ADD_SLASHES);
            array_push($arrayRequired,$confirmarSenha); 
        }
        if(isset($_POST['novaSenha'])){
            $novaSenha = filter_input(INPUT_POST, 'novaSenha', FILTER_SANITIZE_ADD_SLASHES);
            array_push($arrayRequired,$novaSenha); 
        }
        if(isset($_POST['senhaAtual'])){
            $senhaAtual = filter_input(INPUT_POST, 'senhaAtual', FILTER_SANITIZE_ADD_SLASHES);
            array_push($arrayRequired,$senhaAtual); 
        }
        
        $this->Validate->validateFilds($arrayRequired);
        
        if($novaSenha!=$confirmarSenha){$this->Validate->setError("Os campos 'Nova Senha' e 'Confirma Nova Senha' estão com valores diferentes");}
        
        $this->Validate->validateSenha($_SESSION['email'],$_SESSION['TipoCliente'],$senhaAtual,'verificar');
        
        $this->Validate->validateMudarSenha([
            "email"=>$_SESSION['email'],
            "novaSenha"=>$novaSenha,
            "TipoCliente"=>$_SESSION['TipoCliente']
        ]);
        
        $json = array(
            'sucessos'=>$this->Validate->getMessage(),
            'erros'=>$this->Validate->getError()
        );
        
        echo(json_encode($json));
    }
}
?>