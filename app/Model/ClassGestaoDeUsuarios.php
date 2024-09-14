<?php
namespace App\Model;
use App\Model\ClassCrud;
class ClassGestaoDeUsuarios extends ClassCrud{

    public function getCPF_Email($email){
        $select=$this->selectDB(
            "str_cpf_PF as CPF",
            "PF",
            "WHERE str_email_PF = ?",
            [
              $email  
            ]
        );
        $linhas=$select->rowCount();
        $dados=$select->fetch(\PDO::FETCH_ASSOC);
        return [
            "linhas"=>$linhas,
            "dados"=>$dados
        ];
    }
    
    public function insertAssociado($Dados){
        
        $this->insertDB(
            "Associados",
            "?,?,?,?",
            [
                $Dados["id"],
                $Dados["empresa"],
                $Dados["cpf"],
                $Dados["permissao"]
            ]
        );
        $select=$this->selectDB(
            "*",
            'Associados',
            "WHERE str_id_Associados = ?",
            [
                $Dados["id"]
            ]
        );
        $linhas=$select->rowCount();
        return $linhas;
    }
    
    public function validateInsertPF($Dados){
       
        $this->insertDB(
            "PF (dtm_dataDeCriacao_PF, str_nome_PF, str_cpf_PF, str_email_PF, str_senha_PF, bool_ativo_PF)",
            "?,?,?,?,?,?",
            [
                $Dados["DataAtual"],
                $Dados["Nome"],
                $Dados["CPF"],
                $Dados["Email"],
                $Dados["Senha"],
                false
            ]
        );
        
        $sec=$this->selectDB(
        "*",
        "PF",
        "WHERE str_cpf_PF = ? AND str_email_PF = ?",
        array(
        $Dados["CPF"],
        $Dados["Email"]
        ));
        return $sec->rowCount();
    }
    
    public function getPermissoes(){
        $select=$this->selectDB(
            "int_id_NiveisDePermissoes as ID,
            str_cargo_NiveisDePermissoes as Cargo",
            "NiveisDePermissoes",
            "",
            []
        );
        $linhas=$select->rowCount();
        $dados=$select->fetchAll(\PDO::FETCH_ASSOC);
        
        return[
            "linhas"=>$linhas,
            "dados"=>$dados
        ];
    }
    
    public function getAssociados($cnpj){
     
        $select=$this->selectDB(
            "str_id_Associados as ID,
            str_nomeFantasia_PJ as NomePJ,
            str_nome_PF as NomePF,
            str_cargo_NiveisDePermissoes as Cargo",
            
            "Associados ",
            
            "INNER JOIN PJ
            ON
            str_cnpj_PJ = ?
            
            INNER JOIN PF
            ON
            str_cpf_PF = str_cpf_Associados
            
            INNER JOIN NiveisDePermissoes 
            ON
            int_id_NiveisDePermissoes = int_permissao_Associados
            
            WHERE
            str_empresa_Associados = ?
            ORDER BY str_nome_PF",
            [
                $cnpj,
                $cnpj
            ]
        );
        $linhas=$select->rowCount();
        $dados=$select->fetchAll(\PDO::FETCH_ASSOC);
        
        return[
            "linhas"=>$linhas,
            "dados"=>$dados
        ];
    }
    
    public function issetAssociado($dados){
        
        $select=$this->selectDB(
            "*",
            "Associados",
            "WHERE str_empresa_Associados = ? AND str_cpf_Associados= ?",
            [
                $dados['cnpj'],
                $dados['cpf']
            ]
        );
        
        $linhas = $select->rowCount();
        $dados =  $select->fetch();
        
        return[
            "linhas"=>$linhas,
            "dados"=>$dados
        ];
    }
    
    public function updateAssociado($dados){
        $this->updateDB(
            "Associados",
            "int_permissao_Associados = ?",
            "str_empresa_Associados = ? AND str_cpf_Associados = ?",
            [
                $dados['permissao'],
                $dados['cnpj'],
                $dados['cpf']
            ]
        );
        
        $select = $this->selectDB(
            "*",
            "Associados",
            "WHERE int_permissao_Associados = ? AND str_empresa_Associados = ? AND str_cpf_Associados = ?",
            [
                $dados['permissao'],
                $dados['cnpj'],
                $dados['cpf']
            ]
        );
        
        $linhas = $select->rowCount();
        
        return $linhas;
    }
    
    public function deleteAssociados($id){
        
        $this->deleteDB(
            "Associados",
            "str_id_Associados = ?",
            [$id]
        );
        
        $select = $this->selectDB(
            "*",
            "Associados",
            "WHERE str_id_Associados = ?",
            [$id]
        );
        
        $linhas = $select->rowCount();
        
        return $linhas;
    }
}
?>