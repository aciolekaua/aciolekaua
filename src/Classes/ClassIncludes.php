<?php
namespace Src\Classes;
class ClassIncludes{
  public function includes($Param=array()){ 
    $contador=count($Param);
    $erro=array();
    if($contador > 0){
        for($i=1; $i <= $contador; $i++){
            if(file_exists($Param[$i-1])){include_once($Param[$i-1]);}
            else{array_push($erro,"Arquivos inexistente");}
        }
    }
  }
}
?>