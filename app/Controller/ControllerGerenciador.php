<?php
namespace App\Controller;
use Src\Traits\TraitUrlParser;
use Src\Classes\ClassRender;
//use Src\Classes\ClassValidate;
use Src\Classes\ClassValidateGerenciador;
use Src\Classes\ClassSessions;
class ControllerGerenciador{
    use TraitUrlParser;
    private $Render;
    private $Validate;
    private $Session;
    private $ValidateGerenciador;
    function __construct(){
        $this->Render = new ClassRender;
        //$this->Validate = new ClassValidate;
        $this->ValidateGerenciador = new ClassValidateGerenciador();
        $this->Session=new ClassSessions;
        $this->Render->setDir("Tabelas/Gerenciador");
        $this->Render->setTitle("Gerenciador");
        $this->Render->setDescription("Pagina área do contador MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout("Home");
        }
    }
    

}
?>