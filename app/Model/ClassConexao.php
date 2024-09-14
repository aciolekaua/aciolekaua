<?php
namespace App\Model;
abstract class ClassConexao{
    public function conexaoDB(){
        try{
            $Con= new \PDO("mysql:host=".HOST.";dbname=".DB, USER, PASS);
            return $Con;
        }catch(\PDOExeption $Erro){
            return $Erro->getMessage();
        }
    }
}
?>