<?php 
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassSessions;
use Src\Traits\TraitUrlParser;

class ControllerRegistroEmpresa{
    use TraitUrlParser;
    private $Render;
    private $Session;
    
    function __construct(){
        $this->Render=new ClassRender;
        $this->Session=new ClassSessions;
        $this->Render->setDir("RegistroDeEmpresa");
        $this->Render->setTitle("Registro de Empresa");
        $this->Render->setDescription("Pagina de Registro de Empresa MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
            if(isset($url[1])){
                $this->Render->addSession();
                header("Content-Type:application/json");
            }else{
                $this->Render->renderLayout("Home");
            }
        }
}

?>