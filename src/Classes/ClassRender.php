<?php
namespace Src\Classes;
class ClassRender{
    
    private $Dir;
    private $Title;
    private $Description;
    private $Keywords;
  
    public function setDir($Dir){return $this->Dir=$Dir;}
    public function getDir(){return $this->Dir;}
    
    public function setTitle($Title){return $this->Title=$Title;}
    public function getTitle(){return $this->Title;}
    
    public function setDescription($Description){return $this->Description=$Description;}
    public function getDescription(){return $this->Description;}
    
    public function setKeywords($Keywords){return $this->Keywords=$Keywords;}
    public function getKeywords(){return $this->Keywords;}
    
    public function renderLayout($param=false){
        if($param==="Home"){
            require_once(DIRREQ."app/View/LayoutHome.php");
        }else if(!$param){
            require_once(DIRREQ."app/View/Layout.php");
        }
    }
    
    public function addSession(){
        if(file_exists(DIRREQ."app/View/{$this->getDir()}/Session.php")){
            include(DIRREQ."app/View/{$this->getDir()}/Session.php");
        }else{
            return DIRREQ."app/View/{$this->getDir()}/Session.php";
        }
    }
    
    public function addHead(){
        if(file_exists(DIRREQ."app/View/{$this->getDir()}/Head.php")){
            include(DIRREQ."app/View/{$this->getDir()}/Head.php");
        }else{
            return DIRREQ."app/View/{$this->getDir()}/Head.php";
        }
    }
    
    public function addHeader(){
        if(file_exists(DIRREQ."app/View/{$this->getDir()}/Header.php")){
            include(DIRREQ."app/View/{$this->getDir()}/Header.php");
        }
    }
    
    public function addMain(){
        if(file_exists(DIRREQ."app/View/{$this->getDir()}/Main.php")){
            include(DIRREQ."app/View/{$this->getDir()}/Main.php");
        }
    }
    
    public function addFooter(){
        if(file_exists(DIRREQ."app/View/{$this->getDir()}/Footer.php")){
            include(DIRREQ."app/View/{$this->getDir()}/Footer.php");
        }
    }
   
}
?>