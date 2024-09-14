<?php
namespace App\Model;
use App\Model\ClassCrud;
class ClassCadastro extends ClassCrud{
    
    public function getTipoJuridico(){
        $select = $this->selectDB(
            "int_id_TipoJuridico as ID,
            str_tipoJuridico_TipoJuridico as Tipo",
            "TipoJuridico",
            "WHERE NOT int_id_TipoJuridico = 866252466",
            []
        );
        $linhas = $select->rowCount();
        $dados = $select->fetchAll(\PDO::FETCH_ASSOC);
        return[
            "linhas"=>$linhas,
            "dados"=>$dados
        ];
    }
    
    public function issetEmail($Email,$Tabela){
        //exit(json_encode([$Email,$Tabela]));
        $sec=$this->selectDB(
            "str_email_{$Tabela}",
            "{$Tabela}",
            "WHERE str_email_{$Tabela} = ?",
            [$Email]);
        $res=$sec->rowCount();
        return $res;
    }
    
    public function issetCPF($CPF){
        $sec=$this->selectDB(
            "str_cpf_PF",
            "PF",
            "WHERE str_cpf_PF = ?",
            [$CPF]);
        $res=$sec->rowCount();
        return $res;
    }
    
    public function issetCNPJ($CNPJ){
        $sec=$this->selectDB(
            "str_cnpj_PJ",
            "PJ",
            "WHERE str_cnpj_PJ = ?",
            [$CNPJ]);
        $res=$sec->rowCount();
        return $res;
    }
    
    public function validateInsertPF($Dados){
        
        $this->insertDB(
            "PF",
            "?,?,?,?,?,?,?,?,?,?,?,?,?,?,?",
            array(
                $Dados["DataAtual"],
                $Dados["Nome"],
                $Dados["Email"],
                $Dados["Senha"],
                $Dados["Telefone"],
                $Dados["CPF"],
                $Dados["dtNascimento"],
                $Dados["CEP"],
                $Dados["Endereco"],
                $Dados["Numero"],
                $Dados["Complemento"],
                $Dados["Bairro"],
                $Dados["Cidade"],
                $Dados["UF"],
                false
            ));
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
    
    public function validateInsertPJ($Dados){
        $this->insertDB(
            "PJ",
            "?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?",
            array(
                $Dados["DataAtual"],
                $Dados["NomeFantazia"],
                $Dados["RazaoSocial"],
                $Dados["Email"],
                $Dados["Senha"],
                $Dados["CNPJ"],
                $Dados["TipoJuridico"],
                $Dados["Telefone"],
                $Dados["CEP"],
                $Dados["Endereco"],
                $Dados["Numero"],
                $Dados["Complemento"],
                $Dados["Bairro"],
                $Dados["Cidade"],
                $Dados["UF"],
                false
            ));
        $sec=$this->selectDB(
        "*",
        "PJ",
        "WHERE str_cnpj_PJ = ? AND str_email_PJ = ?",
        array(
        $Dados["CNPJ"],
        $Dados["Email"]
        ));
        return $sec->rowCount();
    }
    
    public function insertTokenConfirmaCad($dados){
        
        $this->insertDB(
            "ConfirmaCadastro",
            "?,?,?,?,?",
            [
                $dados['DataAtual'],
                $dados['IP'],
                $dados['Email'],
                $dados['TipoCliente'],
                $dados['Token']
            ]
        );
        
        $select = $this->selectDB(
            "*",
            "ConfirmaCadastro",
            "WHERE 	str_token_ConfirmaCadastro = ?",
            [$dados['Token']]
        );
        
        $linhas = $select->rowCount();
        
        return $linhas>0;
    }
    
    public function updateTokenConfirmaCad($dados){
        $this->updateDB(
            "ConfirmaCadastro",
            "str_token_ConfirmaCadastro = ?",
            "str_email_ConfirmaCadastro = ?",
            [$dados['Token'],$dados['Email']]
        );
        
        $select = $this->selectDB(
            '*',
            "ConfirmaCadastro",
            "WHERE str_token_ConfirmaCadastro = ? AND str_email_ConfirmaCadastro = ?",
            [$dados['Token'],$dados['Email']]
        );
        
        return $select->rowCount();
    }
    
    public function issetTokenEmailConfirmaCad($email){

        $select = $this->selectDB(
            '*',
            "ConfirmaCadastro",
            "WHERE str_email_ConfirmaCadastro = ?",
            [$email]
        );
        
        $linhas = $select->rowCount();
        //$dados = $select->fetch(\PDO::FETCH_ASSOC);
        
        return $linhas;
    }
    
    public function issetTokenConfirmaCad($token){

        $select = $this->selectDB(
            'dtm_dataDeRegidtro_ConfirmaCadastro as Data,
            str_ip_ConfirmaCadastro as IP,
            str_email_ConfirmaCadastro as Email,
            str_tipoCliente_ConfirmaCadastro as TipoCleinte,
            str_token_ConfirmaCadastro as Token',
            "ConfirmaCadastro",
            "WHERE str_token_ConfirmaCadastro = ?",
            [$token]
        );
        
        $linhas = $select->rowCount();
        $dados = $select->fetch(\PDO::FETCH_ASSOC);
        
        return [
            'linhas'=>$linhas,
            'dados'=>$dados
        ];
    }
    
    public function ativarConta($email,$tabela){
        
        $this->updateDB(
            "{$tabela}",
            "bool_ativo_{$tabela} = true",
            "str_email_{$tabela} = ?",
            [$email]
        );
        
        $select = $this->selectDB(
            "*",
            "{$tabela}",
            "WHERE str_email_{$tabela} = ? AND bool_ativo_{$tabela} = true",
            [$email]
        );
        
        $linhas = $select->rowCount();
        
        return $linhas>0;
    }
    
    public function deleteTokenConfirmaCad($token){
        
        $this->deleteDB(
            'ConfirmaCadastro',
            "str_token_ConfirmaCadastro = ?",
            [$token]
        );
        
        $select = $this->selectDB(
            "*",
            "ConfirmaCadastro",
            "WHERE str_token_ConfirmaCadastro = ?",
            [$token]
        );
        
        $linhas = $select->rowCount();
        
        return $linhas<=0;
    }
}
?>