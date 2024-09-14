<?php
namespace App\Model;
use App\Model\ClassCrud;
class ClassGestaoDeConselho extends ClassCrud{
    
    public function getCNPJ_IdTabela($id,$tabela){
        
        if($tabela=="Pagamento" || $tabela=="Contrato" || $tabela=="Recebimento" || $tabela=="Nota"){}else{$tabela="";}
        
        $select=$this->selectDB(
            "str_empresa_".$tabela,
            "{$tabela}",
            "WHERE str_id_{$tabela} = ?",
            [$id]
        );
        
        $linhas = $select->rowCount();
        $dados = $select->fetch();
        
        return [
            "linhas"=>$linhas,
            "dados"=>$dados
        ];
    }
    
    public function getConselheirosVotacao($ID,$tabela){
        $select=$this->selectDB(
            "str_id_{$tabela} as Id{$tabela},
            str_nome_PF as NomePF,
            str_descricao_StatusVotacaoConselho as Status,
            int_status_VotacaoConselho{$tabela} as IdStatus,
            str_cpf_{$tabela} as CPF",
            
            "{$tabela}",
            
            "INNER JOIN VotacaoConselho{$tabela}
            ON str_id{$tabela}_VotacaoConselho{$tabela} = str_id_{$tabela} AND str_cnpj_VotacaoConselho{$tabela} = ? AND str_empresa_{$tabela} = ? 
            
            INNER JOIN PF 
            ON str_cpf_PF = str_cpf_VotacaoConselho{$tabela}  
            
            INNER JOIN StatusVotacaoConselho
            ON int_id_StatusVotacaoConselho = int_status_VotacaoConselho{$tabela}
            WHERE str_empresa_{$tabela} = ?
            ORDER BY str_id{$tabela}_VotacaoConselho{$tabela}, str_nome_PF",
            [$ID,$ID,$ID]
        );
        $linhas=$select->rowCount();
        $dados=$select->fetchAll(\PDO::FETCH_ASSOC);
        return[
            "linhas"=>$linhas,
            "dados"=>$dados
        ];
    }
    
    public function getNumConselheirosNaRegra($ID){
        $select=$this->selectDB(
            "int_maxConselheiros_RegrasDoConselho as NumMaxCon,
            int_minVotos_RegrasDoConselho as NumMinVot,
            int_maxVotos_RegrasDoConselho as NumMaxVot",
            
            "RegrasDoConselho",
            
            "WHERE str_empresa_RegrasDoConselho= ?",
            [$ID]
        );
        $linhas=$select->rowCount();
        $dados=$select->fetchAll(\PDO::FETCH_ASSOC);
        return[
            "linhas"=>$linhas,
            "dados"=>$dados
        ];
    }
    
    public function getConselheiros($cnpj){
        $select=$this->selectDB(
            "str_nome_PF as NomePF,
            str_cpf_PF as CPF,
            int_permissao_Associados as IdPermissao,
            str_cargo_NiveisDePermissoes as Permissao",
            "Associados assoc",
            "INNER JOIN PF
            ON str_cpf_PF = str_cpf_Associados
            
            INNER JOIN NiveisDePermissoes
            ON int_permissao_Associados = int_id_NiveisDePermissoes
            
            WHERE str_empresa_Associados = ? AND (int_permissao_Associados = 147031419 OR int_permissao_Associados = 948880538)
            ORDER BY str_nome_PF",
            [$cnpj]
        );
        $linhas=$select->rowCount();
        $dados=$select->fetchAll(\PDO::FETCH_ASSOC);
        return [
            "linhas"=>$linhas,
            "dados"=>$dados
        ];
    }
    
    public function getVotacaoConselheiros($dados,$tabela){
        $select=$this->selectDB(
            "cad.str_nome_PF",
            
            "VotacaoConselho{$tabela}",
            
            "
            INNER JOIN 
                PF cad
            ON 
                cad.str_cpf_PF = str_cpf_VotacaoConselho{$tabela}
            WHERE
            str_cnpj_VotacaoConselho{$tabela} = ? AND str_id{$tabela}_VotacaoConselho{$tabela} = ?",
            [
                $dados['cnpj'],
                $dados['IdTabela']
            ]
        );
        $linhas=$select->rowCount();
        $dados=$select->fetchAll();
        return[
            "linhas"=>$linhas,
            "dados"=>$dados
        ];
    }
    
