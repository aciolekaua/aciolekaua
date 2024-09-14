<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Traits\TraitUrlParser;
use Src\Classes\ClassRequestJSON;

class ControllerTestes2{
    use TraitUrlParser;
    private $Render;
    private $RequestJSON;

    public function __construct() {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
        $this->Render = new ClassRender;
        //$this->RequestJSON = new ClassRequestJSON;
        $this->Render->setDir("Testes2");
        $this->Render->setTitle("Pagina testes2");
        $this->Render->setDescription("Pagina testes MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();

        if(isset($url[1])){
            //$this->Render->addSession();
            //$var='Access-Control-Allow-Origin:'.DOMAIN;
            header("Content-Type:application/json");
            header('Access-Control-Allow-Origin:*');
        }else{
            $this->Render->renderLayout();
        }
    }

    function oi(){
       exit(json_encode('OI')); 
    }
}
?>