<?php 
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassSessions;
use Src\Traits\TraitUrlParser;
use Src\Classes\ClassValidateLojaVirtual;
class ControllerLojaVirtual {
     use TraitUrlParser;
     private $Render;
     private $Session;
     private $ValidateLojaVirtual;
     private $Request;
     function __construct(){
        $this->Request = array();
        $this->Render=new ClassRender;
        $this->ValidateLojaVirtual = new ClassValidateLojaVirtual;
        $this->Session=new ClassSessions;
        $this->Render->setDir("LojaVirtual");
        $this->Render->setTitle("Loja Virtual");
        $this->Render->setDescription("Pagina de Loja Virtual MVC");
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