    public function issetRegra($cnpj){
        $select=$this->selectDB(
            "*",
            "RegrasDoConselho",
            "WHERE 	str_empresa_RegrasDoConselho = ?",
            [$cnpj]
        );
        
        $linhas=$select->rowCount();
        return $linhas;
    }
    
    public function insertRegra($dados){
        $this->insertDB(
            "RegrasDoConselho",
            "?,?,?,?",
            [
                $dados['cnpj'],
                $dados['nMaxConselheiros'],
                $dados['nMinVotos'],
                $dados['nMaxVotos']
            ]
        );
        
        $select=$this->selectDB(
            '*',
            "RegrasDoConselho",
            "WHERE str_empresa_RegrasDoConselho = ?",
            [$dados['cnpj']]
        );
        
        return $select->rowCount();
    }
    
    public function updateRegra($dados){
        $this->updateDB(
            "RegrasDoConselho",
            "int_maxConselheiros_RegrasDoConselho = ?, 	int_minVotos_RegrasDoConselho = ?, int_maxVotos_RegrasDoConselho = ?",
            "str_empresa_RegrasDoConselho = ?",
            [
                
                $dados['nMaxConselheiros'],
                $dados['nMinVotos'],
                $dados['nMaxVotos'],
                $dados['cnpj']
            ]
        );
        
        $select=$this->selectDB(
            "*",
            "RegrasDoConselho",
            "WHERE str_empresa_RegrasDoConselho = ? AND
            int_maxConselheiros_RegrasDoConselho = ? AND 	
            int_minVotos_RegrasDoConselho = ? AND 
            int_maxVotos_RegrasDoConselho = ?",
            [
                $dados['cnpj'],
                $dados['nMaxConselheiros'],
                $dados['nMinVotos'],
                $dados['nMaxVotos']
            ]
        );
        
        return $select->rowCount();
    }
    
    public function updateAprovacao($dados,$tabela){
        
        $this->updateDB(
            "VotacaoConselho{$tabela}",
            "int_status_VotacaoConselho{$tabela} = ?",
            "str_id{$tabela}_VotacaoConselho{$tabela} = ? AND str_cpf_VotacaoConselho{$tabela} = ?",
            [
                $dados["status"],
                $dados['IdTabela'],
                $dados['cpf']
            ]
        );
        
        $select=$this->selectDB(
            "*",
            "VotacaoConselho{$tabela}",
            "WHERE int_status_VotacaoConselho{$tabela} = ? AND str_id{$tabela}_VotacaoConselho{$tabela} = ? AND str_cpf_VotacaoConselho{$tabela} = ?",
            [
                $dados["status"],
                $dados['IdTabela'],
                $dados['cpf']
            ]
        );
        
        return $select->rowCount();
    }
    
    public function insertAprovacao($dados,$tabela){
        
        $this->insertDB(
            "VotacaoConselho{$tabela}",
            "?,?,?,?,?",
            [
                $dados['ID'],
                $dados['IdTabela'],
                $dados['cnpj'],
                $dados['cpf'],
                $dados['status']
            ]
        );
        
        $select=$this->selectDB(
            "*",
            "VotacaoConselho{$tabela}",
            "WHERE str_id_VotacaoConselho{$tabela} = ?",
            [$dados['ID']]
        );
        
        $linhas = $select->rowCount();
        
        return $linhas;
    }
    
    public function issetAprovacao($dados,$tabela){
        $select=$this->selectDB(
            "*",
            "VotacaoConselho{$tabela}",
            "WHERE str_id{$tabela}_VotacaoConselho{$tabela} = ? AND str_cnpj_VotacaoConselho{$tabela} = ? AND str_cpf_VotacaoConselho{$tabela} = ?",
            [
                $dados['IdTabela'],
                $dados['cnpj'],
                $dados['cpf']
            ]
        );
        
        $linhas = $select->rowCount();
        
        return $linhas;
    }
}
?>