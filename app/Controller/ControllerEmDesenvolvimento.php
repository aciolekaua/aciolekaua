<?php 
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassSessions;
use Src\Traits\TraitUrlParser;
use Src\Classes\ClassValidateEmDesenvolvimento;
class ControllerEmDesenvolvimento {
     use TraitUrlParser;
     private $Render;
     private $Session;
     private $ValidateEmDesenvolvimento;
     private $Request;
     function __construct(){
        $this->Request = array();
        $this->Render=new ClassRender;
        $this->ValidateEmDesenvolvimento = new ClassValidateEmDesenvolvimento;
        $this->Session=new ClassSessions;
        $this->Render->setDir("emDesenvolvimento");
        $this->Render->setTitle("Em Desenvolvimento");
        $this->Render->setDescription("Pagina Em Desenvolvimento MVC");
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