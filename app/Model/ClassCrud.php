<?php
namespace App\Model;
use App\Model\ClassConexao;
class ClassCrud extends ClassConexao{
    
    private $Crud;
    
    private function prepareExecute($Prep,$Exec){
        try{
            $this->Crud = $this->conexaoDB()->prepare($Prep);
            $this->Crud->execute($Exec);
        }catch(\PDOException $e){
            die(json_encode($e));
        }
        
    }
    
    public function selectDB($Filtros, $Tabela, $Where, $Exec){
        $this->prepareExecute("SELECT {$Filtros} FROM {$Tabela} {$Where}",$Exec);
        return $this->Crud;
    }
    
    public function insertDB($Tabela, $Valores, $Exec){
        $this->prepareExecute("INSERT INTO {$Tabela} VALUES ({$Valores})",$Exec);
        return $this->Crud;
    }
    
    public function deleteDB($Tabela, $Where, $Exec){
        $this->prepareExecute("DELETE FROM {$Tabela} WHERE {$Where}",$Exec);
        return $this->Crud;
    }
    
    public function updateDB($Tabela, $Valores, $Where, $Exec){
        $this->prepareExecute("UPDATE {$Tabela} SET {$Valores} WHERE {$Where}",$Exec);
        return $this->Crud;
    }

    public function callProcedureDB(string $nome, array $dados, array $exec){
        $dados_temp = "";
        
        foreach($dados as $key => $value){
            if(array_key_first($dados) == $key){
                $dados_temp .="{$value}";
            }else{
                $dados_temp .=",{$value}"; 
            } 
        }   
            
        $this->prepareExecute("CALL {$nome}({$dados_temp})", $exec);
        return $this->Crud;
    }
}
?>