<?php
namespace Src\Classes;
use Src\Traits\TraitUrlParser;
class ClassBreadCrumbs{
    use TraitUrlParser;
    private $url;
    public function breadCrums($param=null){
        /*
        $url=$this->parseUrl();
        
        if(!$param){
            echo('<h1>Dashboard</h1>
            <div aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="'.DIRPAGE.'home">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Library</li>
              </ol>
            </div>');
        }else{
            return $url;  
        }*/
    }
}
?>