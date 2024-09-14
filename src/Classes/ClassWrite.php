<?php
namespace Src\Classes;
class ClassWrite{
    private $Indicador="/*ClassWrite*/";
    
    function Erros($Param,$Id,$Class=''){
        if(count($Param)>0){
            
            echo"<script>";
            echo $this->Indicador;
            echo "const {$Id}=document.getElementById('{$Id}');";
            echo "{$Id}.setAttribute('class','{$Class}');";
            echo "{$Id}.innerHTML='';";
            foreach($Param as $Key => $Value){
                echo "{$Id}.innerHTML+='<p>{$Value}</p>';";
            }
            echo"</script>";
            
            return true;
        }else if(count($Param)<=0){return false;}
    }
    
    function Mensage($Param,$Id,$Class=''){
        echo"<script>";
        echo $this->Indicador;
        echo "const {$Id}=document.getElementById('{$Id}');";
        echo "{$Id}.setAttribute('class','{$Class}');";
        echo "{$Id}.innerHTML='';";
        echo "{$Id}.innerHTML='<p>{$Param}</p>';";
        echo"</script>";
    }
    
    function Table($Param,$Id,$Parte,$Link=array()){
        echo"<script>";
        echo $this->Indicador;
        echo "const {$Id}=document.getElementById('{$Id}');";
        $lNum=count($Param);
        if($Parte=="tbory"){
            for($l=0;$l<=$lNum-1;$l++){
                $cNum=count($Param[$l])/2;
                echo"$Id.innerHTML+='<tr id=tr{$l}>';";
                echo "const tr{$l}=document.getElementById('tr{$l}');";
                for($c=1;$c<=$cNum-1;$c++){
                    if(empty($Param[$l][$c])){
                        echo"tr{$l}.innerHTML+='<td>Nenhum</td>';";
                    }else{
                        echo"tr{$l}.innerHTML+='<td>{$Param[$l][$c]}</td>';";
                    }
                    
                }
                echo"$Id.innerHTML+='</tr>';";
            }
        }else if($Parte=="thead"){
            
        }else if($Parte=="tfoot"){
            
        }
        
    
        echo"</script>";
    }
    
    function Alert($Text,$href=null){
        echo"<script>";
        echo $this->Indicador;
        echo "alert('{$Text}');";
        if($href!=null){
            echo"window.location.href='{$href}'";
        }
        echo"</script>";
    }
    public function dSelect(){
        echo"<script>";
        echo"
        const select=document.querySelectorAll('.dselect');
        for(i=0;i<select.length;i++){dselect(select[i],{search:true})};
        ";
        echo"</script>";
    }
    public function SelectOptions($Array,$Id,$Const,$Index=null,$dselct=null){
        echo"<script>";
        echo $this->Indicador;
        echo "const {$Const}=document.querySelector('{$Id}');";
        
        if(is_array($Index)){
            $lNum=count($Array);
           for($l=0;$l<=$lNum-1;$l++){
               echo "{$Const}.innerHTML+='<option value={$Array[$l][$Index['Value']]} >{$Array[$l][$Index['Text']]}</option>';";
           }
        }else if($Index==2){
            foreach($Array as $Key=>$Value){
                echo "{$Const}.innerHTML+='<option value={$Key} >{$Value}</option>';";
            }
        }else{
            foreach($Array as $Key=>$Value){
                echo "{$Const}.innerHTML+='<option value={$Value} >{$Value}</option>';";
            }
        }
        echo"</script>";
    }
}
?>