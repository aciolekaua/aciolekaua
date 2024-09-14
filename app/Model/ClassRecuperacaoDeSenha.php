<?php
namespace App\Model;
use App\Model\ClassCrud;
class ClassRecuperacaoDeSenha extends ClassCrud{
    
    function updateSenha($email,$senha,$tabela){
        //var_dump($email,$senha,$tabela);
        if($tabela=="PF"){
            $valores="str_senha_PF = ?";
            $where1="str_email_PF = ?";
            $where2="WHERE str_email_PF = ? AND str_senha_PF = ?";
        }else if($tabela=="PJ"){
            $valores="str_senha_PJ = ?";
            $where1="str_email_PJ = ?";
            $where2="WHERE str_email_PJ = ? AND str_senha_PJ = ?";
        }
        $this->updateDB(
            "{$tabela}",
            "{$valores}",
            "{$where1}",
            [$senha,$email]
        );
        $select = $this->selectDB(
            "*",
            "{$tabela}",
            "{$where2}",
            [$email,$senha]
        );
        return $select->rowCount()>0;
    }
    
    function getEmail($token){
        $select = $this->selectDB(
            "str_email_RecuperacaoDeSenha as Email",
            "RecuperacaoDeSenha",
            "WHERE str_token_RecuperacaoDeSenha = ?",
            [$token]
        );
        
        return[
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetch(\PDO::FETCH_ASSOC)
        ];
    }
    
    function insertToken($email,$token){
        $this->insertDB(
            "RecuperacaoDeSenha",
            "LOCALTIMESTAMP(),?,?",
            [
                $email,
                $token
            ]
        );
        
        $select = $this->selectDB(
            "*",
            "RecuperacaoDeSenha",
            "WHERE str_email_RecuperacaoDeSenha = ? AND str_token_RecuperacaoDeSenha = ?",
            [
                $email,
                $token
            ]
        );
        
        return ($select->rowCount()>0);
    }
    
    function issetToken($email,$token=null){
        if($token!=null){
            $select = $this->selectDB(
                "*",
                "RecuperacaoDeSenha",
                "WHERE str_token_RecuperacaoDeSenha = ?",
                [$token]
            );
        }else{
            $select = $this->selectDB(
                "*",
                "RecuperacaoDeSenha",
                "WHERE str_email_RecuperacaoDeSenha = ?",
                [$email]
            );
        }
        
        return ($select->rowCount()>0);
    }
    
    function deleteToken($email,$token){
        $this->deleteDB(
            "RecuperacaoDeSenha",
            "str_email_RecuperacaoDeSenha = ?",
            [$email]
        );
        
        $select = $this->selectDB(
            "*",
            "RecuperacaoDeSenha",
            "WHERE 	str_email_RecuperacaoDeSenha = ?",
            [$email]
        );
        return ($select->rowCount()<=0);
    }
}
?>