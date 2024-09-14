<?php
namespace App\Controller;
use Src\Classes\ClassRender;
class Controller404{
    private $Render;
    function __construct(){
        $this->Render=new ClassRender;
        $this->Render->setDir("404");
        $this->Render->setTitle("404");
        $this->Render->setDescription("Pagina inesistente");
        $this->Render->setKeywords("");
        $this->Render->renderLayout();
    }
}
?>