<?php
namespace App\Model;
use App\Model\ClassCrud;
use Src\Traits\TraitGetIp;
class ClassLogin extends ClassCrud{
    
    private $Tabela=null;
    private $Ip;
    private $dataAtual;
    
    public function __construct(){
        $this->Ip=TraitGetIp::getUserIp();
        $this->dataAtual=date("Y-m-d H:i:s");
    }
    
    public function getDataUser($Email,$TipoCliente){
        $tabela = "";
        $seletor = "";
        if($TipoCliente=="PF"){
            $tabela="PF";
            
            /*$where="
            INNER JOIN Associados
            ON 
            str_cpf_Associados = str_cpf_PF
            WHERE str_email_PF = ?";*/
            $seletor = "
                str_cpf_{$tabela} as CPF,
                dt_nascimento_{$tabela} as DataNascimento,
                str_nome_{$tabela} as Nome,
            ";
            $where="WHERE str_email_PF = ?";
        }else if($TipoCliente=="PJ"){
            $tabela="PJ";
            $seletor = "
                str_cnpj_{$tabela} as CNPJ,
                int_tipoJuridico_{$tabela} as TipoJuridico,
                str_nomeFantasia_{$tabela} as NomeFantasia,
                str_razaoSocial_{$tabela} as RazaoSocial,
            ";
            $where="WHERE str_email_PJ = ?";
        }else{
            return false;
        }
        $seletor .= "
            dtm_dataDeCriacao_{$tabela} as DataDeCriacao,
            str_senha_{$tabela} as Senha,
            str_email_{$tabela} as Email,
            str_telefone_{$tabela} as Telefone,
            str_cep_{$tabela} as CEP,
            str_endereco_{$tabela} as Endereco,
            str_numero_{$tabela} as Numero,
            str_complemento_{$tabela} as Complemento,
            str_bairro_{$tabela} as Bairro,
            str_cidade_{$tabela} as Cidade,
            str_uf_{$tabela} as UF,
            bool_ativo_{$tabela} as Ativo
        ";

        $select=$this->selectDB(
            $seletor,
            "{$tabela}",
            $where,
            [$Email]
        );
        $result = $select->fetch(\PDO::FETCH_ASSOC);
        $count = $select->rowCount();
        $tabela="";
        
        return [
            "dados"=>$result,
            "linhas"=>$count
        ];
        
    }
    
    public function countTentativas(){
        $select=$this->selectDB(
            "*",
            "TentativasDeLogin",
            "WHERE str_ip_TentativasDeLogin = ?",
            [$this->Ip]
        );
        $count=0;
        while($reg=$select->fetch(\PDO::FETCH_ASSOC)){
            if(strtotime($reg["dt_data_TentativasDeLogin"]) > strtotime($this->dataAtual)-1800){
                $count++;
            }
        }
        return $count;
    } 
    
    public function ultimaOcorrenciaDeTentativa(){
        $select = $this->selectDB(
            "dt_data_TentativasDeLogin as Data",
            "TentativasDeLogin",
            "WHERE str_ip_TentativasDeLogin = ? ORDER BY dt_data_TentativasDeLogin DESC",
            [$this->Ip]
        );
        
        return [
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetch(\PDO::FETCH_ASSOC)
        ];
    }
    
    public function insertTentativas(){
        if($this->countTentativas() < 5){
            $this->insertDB("TentativasDeLogin","?,?,?",[null,$this->Ip,$this->dataAtual]);
            $selct=$this->selectDB("*","TentativasDeLogin","WHERE str_ip_TentativasDeLogin = ? AND dt_data_TentativasDeLogin = ?",[$this->Ip,$this->dataAtual]);
            return $selct->rowCount();
        }else{return false;}
    } 
    
    public function deleteTentativas(){
        $this->deleteDB("TentativasDeLogin","str_ip_TentativasDeLogin = ?",[$this->Ip]);
        $select=$this->selectDB("*","TentativasDeLogin","WHERE str_ip_TentativasDeLogin = ?",[$this->Ip]);
        if($select->rowCount()<=0){return true;}else{return false;}
    } 
    
}
?>