<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassValidate;
use Src\Classes\ClassJWT;
use Src\Classes\ClassRequestJSON;
//use Src\Classes\ClassWrite;
use Src\Traits\TraitUrlParser;
use Src\Classes\ClassValidateAreaNotaLancamnetoNFSE;
class ControllerNodeRed{
    use TraitUrlParser;

    private $Render;
    private $JWT;
    private $RequestJSON;
    private $Validate;
    private $ValidateAreaNotaLancamnetoNFSE;
    private $arrayNota = array();
    function __construct(){
        $this->Validate=new ClassValidate;
        $this->Render=new ClassRender;
        $this->JWT = new ClassJWT;
        $this->RequestJSON = new ClassRequestJSON;
        $this->ValidateAreaNotaLancamnetoNFSE = new ClassValidateAreaNotaLancamnetoNFSE;
        $url=$this->parseUrl();
        if(isset($url[1])){
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout();
        }
    }

}
?>