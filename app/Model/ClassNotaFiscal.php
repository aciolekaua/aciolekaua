<?php
namespace App\Model;
use App\Model\ClassCrud;
class ClassNotaFiscal extends ClassCrud{
    
    function insertNotaFiscalServico($dados){
        $this->insertDB(
            "NotaFiscalServico",
            "?,?,?,?,?,?,?,?,?,?,?,?,?",
            [
                $dados['ID'],
                $dados['Numero'],
                $dados['CodigoVerificacao'],
                $dados['ValorServicos'],
                $dados['IssRetido'],
                $dados['ValorIss'],
                $dados['BaseCalculo'],
                $dados['Aliquota'],
                $dados['ValorLiquidoNfse'],
                $dados['ItemListaServico'],
                $dados['CodigoTributacaoMunicipio'],
                $dados['Discriminacao'],
                $dados['CodigoMunicipio']
            ]
        );
        $select=$this->selectDB(
            "*",
            "NotaFiscalServico",
            "WHERE str_id_NotaFiscalServico = ?",
            [$dados['ID']]
        );
        
        return $select->rowCount()>0;
    }
    
    function insertNotaFiscalPrestador($dados){
        /*var_dump($dados);
        echo("<hr>");*/
        $this->insertDB(
            "NotaFiscalPrestador",
            "?,?,?,?,?,?,?,?,?,?,?,?,?,?,?",
            [
                $dados["ID"],
                $dados["Numero"],
                $dados["CodigoVerificacao"],
                $dados["cnpjCpfPrestador"],
                $dados["InscricaoMunicipal"],
                $dados["RazaoSocial"],
                $dados["Endereco"],
                $dados["NumeroEndereco"],
                $dados["Complemento"],
                $dados["Bairro"],
                $dados["CodigoMunicipio"],
                $dados["Uf"],
                $dados["Cep"],
                $dados["Telefone"],
                $dados["Email"]
            ]
        );
        $select=$this->selectDB(
            "*",
            "NotaFiscalPrestador",
            "WHERE str_id_NotaFiscalPrestador = ?",
            [$dados['ID']]
        );
        
        return $select->rowCount()>0;
    }
    
    function insertNotaFiscalTomador($dados){
        $this->insertDB(
            "NotaFiscalTomador",
            "?,?,?,?,?,?,?,?,?,?,?,?,?,?,?",
            [
                $dados["ID"],
                $dados["Numero"],
                $dados["CodigoVerificacao"],
                $dados["cnpjCpfTomador"],
                $dados["InscricaoMunicipal"],
                $dados["RazaoSocial"],
                $dados["Endereco"],
                $dados["NumeroEndereco"],
                $dados["Complemento"],
                $dados["Bairro"],
                $dados["CodigoMunicipio"],
                $dados["Uf"],
                $dados["Cep"],
                $dados["Telefone"],
                $dados["Email"]
            ]
        );
        $select=$this->selectDB(
            "*",
            "NotaFiscalTomador",
            "WHERE str_id_NotaFiscalTomador = ?",
            [$dados['ID']]
        );
        
        return $select->rowCount()>0;
    }
    
    function insertNotaFiscalBruta($dados){
        $this->insertDB(
            "NotaFiscalBruta",
            "?,?,?,?,?,?,?,?,?,?,?",
            [
                $dados["ID"],
                $dados["Numero"],
                $dados["CodigoVerificacao"],
                $dados["DataEmissao"],
                $dados["NaturezaOperacao"],
                $dados["OptanteSimplesNacional"],
                $dados["IncentivadorCultural"],
                $dados["Competencia"],
                $dados["ValorCredito"],
                $dados["CodigoMunicipio"],
                $dados["Uf"]
            ]
        );
        $select=$this->selectDB(
            "*",
            "NotaFiscalBruta",
            "WHERE str_id_NotaFiscalBruta = ?",
            [$dados['ID']]
        );
        
        return $select->rowCount()>0;
    }
    
    function issetNotaFiscalBruta($dados){
        
        $select=$this->selectDB(
            "*",
            "NotaFiscalBruta",
            "
            INNER JOIN 
                NotaFiscalPrestador
            ON 
                str_id_NotaFiscalBruta = str_id_NotaFiscalPrestador
            WHERE YEAR(dtm_competencia_NotaFiscalBruta) = YEAR(?) AND int_cnpjCPF_NotaFiscalPrestador = ? AND int_numero_NotaFiscalBruta = ? AND str_codigoVerificacao_NotaFiscalBruta = ?
            ",
            [
                $dados['Competencia'],
                $dados['cnpjCpfPrestador'],
                $dados['Numero'],
                $dados['CodigoVerificacao']
            ]
        );
        
        return $select->rowCount()>0;
    }
    
    function issetNotaFiscalTomador($dados){
        $select=$this->selectDB(
            "*",
            "NotaFiscalTomador",
            "
            INNER JOIN 
                NotaFiscalPrestador
            ON 
                str_id_NotaFiscalTomador = str_id_NotaFiscalPrestador
                
            INNER JOIN
                NotaFiscalBruta
            ON
                str_id_NotaFiscalTomador = str_id_NotaFiscalBruta
                
            WHERE YEAR(dtm_competencia_NotaFiscalBruta) = YEAR(?) AND int_cnpjCPF_NotaFiscalPrestador = ? AND int_numero_NotaFiscalTomador = ? AND str_codigoVerificacao_NotaFiscalTomador = ?
            ",
            [
                $dados['Competencia'],
                $dados['cnpjCpfPrestador'],
                $dados['Numero'],
                $dados['CodigoVerificacao']
            ]
        );
        
        return $select->rowCount()>0;
    }
    
    function issetNotaFiscalPrestador($dados){
        $select=$this->selectDB(
            "*",
            "NotaFiscalPrestador",
            "
            INNER JOIN
                NotaFiscalBruta
            ON
                str_id_NotaFiscalPrestador = str_id_NotaFiscalBruta
            WHERE YEAR(dtm_competencia_NotaFiscalBruta) = YEAR(?) AND int_cnpjCPF_NotaFiscalPrestador = ? AND int_numero_NotaFiscalPrestador = ? AND str_codigoVerificacao_NotaFiscalPrestador = ?
            ",
            [
                $dados['Competencia'],
                $dados['cnpjCpfPrestador'],
                $dados['Numero'],
                $dados['CodigoVerificacao']
            ]
        );
        
        return $select->rowCount()>0;
    }
    
    function issetNotaFiscalServico($dados){
        $select=$this->selectDB(
            "*",
            "NotaFiscalServico",
            "
            INNER JOIN 
                NotaFiscalPrestador
            ON 
                str_id_NotaFiscalServico = str_id_NotaFiscalPrestador
                
            INNER JOIN
                NotaFiscalBruta
            ON
                str_id_NotaFiscalServico = str_id_NotaFiscalBruta
                
            WHERE YEAR(dtm_competencia_NotaFiscalBruta) = YEAR(?) AND int_cnpjCPF_NotaFiscalPrestador = ? AND int_numero_NotaFiscalServico = ? AND str_codigoVerificacao_NotaFiscalServico = ?
            ",
            [
                $dados['Competencia'],
                $dados['cnpjCpfPrestador'],
                $dados['Numero'],
                $dados['CodigoVerificacao']
            ]
        );
        
        return $select->rowCount()>0;
    }
}
?>