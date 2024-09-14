<?php
namespace App;
use Src\Classes\ClassRoutes;
class Despatch extends ClassRoutes{
    private $Method;
    private $Param=array();
    private $Obj;
    
    protected function getMethod(){return $this->Method;}
    public function setMethod($Method){return $this->Method=$Method;}
    
    protected function getParam(){return $this->Param;}
    public function setParam($Param){return $this->Param=$Param;}
    
    function __construct(){
        self::addController();
    }
    
    private function addController(){
        $RotaControlller=$this->getRota();
        $NameSpace="App\\Controller\\{$RotaControlller}";
        $this->Obj=new $NameSpace;
        if(isset($this->parseUrl()[1])){
            self::addMethod();
        }
        
    }
    
    private function addMethod(){
        if(method_exists($this->Obj,$this->parseUrl()[1])){
            $this->setMethod("{$this->parseUrl()[1]}");
            self::addParam();
            call_user_func_array([$this->Obj,$this->getMethod()],$this->getParam());
        }
    }
    
    private function addParam(){
        $CountArry=count($this->parseUrl());
        if($CountArry > 2){
            foreach($this->parseUrl() as $Key => $Value){
                if($Key > 1){
                    $this->setParam($this->Param += [$Key => $Value]);   
                }
            }
        }
    }
}
?>