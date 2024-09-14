<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassValidate;
use Src\Classes\ClassMail;
use Src\Traits\TraitUrlParser;
class ControllerConfirmaCadastro{
    use TraitUrlParser;
    private $Validate;
    private $Render;
    private $Mail;
    function __construct(){
        $this->Validate=new ClassValidate;
        $this->Render=new ClassRender;
        $this->Mail = new ClassMail;
        $this->Render->setTitle("ComfirmaCadastro");
        $this->Render->setDescription("Pagina de confirmar cadastro MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        /*$this->Render->setDir("ComfirmaCadastro/NaoAtivado");
        $this->Render->renderLayout();*/
    }
    
    function confirmarCadastro($token,$email){
        
        $dados = $this->Validate->validateIssetTokenCadastro($token);
        
        //echo(json_encode($dados));
        
        if(!$dados){
            $this->Render->setDir("ComfirmaCadastro/NaoAtivado");
            $this->Render->renderLayout();
        }else{
            $var = $this->Validate->validateAtivarContaCad([
                "TipoCliente"=>$dados['TipoCleinte'],
                "Token"=>$dados['Token'],
                "Email"=>$dados['Email']
            ]);
            
            if($var){
                $this->Render->setDir("ComfirmaCadastro/Ativado");
                $this->Render->renderLayout();
            }else{
                $this->Render->setDir("ComfirmaCadastro/NaoAtivado");
                $this->Render->renderLayout();
            }
        }
    }
}
?>